# controllers/CatalogoController.php

## Descripción General

Controlador del catálogo público. Muestra las categorías disponibles y los productos de cada categoría. Accesible para todos los roles excepto domiciliario.

## Ubicación

```
controllers/CatalogoController.php
```

## Dependencias

- `models/Producto.php`

## Métodos

### `index()`

**Ruta**: `?page=catalogo` o `?page=home`

Carga todas las categorías desde la BD y las muestra en grid.

```php
include views/catalogo/index.php
// La vista hace su propia query a la BD para obtener categorías
```

### `productosPorCatalogo()`

**Ruta**: `?page=productos_catalogo&idcatalogo=X`

```
1. Lee $_GET['idcatalogo']
2. Si no existe → redirect(catalogo)
3. Producto::obtenerPorCatalogo($idcatalogo) → solo disponibles
4. Producto::obtenerCatalogoPorId($idcatalogo) → datos del catálogo
5. include views/catalogo/productos.php
```

## Variables Pasadas a la Vista

| Variable | Descripción |
|---|---|
| `$productos` | Array de productos disponibles de la categoría |
| `$catalogo` | Datos del catálogo (nombre, descripción, estado) |

## Detección de Categoría en la Vista

La vista `productos.php` usa el nombre del catálogo para determinar el tipo de botón:

```php
$esYogurt   = str_contains(strtolower($catalogo['nombre']), 'yogurt')
$esEnsalada = str_contains(strtolower($catalogo['nombre']), 'ensalada')
$esPersonalizable = $esYogurt || $esEnsalada || 
                    str_contains($nombreCat, 'malteada') || 
                    str_contains($nombreCat, 'canasta') || 
                    str_contains($nombreCat, 'waffle')
```

## Posibles Fallos

- **`idcatalogo` inválido**: Si se pasa un ID que no existe, `obtenerPorCatalogo()` retorna array vacío y la vista muestra "No hay productos disponibles".
- **Categorías inactivas**: `obtenerPorCatalogo()` no filtra por estado del catálogo, solo por `producto.disponible = 1`.
