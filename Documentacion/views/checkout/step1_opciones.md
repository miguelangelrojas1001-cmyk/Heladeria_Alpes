# views/checkout/step1_opciones.php

## Descripción General

Vista del **Paso 1** del proceso de compra. Muestra un formulario de personalización diferente según la categoría del producto. Es el archivo más complejo del sistema de vistas.

## Ubicación

```
views/checkout/step1_opciones.php
```

## Flujos por Categoría

| Condición | Flujo | Descripción |
|---|---|---|
| `$esYogurt` | Toppings | Selector de toppings por categoría con precios |
| `$esYogurt && $esMoonIce` | Moon Ice | Máx. 4 toppings, premium con recargo $1.000 |
| `$esEnsalada` | Ensalada | Primero elige tamaño, luego sabores de helado |
| `$esMalteadaSencilla` | Malteada Sencilla | Elige 1 sabor de 22 opciones, $13.000 fijo |
| `$esMalteadaEspecial` | Malteada Especial | Solo cantidad, precio fijo del producto |
| `$esWaffleArmar` | Waffle Entero/Medio | Untables + toppings + helado + extras |
| `$esWaffleConHelado` | Waffle con helado | Elige sabor(es) de helado + untable opcional |
| `$esWaffleFijo` | Waffle fijo | Solo cantidad (Jamón y Queso, Quesudo, etc.) |
| `$esCanasta` | Canasta | Sabores según producto; Sencilla/Especial con selector |
| `else` | Genérico | Solo cantidad y observaciones |

## Detección de Categorías (PHP)

```php
$cat = strtolower($producto['catalogo'] ?? '');
$np  = strtolower($producto['nombre']   ?? '');

$esYogurt          = str_contains($cat, 'yogurt') || str_contains($cat, 'yogur');
$esEnsalada        = str_contains($cat, 'ensalada');
$esMalteada        = str_contains($cat, 'malteada');
$esCanasta         = str_contains($cat, 'canasta');
$esWaffle          = str_contains($cat, 'waffle');
$esMoonIce         = str_contains($np, 'moon ice');
$esMalteadaSencilla = $esMalteada && str_contains($np, 'sencilla');
$esMalteadaEspecial = $esMalteada && !$esMalteadaSencilla;
$esWaffleArmar     = $esWaffle && (str_contains($np, 'entero') || str_contains($np, 'medio'));
```

## Listas de Opciones

| Lista | Cantidad | Uso |
|---|---|---|
| `$saboresHelado` | 16 | Ensaladas, canastas, flujo genérico |
| `$saboresMalteada` | 22 | Malteada Sencilla |
| `$saboresHeladoWaffle` | 20 | Waffles |
| `$toppingsFrutas` | 12 | Yogurt |
| `$toppingsPremium` | 16 | Yogurt |
| `$toppingsDulces` | 32 | Yogurt |
| `$toppingsSalsas` | 5 | Yogurt |
| `$salsasPremium` | 3 | Yogurt |
| `$untablesWaffle` | 11 | Waffles |
| `$toppingsWaffleGratis` | 33 | Waffles (Entero: 4, Medio: 2) |
| `$toppingsWafflePremium` | 21 | Waffles ($1.500 c/u) |

## Campos Hidden del Formulario

| Campo | Uso |
|---|---|
| `idproducto` | ID del producto |
| `accion` | `'carrito'` o `'pedir'` |
| `precio_ensalada` | Precio dinámico para ensaladas |
| `tamano` | Tamaño seleccionado (ensaladas) |
| `precio_canasta` | Precio dinámico para canastas |
| `precio_malteada` | Siempre `13000` para malteada sencilla |
| `precio_waffle` | Precio base del waffle |

## Botones de Acción

```html
<!-- Agregar al carrito (verde) -->
<button onclick="document.getElementById('accion_form').value='carrito'">
    🛒 Agregar al carrito
</button>

<!-- Pedir ahora (azul) -->
<button onclick="document.getElementById('accion_form').value='pedir'">
    ⚡ Pedir ahora
</button>
```

## JavaScript por Flujo

| Flujo | Funciones JS |
|---|---|
| Yogurt | `tt()`, `ar()`, `cq()`, `contarTodos()` |
| Ensalada | `elegirTamano()`, `ts()`, `cqe()` |
| Malteada Sencilla | `selSaborMalt()`, `cqm()` |
| Waffle Armar | `wToggle()`, `wTogglePremium()`, `wSelHelado()`, `wActualizar()`, `cqw()` |
| Waffle con helado | `whSel()`, `whSelUntable()`, `cqwh()` |
| Canasta con selector | `elegirOpcionCanasta()`, `tsCanasta()` |

## Posibles Fallos

- **Función `cop()` duplicada**: Si se incluye el archivo dos veces, PHP lanzará error de función ya definida. Usar `if (!function_exists('cop'))`.
- **Precio manipulable**: Los precios de ensaladas, canastas y waffles vienen del formulario POST. Validar en el servidor.
- **Waffle Alpes**: Tiene "alpes" en el nombre pero es un waffle con helado de yogurt. La detección `$esWaffleConHelado` lo maneja correctamente.
