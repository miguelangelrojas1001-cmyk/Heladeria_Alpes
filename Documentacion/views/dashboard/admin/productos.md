# productos.php

## Descripción General
Vista del panel de administración para gestionar los productos de la heladería. Presenta un formulario dual (crear / editar) en la columna izquierda y una grilla de tarjetas de productos en la columna derecha. Soporta subida de imágenes y asociación de insumos con cantidades por unidad vendida.

## Ubicación
`views/dashboard/admin/productos.php`

## Estado
✅ Implementada y funcional (renderiza datos reales desde `AdminController`).

## Dependencias
- No incluye archivos PHP directamente.
- Es incluida por `AdminController.php` con la página `admin_productos`.
- Requiere que las variables `$productos`, `$catalogos`, `$insumos`, `$productoEditar`, `$insumosProducto` y `$mensaje` estén definidas antes de incluirla.

## Métodos / Funcionalidades

Este archivo es una vista pura. Sus secciones son:

| Sección | Descripción |
|---|---|
| Estilos CSS inline | Define estilos para `.grid-2`, `.prod-grid`, `.prod-card`, `.prod-img`, `.badge-ok/no`, `.btn-edit`, `.btn-del`, `.insumo-row`, `.edit-banner`. |
| Cabecera | Título "📦 Productos" y subtítulo. |
| Alerta de mensaje | Muestra `$mensaje` con estilo verde o rojo según si contiene la palabra `'Error'`. |
| Formulario "Nuevo Producto" | POST con `enctype="multipart/form-data"` a `index.php?page=admin_productos`. Campos: `idcatalogo` (select), `nombre`, `descripcion`, `precio`, `imagen` (file), `disponible` (checkbox). Sección opcional de insumos si `$insumos` no está vacío. |
| Formulario "Editar Producto" | Se muestra cuando `$productoEditar` no es null. Igual al de creación pero con `input[hidden] name="_editar"` y campos pre-rellenados. Los insumos muestran la cantidad actual desde `$insumosProducto`. |
| Grilla de productos | Itera `$productos`. Cada tarjeta muestra: imagen (o emoji 🍦), nombre, categoría, precio, badge disponible/no disponible, botones Editar y Eliminar. |
| Acción Editar | Enlace GET a `?page=admin_productos&editar={idproducto}`. |
| Acción Eliminar | Enlace GET a `?page=admin_productos&eliminar={idproducto}` con confirmación JS. |

## Variables Recibidas / Pasadas

| Variable | Tipo | Descripción |
|---|---|---|
| `$productos` | `array` | Lista de productos. Cada elemento: `idproducto`, `nombre`, `descripcion`, `precio`, `imagen`, `disponible`, `catalogo`, `idcatalogo`. |
| `$catalogos` | `array` | Lista de categorías activas. Cada elemento: `idcatalogo`, `nombre`. |
| `$insumos` | `array` | Lista de insumos disponibles. Cada elemento: `idinsumo`, `nombre`, `stock_actual`, `unidad_medida`. |
| `$productoEditar` | `array\|null` | Datos del producto en edición, o `null` si se está creando. |
| `$insumosProducto` | `array` | Mapa `[idinsumo => cantidad]` de insumos asociados al producto en edición. |
| `$mensaje` | `string\|null` | Mensaje de éxito o error. |

## Interacción con la BD
No directa. Las tablas involucradas (gestionadas por `AdminController`) son:
- `producto` — tabla principal de productos.
- `catalogo` — para el select de categorías.
- `insumo` — para la sección de insumos asociados.
- `producto_insumo` — tabla pivote que relaciona productos con insumos y cantidades.

## Posibles Fallos
- La eliminación y la carga del formulario de edición son vía GET, vulnerables a CSRF.
- La detección de error en `$mensaje` usa `str_contains($mensaje, 'Error')`, lo que puede fallar si el mensaje de error no contiene exactamente esa palabra.
- La imagen se guarda como ruta en BD; si el archivo no se sube correctamente, el campo `imagen` puede quedar vacío o con ruta inválida.
- `$productoEditar` se usa sin verificar que sea un array válido; si el controlador pasa un valor inesperado, puede causar errores de acceso a índice.
- No hay validación de tipo/tamaño de imagen en el lado del cliente.
- `number_format($p['precio'], 0, ',', '.')` puede fallar si `precio` es `null`.
