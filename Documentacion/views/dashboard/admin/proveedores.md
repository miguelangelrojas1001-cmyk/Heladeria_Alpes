# proveedores.php

## Descripción General
Vista del panel de administración para gestionar los proveedores de insumos de la heladería. Presenta un formulario para registrar nuevos proveedores y una tabla con los proveedores existentes, con opción de eliminar cada uno.

## Ubicación
`views/dashboard/admin/proveedores.php`

## Estado
✅ Implementada y funcional (renderiza datos reales desde `AdminController`).

## Dependencias
- No incluye archivos PHP directamente.
- Es incluida por `AdminController.php` con la página `admin_proveedores`.
- Requiere que las variables `$proveedores` y `$mensaje` estén definidas antes de incluirla.

## Métodos / Funcionalidades

Este archivo es una vista pura. Sus secciones son:

| Sección | Descripción |
|---|---|
| Estilos CSS inline | Define estilos para `.grid-2`, `.card`, `.btn`, `.btn-primary`, `.btn-danger`, tabla y alerta de éxito. |
| Cabecera | Título "🚚 Proveedores" y subtítulo descriptivo. |
| Alerta de éxito | Muestra `$mensaje` en un bloque verde si está definido y no vacío. |
| Formulario "Nuevo Proveedor" | POST a `index.php?page=admin_proveedores`. Campos: `nombre` (requerido), `telefono` (opcional), `correo` (tipo email, opcional). |
| Tabla de proveedores | Itera `$proveedores`. Columnas: Nombre, Teléfono, Correo, Acciones. |
| Acción Eliminar | Enlace GET a `?page=admin_proveedores&eliminar={idproveedor}` con confirmación JS. |

## Variables Recibidas / Pasadas

| Variable | Tipo | Descripción |
|---|---|---|
| `$proveedores` | `array` | Lista de proveedores. Cada elemento: `idproveedor`, `nombre`, `telefono`, `correo`. |
| `$mensaje` | `string\|null` | Mensaje de éxito a mostrar en la alerta verde. |

## Interacción con la BD
No directa. Las operaciones se realizan a través del controlador que incluye esta vista. La tabla involucrada es:
- `proveedor` — tabla de proveedores (campos: `idproveedor`, `nombre`, `telefono`, `correo`).

## Posibles Fallos
- Si `$proveedores` no está definida, el `foreach` lanza un error de variable indefinida.
- La eliminación se hace vía GET (`&eliminar=`), vulnerable a CSRF.
- No hay formulario de edición; para modificar un proveedor habría que eliminarlo y recrearlo.
- El campo `telefono` es `type="text"`, sin validación de formato numérico en el cliente.
- No hay paginación; con muchos proveedores la tabla puede crecer sin límite.
- Los campos `telefono` y `correo` se muestran como `'-'` si son `null`, pero si la BD devuelve cadena vacía `''`, se mostrará vacío en lugar del guion.
