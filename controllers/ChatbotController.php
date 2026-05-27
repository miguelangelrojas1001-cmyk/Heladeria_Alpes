<?php

require_once '../config/session.php';
require_once '../config/database.php';

class ChatbotController
{
    public static function responder()
    {
        requireLogin();
        header('Content-Type: application/json; charset=utf-8');

        $msg = strtolower(trim($_POST['mensaje'] ?? ''));
        if (empty($msg)) {
            echo json_encode(['respuesta' => 'Escribe tu pregunta y te ayudo.']);
            exit();
        }

        $rol = getUserRole();
        $respuesta = self::procesar($msg, $rol);

        echo json_encode(['respuesta' => $respuesta]);
        exit();
    }

    private static function procesar(string $msg, ?string $rol): string
    {
        // ── Saludos ──────────────────────────────────────────────────────
        if (self::contiene($msg, ['hola','buenas','buenos','hey','saludos','hi'])) {
            $nombre = getUserName() ?? 'amigo';
            return "¡Hola, {$nombre}! Soy el asistente de Los Alpes. ¿En qué te puedo ayudar hoy?";
        }

        // ── Cómo hacer un pedido ─────────────────────────────────────────
        if (self::contiene($msg, ['como hago','como hacer','como pedir','como comprar','como realizo','quiero pedir','quiero comprar','hacer un pedido','realizar un pedido','proceso de compra'])) {
            return "Para hacer un pedido:\n1. Ve al <strong>Catálogo</strong> y elige una categoría\n2. Selecciona el producto que quieres\n3. Personalízalo (sabores, toppings, etc.)\n4. Haz clic en <strong>Agregar al carrito</strong> o <strong>Pedir ahora</strong>\n5. Completa los datos de entrega\n6. Elige el método de pago\n7. ¡Listo! Recibirás tu pedido en 30-45 minutos.";
        }

        // ── Ver estado de pedidos ────────────────────────────────────────
        if (self::contiene($msg, ['ver mis pedidos','estado del pedido','estado de mi pedido','mis pedidos','historial de pedidos','donde esta mi pedido','seguimiento'])) {
            if ($rol === 'cliente') {
                return "Puedes ver el estado de tus pedidos en <strong>Mis Pedidos</strong> en el menú lateral. Ahí verás si están pendientes, en proceso o completados, y podrás imprimir la factura de cada uno.";
            }
        }

        // ── Pedidos (general) ────────────────────────────────────────────
        if (self::contiene($msg, ['pedido','pedidos','orden','compra'])) {
            if ($rol === 'cliente') {
                return "¿Qué necesitas saber sobre pedidos?\n• Para <strong>hacer un pedido</strong>: ve al catálogo y selecciona un producto\n• Para <strong>ver tus pedidos</strong>: haz clic en <strong>Mis Pedidos</strong> en el menú\n• Para <strong>imprimir una factura</strong>: abre el pedido en Mis Pedidos y haz clic en Imprimir";
            }
            if ($rol === 'administrador') {
                return "En <strong>Ventas</strong> puedes ver todos los pedidos, cambiar su estado (pendiente → en proceso → completado) y ver a qué domiciliario están asignados.";
            }
            if ($rol === 'domiciliario') {
                return "En <strong>Pedidos asignados</strong> ves los pedidos que debes entregar. Puedes marcarlos como 'En camino' o 'Entregado'.";
            }
        }

        // ── Carrito ──────────────────────────────────────────────────────
        if (self::contiene($msg, ['carrito','agregar al carrito','añadir al carrito'])) {
            return "Para agregar productos al carrito:\n1. Ve al catálogo y selecciona una categoría\n2. Haz clic en <strong>Personalizar y pedir</strong>\n3. Elige tus opciones y haz clic en <strong>Agregar al carrito</strong>\n4. Sigue agregando más productos\n5. Cuando termines, ve al carrito y haz clic en <strong>Proceder al pago</strong>.";
        }

        // ── Pago ─────────────────────────────────────────────────────────
        if (self::contiene($msg, ['pago','pagar','metodo','nequi','daviplata','tarjeta'])) {
            return "Aceptamos los siguientes métodos de pago:\n• <strong>Nequi</strong>\n• <strong>Daviplata</strong>\n• <strong>Tarjeta crédito/débito</strong> (Visa, Mastercard, Amex)\n\nNo aceptamos pago en efectivo.";
        }

        // ── Domicilio ────────────────────────────────────────────────────
        if (self::contiene($msg, ['domicilio','envio','entrega','despacho','llega','tiempo'])) {
            return "El domicilio tiene un costo de <strong>$2.000</strong> y el tiempo estimado de entrega es de <strong>30 a 45 minutos</strong>. Solo hacemos entregas en <strong>Campoalegre</strong>.";
        }

        // ── Ciudades ─────────────────────────────────────────────────────
        if (self::contiene($msg, ['ciudad','campoalegre','zona','cobertura','donde'])) {
            return "Hacemos entregas únicamente en <strong>Campoalegre</strong>. Si estás en otra ciudad, por ahora no tenemos cobertura.";
        }

        // ── Productos / Categorías ───────────────────────────────────────
        if (self::contiene($msg, ['producto','categoria','menu','catalogo','que tienen','que venden','que hay'])) {
            return "Tenemos estas categorías:\n• <strong>Helado de Yogurt</strong> — bajo en grasa y azúcar\n• <strong>Ensaladas de Frutas</strong> — Mini, Especial, Super Especial\n• <strong>Malteadas</strong> — más de 20 sabores\n• <strong>Canastas</strong> — arma la tuya con toppings\n• <strong>Waffles</strong> — clásicos y especiales\n\nVe al catálogo para ver todos los productos.";
        }

        // ── Waffles ──────────────────────────────────────────────────────
        if (self::contiene($msg, ['waffle','wafle'])) {
            return "Tenemos waffles artesanales belgas:\n• <strong>Waffle Entero</strong> ($23.000) — 4 toppings + helado\n• <strong>Waffle Medio</strong> ($16.000) — 2 toppings + helado\n• Waffles especiales: Oreo, Nutella, Hersheys, Jet, Kinder, Nucita y más\n• Adición bola de helado extra: <strong>$4.000</strong>\n\nTodos incluyen untable y sabor de helado a tu elección.";
        }

        // ── Malteadas ────────────────────────────────────────────────────
        if (self::contiene($msg, ['malteada','malteadas','shake'])) {
            return "Nuestras malteadas:\n• <strong>Malteada Sencilla</strong> — $13.000, elige 1 sabor de 22 opciones\n• <strong>Malteadas especiales</strong>: Baileys, Nutella, Yogurt ($15.000), Kiwi\n\nSabores disponibles: Oreo, Frutos rojos, Chocolate, Arequipe, Chicle, Maracuyá, Tres leches, Unicornio, Lulo, Acid Mix y muchos más.";
        }

        // ── Helado de Yogurt ─────────────────────────────────────────────
        if (self::contiene($msg, ['yogurt','yogur','helado de yogurt','moon ice','ice fit'])) {
            return "Nuestro helado de yogurt es bajo en grasa y azúcar. Algunos productos destacados:\n• <strong>Moon Ice</strong> ($17.000) — base + 4 acompañamientos\n• <strong>Ice Fit</strong> ($18.000) — con arándanos, granola, fresa y nueces\n• <strong>7 Deseos</strong> ($26.000) — 7 acompañamientos\n\nPuedes agregar toppings de frutas ($2.500), premium ($3.000) y salsas.";
        }

        // ── Canastas ─────────────────────────────────────────────────────
        if (self::contiene($msg, ['canasta','canastas'])) {
            return "Las canastas son waffles en forma de canasta con helado y toppings:\n• <strong>Sencilla</strong> — 2 sabores $7.000 / 3 sabores $8.000\n• <strong>Especial</strong> — 4 sabores $12.000 / 5 sabores $14.000\n• <strong>Lasaña</strong> — 4 sabores $19.000\n• <strong>Chocorramo, Oreo, Chicle</strong> — 3 sabores $15.000\n• <strong>Chocolatísima, Fresura</strong> — 3 sabores $19.000";
        }

        // ── Ensaladas ────────────────────────────────────────────────────
        if (self::contiene($msg, ['ensalada','ensaladas','fruta','frutas'])) {
            return "Ensaladas de frutas frescas:\n• <strong>Mini</strong> — 1 sabor de helado, $15.000\n• <strong>Especial</strong> — 2 sabores de helado, $19.000\n• <strong>Super Especial</strong> — 3 sabores de helado, $25.000\n\nTodas incluyen fruta fresca, salsa, galletas y queso doble crema.";
        }

        // ── Toppings ─────────────────────────────────────────────────────
        if (self::contiene($msg, ['topping','toppings','acompañamiento','sabor','sabores'])) {
            return "Los toppings para helado de yogurt tienen estos precios:\n• <strong>Frutas y Dulces</strong>: $2.500 c/u\n• <strong>Premium</strong> (arándanos, nueces, caviares): $3.000 c/u\n• <strong>Salsas</strong>: $2.500 c/u\n• <strong>Salsas Premium Hershey's</strong>: $3.000 c/u\n\nPara waffles los toppings premium cuestan $1.500 c/u.";
        }

        // ── Factura ──────────────────────────────────────────────────────
        if (self::contiene($msg, ['factura','recibo','comprobante','imprimir'])) {
            return "Puedes ver e imprimir tu factura de dos formas:\n1. Al finalizar el pedido, en la pantalla de confirmación\n2. En <strong>Mis Pedidos</strong> → expande cualquier pedido → botón <strong>Imprimir factura</strong>";
        }

        // ── Registro / Login ─────────────────────────────────────────────
        if (self::contiene($msg, ['registrar','registro','cuenta','crear cuenta','contraseña','login','iniciar sesion'])) {
            return "Para crear una cuenta:\n1. Haz clic en <strong>Registrarse</strong>\n2. Ingresa tu nombre, correo y contraseña (mínimo 6 caracteres)\n3. ¡Listo! Ya puedes hacer pedidos\n\nSi ya tienes cuenta, usa <strong>Iniciar sesión</strong>.";
        }

        // ── Admin: productos ─────────────────────────────────────────────
        if ($rol === 'administrador' && self::contiene($msg, ['agregar producto','nuevo producto','crear producto','editar producto'])) {
            return "Para gestionar productos:\n• Ve a <strong>Productos</strong> en el menú\n• Usa el formulario de la izquierda para crear uno nuevo\n• Haz clic en <strong>Editar</strong> en cualquier producto para modificarlo\n• Haz clic en <strong>Eliminar</strong> para borrarlo";
        }

        // ── Admin: inventario ────────────────────────────────────────────
        if ($rol === 'administrador' && self::contiene($msg, ['inventario','insumo','stock','entrada','salida'])) {
            return "En <strong>Inventario</strong> puedes:\n• Agregar nuevos insumos con su stock inicial\n• Registrar entradas y salidas de stock\n• Ver el historial de los últimos 30 movimientos\n• Eliminar insumos (también elimina sus movimientos)";
        }

        // ── Admin: usuarios ──────────────────────────────────────────────
        if ($rol === 'administrador' && self::contiene($msg, ['usuario','usuarios','rol','domiciliario','cliente','administrador'])) {
            return "En <strong>Usuarios</strong> puedes:\n• Ver todos los usuarios registrados\n• Cambiar el rol de cualquier usuario (cliente, domiciliario, administrador)\n• Crear nuevos usuarios con cualquier rol\n• Eliminar usuarios";
        }

        // ── Admin: ventas ────────────────────────────────────────────────
        if ($rol === 'administrador' && self::contiene($msg, ['venta','ventas','ingreso','ingresos','estadistica'])) {
            return "En <strong>Ventas</strong> puedes:\n• Ver el total de pedidos e ingresos\n• Cambiar el estado de cada pedido\n• Al cambiar a 'Pendiente' o 'En proceso', se asigna automáticamente un domiciliario\n• Ver qué domiciliario tiene asignado cada pedido";
        }

        // ── Domiciliario ─────────────────────────────────────────────────
        if ($rol === 'domiciliario' && self::contiene($msg, ['asignado','asignar','entregar','entrega','camino'])) {
            return "En tu panel de <strong>Pedidos asignados</strong>:\n• Ves todos los pedidos que debes entregar con la dirección del cliente\n• Haz clic en <strong>Marcar en camino</strong> cuando salgas\n• Haz clic en <strong>Confirmar entrega</strong> cuando entregues\n• En <strong>Historial</strong> ves todas tus entregas anteriores";
        }

        // ── Precios ──────────────────────────────────────────────────────
        if (self::contiene($msg, ['precio','precios','cuanto','cuánto','costo','vale','valor'])) {
            return "Algunos precios de referencia:\n• Malteada Sencilla: <strong>$13.000</strong>\n• Waffle Entero: <strong>$23.000</strong>\n• Waffle Medio: <strong>$16.000</strong>\n• Ensalada Mini: <strong>$15.000</strong>\n• Ensalada Super Especial: <strong>$25.000</strong>\n• Domicilio: <strong>$2.000</strong>\n\nVe al catálogo para ver todos los precios.";
        }

        // ── Horario ──────────────────────────────────────────────────────
        if (self::contiene($msg, ['horario','hora','abierto','cerrado','atienden','cuando'])) {
            return "Para consultar nuestro horario de atención, contáctanos directamente por nuestras redes sociales o WhatsApp.";
        }

        // ── Ayuda general ────────────────────────────────────────────────
        if (self::contiene($msg, ['ayuda','help','no entiendo','como','cómo','que puedo','que hago'])) {
            return "Puedo ayudarte con:\n• <strong>Hacer un pedido</strong>\n• <strong>Ver mis pedidos</strong>\n• <strong>Métodos de pago</strong>\n• <strong>Información de domicilio</strong>\n• <strong>Productos y precios</strong>\n• <strong>Facturas</strong>\n\n¿Sobre qué quieres saber más?";
        }

        // ── Respuesta por defecto ────────────────────────────────────────
        return "No estoy seguro de cómo ayudarte con eso. Puedes preguntarme sobre:\n• Pedidos y estado de entregas\n• Productos y precios\n• Métodos de pago\n• Domicilio y cobertura\n• Cómo usar el sistema\n\n¿Qué necesitas?";
    }

    private static function contiene(string $texto, array $palabras): bool
    {
        foreach ($palabras as $p) {
            if (str_contains($texto, $p)) return true;
        }
        return false;
    }
}
