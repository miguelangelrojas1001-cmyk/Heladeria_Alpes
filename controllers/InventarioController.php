<?php

require_once '../config/session.php';

class InventarioController
{
    public static function index()
    {
        requireRole('administrador');
        include '../views/dashboard/admin/inventario.php';
    }

    public static function registrarMovimiento()
    {
        requireRole('administrador');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Luego conectamos con modelo Inventario
            header('Location: index.php?page=admin_inventario');
            exit();
        }

        include '../views/dashboard/admin/inventario.php';
    }
}