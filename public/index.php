<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/session.php';

$page = $_GET['page'] ?? 'home';

ob_start();

switch ($page) {

    // Catálogo público
    case 'home':
    case 'catalogo':
        // Domiciliario no tiene acceso al catálogo
        if (isLoggedIn() && getUserRole() === 'domiciliario') {
            header('Location: index.php?page=domiciliario_pedidos'); exit();
        }
        require_once '../controllers/CatalogoController.php';
        CatalogoController::index();
        break;

    case 'productos_catalogo':
        // Domiciliario no tiene acceso al catálogo
        if (isLoggedIn() && getUserRole() === 'domiciliario') {
            header('Location: index.php?page=domiciliario_pedidos'); exit();
        }
        // Redirigir al catálogo con tabs
        $idcat = (int)($_GET['idcatalogo'] ?? 0);
        header('Location: index.php?page=catalogo' . ($idcat ? '&idcatalogo='.$idcat : ''));
        exit();

    // Auth
    case 'login':
        require_once '../controllers/AuthController.php';
        AuthController::login();
        break;

    case 'register':
        require_once '../controllers/AuthController.php';
        AuthController::register();
        break;

    case 'logout':
        require_once '../controllers/AuthController.php';
        AuthController::logout();
        break;

    // ── Checkout 4 pasos ──────────────────────────────────────────────────
    case 'checkout_opciones':
        require_once '../controllers/CheckoutController.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CheckoutController::guardarOpciones();
        } else {
            CheckoutController::opciones();
        }
        break;

    case 'checkout_entrega':
        require_once '../controllers/CheckoutController.php';
        // Si viene desde el carrito, establecer modo carrito
        if (isset($_GET['desde']) && $_GET['desde'] === 'carrito' && !empty($_SESSION['carrito'])) {
            $_SESSION['checkout_modo'] = 'carrito';
            unset($_SESSION['checkout_orden']); // limpiar orden individual si existía
        } elseif (!empty($_SESSION['carrito']) && empty($_SESSION['checkout_orden'])) {
            $_SESSION['checkout_modo'] = 'carrito';
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CheckoutController::guardarEntrega();
        } else {
            CheckoutController::entrega();
        }
        break;

    case 'checkout_pago':
        require_once '../controllers/CheckoutController.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CheckoutController::confirmar();
        } else {
            CheckoutController::pago();
        }
        break;

    case 'checkout_confirmar':
        require_once '../controllers/CheckoutController.php';
        CheckoutController::confirmar();
        break;

    case 'checkout_factura':
        require_once '../controllers/CheckoutController.php';
        CheckoutController::factura();
        break;

    // Carrito clásico (por compatibilidad)
    case 'carrito':
        require_once '../controllers/CarritoController.php';
        CarritoController::index();
        break;

    case 'carrito_agregar':
        require_once '../controllers/CarritoController.php';
        CarritoController::agregar();
        break;

    case 'carrito_actualizar':
        require_once '../controllers/CarritoController.php';
        CarritoController::actualizar();
        break;

    case 'carrito_confirmar':
        require_once '../controllers/CarritoController.php';
        CarritoController::confirmar();
        break;

    case 'carrito_eliminar':
        require_once '../controllers/CarritoController.php';
        CarritoController::eliminar();
        break;

    case 'carrito_vaciar':
        require_once '../controllers/CarritoController.php';
        CarritoController::vaciar();
        break;

    // Admin
    case 'admin_productos':
        require_once '../controllers/AdminController.php';
        AdminController::productos();
        break;

    case 'admin_inventario':
        require_once '../controllers/AdminController.php';
        AdminController::inventario();
        break;

    case 'admin_ventas':
        require_once '../controllers/AdminController.php';
        AdminController::ventas();
        break;

    case 'admin_proveedores':
        require_once '../controllers/AdminController.php';
        AdminController::proveedores();
        break;

    case 'admin_catalogo':
        require_once '../controllers/AdminController.php';
        AdminController::catalogo();
        break;

    case 'admin_usuarios':
        require_once '../controllers/AdminController.php';
        AdminController::usuarios();
        break;

    case 'admin_reportes':
        require_once '../controllers/AdminController.php';
        AdminController::reportes();
        break;

    // Domiciliario
    case 'domiciliario_pedidos':
        require_once '../controllers/DomiciliarioController.php';
        DomiciliarioController::pedidos();
        break;

    // Chatbot
    case 'chatbot_responder':
        require_once '../controllers/ChatbotController.php';
        ChatbotController::responder();
        break;

    // Cliente
    case 'cliente_pedidos':
    case 'cliente_pedidos_activos':
        require_once '../controllers/ClienteController.php';
        ClienteController::pedidos();
        break;

    default:
        require_once '../controllers/CatalogoController.php';
        CatalogoController::index();
        break;
}

$content = ob_get_clean();

// Si no hay contenido (redirect ya ocurrió y limpió el buffer), no continuar
if ($content === false || trim($content) === '') {
    exit();
}

// Login y register tienen HTML propio
if (in_array($page, ['login', 'register'])) {
    echo $content;
    exit();
}

require_once '../views/layouts/main.php';
