# controllers/ClienteController.php

## Descripción General

Controlador del panel del cliente. Carga todos los pedidos del cliente con sus detalles y facturas para mostrarlos en la vista de "Mis Pedidos".

## Ubicación

```
controllers/ClienteController.php
```

## Dependencias

- `config/session.php`
- `config/database.php`

## Métodos

### `pedidos()`

**Ruta**: `?page=cliente_pedidos`  
**Requiere**: Usuario logueado (`requireLogin()`)

**Flujo:**
```
1. Obtener idpersona de la sesión
2. Buscar idcliente en tabla cliente WHERE idpersona = :id
3. Si existe idcliente:
   a. Obtener todos los pedidos ORDER BY fecha DESC
   b. Obtener detalles de todos los pedidos (con nombre del producto)
   c. Obtener facturas de todos los pedidos
4. include views/dashboard/cliente/pedidos.php
```

## Variables Pasadas a la Vista

| Variable | Tipo | Descripción |
|---|---|---|
| `$pedidos` | array | Todos los pedidos del cliente |
| `$detallesPorPedido` | array | `[idpedido => [detalles]]` |
| `$facturasPorPedido` | array | `[idpedido => factura]` |

## Optimización de Queries

Para evitar N+1 queries, carga todos los detalles y facturas en una sola consulta usando `IN`:

```sql
-- Detalles
SELECT dp.*, p.nombre AS nombre_producto
FROM detalle_pedido dp
LEFT JOIN producto p ON dp.idproducto = p.idproducto
WHERE dp.idpedido IN (1, 2, 3, ...)

-- Facturas
SELECT * FROM factura WHERE idpedido IN (1, 2, 3, ...)
```

## Posibles Fallos

- **Cliente sin registro en tabla `cliente`**: Si el usuario se registró pero nunca hizo un pedido, puede que no exista en `cliente`. En ese caso `$pedidos` queda vacío — comportamiento correcto.
- **IDs en IN clause**: Si el cliente tiene muchos pedidos, el `IN (...)` puede ser muy largo. No hay paginación.
