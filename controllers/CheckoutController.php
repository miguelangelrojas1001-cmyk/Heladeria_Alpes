<?php

require_once '../config/session.php';
require_once '../models/Producto.php';
require_once '../config/database.php';

class CheckoutController
{
    public static function opciones()
    {
        requireLogin();

        if (!empty($_SESSION['carrito']) && ($_GET['desde'] ?? '') === 'carrito') {
            redirect('index.php?page=checkout_entrega');
        }

        $idproducto = $_GET['idproducto'] ?? null;
        if (!$idproducto) { redirect('index.php?page=catalogo'); }

        $producto = Producto::obtenerPorId($idproducto);
        if (!$producto) { redirect('index.php?page=catalogo'); }

        include '../views/checkout/step1_opciones.php';
    }

    public static function guardarOpciones()
    {
        requireLogin();

        $idproducto = $_POST['idproducto'] ?? null;
        if (!$idproducto) { redirect('index.php?page=catalogo'); }

        $producto = Producto::obtenerPorId($idproducto);
        if (!$producto) { redirect('index.php?page=catalogo'); }

        $cantidad = max(1, (int)($_POST['cantidad'] ?? 1));
        $obs      = trim($_POST['observaciones'] ?? '');

        $nombreCat       = strtolower($producto['catalogo'] ?? '');
        $nombreProd      = strtolower($producto['nombre']   ?? '');
        $esYogurt        = str_contains($nombreCat, 'yogurt') || str_contains($nombreCat, 'yogur');
        $esEnsalada      = str_contains($nombreCat, 'ensalada');
        $esMalteada      = str_contains($nombreCat, 'malteada');
        $esCanasta       = str_contains($nombreCat, 'canasta');
        $esMalteadaSencilla = $esMalteada && str_contains($nombreProd, 'sencilla');
        $esMalteadaEspecial = $esMalteada && !$esMalteadaSencilla;

        $precioBase = (float)$producto['precio'];
        if ($esYogurt && $precioBase < 1000 && $precioBase > 0) {
            $precioBase *= 1000;
        }

        $costoToppings   = 0;
        $toppingsResumen = [];

        if ($esYogurt) {
            // ── Yogurt (con o sin Moon Ice) ──────────────────────────────────
            $esMoonIce = str_contains($nombreProd, 'moon ice');
            $tFrutas   = $_POST['toppings_frutas']  ?? [];
            $tPremium  = $_POST['toppings_premium'] ?? [];
            $tDulces   = $_POST['toppings_dulces']  ?? [];
            $tSalsas   = $_POST['toppings_salsas']  ?? [];
            $tSalsasP  = $_POST['toppings_salsasp'] ?? [];

            if ($esMoonIce) {
                foreach ($tFrutas  as $t) { $toppingsResumen[] = htmlspecialchars($t); }
                foreach ($tPremium as $t) { $costoToppings += 1000; $toppingsResumen[] = htmlspecialchars($t) . ' (Premium)'; }
                foreach ($tDulces  as $t) { $toppingsResumen[] = htmlspecialchars($t); }
                foreach ($tSalsas  as $t) { $toppingsResumen[] = htmlspecialchars($t); }
                foreach ($tSalsasP as $t) { $costoToppings += 1000; $toppingsResumen[] = htmlspecialchars($t) . ' (Hersheys)'; }
            } else {
                foreach ($tFrutas  as $t) { $costoToppings += 2500; $toppingsResumen[] = htmlspecialchars($t); }
                foreach ($tPremium as $t) { $costoToppings += 3000; $toppingsResumen[] = htmlspecialchars($t) . ' (Premium)'; }
                foreach ($tDulces  as $t) { $costoToppings += 2500; $toppingsResumen[] = htmlspecialchars($t); }
                foreach ($tSalsas  as $t) { $costoToppings += 2500; $toppingsResumen[] = htmlspecialchars($t); }
                foreach ($tSalsasP as $t) { $costoToppings += 3000; $toppingsResumen[] = htmlspecialchars($t) . ' (Hersheys)'; }
            }
            $sabores = implode(', ', $toppingsResumen);
            $tamano  = '';

        } elseif ($esMalteadaSencilla) {
            // ── Malteada Sencilla: 1 sabor, precio fijo $13.000 ─────────────
            $saboresArr = $_POST['sabores'] ?? [];
            $sabores    = implode(', ', array_map('htmlspecialchars', $saboresArr));
            $precioBase = 13000;
            $tamano     = '';

        } elseif ($esMalteadaEspecial) {
            // ── Malteada Especial: sin sabores que elegir, precio del producto
            $sabores = '';
            $tamano  = '';
            // $precioBase ya viene del producto

        } elseif ($esCanasta) {
            // ── Canasta: sabores elegidos, precio del selector o del producto ─
            $saboresArr = $_POST['sabores'] ?? [];
            $sabores    = implode(', ', array_map('htmlspecialchars', $saboresArr));
            $tamano     = '';
            $precioForm = (float)($_POST['precio_canasta'] ?? 0);
            if ($precioForm > 0) {
                $precioBase = $precioForm;
            }
            // Si precio_canasta no vino (canastas con precio fijo), se usa $precioBase del producto

        } elseif ($esEnsalada) {
            // ── Ensalada ─────────────────────────────────────────────────────
            $saboresArr = $_POST['sabores'] ?? [];
            $sabores    = implode(', ', array_map('htmlspecialchars', $saboresArr));
            $tamano     = htmlspecialchars(trim($_POST['tamano'] ?? ''));
            $precioForm = (float)($_POST['precio_ensalada'] ?? $precioBase);
            $precioBase = $precioForm > 0 ? $precioForm : $precioBase;

        } else {
            // ── Genérico ─────────────────────────────────────────────────────
            $saboresArr = $_POST['sabores'] ?? [];
            $sabores    = implode(', ', array_map('htmlspecialchars', $saboresArr));
            $tamano     = $_POST['tamano'] ?? '';
        }

        $precioUnitario = $precioBase + $costoToppings;
        $accion         = $_POST['accion'] ?? 'pedir';

        if ($accion === 'carrito') {
            if (!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];
            $clave = $producto['idproducto'] . '_' . md5($sabores . $tamano . $obs);
            if (isset($_SESSION['carrito'][$clave])) {
                $_SESSION['carrito'][$clave]['cantidad'] += $cantidad;
            } else {
                $_SESSION['carrito'][$clave] = [
                    'idproducto'          => $producto['idproducto'],
                    'nombre'              => $producto['nombre'],
                    'precio'              => $precioUnitario,
                    'precio_base'         => $precioBase,
                    'costo_toppings'      => $costoToppings,
                    'sabores'             => $sabores,
                    'tamano'              => $tamano,
                    'observaciones'       => $obs,
                    'cantidad'            => $cantidad,
                    'es_yogurt'           => $esYogurt,
                    'es_ensalada'         => $esEnsalada,
                    'es_malteada_sencilla'=> $esMalteadaSencilla,
                    'es_malteada_especial'=> $esMalteadaEspecial,
                    'es_canasta'          => $esCanasta,
                ];
            }
            $_SESSION['carrito_msg'] = htmlspecialchars($producto['nombre']) . ' agregado al carrito';
            $idcatalogo = $producto['idcatalogo'] ?? null;
            redirect($idcatalogo
                ? "index.php?page=catalogo&idcatalogo={$idcatalogo}&agregado=1"
                : 'index.php?page=catalogo&agregado=1');
        } else {
            unset($_SESSION['carrito']);
            $_SESSION['checkout_modo']  = 'individual';
            $_SESSION['checkout_orden'] = [
                'idproducto'          => $producto['idproducto'],
                'nombre_producto'     => $producto['nombre'],
                'precio_unitario'     => $precioUnitario,
                'precio_base'         => $precioBase,
                'costo_toppings'      => $costoToppings,
                'costo_domicilio'     => 2000,
                'sabores'             => $sabores,
                'tamano'              => $tamano,
                'cantidad'            => $cantidad,
                'observaciones'       => $obs,
                'es_yogurt'           => $esYogurt,
                'es_ensalada'         => $esEnsalada,
                'es_malteada_sencilla'=> $esMalteadaSencilla,
                'es_malteada_especial'=> $esMalteadaEspecial,
                'es_canasta'          => $esCanasta,
            ];
            redirect('index.php?page=checkout_entrega');
        }
    }

    public static function entrega()
    {
        requireLogin();
        $modo = $_SESSION['checkout_modo'] ?? 'individual';
        if ($modo === 'carrito') {
            if (empty($_SESSION['carrito'])) { redirect('index.php?page=catalogo'); }
        } else {
            if (empty($_SESSION['checkout_orden'])) { redirect('index.php?page=catalogo'); }
        }
        include '../views/checkout/step2_entrega.php';
    }

    public static function guardarEntrega()
    {
        requireLogin();
        $modo = $_SESSION['checkout_modo'] ?? 'individual';
        if ($modo === 'carrito') {
            if (empty($_SESSION['carrito'])) { redirect('index.php?page=carrito'); }
            $_SESSION['checkout_carrito_snapshot'] = $_SESSION['carrito'];
        } else {
            if (empty($_SESSION['checkout_orden'])) { redirect('index.php?page=catalogo'); }
        }
        $_SESSION['checkout_entrega'] = [
            'destinatario'  => trim($_POST['destinatario']  ?? ''),
            'direccion'     => trim($_POST['direccion']      ?? ''),
            'barrio'        => trim($_POST['barrio']         ?? ''),
            'ciudad'        => trim($_POST['ciudad']         ?? ''),
            'telefono'      => trim($_POST['telefono']       ?? ''),
            'instrucciones' => trim($_POST['instrucciones']  ?? ''),
        ];
        redirect('index.php?page=checkout_pago');
    }

    public static function pago()
    {
        requireLogin();
        $modo = $_SESSION['checkout_modo'] ?? 'individual';
        if ($modo === 'carrito') {
            $activo = $_SESSION['carrito'] ?? $_SESSION['checkout_carrito_snapshot'] ?? [];
            if (empty($activo)) { redirect('index.php?page=carrito'); }
            if (empty($_SESSION['carrito']) && !empty($_SESSION['checkout_carrito_snapshot'])) {
                $_SESSION['carrito'] = $_SESSION['checkout_carrito_snapshot'];
            }
        } else {
            if (empty($_SESSION['checkout_orden'])) { redirect('index.php?page=catalogo'); }
        }
        if (empty($_SESSION['checkout_entrega'])) { redirect('index.php?page=checkout_entrega'); }

        $orden   = $_SESSION['checkout_orden'] ?? [];
        $carrito = $_SESSION['carrito'] ?? $_SESSION['checkout_carrito_snapshot'] ?? [];
        $entrega = $_SESSION['checkout_entrega'];
        $error   = $_SESSION['checkout_error'] ?? null;
        unset($_SESSION['checkout_error']);

        $domicilio = 2000;
        if ($modo === 'carrito') {
            $subtotal = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], $carrito));
            $total    = $subtotal + $domicilio;
        } else {
            $subtotal  = ($orden['precio_unitario'] ?? 0) * ($orden['cantidad'] ?? 1);
            $domicilio = (int)($orden['costo_domicilio'] ?? 2000);
            $total     = $subtotal + $domicilio;
        }
        include '../views/checkout/step3_pago.php';
    }

    public static function confirmar()
    {
        requireLogin();
        $modo = $_SESSION['checkout_modo'] ?? 'individual';
        if ($modo === 'carrito') {
            $activo = $_SESSION['carrito'] ?? $_SESSION['checkout_carrito_snapshot'] ?? [];
            if (empty($activo) || empty($_SESSION['checkout_entrega'])) { redirect('index.php?page=carrito'); }
        } else {
            if (empty($_SESSION['checkout_orden']) || empty($_SESSION['checkout_entrega'])) { redirect('index.php?page=catalogo'); }
        }

        $metodopago = $_POST['metodopago'] ?? null;
        if (!$metodopago) {
            $_SESSION['checkout_error'] = 'Debes seleccionar un método de pago.';
            redirect('index.php?page=checkout_pago');
        }

        $entrega  = $_SESSION['checkout_entrega'];
        $database = new Database();
        $db       = $database->conectar();

        try {
            $db->beginTransaction();

            $idpersona = getUserId();
            $idcliente = Producto::obtenerIdClientePorPersona($idpersona);
            if (!$idcliente) {
                $db->prepare("INSERT INTO cliente (idpersona) VALUES (:id)")->execute([':id' => $idpersona]);
                $idcliente = $db->lastInsertId();
            }

            $descDir = $entrega['direccion'] . ', ' . $entrega['barrio'] . ', ' . $entrega['ciudad'];
            $db->prepare("INSERT INTO direccion (descripcion) VALUES (:desc)")->execute([':desc' => $descDir]);
            $iddireccion = (int)$db->lastInsertId();

            if ($modo === 'carrito') {
                $carrito   = $_SESSION['carrito'] ?? $_SESSION['checkout_carrito_snapshot'] ?? [];
                $subtotal  = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], $carrito));
                $total     = $subtotal + 2000;

                $db->prepare("INSERT INTO pedido (idcliente, total, fecha, estado) VALUES (:idc, :total, NOW(), 'pendiente')")
                   ->execute([':idc' => $idcliente, ':total' => $total]);
                $idpedido = $db->lastInsertId();

                $db->prepare("INSERT INTO factura (idpedido, fecha, metodopago, totalfactura) VALUES (:idp, NOW(), :mp, :tot)")
                   ->execute([':idp' => $idpedido, ':mp' => $metodopago, ':tot' => $total]);
                $idfactura = $db->lastInsertId();

                $stmtDet  = $db->prepare("INSERT INTO detalle_pedido (idpedido, idproducto, cantidad, tamano, sabores, observaciones, precio_unitario, total) VALUES (:idp, :idpr, :cant, :tam, :sab, :obs, :pu, :tot)");
                $stmtDFac = $db->prepare("INSERT INTO detalle_factura (idfactura, idproducto, cantidad, precio_unitario, total) VALUES (:idf, :idpr, :cant, :pu, :tot)");

                foreach ($carrito as $item) {
                    $sub = $item['precio'] * $item['cantidad'];
                    $stmtDet->execute([':idp'=>$idpedido,':idpr'=>$item['idproducto'],':cant'=>$item['cantidad'],':tam'=>'',':sab'=>'',':obs'=>'',':pu'=>$item['precio'],':tot'=>$sub]);
                    $stmtDFac->execute([':idf'=>$idfactura,':idpr'=>$item['idproducto'],':cant'=>$item['cantidad'],':pu'=>$item['precio'],':tot'=>$sub]);
                    Producto::descontarInsumos($item['idproducto'], $item['cantidad']);
                }

                $_SESSION['checkout_orden'] = ['metodopago'=>$metodopago,'items'=>$carrito,'total'=>$total];
                unset($_SESSION['carrito']);

            } else {
                $orden     = $_SESSION['checkout_orden'];
                $subtotal  = $orden['precio_unitario'] * $orden['cantidad'];
                $domicilio = (int)($orden['costo_domicilio'] ?? 2000);
                $total     = $subtotal + $domicilio;

                $db->prepare("INSERT INTO pedido (idcliente, total, fecha, estado) VALUES (:idc, :total, NOW(), 'pendiente')")
                   ->execute([':idc' => $idcliente, ':total' => $total]);
                $idpedido = $db->lastInsertId();

                $db->prepare("INSERT INTO detalle_pedido (idpedido, idproducto, cantidad, tamano, sabores, observaciones, precio_unitario, total) VALUES (:idp, :idpr, :cant, :tam, :sab, :obs, :pu, :tot)")
                   ->execute([':idp'=>$idpedido,':idpr'=>$orden['idproducto'],':cant'=>$orden['cantidad'],':tam'=>$orden['tamano'],':sab'=>$orden['sabores'],':obs'=>$orden['observaciones'],':pu'=>$orden['precio_unitario'],':tot'=>$subtotal]);

                $db->prepare("INSERT INTO factura (idpedido, fecha, metodopago, totalfactura) VALUES (:idp, NOW(), :mp, :tot)")
                   ->execute([':idp'=>$idpedido,':mp'=>$metodopago,':tot'=>$total]);
                $idfactura = $db->lastInsertId();

                $db->prepare("INSERT INTO detalle_factura (idfactura, idproducto, cantidad, precio_unitario, total) VALUES (:idf, :idpr, :cant, :pu, :tot)")
                   ->execute([':idf'=>$idfactura,':idpr'=>$orden['idproducto'],':cant'=>$orden['cantidad'],':pu'=>$orden['precio_unitario'],':tot'=>$subtotal]);

                Producto::descontarInsumos($orden['idproducto'], $orden['cantidad']);
                $orden['metodopago'] = $metodopago;
                $_SESSION['checkout_orden'] = $orden;
            }

            // Asignar domiciliario automáticamente (fuera de la transacción principal
            // para que un fallo en la asignación no revierta el pedido ya confirmado)
            $db->commit();

            if (!class_exists('Domiciliario')) {
                require_once __DIR__ . '/../models/Domiciliario.php';
            }
            try {
                Domiciliario::asignarPedido(
                    (int)$idpedido,
                    (int)$idcliente,
                    (int)$iddireccion,
                    $entrega['telefono'] ?? null
                );
            } catch (Exception $eDom) {
                error_log('[Domiciliario] Fallo al asignar pedido ' . $idpedido . ': ' . $eDom->getMessage());
            }

            $_SESSION['ultima_factura'] = $idfactura;
            $_SESSION['ultimo_pedido']  = $idpedido;
            redirect('index.php?page=checkout_factura');

        } catch (Exception $e) {
            $db->rollBack();
            // Log del error real para diagnóstico
            error_log('[Checkout] Error al confirmar pedido: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            $_SESSION['checkout_error'] = 'Ocurrió un error al procesar tu pedido: ' . $e->getMessage();
            redirect('index.php?page=checkout_pago');
        }
    }

    public static function factura()
    {
        requireLogin();
        if (empty($_SESSION['ultima_factura'])) { redirect('index.php?page=catalogo'); }
        include '../views/checkout/step4_factura.php';
        unset($_SESSION['checkout_orden'], $_SESSION['checkout_entrega'],
              $_SESSION['ultima_factura'], $_SESSION['ultimo_pedido'],
              $_SESSION['checkout_modo'], $_SESSION['checkout_carrito_snapshot']);
    }
}
