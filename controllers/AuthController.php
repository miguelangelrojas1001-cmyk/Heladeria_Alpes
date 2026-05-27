<?php

require_once '../models/Persona.php';
require_once '../config/session.php';

class AuthController
{
    public static function login()
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo     = trim($_POST['correo']     ?? '');
            $contrasena = $_POST['contrasena']      ?? '';

            $usuario = Persona::login($correo, $contrasena);

            if ($usuario) {
                loginUser($usuario);

                if ($usuario['rol'] === 'administrador') {
                    redirect('index.php?page=admin_productos');
                }
                if ($usuario['rol'] === 'domiciliario') {
                    redirect('index.php?page=domiciliario_pedidos');
                }
                redirect('index.php?page=catalogo');
            }

            $error = 'Correo o contraseña incorrectos. Intenta de nuevo.';
        }

        include '../views/auth/login.php';
    }

    public static function register()
    {
        $error   = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre      = trim($_POST['nombre']      ?? '');
            $correo      = trim($_POST['correo']      ?? '');
            $contrasena  = $_POST['contrasena']       ?? '';
            $contrasena2 = $_POST['contrasena2']      ?? '';

            if (empty($nombre) || empty($correo) || empty($contrasena)) {
                $error = 'Todos los campos son obligatorios.';
            } elseif ($contrasena !== $contrasena2) {
                $error = 'Las contraseñas no coinciden.';
            } elseif (strlen($contrasena) < 6) {
                $error = 'La contraseña debe tener al menos 6 caracteres.';
            } else {
                $resultado = Persona::registrar($nombre, $correo, $contrasena, 'cliente');
                if ($resultado) {
                    redirect('index.php?page=login');
                } else {
                    $error = 'El correo ya está registrado. Intenta iniciar sesión.';
                }
            }
        }

        include '../views/auth/register.php';
    }

    public static function logout()
    {
        logoutUser();
    }
}
