<?php

if (session_status() === PHP_SESSION_NONE) {
    // Configurar sesión antes de iniciarla para evitar pérdida entre páginas
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

// Verificar si hay sesión activa
function isLoggedIn()
{
    return isset($_SESSION['idpersona']);
}

// Obtener datos del usuario
function getUserId()
{
    return $_SESSION['idpersona'] ?? null;
}

function getUserName()
{
    return $_SESSION['nombre'] ?? null;
}

function getUserRole()
{
    return $_SESSION['rol'] ?? null;
}

// Proteger rutas
function requireLogin()
{
    if (!isLoggedIn()) {
        redirect('index.php?page=login');
    }
}

// Validar rol específico — redirige a la página principal del rol
function requireRole($rol)
{
    requireLogin();

    if (getUserRole() !== $rol) {
        $rolActual = getUserRole();
        if ($rolActual === 'administrador') {
            redirect('index.php?page=admin_productos');
        } elseif ($rolActual === 'domiciliario') {
            redirect('index.php?page=domiciliario_pedidos');
        } else {
            redirect('index.php?page=catalogo');
        }
    }
}

// Guardar sesión (LOGIN)
function loginUser($usuario)
{
    $_SESSION['idpersona'] = $usuario['idpersona'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['correo'] = $usuario['correo'];
    $_SESSION['rol'] = $usuario['rol']; // viene de roles.nombre
}

// Cerrar sesión
function logoutUser()
{
    session_unset();
    session_destroy();

    redirect('index.php');
}

// Redirect — limpia el buffer si existe y redirige
function redirect(string $url): void
{
    // Limpiar todos los niveles del output buffer
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    header("Location: $url");
    exit();
}