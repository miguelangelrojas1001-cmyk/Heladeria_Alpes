<?php

require_once '../config/session.php';

class ProductoController
{
    public static function index()
    {
        requireRole('administrador');
        include '../views/dashboard/admin/productos.php';
    }

    public static function crear()
    {
        requireRole('administrador');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Luego conectamos con modelo Producto
            header('Location: index.php?page=admin_productos');
            exit();
        }

        include '../views/dashboard/admin/productos.php';
    }

    public static function editar()
    {
        requireRole('administrador');

        $idproducto = $_GET['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Luego conectamos con modelo Producto
            header('Location: index.php?page=admin_productos');
            exit();
        }

        include '../views/dashboard/admin/productos.php';
    }

    public static function eliminar()
    {
        requireRole('administrador');

        $idproducto = $_GET['id'] ?? null;

        // Luego conectamos con modelo Producto
        header('Location: index.php?page=admin_productos');
        exit();
    }
}