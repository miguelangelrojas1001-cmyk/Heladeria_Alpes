# views/dashboard/cliente/pedidos.php

## Descripción General
Vista del panel del cliente "Mis Pedidos". Muestra pedidos activos e historial con detalles expandibles y opción de imprimir factura.

## Ubicación
`views/dashboard/cliente/pedidos.php`

## Variables Recibidas
| Variable | Descripción |
|---|---|
| `$pedidos` | Todos los pedidos del cliente |
| `$detallesPorPedido` | `[idpedido => [items]]` |
| `$facturasPorPedido` | `[idpedido => factura]` |

## Pestañas
- **🕐 Pedidos activos**: estado `pendiente` o `en proceso`
- **📜 Historial**: estado `completado` o `cancelado`

## Tarjeta de Pedido (expandible)
Al hacer clic en una tarjeta se expande mostrando:
1. Lista de productos con sabores, tamaño y cantidad
2. Factura mini con encabezado azul oscuro
3. Desglose: productos + domicilio + total
4. Botón "🖨 Imprimir factura"

## Badges de Estado
| Estado | Color | Ícono |
|---|---|---|
| pendiente | Amarillo | ⏳ |
| en proceso | Azul | 🔄 |
| completado | Verde | ✅ |
| cancelado | Rojo | ❌ |

## Impresión de Factura
Abre una ventana nueva con el HTML de la factura y llama `window.print()` automáticamente.

## JavaScript
```javascript
function switchTab(tab, btn)    // Cambia entre pestañas
function togglePedido(uid)      // Expande/colapsa tarjeta
function imprimirFactura(facId) // Abre ventana de impresión
```
