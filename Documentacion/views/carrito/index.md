# views/carrito/index.php

## Descripción General
Vista del carrito de compras. Muestra los productos agregados con sus personalizaciones, permite modificar cantidades y proceder al pago.

## Ubicación
`views/carrito/index.php`

## Variables de Sesión Usadas
| Variable | Descripción |
|---|---|
| `$_SESSION['carrito']` | Array de items del carrito |

## Estructura de un Item del Carrito
```php
[
    'idproducto'  => 3,
    'nombre'      => 'Moon Ice',
    'precio'      => 18000,      // precio unitario (base + toppings)
    'precio_base' => 17000,      // precio base del producto
    'sabores'     => 'Arándanos (Premium)',
    'tamano'      => '',
    'cantidad'    => 1,
    'es_yogurt'   => true
]
```

## Funcionalidades
- Mostrar nombre, sabores/toppings y tamaño de cada item
- Controles +/- para cambiar cantidad (submit automático)
- Botón ✕ para eliminar item
- Resumen con subtotal por item y total general
- Botón "Proceder al pago →" → `checkout_entrega&desde=carrito`
- Botón "🗑 Vaciar carrito" con confirmación

## Clave del Carrito
Los items usan claves compuestas: `{idproducto}_{md5(sabores+tamano+obs)}` para productos personalizados, o simplemente `{idproducto}` para productos sin personalización.

## JavaScript
```javascript
function cambiarCantidad(btn, delta) {
    // Modifica el input de cantidad y hace submit del formulario
}
```

## Posibles Fallos
- Si el carrito tiene items con clave compuesta y el usuario actualiza la cantidad, la clave debe coincidir exactamente.
- No hay validación de stock al proceder al pago.
