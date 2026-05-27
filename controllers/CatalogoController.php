<?php

require_once '../models/Producto.php';

class CatalogoController
{
    public static function index()
    {
        include __DIR__ . '/../views/catalogo/index.php';
    }

    public static function productosPorCatalogo()
    {
        $idcatalogo = $_GET['idcatalogo'] ?? null;

        if (!$idcatalogo) {
            header('Location: index.php?page=catalogo');
            exit();
        }

        // El nuevo catálogo usa tabs en index.php, redirigir allí
        header('Location: index.php?page=catalogo&idcatalogo=' . (int)$idcatalogo);
        exit();
    }
}
