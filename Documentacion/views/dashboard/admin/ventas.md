# ventas.php

## Descripción General
Vista del panel de administración para el seguimiento de ventas y pedidos. Muestra tres tarjetas de estadísticas (total de pedidos, ingresos totales, ingresos de pedidos completados) y una tabla completa de pedidos con la posibilidad de cambiar el estado de cada uno directamente desde la vista.

## Ubicación
`views/dashboard/admin/ventas.php`

## Estado
✅ Implementada y funcional (renderiza datos reales desde `AdminController`).

## Dependencias
- No incluye archivos PHP directamente.
- Es incluida por `AdminController.php` con la página `admin_ventas`.
- Requiere que las variables `$pedidos` y `$totales` estén definidas antes de incluirla.

## Métodos / Funcionalidades

Este archivo es una vista pura. Sus secciones son:

| Sección | Descripción |
|---|---|
| Estilos CSS inline | Define estilos para `.stats-row`, `.stat-card`, `.badge-pendiente/completado/cancelado/proceso`, `.estado-sel` y tabla. |
| Cabecera | Título "💰 Ventas y Pedidos" y subtítulo. |
| Tarjetas de estadísticas | Tres cards: Total Pedidos (`$totales['total_pedidos']`), Ingresos Totales (`$totales['ingresos_totales']`), Completados (`$totales['ingresos_completados']`). |
| Tabla de pedidos | Itera `$pedidos`. Columnas: #ID, Cliente, Total, Domiciliario, Estado (badge), Fecha, Cambiar estado. |
| Badge de estado | Usa `match()` para asignar clase CSS según estado: `completado`, `cancelado`, `en proceso`, `pendiente` (default). |
| Cambiar estado | Formulario POST inline por fila a `index.php?page=admin_ventas`. Select con opciones: pendiente, en proceso, completado, cancelado. Se envía automáticamente con `onchange="this.form.submit()"`. |
| Domiciliario | Muestra nombre con emoji 🛵 si está asignado, o "Sin asignar" en gris si está vacío. |

## Variables Recibidas / Pasadas

| Variable | Tipo | Descripción |
|---|---|---|
| `$pedidos` | `array` | Lista de pedidos. Cada elemento: `idpedido`, `cliente`, `total`, `domiciliario`, `estado`, `fecha`. |
| `$totales` | `array` | Estadísticas agregadas: `total_pedidos` (int), `ingresos_totales` (float), `ingresos_completados` (float). |

## Interacción con la BD
No directa. Las tablas involucradas (gestionadas por `AdminController`) son:
- `pedido` — tabla principal de pedidos (campos: `idpedido`, `total`, `estado`, `fecha`).
- `persona` — para obtener el nombre del cliente.
- `domiciliario` / `persona` — para obtener el nombre del domiciliario asignado.

## Posibles Fallos
- El cambio de estado se envía automáticamente con `onchange`, sin confirmación del usuario; un clic accidental cambia el estado del pedido.
- No hay protección CSRF en el formulario de cambio de estado.
- `number_format($totales['ingresos_totales'], 0, ',', '.')` puede fallar si el valor es `null` (cuando no hay pedidos).
- `date('d/m/Y H:i', strtotime($p['fecha']))` puede producir resultados incorrectos si `fecha` es `null` (aunque hay ternario de protección con `'-'`).
- El `match()` de estado es estricto; si el valor en BD tiene mayúsculas o espacios extra, caerá en el `default` y mostrará badge amarillo de "pendiente" aunque el estado real sea otro.
- No hay filtros ni búsqueda por fecha, cliente o estado; con muchos pedidos la tabla puede ser difícil de navegar.
