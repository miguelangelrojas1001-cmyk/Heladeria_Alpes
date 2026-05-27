<?php

require_once '../config/session.php';

class CompraController
{
    public static function carrito()
    {
        include '../views/compra/carrito.php';
    }

    public static function gestionarPedido()
    {
        requireLogin();
        include '../views/compra/gestionar_pedido.php';
    }

    public static function entrega()
    {
        requireLogin();
        include '../views/compra/entrega.php';
    }

    public static function pago()
    {
        requireLogin();
        include '../views/compra/pago.php';
    }

    public static function factura()
    {
        requireLogin();
        include '../views/compra/factura.php';
    }
}