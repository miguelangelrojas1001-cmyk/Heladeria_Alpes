<?php

require_once '../config/session.php';
require_once '../config/database.php';

class ClienteController
{
    public static function pedidos()
    {
        requireLogin();

        // Clientes y domiciliarios pueden ver sus pedidos
        $idpersona = getUserId();

        $database = new Database();
        $db = $database->conectar();

        // Obtener idcliente
        $rowCliente = $db->prepare("SELECT idcliente FROM cliente WHERE idpersona = :id LIMIT 1");
        $rowCliente->execute([':id' => $idpersona]);
        $cliente = $rowCliente->fetch(PDO::FETCH_ASSOC);

        $pedidos             = [];
        $detallesPorPedido   = [];
        $facturasPorPedido   = [];

        if ($cliente) {
            $idcliente = $cliente['idcliente'];

            // Todos los pedidos del cliente
            $stmtPed = $db->prepare("
                SELECT * FROM pedido
                WHERE idcliente = :idc
                ORDER BY fecha DESC
            ");
            $stmtPed->execute([':idc' => $idcliente]);
            $pedidos = $stmtPed->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($pedidos)) {
                $ids = implode(',', array_map('intval', array_column($pedidos, 'idpedido')));

                // Detalles de cada pedido con nombre del producto
                $stmtDet = $db->query("
                    SELECT dp.*, p.nombre AS nombre_producto
                    FROM detalle_pedido dp
                    LEFT JOIN producto p ON dp.idproducto = p.idproducto
                    WHERE dp.idpedido IN ($ids)
                ");
                foreach ($stmtDet->fetchAll(PDO::FETCH_ASSOC) as $d) {
                    $detallesPorPedido[$d['idpedido']][] = $d;
                }

                // Facturas de cada pedido
                $stmtFac = $db->query("
                    SELECT * FROM factura
                    WHERE idpedido IN ($ids)
                ");
                foreach ($stmtFac->fetchAll(PDO::FETCH_ASSOC) as $f) {
                    $facturasPorPedido[$f['idpedido']] = $f;
                }
            }
        }

        include '../views/dashboard/cliente/pedidos.php';
    }
}
