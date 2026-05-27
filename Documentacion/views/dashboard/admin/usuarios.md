# usuarios.php

## Descripción General
Vista del panel de administración para gestionar los usuarios del sistema. Muestra una tabla con todos los usuarios registrados, permite cambiar el rol de cada uno mediante un select inline, eliminar usuarios y crear nuevos usuarios directamente desde el panel.

## Ubicación
`views/dashboard/admin/usuarios.php`

## Estado
✅ Implementada y funcional (renderiza datos reales desde `AdminController`).

## Dependencias
- No incluye archivos PHP directamente.
- Es incluida por `AdminController.php` con la página `admin_usuarios`.
- Requiere que las variables `$usuarios`, `$roles` y `$mensaje` estén definidas antes de incluirla.

## Métodos / Funcionalidades

Este archivo es una vista pura. Sus secciones son:

| Sección | Descripción |
|---|---|
| Estilos CSS inline | Define estilos para `.usu-table`, `.rol-badge`, `.rol-select`, `.btn-save/del`, `.new-user-card`, `.form-grid` y mensajes. |
| Cabecera | Título "👥 Gestión de Usuarios" y subtítulo. |
| Mensaje de estado | Muestra `$mensaje['texto']` con clase `ok` (verde) o `err` (rojo) según `$mensaje['tipo']`. |
| Tabla de usuarios | Itera `$usuarios`. Columnas: ID, Nombre, Correo, Rol actual (badge), Cambiar rol (select + botón), Acciones. |
| Cambiar rol | Formulario POST inline por fila con `accion=cambiar_rol`, `idpersona` e `idrol`. |
| Eliminar usuario | Botón que llama a `confirmarEliminar(id, nombre)` en JS. Redirige a `?page=admin_usuarios&eliminar={id}`. |
| Formulario "Crear nuevo usuario" | POST a `index.php?page=admin_usuarios` con `accion=crear_usuario`. Campos: `nombre`, `correo`, `contrasena` (minlength=6), `rol` (select). |
| Script JS | Función `confirmarEliminar()` que muestra `confirm()` y redirige vía `window.location.href`. |

## Variables Recibidas / Pasadas

| Variable | Tipo | Descripción |
|---|---|---|
| `$usuarios` | `array` | Lista de usuarios. Cada elemento: `idpersona`, `nombre`, `correo`, `rol`, `idrol`. |
| `$roles` | `array` | Lista de roles disponibles. Cada elemento: `idrol`, `nombre`. |
| `$mensaje` | `array\|null` | Array con `tipo` (`'ok'`/`'err'`) y `texto`. Null si no hay mensaje. |

## Interacción con la BD
No directa. Las tablas involucradas (gestionadas por `AdminController`) son:
- `persona` — tabla de usuarios (campos: `idpersona`, `nombre`, `correo`, `contrasena`).
- `rol` — tabla de roles (campos: `idrol`, `nombre`).
- `persona_rol` o campo `idrol` en `persona` — relación usuario-rol.

## Posibles Fallos
- La eliminación se hace vía GET (`&eliminar=`), vulnerable a CSRF (aunque hay confirmación JS).
- No hay protección para evitar que el administrador activo se elimine a sí mismo.
- La contraseña en el formulario de creación se envía en texto plano por POST; debe hashearse en el controlador (no verificable desde la vista).
- `$mensaje` se usa con `$mensaje['tipo']` y `$mensaje['texto']` sin verificar que sea un array; si es una cadena, lanzará error.
- Los badges de rol usan la clase `rol-{nombre}` dinámicamente; si se agrega un nuevo rol en BD sin agregar su clase CSS, el badge no tendrá estilo.
- `addslashes()` en el atributo `onclick` no es suficiente para escapar nombres con comillas simples en todos los contextos.
