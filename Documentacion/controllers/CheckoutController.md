# controllers/CheckoutController.php

## Descripción General

Controlador del proceso de compra de 4 pasos. Maneja dos modos: **individual** (un producto con personalización) y **carrito** (múltiples productos). Gestiona la creación de pedidos, facturas y asignación de domiciliarios.

## Ubicación

```
controllers/CheckoutController.php
```

## Dependencias

- `config/session.php`
- `models/Producto.php`
- `config/database.php`
- `models/Domiciliario.php` (en `confirmar()`)

## Los 4 Pasos

| Paso | Ruta | Método GET | Método POST |
|---|---|---|---|
| 1 | `checkout_opciones` | `opciones()` | `guardarOpciones()` |
| 2 | `checkout_entrega` | `entrega()` | `guardarEntrega()` |
| 3 | `checkout_pago` | `pago()` | `confirmar()` |
| 4 | `checkout_factura` | `factura()` | — |

## Variables de Sesión

| Variable | Descripción |
|---|---|
| `$_SESSION['checkout_modo']` | `'individual'` o `'carrito'` |
| `$_SESSION['checkout_orden']` | Datos del producto individual personalizado |
| `$_SESSION['checkout_entrega']` | Datos de entrega (destinatario, dirección, ciudad, etc.) |
| `$_SESSION['checkout_carrito_snapshot']` | Copia del carrito para no perderlo |
| `$_SESSION['ultima_factura']` | ID de la factura generada |
| `$_SESSION['ultimo_pedido']` | ID del pedido generado |
| `$_SESSION['checkout_error']` | Mensaje de error entre pasos |
| `$_SESSION['carrito_msg']` | Mensaje de confirmación al agregar al carrito |

## Detección de Categorías en `guardarOpciones()`

```php
$esYogurt          = str_contains($nombreCat, 'yogurt')
$esEnsalada        = str_contains($nombreCat, 'ensalada')
$esMalteada        = str_contains($nombreCat, 'malteada')
$esCanasta         = str_contains($nombreCat, 'canasta')
$esWaffle          = str_contains($nombreCat, 'waffle')
$esMalteadaSencilla = $esMalteada && str_contains($nombreProd, 'sencilla')
$esWaffleArmar     = $esWaffle && (str_contains($nombreProd, 'entero') || str_contains($nombreProd, 'medio'))
```

## Cálculo de Precios

| Categoría | Lógica de precio |
|---|---|
| Yogurt normal | `precioBase + (toppings × $2.500/$3.000)` |
| Moon Ice | `precioBase + (premium × $1.000)` |
| Malteada Sencilla | Fijo `$13.000` |
| Malteada Especial | Precio del producto |
| Ensalada | Precio del selector (Mini/Especial/Super) |
| Canasta | Precio del producto o selector |
| Waffle Entero/Medio | `precioBase + (premium × $1.500) + (yogurt × $1.000) + (extra × $4.000)` |
| Domicilio | Siempre `$2.000` adicional |

## Flujo de `confirmar()` — Modo Individual

```
1. Validar sesión y método de pago
2. Obtener/crear idcliente
3. INSERT direccion
4. INSERT pedido (estado='pendiente')
5. INSERT detalle_pedido
6. INSERT factura
7. INSERT detalle_factura
8. Producto::descontarInsumos()
9. Domiciliario::asignarPedido() [en try/catch]
10. Guardar ultima_factura y ultimo_pedido en sesión
11. redirect(checkout_factura)
```

## Flujo de `confirmar()` — Modo Carrito

Igual que individual pero itera sobre todos los items del carrito, insertando un `detalle_pedido` y `detalle_factura` por cada producto.

## Posibles Fallos

- **Sesión perdida entre pasos**: Si el usuario cierra el navegador entre pasos, pierde el checkout. No hay persistencia en BD hasta `confirmar()`.
- **Precio del formulario**: En ensaladas y canastas el precio viene del POST (`precio_ensalada`, `precio_canasta`). Un usuario malicioso podría manipularlo. **Recomendación**: validar que el precio recibido corresponda a una opción válida.
- **Carrito con claves complejas**: Las claves del carrito son `{idproducto}_{md5(sabores+tamano+obs)}`. Si el mismo producto se agrega dos veces con los mismos toppings, se suma la cantidad en lugar de crear un item nuevo.
