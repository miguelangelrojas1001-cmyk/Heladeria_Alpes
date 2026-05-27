# controllers/CarritoController.php

## Descripción General

Controlador del carrito de compras. Gestiona agregar, actualizar, eliminar y vaciar productos del carrito almacenado en sesión.

## Ubicación

```
controllers/CarritoController.php
```

## Dependencias

- `config/session.php`
- `models/Producto.php`

## Métodos

| Método | Ruta | HTTP | Descripción |
|---|---|---|---|
| `index()` | `carrito` | GET | Muestra el carrito |
| `agregar()` | `carrito_agregar` | POST | Agrega producto simple al carrito |
| `actualizar()` | `carrito_actualizar` | POST | Cambia cantidad de un item |
| `eliminar()` | `carrito_eliminar` | GET | Elimina un item por clave |
| `vaciar()` | `carrito_vaciar` | GET | Vacía todo el carrito |
| `confirmar()` | `carrito_confirmar` | GET | Descuenta insumos (legacy) |

## Estructura del Carrito en Sesión

```php
$_SESSION['carrito'] = [
    // Clave simple (productos sin personalización)
    '5' => [
        'idproducto' => 5,
        'nombre'     => 'Brownie',
        'precio'     => 11000,
        'cantidad'   => 2
    ],
    // Clave compuesta (productos personalizados desde checkout)
    '3_a1b2c3d4' => [
        'idproducto'     => 3,
        'nombre'         => 'Moon Ice',
        'precio'         => 18000,  // precio base + toppings
        'precio_base'    => 17000,
        'costo_toppings' => 1000,
        'sabores'        => 'Arándanos (Premium)',
        'tamano'         => '',
        'observaciones'  => '',
        'cantidad'       => 1,
        'es_yogurt'      => true
    ]
]
```

## Diferencia entre `agregar()` y el carrito desde `CheckoutController`

| Origen | Clave | Personalización |
|---|---|---|
| `carrito_agregar` (botón directo) | `idproducto` simple | Sin toppings |
| `checkout_opciones` con accion=carrito | `{id}_{md5}` | Con toppings/sabores |

## Posibles Fallos

- **`confirmar()`**: Método legacy que descuenta insumos sin crear pedido en BD. No debería usarse en el flujo actual.
- **Clave duplicada**: Si se agrega el mismo producto simple dos veces, se suma la cantidad. Si se agrega con distintos toppings, crea items separados.
- **Sin validación de stock**: No verifica si hay stock disponible antes de agregar.
