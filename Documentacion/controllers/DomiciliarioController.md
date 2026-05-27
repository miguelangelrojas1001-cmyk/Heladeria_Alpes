# controllers/DomiciliarioController.php

## Descripción General

Controlador del panel del domiciliario. Muestra los pedidos asignados, permite marcarlos como "en camino" o "entregado", y muestra el historial de entregas con estadísticas.

## Ubicación

```
controllers/DomiciliarioController.php
```

## Dependencias

- `config/session.php`
- `config/database.php`

## Métodos

### `pedidos()`

**Ruta**: `?page=domiciliario_pedidos`  
**Requiere**: Rol `domiciliario`

**Flujo:**
```
1. Si es POST → procesar acción (marcar_entregado / marcar_en_camino) → redirect
2. Obtener iddomiciliario del usuario logueado
3. Consultar pedidos activos (pendiente/en proceso) asignados a este domiciliario
4. Consultar historial (completado/cancelado) — últimos 50
5. Calcular estadísticas: total entregas, entregados hoy
6. Cargar detalles de productos de todos los pedidos
7. include views/dashboard/domiciliario/pedidos.php
```

**Acciones POST:**

| `$_POST` | Estado resultante | Descripción |
|---|---|---|
| `marcar_en_camino` | `en proceso` | El domiciliario salió a entregar |
| `marcar_entregado` | `completado` | El pedido fue entregado |

## Variables Pasadas a la Vista

| Variable | Tipo | Descripción |
|---|---|---|
| `$pedidosAsignados` | array | Pedidos activos del domiciliario |
| `$pedidosHistorial` | array | Últimas 50 entregas completadas/canceladas |
| `$detallesPorPedido` | array | Productos indexados por idpedido |
| `$totalEntregas` | int | Total de entregas históricas |
| `$totalHoy` | int | Entregas completadas hoy |

## Query Principal de Pedidos Asignados

```sql
SELECT p.idpedido, p.total, p.fecha, p.estado,
       pe.nombre AS cliente, e.telefono_contacto,
       e.observaciones AS obs_envio,
       d.descripcion AS direccion_completa
FROM envios e
JOIN pedido p    ON e.idpedido    = p.idpedido
JOIN cliente c   ON e.idcliente   = c.idcliente
JOIN persona pe  ON c.idpersona   = pe.idpersona
LEFT JOIN direccion d ON e.iddireccion = d.iddireccion
WHERE e.iddomiciliario = :idd
  AND p.estado IN ('pendiente','en proceso')
ORDER BY p.fecha ASC
```

## Posibles Fallos

- **Sin iddomiciliario**: Si el usuario tiene rol `domiciliario` pero no está en la tabla `domiciliario`, `$domiciliario` será `false` y las listas quedarán vacías sin error visible.
- **Dirección nula**: Si `e.iddireccion` es NULL, `direccion_completa` será NULL. La vista debe manejar este caso.
- **Cambio de estado sin validación**: El domiciliario puede marcar cualquier pedido como entregado sin verificar que realmente le pertenece (solo se valida que sea POST con idpedido).
