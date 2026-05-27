<?php

require_once '../config/session.php';
require_once '../models/Producto.php';

class CarritoController
{
    public static function index()
    {
        requireLogin();
        include '../views/carrito/index.php';
    }

    public static function agregar()
    {
        requireLogin();

        $idproducto = $_POST['idproducto'] ?? null;
        $cantidad   = (int)($_POST['cantidad'] ?? 1);

        if (!$idproducto) { redirect('index.php?page=catalogo'); }

        $productos = Producto::obtenerDisponibles();
        $productoSeleccionado = null;
        foreach ($productos as $p) {
            if ($p['idproducto'] == $idproducto) { $productoSeleccionado = $p; break; }
        }

        if (!$productoSeleccionado) { redirect('index.php?page=catalogo'); }

        if (!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];

        if (isset($_SESSION['carrito'][$idproducto])) {
            $_SESSION['carrito'][$idproducto]['cantidad'] += $cantidad;
        } else {
            $_SESSION['carrito'][$idproducto] = [
                'idproducto' => $productoSeleccionado['idproducto'],
                'nombre'     => $productoSeleccionado['nombre'],
                'precio'     => $productoSeleccionado['precio'],
                'cantidad'   => $cantidad,
            ];
        }

        redirect('index.php?page=carrito');
    }

    public static function actualizar()
    {
        requireLogin();
        $clave    = $_POST['idproducto'] ?? null;
        $cantidad = max(1, (int)($_POST['cantidad'] ?? 1));

        if ($clave && isset($_SESSION['carrito'][$clave])) {
            $_SESSION['carrito'][$clave]['cantidad'] = $cantidad;
        }
        redirect('index.php?page=carrito');
    }

    public static function eliminar()
    {
        requireLogin();
        $clave = $_GET['id'] ?? null;
        if ($clave && isset($_SESSION['carrito'][$clave])) {
            unset($_SESSION['carrito'][$clave]);
        }
        redirect('index.php?page=carrito');
    }

    public static function vaciar()
    {
        requireLogin();
        unset($_SESSION['carrito']);
        redirect('index.php?page=carrito');
    }

    public static function confirmar()
    {
        requireLogin();
        $carrito = $_SESSION['carrito'] ?? [];
        if (!empty($carrito)) {
            foreach ($carrito as $item) {
                Producto::descontarInsumos($item['idproducto'], $item['cantidad']);
            }
            unset($_SESSION['carrito']);
        }
        redirect('index.php?page=catalogo');
    }
}
