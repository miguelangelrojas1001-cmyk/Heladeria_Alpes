<?php

if (!class_exists('Database')) {
    require_once __DIR__ . '/../config/database.php';
}

class Producto
{
    public static function obtenerDisponibles()
    {
        $database = new Database();
        $db = $database->conectar();

        $sql = "SELECT * FROM producto WHERE disponible = 1";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorCatalogo($idcatalogo)
    {
        $database = new Database();
        $db = $database->conectar();

        $sql = "SELECT * FROM producto 
                WHERE idcatalogo = :idcatalogo 
                AND disponible = 1";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':idcatalogo', $idcatalogo, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerTodos()
    {
        $database = new Database();
        $db = $database->conectar();

        $sql = "SELECT p.*, c.nombre AS catalogo
                FROM producto p
                LEFT JOIN catalogo c ON p.idcatalogo = c.idcatalogo
                ORDER BY p.idproducto DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerCatalogos()
    {
        $database = new Database();
        $db = $database->conectar();

        $stmt = $db->prepare("SELECT * FROM catalogo ORDER BY nombre ASC");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerInsumos()
    {
        $database = new Database();
        $db = $database->conectar();

        $stmt = $db->prepare("SELECT * FROM insumo ORDER BY nombre ASC");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function crearProducto($datos, $insumos)
    {
        $database = new Database();
        $db = $database->conectar();

        try {
            $db->beginTransaction();

            $sql = "INSERT INTO producto 
                    (idcatalogo, nombre, descripcion, precio, imagen, disponible)
                    VALUES
                    (:idcatalogo, :nombre, :descripcion, :precio, :imagen, :disponible)";

            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':idcatalogo' => $datos['idcatalogo'],
                ':nombre' => $datos['nombre'],
                ':descripcion' => $datos['descripcion'],
                ':precio' => $datos['precio'],
                ':imagen' => $datos['imagen'],
                ':disponible' => $datos['disponible']
            ]);

            $idproducto = $db->lastInsertId();

            foreach ($insumos as $idinsumo => $cantidad) {
                if ($cantidad > 0) {
                    $sqlDetalle = "INSERT INTO detalle_insumo 
                                   (idproducto, idinsumo, cantidad)
                                   VALUES
                                   (:idproducto, :idinsumo, :cantidad)";

                    $stmtDetalle = $db->prepare($sqlDetalle);
                    $stmtDetalle->execute([
                        ':idproducto' => $idproducto,
                        ':idinsumo' => $idinsumo,
                        ':cantidad' => $cantidad
                    ]);
                }
            }

            $db->commit();
            return true;

        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }

    public static function descontarInsumos($idproducto, $cantidadVendida)
    {
        $database = new Database();
        $db = $database->conectar();

        $sql = "SELECT idinsumo, cantidad 
                FROM detalle_insumo 
                WHERE idproducto = :idproducto";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':idproducto', $idproducto, PDO::PARAM_INT);
        $stmt->execute();

        $insumos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($insumos)) {
            return false;
        }

        // ── Validar stock suficiente antes de descontar ───────────────────
        foreach ($insumos as $insumo) {
            $cantidadNecesaria = $insumo['cantidad'] * $cantidadVendida;
            $stmtStock = $db->prepare("SELECT stock_actual, nombre FROM insumo WHERE idinsumo = :id");
            $stmtStock->execute([':id' => $insumo['idinsumo']]);
            $stockInfo = $stmtStock->fetch(PDO::FETCH_ASSOC);

            if ($stockInfo && $stockInfo['stock_actual'] < $cantidadNecesaria) {
                // Stock insuficiente — registrar advertencia pero continuar
                // (no bloquear el pedido, solo dejar el stock en negativo y alertar)
                error_log("[Stock] Insumo «{$stockInfo['nombre']}» sin stock suficiente. Necesario: {$cantidadNecesaria}, disponible: {$stockInfo['stock_actual']}");
            }
        }

        foreach ($insumos as $insumo) {
            $cantidadDescontar = $insumo['cantidad'] * $cantidadVendida;

            $sqlUpdate = "UPDATE insumo
                          SET stock_actual = stock_actual - :cantidad
                          WHERE idinsumo = :idinsumo";

            $stmtUpdate = $db->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':cantidad' => $cantidadDescontar,
                ':idinsumo' => $insumo['idinsumo']
            ]);

            $sqlInventario = "INSERT INTO inventario
                              (idinsumo, tipo_entrada, tipo_salida, cantidad, fecha)
                              VALUES
                              (:idinsumo, 0, 1, :cantidad, NOW())";

            $stmtInventario = $db->prepare($sqlInventario);
            $stmtInventario->execute([
                ':idinsumo' => $insumo['idinsumo'],
                ':cantidad' => $cantidadDescontar
            ]);

            // ── Alerta de stock crítico ──────────────────────────────────────
            // Verificar si el stock quedó en o por debajo del mínimo
            $stmtCheck = $db->prepare("
                SELECT idinsumo, nombre, stock_actual, stock_minimo
                FROM insumo
                WHERE idinsumo = :id AND stock_actual <= stock_minimo
            ");
            $stmtCheck->execute([':id' => $insumo['idinsumo']]);
            $critico = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($critico) {
                // Insertar notificación solo si no existe una reciente (últimas 24h) para este insumo
                $stmtDup = $db->prepare("
                    SELECT idnotificacion FROM notificacion
                    WHERE idinsumo = :id
                      AND tipo_stock_minimo = 1
                      AND fecha >= NOW() - INTERVAL 24 HOUR
                    LIMIT 1
                ");
                $stmtDup->execute([':id' => $critico['idinsumo']]);
                if (!$stmtDup->fetch()) {
                    // Notificar a todos los administradores
                    $admins = $db->query("
                        SELECT p.idpersona FROM persona p
                        JOIN roles r ON p.idrol = r.idrol
                        WHERE r.nombre = 'administrador'
                    ")->fetchAll(PDO::FETCH_ASSOC);

                    $msg = "⚠️ Stock crítico: «{$critico['nombre']}» tiene {$critico['stock_actual']} unidades (mínimo: {$critico['stock_minimo']}).";
                    $stmtNot = $db->prepare("
                        INSERT INTO notificacion (idpersona, idinsumo, tipo_stock_minimo, tipo_nuevo_pedido, tipo_cambio_estado, mensaje, fecha)
                        VALUES (:idp, :idi, 1, 0, 0, :msg, NOW())
                    ");
                    foreach ($admins as $admin) {
                        $stmtNot->execute([
                            ':idp' => $admin['idpersona'],
                            ':idi' => $critico['idinsumo'],
                            ':msg' => $msg,
                        ]);
                    }
                }
            }
        }

        return true;
    }

    public static function obtenerPorId($idproducto)
    {
        $database = new Database();
        $db = $database->conectar();

        $stmt = $db->prepare("SELECT p.*, c.nombre AS catalogo FROM producto p LEFT JOIN catalogo c ON p.idcatalogo = c.idcatalogo WHERE p.idproducto = :id LIMIT 1");
        $stmt->execute([':id' => $idproducto]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenerIdClientePorPersona($idpersona)
    {
        $database = new Database();
        $db = $database->conectar();

        $stmt = $db->prepare("SELECT idcliente FROM cliente WHERE idpersona = :id LIMIT 1");
        $stmt->execute([':id' => $idpersona]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['idcliente'] : null;
    }

    public static function obtenerCatalogoPorId($idcatalogo)
    {
        $database = new Database();
        $db = $database->conectar();

        $stmt = $db->prepare("SELECT * FROM catalogo WHERE idcatalogo = :id LIMIT 1");
        $stmt->execute([':id' => $idcatalogo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function actualizarProducto($idproducto, $datos, $insumos)
    {
        $database = new Database();
        $db = $database->conectar();

        try {
            $db->beginTransaction();

            $campos = "idcatalogo = :idcatalogo, nombre = :nombre, descripcion = :descripcion, precio = :precio, disponible = :disponible";
            $params = [
                ':idcatalogo'  => $datos['idcatalogo'],
                ':nombre'      => $datos['nombre'],
                ':descripcion' => $datos['descripcion'],
                ':precio'      => $datos['precio'],
                ':disponible'  => $datos['disponible'],
                ':id'          => $idproducto,
            ];

            if (!empty($datos['imagen'])) {
                $campos .= ", imagen = :imagen";
                $params[':imagen'] = $datos['imagen'];
            }

            $stmt = $db->prepare("UPDATE producto SET {$campos} WHERE idproducto = :id");
            $stmt->execute($params);

            // Actualizar insumos: borrar los anteriores y reinsertar
            $db->prepare("DELETE FROM detalle_insumo WHERE idproducto = :id")->execute([':id' => $idproducto]);

            foreach ($insumos as $idinsumo => $cantidad) {
                if ($cantidad > 0) {
                    $sqlDetalle = "INSERT INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (:idproducto, :idinsumo, :cantidad)";
                    $stmtDetalle = $db->prepare($sqlDetalle);
                    $stmtDetalle->execute([
                        ':idproducto' => $idproducto,
                        ':idinsumo'   => $idinsumo,
                        ':cantidad'   => $cantidad,
                    ]);
                }
            }

            $db->commit();
            return true;

        } catch (Exception $e) {
            $db->rollBack();
            return false;
        }
    }

    public static function obtenerInsumosPorProducto($idproducto)
    {
        $database = new Database();
        $db = $database->conectar();

        $stmt = $db->prepare("SELECT idinsumo, cantidad FROM detalle_insumo WHERE idproducto = :id");
        $stmt->execute([':id' => $idproducto]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($rows as $r) {
            $result[$r['idinsumo']] = $r['cantidad'];
        }
        return $result;
    }
}
