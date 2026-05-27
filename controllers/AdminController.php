<?php

require_once '../config/session.php';
require_once '../models/Producto.php';
require_once '../config/database.php';

class AdminController
{
    public static function productos()
    {
        requireRole('administrador');

        $mensaje = null;
        $productoEditar = null;
        $insumosProducto = [];

        $database = new Database();
        $db = $database->conectar();

        // Eliminar producto
        if (isset($_GET['eliminar'])) {
            $idproducto = (int)$_GET['eliminar'];
            try {
                $db->beginTransaction();
                $db->prepare("DELETE FROM detalle_insumo WHERE idproducto = :id")->execute([':id' => $idproducto]);
                $db->prepare("DELETE FROM producto WHERE idproducto = :id")->execute([':id' => $idproducto]);
                $db->commit();
                redirect('index.php?page=admin_productos');
            } catch (Exception $e) {
                $db->rollBack();
                $mensaje = 'Error al eliminar el producto.';
            }
        }

        // Cargar producto para editar
        if (isset($_GET['editar'])) {
            $productoEditar  = Producto::obtenerPorId((int)$_GET['editar']);
            $insumosProducto = Producto::obtenerInsumosPorProducto((int)$_GET['editar']);
        }

        // Guardar nuevo producto
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['_editar'])) {
            $datos = [
                'idcatalogo'  => $_POST['idcatalogo'] ?? null,
                'nombre'      => $_POST['nombre'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'precio'      => $_POST['precio'] ?? 0,
                'imagen'      => '',
                'disponible'  => isset($_POST['disponible']) ? 1 : 0,
            ];
            if (!empty($_FILES['imagen']['name'])) {
                $nombreImagen = time() . '_' . basename($_FILES['imagen']['name']);
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], '../public/img/' . $nombreImagen)) {
                    $datos['imagen'] = 'img/' . $nombreImagen;
                }
            }
            $insumos = $_POST['insumos'] ?? [];
            $mensaje = Producto::crearProducto($datos, $insumos)
                ? 'Producto agregado correctamente.'
                : 'Error al agregar el producto.';
        }

        // Actualizar producto existente
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_editar'])) {
            $idproducto = (int)$_POST['_editar'];
            $datos = [
                'idcatalogo'  => $_POST['idcatalogo'] ?? null,
                'nombre'      => $_POST['nombre'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'precio'      => $_POST['precio'] ?? 0,
                'imagen'      => '',
                'disponible'  => isset($_POST['disponible']) ? 1 : 0,
            ];
            if (!empty($_FILES['imagen']['name'])) {
                $nombreImagen = time() . '_' . basename($_FILES['imagen']['name']);
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], '../public/img/' . $nombreImagen)) {
                    $datos['imagen'] = 'img/' . $nombreImagen;
                }
            }
            $insumos  = $_POST['insumos'] ?? [];
            $resultado = Producto::actualizarProducto($idproducto, $datos, $insumos);
            $mensaje  = $resultado ? 'Producto actualizado correctamente.' : 'Error al actualizar el producto.';
        }

        $productos = Producto::obtenerTodos();
        $catalogos = Producto::obtenerCatalogos();
        $insumos   = Producto::obtenerInsumos();
        include '../views/dashboard/admin/productos.php';
    }

    public static function inventario()
    {
        requireRole('administrador');

        $database = new Database();
        $db = $database->conectar();
        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
            if ($_POST['accion'] === 'agregar_insumo') {
                $db->prepare("INSERT INTO insumo (nombre, stock_actual, stock_minimo, unidad_medida, categoria) VALUES (:nombre, :stock, :min, :um, :cat)")
                   ->execute([
                       ':nombre' => trim($_POST['nombre']),
                       ':stock'  => (float)($_POST['stock_actual'] ?? 0),
                       ':min'    => (float)($_POST['stock_minimo'] ?? 0),
                       ':um'     => $_POST['unidad_medida'] ?? 'unidad',
                       ':cat'    => $_POST['categoria'] ?? 'General',
                   ]);
                $mensaje = ['tipo' => 'ok', 'texto' => 'Insumo agregado correctamente.'];

            } elseif ($_POST['accion'] === 'entrada') {
                $db->prepare("UPDATE insumo SET stock_actual = stock_actual + :cant WHERE idinsumo = :id")
                   ->execute([':cant' => (float)$_POST['cantidad'], ':id' => (int)$_POST['idinsumo']]);
                $db->prepare("INSERT INTO inventario (idinsumo, tipo_entrada, tipo_salida, cantidad, fecha) VALUES (:id, 1, 0, :cant, NOW())")
                   ->execute([':id' => (int)$_POST['idinsumo'], ':cant' => (float)$_POST['cantidad']]);
                $mensaje = ['tipo' => 'ok', 'texto' => 'Entrada registrada correctamente.'];

            } elseif ($_POST['accion'] === 'salida') {
                $db->prepare("UPDATE insumo SET stock_actual = stock_actual - :cant WHERE idinsumo = :id")
                   ->execute([':cant' => (float)$_POST['cantidad'], ':id' => (int)$_POST['idinsumo']]);
                $db->prepare("INSERT INTO inventario (idinsumo, tipo_entrada, tipo_salida, cantidad, fecha) VALUES (:id, 0, 1, :cant, NOW())")
                   ->execute([':id' => (int)$_POST['idinsumo'], ':cant' => (float)$_POST['cantidad']]);
                $mensaje = ['tipo' => 'ok', 'texto' => 'Salida registrada correctamente.'];

            } elseif ($_POST['accion'] === 'editar_insumo') {
                $db->prepare("UPDATE insumo SET nombre=:nombre, stock_minimo=:min, unidad_medida=:um WHERE idinsumo=:id")
                   ->execute([
                       ':nombre' => trim($_POST['nombre']),
                       ':min'    => (float)$_POST['stock_minimo'],
                       ':um'     => $_POST['unidad_medida'],
                       ':id'     => (int)$_POST['idinsumo'],
                   ]);
                redirect('index.php?page=admin_inventario');
            }
        }

        if (isset($_GET['eliminar_insumo'])) {
            $id = (int)$_GET['eliminar_insumo'];
            try {
                $db->beginTransaction();
                $db->prepare("DELETE FROM inventario     WHERE idinsumo = :id")->execute([':id' => $id]);
                $db->prepare("DELETE FROM detalle_insumo WHERE idinsumo = :id")->execute([':id' => $id]);
                $db->prepare("DELETE FROM insumo          WHERE idinsumo = :id")->execute([':id' => $id]);
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
            }
            redirect('index.php?page=admin_inventario');
        }

        $insumos     = $db->query("SELECT idinsumo, nombre, stock_actual, stock_minimo, unidad_medida, categoria FROM insumo ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
        $movimientos = $db->query("
            SELECT inv.*, ins.nombre AS insumo_nombre
            FROM inventario inv
            LEFT JOIN insumo ins ON inv.idinsumo = ins.idinsumo
            ORDER BY inv.fecha DESC LIMIT 30
        ")->fetchAll(PDO::FETCH_ASSOC);

        include '../views/dashboard/admin/inventario.php';
    }

    public static function ventas()
    {
        requireRole('administrador');

        $database = new Database();
        $db = $database->conectar();

        // Actualizar estado del pedido
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idpedido'], $_POST['estado'])) {
            $idpedido = (int)$_POST['idpedido'];
            $estado   = $_POST['estado'];

            $db->prepare("UPDATE pedido SET estado = :estado WHERE idpedido = :id")
               ->execute([':estado' => $estado, ':id' => $idpedido]);

            // Asignar domiciliario automáticamente si el estado es activo
            if (in_array($estado, ['pendiente', 'en proceso'])) {
                try {
                    if (!class_exists('Domiciliario')) {
                        require_once __DIR__ . '/../models/Domiciliario.php';
                    }
                    Domiciliario::asignarOActualizar($idpedido);
                } catch (Exception $e) {
                    // No interrumpir el flujo si falla la asignación
                }
            }

            redirect('index.php?page=admin_ventas');
        }

        // ── Paginación ────────────────────────────────────────────────────
        $porPagina   = 20;
        $paginaActual = max(1, (int)($_GET['pagina'] ?? 1));
        $offset       = ($paginaActual - 1) * $porPagina;

        // Filtro de estado
        $filtroEstado = $_GET['estado'] ?? '';
        $whereEstado  = $filtroEstado ? "WHERE p.estado = :estado" : "";

        $totalPedidos = $db->prepare("SELECT COUNT(*) FROM pedido p $whereEstado");
        if ($filtroEstado) $totalPedidos->execute([':estado' => $filtroEstado]);
        else               $totalPedidos->execute();
        $totalPedidos = (int)$totalPedidos->fetchColumn();
        $totalPaginas = max(1, (int)ceil($totalPedidos / $porPagina));

        $sqlPedidos = "
            SELECT p.idpedido, p.total, p.fecha, p.estado,
                   pe.nombre  AS cliente,
                   pd.nombre  AS domiciliario
            FROM pedido p
            LEFT JOIN cliente c      ON p.idcliente       = c.idcliente
            LEFT JOIN persona pe     ON c.idpersona        = pe.idpersona
            LEFT JOIN envios e       ON e.idpedido         = p.idpedido
            LEFT JOIN domiciliario d ON e.iddomiciliario   = d.iddomiciliario
            LEFT JOIN persona pd     ON d.idpersona        = pd.idpersona
            $whereEstado
            ORDER BY p.fecha DESC
            LIMIT :limit OFFSET :offset
        ";
        $stmtPed = $db->prepare($sqlPedidos);
        if ($filtroEstado) $stmtPed->bindValue(':estado', $filtroEstado, PDO::PARAM_STR);
        $stmtPed->bindValue(':limit',  $porPagina, PDO::PARAM_INT);
        $stmtPed->bindValue(':offset', $offset,    PDO::PARAM_INT);
        $stmtPed->execute();
        $pedidos = $stmtPed->fetchAll(PDO::FETCH_ASSOC);

        $totales = $db->query("
            SELECT
                COUNT(*) AS total_pedidos,
                COALESCE(SUM(total),0) AS ingresos_totales,
                COALESCE(SUM(CASE WHEN estado='completado' THEN total ELSE 0 END),0) AS ingresos_completados
            FROM pedido
        ")->fetch(PDO::FETCH_ASSOC);

        include '../views/dashboard/admin/ventas.php';
    }

    public static function proveedores()
    {
        requireRole('administrador');

        $database = new Database();
        $db = $database->conectar();
        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre'])) {
            if (!empty($_POST['idproveedor'])) {
                $db->prepare("UPDATE proveedor SET nombre=:n, telefono=:t, correo=:c WHERE idproveedor=:id")
                   ->execute([':n' => trim($_POST['nombre']), ':t' => trim($_POST['telefono']), ':c' => trim($_POST['correo']), ':id' => (int)$_POST['idproveedor']]);
                $mensaje = 'Proveedor actualizado.';
            } else {
                $db->prepare("INSERT INTO proveedor (nombre, telefono, correo) VALUES (:n,:t,:c)")
                   ->execute([':n' => trim($_POST['nombre']), ':t' => trim($_POST['telefono']), ':c' => trim($_POST['correo'])]);
                $mensaje = 'Proveedor agregado.';
            }
        }

        if (isset($_GET['eliminar'])) {
            $db->prepare("DELETE FROM proveedor WHERE idproveedor=:id")->execute([':id' => (int)$_GET['eliminar']]);
            redirect('index.php?page=admin_proveedores');
        }

        $proveedores = $db->query("SELECT * FROM proveedor ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
        include '../views/dashboard/admin/proveedores.php';
    }

    public static function usuarios()
    {
        requireRole('administrador');

        if (!class_exists('Persona')) {
            require_once '../models/Persona.php';
        }

        $database = new Database();
        $db = $database->conectar();
        $mensaje = null;

        // Cambiar rol
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'cambiar_rol') {
            $idpersona = (int)($_POST['idpersona'] ?? 0);
            $idrol     = (int)($_POST['idrol']     ?? 0);
            if ($idpersona > 0 && $idrol > 0) {
                // Obtener nombre del nuevo rol
                $stmtRol = $db->prepare("SELECT nombre FROM roles WHERE idrol = :id LIMIT 1");
                $stmtRol->execute([':id' => $idrol]);
                $rolNuevo = $stmtRol->fetchColumn();

                $db->prepare("UPDATE persona SET idrol = :idrol WHERE idpersona = :id")
                   ->execute([':idrol' => $idrol, ':id' => $idpersona]);

                // Crear registro en la tabla de perfil correspondiente si no existe
                if ($rolNuevo === 'domiciliario') {
                    $db->prepare("INSERT IGNORE INTO domiciliario (idpersona) VALUES (:id)")
                       ->execute([':id' => $idpersona]);
                } elseif ($rolNuevo === 'administrador') {
                    $db->prepare("INSERT IGNORE INTO administrador (idpersona) VALUES (:id)")
                       ->execute([':id' => $idpersona]);
                } elseif ($rolNuevo === 'cliente') {
                    $db->prepare("INSERT IGNORE INTO cliente (idpersona) VALUES (:id)")
                       ->execute([':id' => $idpersona]);
                }

                $mensaje = ['tipo' => 'ok', 'texto' => 'Rol actualizado correctamente.'];
            } else {
                $mensaje = ['tipo' => 'err', 'texto' => 'Datos inválidos.'];
            }
        }

        // Eliminar usuario
        if (isset($_GET['eliminar'])) {
            $id = (int)$_GET['eliminar'];
            try {
                $db->beginTransaction();
                $db->prepare("DELETE FROM cliente      WHERE idpersona = :id")->execute([':id' => $id]);
                $db->prepare("DELETE FROM domiciliario WHERE idpersona = :id")->execute([':id' => $id]);
                $db->prepare("DELETE FROM persona      WHERE idpersona = :id")->execute([':id' => $id]);
                $db->commit();
                redirect('index.php?page=admin_usuarios');
            } catch (Exception $e) {
                $db->rollBack();
                $mensaje = ['tipo' => 'err', 'texto' => 'Error al eliminar: ' . $e->getMessage()];
            }
        }

        // Crear usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'crear_usuario') {
            $nombre     = trim($_POST['nombre']     ?? '');
            $correo     = trim($_POST['correo']     ?? '');
            $contrasena = $_POST['contrasena']      ?? '';
            $rolNombre  = $_POST['rol']             ?? 'cliente';

            if (empty($nombre) || empty($correo) || empty($contrasena)) {
                $mensaje = ['tipo' => 'err', 'texto' => 'Todos los campos son obligatorios.'];
            } elseif (strlen($contrasena) < 6) {
                $mensaje = ['tipo' => 'err', 'texto' => 'La contraseña debe tener al menos 6 caracteres.'];
            } else {
                $ok = Persona::registrar($nombre, $correo, $contrasena, $rolNombre);
                if ($ok) {
                    // Obtener el idpersona recién creado
                    $stmtNew = $db->prepare("SELECT idpersona FROM persona WHERE correo = :correo LIMIT 1");
                    $stmtNew->execute([':correo' => $correo]);
                    $idpersonaNueva = (int)$stmtNew->fetchColumn();

                    // Crear registro en la tabla de perfil correspondiente
                    if ($idpersonaNueva > 0) {
                        if ($rolNombre === 'domiciliario') {
                            $db->prepare("INSERT IGNORE INTO domiciliario (idpersona) VALUES (:id)")
                               ->execute([':id' => $idpersonaNueva]);
                        } elseif ($rolNombre === 'administrador') {
                            $db->prepare("INSERT IGNORE INTO administrador (idpersona) VALUES (:id)")
                               ->execute([':id' => $idpersonaNueva]);
                        } elseif ($rolNombre === 'cliente') {
                            $db->prepare("INSERT IGNORE INTO cliente (idpersona) VALUES (:id)")
                               ->execute([':id' => $idpersonaNueva]);
                        }
                    }
                    $mensaje = ['tipo' => 'ok', 'texto' => 'Usuario creado correctamente.'];
                } else {
                    $mensaje = ['tipo' => 'err', 'texto' => 'El correo ya está registrado o el rol no existe.'];
                }
            }
        }

        $usuarios = $db->query("
            SELECT p.idpersona, p.nombre, p.correo, p.idrol, r.nombre AS rol
            FROM persona p
            JOIN roles r ON p.idrol = r.idrol
            ORDER BY p.idpersona DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        $roles = $db->query("SELECT idrol, nombre FROM roles ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);

        include '../views/dashboard/admin/usuarios.php';
    }

    public static function reportes()
    {
        requireRole('administrador');

        $database = new Database();
        $db = $database->conectar();
        $fechaDesde = $_GET['desde'] ?? date('Y-m-01');          // primer día del mes actual
        $fechaHasta = $_GET['hasta'] ?? date('Y-m-d');           // hoy

        // ── KPIs de ventas ────────────────────────────────────────────────
        $kpi = $db->prepare("
            SELECT
                COUNT(*)                                                          AS total_pedidos,
                COALESCE(SUM(total), 0)                                           AS ingresos_brutos,
                COALESCE(SUM(CASE WHEN estado='completado' THEN total END), 0)    AS ingresos_completados,
                COALESCE(SUM(CASE WHEN estado='cancelado'  THEN total END), 0)    AS ingresos_cancelados,
                COALESCE(AVG(CASE WHEN estado='completado' THEN total END), 0)    AS ticket_promedio,
                SUM(CASE WHEN estado='completado' THEN 1 ELSE 0 END)              AS pedidos_completados,
                SUM(CASE WHEN estado='cancelado'  THEN 1 ELSE 0 END)              AS pedidos_cancelados,
                SUM(CASE WHEN estado='pendiente'  THEN 1 ELSE 0 END)              AS pedidos_pendientes,
                SUM(CASE WHEN estado='en proceso' THEN 1 ELSE 0 END)              AS pedidos_en_proceso
            FROM pedido
            WHERE DATE(fecha) BETWEEN :desde AND :hasta
        ");
        $kpi->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $kpi = $kpi->fetch(PDO::FETCH_ASSOC);

        // ── Ingresos por día ──────────────────────────────────────────────
        $ingresosDia = $db->prepare("
            SELECT DATE(fecha) AS dia, COALESCE(SUM(total), 0) AS total
            FROM pedido
            WHERE estado = 'completado'
              AND DATE(fecha) BETWEEN :desde AND :hasta
            GROUP BY DATE(fecha)
            ORDER BY dia ASC
        ");
        $ingresosDia->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $ingresosDia = $ingresosDia->fetchAll(PDO::FETCH_ASSOC);

        // ── Métodos de pago ───────────────────────────────────────────────
        $metodosPago = $db->prepare("
            SELECT f.metodopago,
                   COUNT(*)                    AS cantidad,
                   COALESCE(SUM(f.totalfactura), 0) AS total
            FROM factura f
            JOIN pedido p ON f.idpedido = p.idpedido
            WHERE DATE(f.fecha) BETWEEN :desde AND :hasta
            GROUP BY f.metodopago
            ORDER BY total DESC
        ");
        $metodosPago->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $metodosPago = $metodosPago->fetchAll(PDO::FETCH_ASSOC);

        // ── Productos más vendidos ────────────────────────────────────────
        $topProductos = $db->prepare("
            SELECT pr.nombre,
                   SUM(dp.cantidad)                        AS unidades,
                   COALESCE(SUM(dp.total), 0)              AS ingresos
            FROM detalle_pedido dp
            JOIN producto pr ON dp.idproducto = pr.idproducto
            JOIN pedido p    ON dp.idpedido   = p.idpedido
            WHERE p.estado = 'completado'
              AND DATE(p.fecha) BETWEEN :desde AND :hasta
            GROUP BY dp.idproducto, pr.nombre
            ORDER BY unidades DESC
            LIMIT 10
        ");
        $topProductos->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $topProductos = $topProductos->fetchAll(PDO::FETCH_ASSOC);

        // ── Ventas por categoría ──────────────────────────────────────────
        $ventasCat = $db->prepare("
            SELECT c.nombre AS categoria,
                   SUM(dp.cantidad)           AS unidades,
                   COALESCE(SUM(dp.total), 0) AS ingresos
            FROM detalle_pedido dp
            JOIN producto pr ON dp.idproducto  = pr.idproducto
            JOIN catalogo c  ON pr.idcatalogo  = c.idcatalogo
            JOIN pedido p    ON dp.idpedido    = p.idpedido
            WHERE p.estado = 'completado'
              AND DATE(p.fecha) BETWEEN :desde AND :hasta
            GROUP BY c.idcatalogo, c.nombre
            ORDER BY ingresos DESC
        ");
        $ventasCat->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $ventasCat = $ventasCat->fetchAll(PDO::FETCH_ASSOC);

        // ── Rendimiento domiciliarios ─────────────────────────────────────
        $domiciliarios = $db->prepare("
            SELECT pe.nombre,
                   COUNT(e.idenvio)                                              AS entregas,
                   SUM(CASE WHEN p.estado='completado' THEN 1 ELSE 0 END)        AS completadas
            FROM envios e
            JOIN domiciliario d ON e.iddomiciliario = d.iddomiciliario
            JOIN persona pe     ON d.idpersona      = pe.idpersona
            JOIN pedido p       ON e.idpedido       = p.idpedido
            WHERE DATE(p.fecha) BETWEEN :desde AND :hasta
            GROUP BY d.iddomiciliario, pe.nombre
            ORDER BY entregas DESC
        ");
        $domiciliarios->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $domiciliarios = $domiciliarios->fetchAll(PDO::FETCH_ASSOC);

        // ── Insumos en stock crítico ──────────────────────────────────────
        $insumosAlerta = $db->query("
            SELECT nombre, stock_actual, stock_minimo, unidad_medida, categoria
            FROM insumo
            WHERE stock_actual <= stock_minimo
            ORDER BY (stock_actual / NULLIF(stock_minimo, 0)) ASC
        ")->fetchAll(PDO::FETCH_ASSOC);

        // ── Movimientos de inventario recientes ───────────────────────────
        $movInventario = $db->prepare("
            SELECT inv.fecha,
                   ins.nombre   AS insumo,
                   ins.categoria,
                   inv.cantidad,
                   inv.tipo_entrada,
                   inv.tipo_salida,
                   pr.nombre    AS proveedor
            FROM inventario inv
            JOIN insumo ins          ON inv.idinsumo    = ins.idinsumo
            LEFT JOIN proveedor pr   ON inv.idproveedor = pr.idproveedor
            WHERE DATE(inv.fecha) BETWEEN :desde AND :hasta
            ORDER BY inv.fecha DESC
            LIMIT 50
        ");
        $movInventario->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $movInventario = $movInventario->fetchAll(PDO::FETCH_ASSOC);

        // ── CONTABILIDAD ──────────────────────────────────────────────────

        // Ingresos confirmados (pedidos completados)
        $contIngresos = $db->prepare("
            SELECT
                COALESCE(SUM(total), 0)  AS total_ingresos,
                COUNT(*)                 AS num_pedidos
            FROM pedido
            WHERE estado = 'completado'
              AND DATE(fecha) BETWEEN :desde AND :hasta
        ");
        $contIngresos->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $contIngresos = $contIngresos->fetch(PDO::FETCH_ASSOC);

        // Gastos registrados (entradas de inventario con proveedor = compras)
        $contGastos = $db->prepare("
            SELECT
                COALESCE(SUM(inv.cantidad), 0) AS unidades_compradas,
                COUNT(*)                        AS num_movimientos
            FROM inventario inv
            WHERE inv.tipo_entrada = 1
              AND DATE(inv.fecha) BETWEEN :desde AND :hasta
        ");
        $contGastos->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $contGastos = $contGastos->fetch(PDO::FETCH_ASSOC);

        // Ingresos por mes (últimos 6 meses) para gráfico de tendencia
        $tendenciaMensual = $db->query("
            SELECT
                DATE_FORMAT(MIN(fecha), '%Y-%m') AS mes,
                DATE_FORMAT(MIN(fecha), '%b %Y') AS mes_label,
                COALESCE(SUM(total), 0)          AS ingresos,
                COUNT(*)                         AS pedidos
            FROM pedido
            WHERE estado = 'completado'
              AND fecha >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(fecha, '%Y-%m')
            ORDER BY mes ASC
        ")->fetchAll(PDO::FETCH_ASSOC);

        // Resumen contable por método de pago (facturas)
        $contMetodos = $db->prepare("
            SELECT
                f.metodopago,
                COUNT(*)                         AS transacciones,
                COALESCE(SUM(f.totalfactura), 0) AS monto
            FROM factura f
            JOIN pedido p ON f.idpedido = p.idpedido
            WHERE DATE(f.fecha) BETWEEN :desde AND :hasta
            GROUP BY f.metodopago
            ORDER BY monto DESC
        ");
        $contMetodos->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $contMetodos = $contMetodos->fetchAll(PDO::FETCH_ASSOC);

        // Ganancia estimada = ingresos completados - costo domicilios ($2000 c/u)
        $costoEnvios = $db->prepare("
            SELECT COUNT(*) AS total_envios
            FROM envios e
            JOIN pedido p ON e.idpedido = p.idpedido
            WHERE p.estado = 'completado'
              AND DATE(p.fecha) BETWEEN :desde AND :hasta
        ");
        $costoEnvios->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $costoEnvios    = (int)$costoEnvios->fetchColumn();
        $gastoEnvios    = $costoEnvios * 2000;
        $gananciaEstim  = $contIngresos['total_ingresos'] - $gastoEnvios;

        // Notificaciones no leídas del admin actual
        $idpersonaAdmin = getUserId();
        $notificaciones = $db->prepare("
            SELECT idnotificacion, mensaje, fecha, idinsumo
            FROM notificacion
            WHERE idpersona = :idp
              AND tipo_stock_minimo = 1
            ORDER BY fecha DESC
            LIMIT 20
        ");
        $notificaciones->execute([':idp' => $idpersonaAdmin]);
        $notificaciones = $notificaciones->fetchAll(PDO::FETCH_ASSOC);

        include '../views/dashboard/admin/reportes.php';
    }

    public static function catalogo()
    {
        requireRole('administrador');

        $database = new Database();
        $db = $database->conectar();
        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre'])) {
            $db->prepare("INSERT INTO catalogo (nombre, descripcion, estado) VALUES (:n,:d,'activo')")
               ->execute([':n' => trim($_POST['nombre']), ':d' => trim($_POST['descripcion'] ?? '')]);
            $mensaje = 'Categoría agregada.';
        }

        if (isset($_GET['toggle'])) {
            $db->prepare("UPDATE catalogo SET estado = CASE WHEN estado='activo' THEN 'inactivo' ELSE 'activo' END WHERE idcatalogo=:id")
               ->execute([':id' => (int)$_GET['toggle']]);
            redirect('index.php?page=admin_catalogo');
        }

        if (isset($_GET['eliminar'])) {
            $db->prepare("DELETE FROM catalogo WHERE idcatalogo=:id")->execute([':id' => (int)$_GET['eliminar']]);
            redirect('index.php?page=admin_catalogo');
        }

        $categorias = $db->query("
            SELECT c.*, COUNT(p.idproducto) AS total_productos
            FROM catalogo c
            LEFT JOIN producto p ON c.idcatalogo = p.idcatalogo
            GROUP BY c.idcatalogo
            ORDER BY c.nombre
        ")->fetchAll(PDO::FETCH_ASSOC);

        include '../views/dashboard/admin/catalogo.php';
    }
}
