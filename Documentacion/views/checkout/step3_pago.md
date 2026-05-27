# views/checkout/step3_pago.php

## Descripción General
Vista del Paso 3 del proceso de compra. Muestra el resumen del pedido y permite seleccionar el método de pago.

## Ubicación
`views/checkout/step3_pago.php`

## Variables de Sesión Usadas
| Variable | Descripción |
|---|---|
| `$_SESSION['checkout_modo']` | `'individual'` o `'carrito'` |
| `$_SESSION['checkout_orden']` | Datos del producto individual |
| `$_SESSION['carrito']` | Items del carrito (modo carrito) |
| `$_SESSION['checkout_carrito_snapshot']` | Backup del carrito |
| `$_SESSION['checkout_error']` | Error del intento anterior |

## Cálculo del Total
```php
$domicilio = 2000; // siempre $2.000
if ($modo === 'carrito') {
    $subtotal = sum(precio * cantidad para cada item);
} else {
    $subtotal = precio_unitario * cantidad;
}
$total = $subtotal + $domicilio;
```

## Métodos de Pago Disponibles
| Método | Value | Descripción |
|---|---|---|
| Nequi | `nequi` | Billetera virtual |
| Daviplata | `daviplata` | Billetera Davivienda |
| Tarjeta | `tarjeta` | Crédito/débito Visa, Mastercard, Amex |

> ⚠️ El pago en efectivo (contraentrega) fue eliminado del sistema.

## JavaScript
```javascript
function selectPago(lbl, val) {
    // Marca la opción seleccionada visualmente
    // Habilita el botón "Confirmar y pagar"
}
```

## Posibles Fallos
- El botón "Confirmar y pagar" está deshabilitado hasta seleccionar método. Si JavaScript falla, el usuario no puede pagar.
- No hay integración real de pagos — solo se registra el método seleccionado.
