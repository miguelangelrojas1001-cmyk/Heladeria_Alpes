# views/dashboard/domiciliario/pedidos.php

## Descripción General
Vista del panel del domiciliario. Muestra estadísticas, pedidos asignados activos e historial de entregas.

## Ubicación
`views/dashboard/domiciliario/pedidos.php`

## Variables Recibidas
| Variable | Descripción |
|---|---|
| `$pedidosAsignados` | Pedidos activos del domiciliario |
| `$pedidosHistorial` | Últimas 50 entregas completadas/canceladas |
| `$detallesPorPedido` | Productos indexados por idpedido |
| `$totalEntregas` | Total histórico de entregas |
| `$totalHoy` | Entregas completadas hoy |

## Estadísticas (3 tarjetas)
- 📦 Pedidos pendientes
- ✅ Entregados hoy
- 📜 Total entregas

## Pestañas
- **🛵 Pedidos asignados**: activos (pendiente/en proceso) — con badge rojo con conteo
- **📜 Historial de entregas**: completados/cancelados

## Tarjeta de Pedido Activo
Expandible, muestra:
1. Dirección destacada con ícono 📍 y teléfono del cliente
2. Info del cliente y datos del pedido
3. Lista de productos con sabores y observaciones
4. Botones de acción:
   - **🛵 Marcar en camino** (solo si está pendiente) → estado `en proceso`
   - **✅ Confirmar entrega** (con confirm()) → estado `completado`

## Comportamiento Especial
- El primer pedido asignado se expande automáticamente al cargar la página
- Los pedidos pendientes tienen borde rojo para destacarlos visualmente

## JavaScript
```javascript
function switchTab(tab, btn)   // Cambia entre pestañas
function togglePedido(uid)     // Expande/colapsa tarjeta
// Auto-expand primer pedido en DOMContentLoaded
```
