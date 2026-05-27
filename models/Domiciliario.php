<?php

if (!class_exists('Database')) {
    require_once __DIR__ . '/../config/database.php';
}

class Domiciliario
{
    /**
     * Asigna automáticamente un pedido al domiciliario con menos pedidos activos.
     * Si ya tiene un envío asignado, no lo duplica.
     * Acepta una conexión PDO existente para participar en la transacción del checkout.
     * Retorna el iddomiciliario asignado o null si no hay domiciliarios.
     */
    public static function asignarPedido(
        int $idpedido,
        int $idcliente,
        ?int $iddireccion = null,
        ?string $telefono = null,
        ?PDO $dbExterna = null
    ): ?int {
        $db = $dbExterna ?? (new Database())->conectar();

        // Verificar si ya tiene envío asignado
        $existe = $db->prepare("SELECT idenvio FROM envios WHERE idpedido = :id LIMIT 1");
        $existe->execute([':id' => $idpedido]);
        if ($existe->fetch()) {
            error_log("[Domiciliario] Pedido $idpedido ya tiene envío asignado.");
            return null; // ya asignado
        }

        // Buscar el domiciliario con menos pedidos activos (pendiente o en proceso)
        $stmt = $db->query("
            SELECT d.iddomiciliario,
                   COUNT(e.idenvio) AS pedidos_activos
            FROM domiciliario d
            LEFT JOIN envios e ON e.iddomiciliario = d.iddomiciliario
                AND e.idpedido IN (
                    SELECT idpedido FROM pedido
                    WHERE estado IN ('pendiente','en proceso')
                )
            GROUP BY d.iddomiciliario
            ORDER BY pedidos_activos ASC
            LIMIT 1
        ");
        $dom = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dom) {
            error_log("[Domiciliario] No hay domiciliarios registrados en la tabla 'domiciliario'.");
            return null; // no hay domiciliarios registrados
        }

        $iddomiciliario = (int)$dom['iddomiciliario'];
        error_log("[Domiciliario] Domiciliario seleccionado: $iddomiciliario para pedido $idpedido");

        // Obtener idadministrador (el primero disponible, puede ser null)
        $stmtAdm = $db->query("SELECT idadministrador FROM administrador LIMIT 1");
        $adm = $stmtAdm->fetch(PDO::FETCH_ASSOC);
        $idadministrador = $adm ? (int)$adm['idadministrador'] : null;
        error_log("[Domiciliario] idadministrador: " . ($idadministrador ?? 'NULL'));

        // Insertar el envío — idadministrador puede ser NULL si no hay admin registrado
        $stmtEnv = $db->prepare("
            INSERT INTO envios
                (idpedido, idcliente, idadministrador, iddomiciliario, iddireccion, telefono_contacto, estado)
            VALUES
                (:idp, :idc, :ida, :idd, :iddir, :tel, 'pendiente')
        ");
        $stmtEnv->execute([
            ':idp'   => $idpedido,
            ':idc'   => $idcliente,
            ':ida'   => $idadministrador,
            ':idd'   => $iddomiciliario,
            ':iddir' => $iddireccion,
            ':tel'   => $telefono,
        ]);

        error_log("[Domiciliario] Envío insertado correctamente para pedido $idpedido → domiciliario $iddomiciliario");
        return $iddomiciliario;
    }

    /**
     * Reasigna o crea el envío cuando el admin cambia el estado a pendiente/en proceso.
     */
    public static function asignarOActualizar(int $idpedido): void
    {
        $database = new Database();
        $db = $database->conectar();

        // Obtener datos del pedido
        $stmtPed = $db->prepare("SELECT idcliente FROM pedido WHERE idpedido = :id LIMIT 1");
        $stmtPed->execute([':id' => $idpedido]);
        $pedido = $stmtPed->fetch(PDO::FETCH_ASSOC);
        if (!$pedido) return;

        $idcliente = (int)$pedido['idcliente'];

        // Verificar si ya tiene envío asignado
        $stmtEnv = $db->prepare("SELECT idenvio FROM envios WHERE idpedido = :id LIMIT 1");
        $stmtEnv->execute([':id' => $idpedido]);
        $envioExistente = $stmtEnv->fetch(PDO::FETCH_ASSOC);

        if ($envioExistente) {
            // Ya tiene envío — solo actualizar estado
            $db->prepare("UPDATE envios SET estado = 'pendiente' WHERE idpedido = :id")
               ->execute([':id' => $idpedido]);
            return;
        }

        // No tiene envío — obtener la última dirección registrada para este cliente
        $stmtDir = $db->prepare("
            SELECT d.iddireccion
            FROM direccion d
            INNER JOIN pedido p ON p.idcliente = :idc
            ORDER BY d.iddireccion DESC
            LIMIT 1
        ");
        $stmtDir->execute([':idc' => $idcliente]);
        $dir = $stmtDir->fetch(PDO::FETCH_ASSOC);

        // Obtener teléfono del cliente desde persona
        $stmtTel = $db->prepare("
            SELECT pe.correo
            FROM cliente c
            JOIN persona pe ON c.idpersona = pe.idpersona
            WHERE c.idcliente = :id LIMIT 1
        ");
        $stmtTel->execute([':id' => $idcliente]);

        self::asignarPedido(
            $idpedido,
            $idcliente,
            $dir ? (int)$dir['iddireccion'] : null,
            null,
            $db
        );
    }
}
