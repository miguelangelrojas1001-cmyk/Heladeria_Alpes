# views/checkout/step4_factura.php

## Descripción General
Vista del Paso 4 (final) del proceso de compra. Muestra la confirmación del pedido y la factura generada. Incluye funcionalidad de impresión que abre una ventana nueva con solo la factura.

## Ubicación
`views/checkout/step4_factura.php`

## Variables de Sesión Usadas
| Variable | Descripción |
|---|---|
| `$_SESSION['checkout_modo']` | `'individual'` o `'carrito'` |
| `$_SESSION['checkout_orden']` | Datos del pedido (incluye metodopago) |
| `$_SESSION['checkout_entrega']` | Datos de entrega |
| `$_SESSION['ultima_factura']` | ID de la factura generada |
| `$_SESSION['ultimo_pedido']` | ID del pedido generado |

## Contenido de la Factura
1. **Encabezado**: Logo Los Alpes, número de pedido y factura, fecha y hora
2. **Productos**: Lista de items con sabores/toppings y subtotales
3. **Entrega**: Destinatario, dirección, ciudad, teléfono
4. **Pago**: Método y estado (Pendiente de pago)
5. **Totales**: Subtotal productos + Domicilio $2.000 = Total

## Impresión
```javascript
function imprimirFactura() {
    var html = document.getElementById('factura-data').innerHTML;
    var win = window.open('', '_blank', 'width=700,height=900');
    win.document.write('<!DOCTYPE html>...' + html + '...');
    win.document.close();
    // window.onload → window.print()
}
```
La factura se imprime en una ventana nueva con estilos propios, sin el sidebar ni el layout.

## Limpieza de Sesión
Después de incluir la vista, `CheckoutController::factura()` limpia:
```php
unset($_SESSION['checkout_orden'], $_SESSION['checkout_entrega'],
      $_SESSION['ultima_factura'], $_SESSION['ultimo_pedido'],
      $_SESSION['checkout_modo'], $_SESSION['checkout_carrito_snapshot']);
```

## Posibles Fallos
- Si el usuario recarga la página después de la factura, `ultima_factura` ya no existe en sesión y es redirigido al catálogo.
- El estado de pago siempre muestra "Pendiente de pago" — no se actualiza automáticamente.
