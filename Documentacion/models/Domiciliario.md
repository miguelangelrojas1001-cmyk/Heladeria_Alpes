# models/Domiciliario.php

## Descripción General

Modelo que gestiona la **asignación automática de domiciliarios** a pedidos. Implementa un algoritmo de balanceo de carga que asigna cada pedido al domiciliario con menos pedidos activos.

## Ubicación

```
models/Domiciliario.php
```

## Dependencias

- `config/database.php` — conexión PDO

## Métodos

### `asignarPedido($idpedido, $idcliente, $iddireccion, $telefono)`

| Parámetro | Tipo | Descripción |
|---|---|---|
| `$idpedido` | int | ID del pedido a asignar |
| `$idcliente` | int | ID del cliente |
| `$iddireccion` | int\|null | ID de la dirección de entrega |
| `$telefono` | string\|null | Teléfono de contacto |
| **Retorna** | `int\|null` | ID del domiciliario asignado o `null` |

**Flujo:**
```
1. Verifica si el pedido ya tiene envío → si existe, retorna null (no duplica)
2. Consulta el domiciliario con menos pedidos activos:
   SELECT d.iddomiciliario, COUNT(e.idenvio) AS pedidos_activos
   FROM domiciliario d LEFT JOIN envios e ...
   ORDER BY pedidos_activos ASC LIMIT 1
3. Si no hay domiciliarios → retorna null
4. Obtiene el primer administrador disponible
5. Inserta en tabla envios con estado 'pendiente'
6. Retorna el iddomiciliario asignado
```

**Algoritmo de balanceo:**
El domiciliario con **menos pedidos en estado `pendiente` o `en proceso`** recibe el nuevo pedido. Esto distribuye la carga equitativamente.

---

### `asignarOActualizar($idpedido)`

| Parámetro | Tipo | Descripción |
|---|---|---|
| `$idpedido` | int | ID del pedido |
| **Retorna** | `void` | — |

**Usado cuando**: El administrador cambia el estado de un pedido a `pendiente` o `en proceso` desde el panel de Ventas.

**Flujo:**
```
1. Obtiene el idcliente del pedido
2. Verifica si ya tiene envío asignado:
   - Si SÍ → solo actualiza estado del envío a 'pendiente'
   - Si NO → busca la última dirección registrada y llama a asignarPedido()
```

## Tablas SQL Involucradas

| Tabla | Operación | Descripción |
|---|---|---|
| `envios` | SELECT, INSERT, UPDATE | Asignaciones de domiciliarios |
| `domiciliario` | SELECT | Lista de domiciliarios |
| `pedido` | SELECT | Datos del pedido |
| `administrador` | SELECT | Primer administrador disponible |
| `direccion` | SELECT | Última dirección registrada |

## Cuándo se Llama

1. **Al confirmar un pedido** (`CheckoutController::confirmar()`) — asigna automáticamente
2. **Al cambiar estado en Ventas** (`AdminController::ventas()`) — cuando estado es `pendiente` o `en proceso`

## Posibles Fallos

- **Sin domiciliarios registrados**: Retorna `null` silenciosamente. El pedido queda sin asignar.
- **Dirección incorrecta**: `asignarOActualizar()` toma la última dirección de la tabla `direccion`, que puede no corresponder al pedido actual.
- **Errores silenciados**: En `CheckoutController` y `AdminController` los errores de asignación están en bloques `try/catch` que los silencian para no interrumpir el flujo principal.
