<?php

require_once '../config/session.php';
require_once '../config/database.php';

class DomiciliarioController
{
    public static function pedidos()
    {
        requireRole('domiciliario');

        $database = new Database();
        $db = $database->conectar();
        $idpersona = getUserId();

        // Procesar acciones POST primero — antes de cargar datos
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idpedido = (int)($_POST['idpedido'] ?? 0);
            if ($idpedido > 0) {
                if (isset($_POST['marcar_entregado'])) {
                    $db->prepare("UPDATE pedido SET estado = 'completado' WHERE idpedido = :id")
                       ->execute([':id' => $idpedido]);
                } elseif (isset($_POST['marcar_en_camino'])) {
                    $db->prepare("UPDATE pedido SET estado = 'en proceso' WHERE idpedido = :id")
                       ->execute([':id' => $idpedido]);
                }
            }
            redirect('index.php?page=domiciliario_pedidos');
        }

        // Obtener iddomiciliario
        $rowDom = $db->prepare("SELECT iddomiciliario FROM domiciliario WHERE idpersona = :id LIMIT 1");
        $rowDom->execute([':id' => $idpersona]);
        $domiciliario = $rowDom->fetch(PDO::FETCH_ASSOC);

        $pedidosAsignados  = [];
        $pedidosHistorial  = [];
        $detallesPorPedido = [];
        $totalEntregas     = 0;
        $totalHoy          = 0;

        if ($domiciliario) {
            $iddomiciliario = (int)$domiciliario['iddomiciliario'];

            $stmtAct = $db->prepare("
                SELECT p.idpedido, p.total, p.fecha, p.estado,
                       pe.nombre AS cliente, pe.correo AS cliente_correo,
                       e.telefono_contacto, e.observaciones AS obs_envio,
                       d.descripcion AS direccion_completa
                FROM envios e
                JOIN pedido p       ON e.idpedido      = p.idpedido
                JOIN cliente c      ON e.idcliente     = c.idcliente
                JOIN persona pe     ON c.idpersona     = pe.idpersona
                LEFT JOIN direccion d ON e.iddireccion = d.iddireccion
                WHERE e.iddomiciliario = :idd
                  AND p.estado IN ('pendiente','en proceso')
                ORDER BY p.fecha ASC
            ");
            $stmtAct->execute([':idd' => $iddomiciliario]);
            $pedidosAsignados = $stmtAct->fetchAll(PDO::FETCH_ASSOC);

            $stmtHist = $db->prepare("
                SELECT p.idpedido, p.total, p.fecha, p.estado,
                       pe.nombre AS cliente,
                       d.descripcion AS direccion_completa
                FROM envios e
                JOIN pedido p       ON e.idpedido      = p.idpedido
                JOIN cliente c      ON e.idcliente     = c.idcliente
                JOIN persona pe     ON c.idpersona     = pe.idpersona
                LEFT JOIN direccion d ON e.iddireccion = d.iddireccion
                WHERE e.iddomiciliario = :idd
                  AND p.estado IN ('completado','cancelado')
                ORDER BY p.fecha DESC
                LIMIT 50
            ");
            $stmtHist->execute([':idd' => $iddomiciliario]);
            $pedidosHistorial = $stmtHist->fetchAll(PDO::FETCH_ASSOC);

            $totalEntregas = count($pedidosHistorial);
            $hoy = date('Y-m-d');
            foreach ($pedidosHistorial as $ph) {
                if ($ph['estado'] === 'completado' && str_starts_with($ph['fecha'] ?? '', $hoy)) {
                    $totalHoy++;
                }
            }

            $todosIds = array_merge(
                array_column($pedidosAsignados, 'idpedido'),
                array_column($pedidosHistorial, 'idpedido')
            );
            if (!empty($todosIds)) {
                $ids = implode(',', array_map('intval', $todosIds));
                $stmtDet = $db->query("
                    SELECT dp.*, pr.nombre AS nombre_producto
                    FROM detalle_pedido dp
                    LEFT JOIN producto pr ON dp.idproducto = pr.idproducto
                    WHERE dp.idpedido IN ($ids)
                ");
                foreach ($stmtDet->fetchAll(PDO::FETCH_ASSOC) as $d) {
                    $detallesPorPedido[$d['idpedido']][] = $d;
                }
            }
        }

        include '../views/dashboard/domiciliario/pedidos.php';
    }
}
