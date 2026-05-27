# models/Producto.php

## Descripción General

Modelo principal del sistema. Gestiona todas las operaciones relacionadas con productos, catálogos, insumos y el descuento automático de stock al confirmar pedidos.

## Ubicación

```
models/Producto.php
```

## Dependencias

- `config/database.php` — conexión PDO

## Métodos

| Método | Retorna | Descripción |
|---|---|---|
| `obtenerDisponibles()` | `array` | Todos los productos con `disponible = 1` |
| `obtenerPorCatalogo($idcatalogo)` | `array` | Productos de una categoría disponibles |
| `obtenerTodos()` | `array` | Todos los productos con nombre de catálogo (admin) |
| `obtenerCatalogos()` | `array` | Todos los catálogos ordenados por nombre |
| `obtenerInsumos()` | `array` | Todos los insumos ordenados por nombre |
| `obtenerPorId($idproducto)` | `array\|false` | Un producto con su catálogo |
| `obtenerIdClientePorPersona($idpersona)` | `int\|null` | ID del cliente dado su idpersona |
| `obtenerCatalogoPorId($idcatalogo)` | `array\|false` | Datos de un catálogo |
| `crearProducto($datos, $insumos)` | `bool` | Crea producto + relaciones de insumos |
| `actualizarProducto($id, $datos, $insumos)` | `bool` | Actualiza producto + reinsertar insumos |
| `obtenerInsumosPorProducto($idproducto)` | `array` | Insumos de un producto (clave: idinsumo) |
| `descontarInsumos($idproducto, $cantidad)` | `bool` | Descuenta stock al vender |

## Detalle de Métodos Críticos

### `crearProducto($datos, $insumos)`

```php
$datos = [
    'idcatalogo'  => 1,
    'nombre'      => 'Moon Ice',
    'descripcion' => '...',
    'precio'      => 17000,
    'imagen'      => 'img/moonice.jpg',
    'disponible'  => 1
];
$insumos = [3 => 100, 5 => 50]; // [idinsumo => cantidad]
```

Usa transacción: si falla el INSERT de insumos, hace rollback del producto.

### `descontarInsumos($idproducto, $cantidadVendida)`

**Lógica:**
```
1. Obtiene los insumos del producto desde detalle_insumo
2. Para cada insumo:
   cantidadDescontar = insumo.cantidad * cantidadVendida
   UPDATE insumo SET stock_actual = stock_actual - cantidadDescontar
3. Registra el movimiento en tabla inventario (tipo_salida = 1)
```

**Ejemplo**: Si un helado usa 100g de leche y se venden 2 unidades → descuenta 200g.

## Tablas SQL Involucradas

| Tabla | Operaciones |
|---|---|
| `producto` | SELECT, INSERT, UPDATE, DELETE |
| `catalogo` | SELECT |
| `insumo` | SELECT, UPDATE |
| `detalle_insumo` | SELECT, INSERT, DELETE |
| `inventario` | INSERT |
| `cliente` | SELECT |

## Posibles Fallos

- **`descontarInsumos` retorna `false`** si el producto no tiene insumos configurados — no es un error, simplemente no descuenta nada.
- **Stock negativo**: No hay validación de stock mínimo antes de descontar. El stock puede quedar negativo.
- **Transacciones en `crearProducto`**: Si el servidor MySQL no soporta transacciones (MyISAM), el rollback no funciona. Las tablas usan InnoDB, así que está bien.
