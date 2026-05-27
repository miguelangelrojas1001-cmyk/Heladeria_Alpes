<?php

require_once '../config/session.php';

class UsuarioController
{
    public static function index()
    {
        requireRole('administrador');
        include '../views/dashboard/admin/usuarios.php';
    }

    public static function cambiarRol()
    {
        requireRole('administrador');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Luego conectamos con modelo Persona
            header('Location: index.php?page=admin_usuarios');
            exit();
        }

        include '../views/dashboard/admin/usuarios.php';
    }
}