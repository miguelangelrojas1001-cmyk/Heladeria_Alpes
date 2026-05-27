# inventario.php

## Descripción General
Vista del panel de administración para gestionar el inventario de insumos de la heladería. Permite agregar nuevos insumos, registrar entradas y salidas de stock, ver el estado actual de cada insumo y consultar los últimos 30 movimientos.

## Ubicación
`views/dashboard/admin/inventario.php`

## Estado
✅ Implementada y funcional (renderiza datos reales desde `AdminController`).

## Dependencias
- No incluye archivos PHP directamente.
- Es incluida por `AdminController.php` con la página `admin_inventario`.
- Requiere que las variables `$insumos`, `$movimientos` y `$mensaje` estén definidas antes de incluirla.

## Métodos / Funcionalidades

Este archivo es una vista pura. Sus secciones son:

| Sección | Descripción |
|---|---|
| Estilos CSS inline | Define estilos para `.grid-2`, `.card`, `.badge-ok/low/out/entrada/salida`, `.btn-success/warning/danger`, tabla y alertas. |
| Cabecera | Título "📋 Inventario de Insumos" y subtítulo. |
| Alerta de mensaje | Muestra `$mensaje['texto']` con estilo verde (`ok`) o rojo (`err`) según `$mensaje['tipo']`. |
| Formulario "Nuevo Insumo" | POST a `index.php?page=admin_inventario` con `accion=agregar_insumo`. Campos: `nombre`, `stock_actual`, `stock_minimo`, `unidad_medida` (select: kg, g, L, ml, unidad). |
| Formulario "Registrar Movimiento" | POST con `accion` dinámica (`entrada` o `salida`). Campos: `idinsumo` (select poblado con `$insumos`), `cantidad`. Dos botones cambian el valor del hidden `accion_mov` vía JS inline. |
| Tabla de insumos | Itera `$insumos`. Columnas: Insumo, Stock actual, Mínimo, Estado (badge), Acciones. |
| Badge de estado | Lógica: `stock_actual <= 0` → "Sin stock" (rojo), `<= stock_minimo` → "Stock bajo" (amarillo), else → "OK" (verde). |
| Acción Eliminar insumo | Enlace GET a `?page=admin_inventario&eliminar_insumo={idinsumo}` con confirmación JS. |
| Tabla de movimientos | Muestra los últimos 30 movimientos. Columnas: Insumo, Tipo (badge entrada/salida), Cantidad, Fecha. |

## Variables Recibidas / Pasadas

| Variable | Tipo | Descripción |
|---|---|---|
| `$insumos` | `array` | Lista de insumos. Cada elemento: `idinsumo`, `nombre`, `stock_actual`, `stock_minimo`, `unidad_medida`. |
| `$movimientos` | `array` | Últimos 30 movimientos. Cada elemento: `insumo_nombre`, `tipo_entrada` (bool), `cantidad`, `fecha`. |
| `$mensaje` | `array\|null` | Array con `tipo` (`'ok'`/`'err'`) y `texto`. Null si no hay mensaje. |

## Interacción con la BD
No directa. Las tablas involucradas (gestionadas por `AdminController`) son:
- `insumo` — tabla de insumos (campos: `idinsumo`, `nombre`, `stock_actual`, `stock_minimo`, `unidad_medida`).
- `movimiento_inventario` — tabla de movimientos (campos: `idinsumo`, `tipo_entrada`, `cantidad`, `fecha`).

## Posibles Fallos
- Si `$insumos` o `$movimientos` no están definidas, los `foreach` lanzan errores de variable indefinida.
- La eliminación de insumos es vía GET, vulnerable a CSRF.
- El cambio de `accion_mov` se hace con `onclick` inline que modifica un `input[type=hidden]`; si JavaScript está deshabilitado, siempre se enviará `entrada`.
- `number_format($ins['stock_actual'], 1)` puede fallar si el valor de BD es `null`.
- La fecha se formatea con `strtotime()` sin validar que no sea `null` o inválida (aunque hay un ternario de protección).
- No hay paginación en la tabla de movimientos; si hay más de 30, el límite es fijo en la consulta del controlador.
