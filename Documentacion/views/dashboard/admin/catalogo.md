# catalogo.php

## Descripción General
Vista del panel de administración para gestionar las categorías del catálogo de productos. Presenta un formulario para crear nuevas categorías y una tabla con las categorías existentes, permitiendo activar/desactivar y eliminar cada una.

## Ubicación
`views/dashboard/admin/catalogo.php`

## Estado
✅ Implementada y funcional (renderiza datos reales desde `AdminController`).

## Dependencias
- No incluye archivos PHP directamente.
- Es incluida por `AdminController.php` (o el router en `public/index.php`) con la página `admin_catalogo`.
- Requiere que las variables `$categorias` y `$mensaje` estén definidas antes de incluirla.

## Métodos / Funcionalidades

Este archivo es una vista pura. Sus secciones son:

| Sección | Descripción |
|---|---|
| Estilos CSS inline | Define estilos para `.grid-2`, `.card`, `.badge`, `.btn-sm`, `.btn-danger`, `.btn-toggle-on/off`, tabla y alertas. |
| Cabecera | Título "📂 Gestionar Categorías" y subtítulo descriptivo. |
| Alerta de éxito | Muestra `$mensaje` en un bloque verde si está definido y no vacío. |
| Formulario "Nueva Categoría" | POST a `index.php?page=admin_catalogo`. Campos: `nombre` (requerido), `descripcion` (opcional). |
| Tabla de categorías | Itera `$categorias`. Columnas: Nombre, Productos (total), Estado (badge), Acciones. |
| Acción Activar/Desactivar | Enlace GET a `?page=admin_catalogo&toggle={idcatalogo}`. |
| Acción Eliminar | Enlace GET a `?page=admin_catalogo&eliminar={idcatalogo}` con confirmación JS. |

## Variables Recibidas / Pasadas

| Variable | Tipo | Descripción |
|---|---|---|
| `$categorias` | `array` | Lista de categorías. Cada elemento debe tener: `idcatalogo`, `nombre`, `descripcion`, `estado` (`'activo'`/`'inactivo'`), `total_productos`. |
| `$mensaje` | `string\|null` | Mensaje de éxito a mostrar en la alerta verde. |

## Interacción con la BD
No directa. Las operaciones se realizan a través del controlador que incluye esta vista. Las tablas involucradas son:
- `catalogo` — tabla de categorías (campos: `idcatalogo`, `nombre`, `descripcion`, `estado`).
- `producto` — se consulta para obtener `total_productos` por categoría (JOIN o subconsulta).

## Posibles Fallos
- Si `$categorias` no está definida, el `foreach` lanza un error de variable indefinida.
- La eliminación se hace vía GET (`&eliminar=`), lo que permite eliminar categorías con solo visitar una URL (vulnerable a CSRF).
- El toggle de estado también es GET, igualmente vulnerable a CSRF.
- No hay validación de longitud máxima para `nombre` en el formulario HTML.
- El badge de estado usa directamente el valor de BD (`badge-activo` / `badge-inactivo`); si el valor en BD difiere, el estilo no se aplica.
- No hay paginación; con muchas categorías la tabla puede volverse lenta.
