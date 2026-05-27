<?php

require_once '../config/session.php';

class ProveedorController
{
    public static function index()
    {
        requireRole('administrador');
        include '../views/dashboard/admin/proveedores.php';
    }

    public static function crear()
    {
        requireRole('administrador');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Luego conectamos con modelo Proveedor
            header('Location: index.php?page=admin_proveedores');
            exit();
        }

        include '../views/dashboard/admin/proveedores.php';
    }

    public static function editar()
    {
        requireRole('administrador');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Luego conectamos con modelo Proveedor
            header('Location: index.php?page=admin_proveedores');
            exit();
        }

        include '../views/dashboard/admin/proveedores.php';
    }

    public static function eliminar()
    {
        requireRole('administrador');

        // Luego conectamos con modelo Proveedor
        header('Location: index.php?page=admin_proveedores');
        exit();
    }
}