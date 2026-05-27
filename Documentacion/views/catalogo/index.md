# views/catalogo/index.php

## Descripción General
Vista principal del catálogo. Muestra todas las categorías disponibles en un grid de 4 columnas. Cada categoría es un enlace que lleva a sus productos.

## Ubicación
`views/catalogo/index.php`

## Dependencias
- Hace su propia consulta a la BD (no recibe variables del controlador)
- `config/database.php` (cargado con class_exists guard)

## Query SQL
```sql
SELECT * FROM catalogo ORDER BY nombre
```

## Comportamiento
- Muestra todas las categorías sin filtrar por estado
- Cada tarjeta enlaza a `?page=productos_catalogo&idcatalogo={id}`
- Si no hay categorías muestra mensaje "No hay categorías activas"

## Posibles Fallos
- La vista hace su propia conexión a BD directamente, duplicando lógica que debería estar en el controlador.
- No filtra categorías inactivas (estado = 'inactivo').
