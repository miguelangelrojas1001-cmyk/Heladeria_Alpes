# views/dashboard/admin/reportes.php

## Descripción General

Vista del módulo de reportes y contabilidad del panel de administración. Presenta los
indicadores de ventas, inventario, rendimiento de domiciliarios y contabilidad del negocio
para un rango de fechas seleccionable. Es la vista más extensa del sistema.

## Ubicación

`views/dashboard/admin/reportes.php`

## Controlador

`AdminController::reportes()` — ruta `index.php?page=admin_reportes`. Restringida a
`requireRole('administrador')`.

## Parámetros de entrada

| Parámetro | Origen | Valor por defecto |
|---|---|---|
| `desde` | `$_GET` | Primer día del mes en curso (`date('Y-m-01')`) |
| `hasta` | `$_GET` | Hoy (`date('Y-m-d')`) |

## Variables recibidas del controlador

| Variable | Contenido |
|---|---|
| `$kpi` | Total de pedidos, ingresos brutos, ingresos completados y cancelados, ticket promedio y conteo de pedidos por estado |
| `$ingresosDia` | Ingresos agrupados por día de los pedidos completados |
| `$metodosPago` | Cantidad y monto de facturas por método de pago |
| `$topProductos` | Diez productos más vendidos por unidades e ingresos |
| `$ventasCat` | Unidades e ingresos agrupados por categoría del catálogo |
| `$domiciliarios` | Entregas totales y completadas por domiciliario |
| `$insumosAlerta` | Insumos cuyo `stock_actual` es menor o igual al `stock_minimo`, ordenados por criticidad |
| `$movInventario` | Últimos 50 movimientos de inventario del periodo, con insumo y proveedor |
| `$contIngresos` | Ingresos y número de pedidos completados del periodo |
| `$contGastos` | Unidades compradas y número de movimientos de entrada |
| `$tendenciaMensual` | Ingresos y pedidos completados de los últimos 6 meses |
| `$contMetodos` | Resumen contable de transacciones y monto por método de pago |
| `$gastoEnvios` | Costo total de domicilios entregados ($2.000 por envío) |
| `$gananciaEstim` | Ingresos completados menos el costo de los domicilios |
| `$notificaciones` | Últimas 20 alertas de stock mínimo dirigidas al administrador |

## Secciones de la vista

1. **Filtro de fechas** — formulario GET con `desde` y `hasta`.
2. **Tarjetas de KPI** — pedidos, ingresos brutos, ingresos completados, ticket promedio.
3. **Ingresos por día** — serie temporal del periodo.
4. **Métodos de pago** — distribución de facturas por método.
5. **Productos más vendidos** — top 10 por unidades.
6. **Ventas por categoría** — unidades e ingresos agrupados por categoría.
7. **Rendimiento de domiciliarios** — entregas asignadas y completadas.
8. **Inventario** — insumos en stock crítico y movimientos recientes.
9. **Contabilidad** — ingresos confirmados, gasto en domicilios, ganancia estimada y
   tendencia de los últimos 6 meses.
10. **Notificaciones** — alertas de stock mínimo pendientes de revisar.

## Cálculos relevantes

```
gananciaEstimada = SUM(pedido.total WHERE estado = 'completado')
                   - (2000 * número de envíos de pedidos completados)
```

## Consideraciones

- Todas las consultas del controlador usan sentencias preparadas con los parámetros
  `:desde` y `:hasta`.
- Si el periodo consultado no tiene movimientos, los indicadores se muestran en cero y las
  tablas quedan vacías; la vista no genera error.
- La vista no realiza consultas propias a la base de datos: recibe todos los datos ya
  preparados por `AdminController::reportes()`.

## Caso de uso y requerimiento asociados

- **CU-21** — Consultar Reportes y Contabilidad
- **REQ 19** — Consultar reportes y contabilidad
- **HU-021** — Consultar reportes y contabilidad
