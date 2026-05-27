# UsuarioController.php

## Descripción General
Controlador del módulo de gestión de usuarios del panel de administración. Permite listar usuarios y cambiar su rol. Es un esqueleto sin implementar: ningún método conecta con la base de datos ni con el modelo `Persona`.

## Ubicación
`controllers/UsuarioController.php`

## Estado
⚠️ **Legacy / Sin implementar.** El método `cambiarRol()` recibe el POST pero no procesa los datos. La lógica real de usuarios (listar, cambiar rol, crear, eliminar) está en `AdminController.php`.

## Dependencias
- `config/session.php` — provee `requireRole()` para restringir acceso a administradores.
- `views/dashboard/admin/usuarios.php` — vista del módulo de usuarios.
- Modelo `Persona` (pendiente de integrar, referenciado en comentario).

## Métodos / Funcionalidades

| Método | Acceso | Descripción |
|---|---|---|
| `index()` | Administrador | Verifica rol e incluye la vista de usuarios. No prepara datos. |
| `cambiarRol()` | Administrador | Recibe POST pero no procesa ni guarda el cambio de rol. Redirige a `admin_usuarios`. |

## Variables Recibidas / Pasadas
- `$_POST` esperado en `cambiarRol()`: campos `accion`, `idpersona`, `idrol` (recibidos pero no procesados).
- No se pasan variables a la vista desde este controlador.

## Interacción con la BD
Ninguna. El comentario `// Luego conectamos con modelo Persona` indica integración pendiente.

## Posibles Fallos
- La vista `usuarios.php` espera las variables `$usuarios`, `$roles` y `$mensaje` que este controlador no provee, causando errores de variable indefinida.
- No implementa la acción `crear_usuario` que la vista sí envía vía POST (`name="accion" value="crear_usuario"`).
- No implementa la eliminación de usuarios que la vista dispara vía `$_GET['eliminar']`.
- `cambiarRol()` no valida que `idpersona` e `idrol` sean enteros válidos antes de procesar.
- No hay protección contra cambio de rol del propio administrador activo.
