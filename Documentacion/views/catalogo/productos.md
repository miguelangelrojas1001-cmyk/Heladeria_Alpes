# views/catalogo/productos.php

## Descripción General
Vista que muestra los productos de una categoría específica. Detecta el tipo de categoría para mostrar banners informativos y botones de acción apropiados.

## Ubicación
`views/catalogo/productos.php`

## Variables Recibidas
| Variable | Descripción |
|---|---|
| `$productos` | Array de productos disponibles |
| `$catalogo` | Datos de la categoría actual |

## Detección de Categoría
```php
$esYogurt   = str_contains($nombreCat, 'yogurt')
$esEnsalada = str_contains($nombreCat, 'ensalada')
$esPersonalizable = $esYogurt || $esEnsalada || 
                    str_contains($nombreCat, 'malteada') || 
                    str_contains($nombreCat, 'canasta') || 
                    str_contains($nombreCat, 'waffle')
```

## Banners por Categoría
- Yogurt: banner verde con info de toppings
- Ensalada: banner naranja
- Waffle: banner amarillo con info de adición de helado
- Malteada: banner púrpura
- Canasta: banner verde azulado

## Botones de Acción por Rol
| Rol | Botón |
|---|---|
| `administrador` | "Vista previa — modo administrador" (sin acción) |
| `cliente` en categoría personalizable | "🧇/🍦/🍓 Personalizar y pedir" → checkout_opciones |
| `cliente` en categoría normal | "🛒 Agregar al carrito" → carrito_agregar |
| No logueado | "Inicia sesión para pedir" → login |

## Sanidad de Precios
```php
// Si el precio está sin los ceros (ej: 15 en vez de 15000)
if (($esYogurt || $esEnsalada) && $precioVista < 1000 && $precioVista > 0) {
    $precioVista *= 1000;
}
```

## Posibles Fallos
- La sanidad de precios solo aplica a yogurt y ensaladas, no a waffles ni malteadas.
- Si el catálogo no tiene nombre reconocible, no muestra banner informativo.
