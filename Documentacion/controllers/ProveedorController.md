# ProveedorController.php

## Descripción General
Controlador del módulo de proveedores del panel de administración. Define los métodos CRUD (listar, crear, editar, eliminar) para los proveedores de insumos de la heladería. Es un esqueleto sin implementar: ningún método conecta con la base de datos ni con el modelo `Proveedor`.

## Ubicación
`controllers/ProveedorController.php`

## Estado
⚠️ **Legacy / Sin implementar.** Todos los métodos tienen comentarios `// Luego conectamos con modelo Proveedor`. La lógica real de proveedores está en `AdminController.php`.

## Dependencias
- `config/session.php` — provee `requireRole()` para restringir acceso a administradores.
- `views/dashboard/admin/proveedores.php` — vista del módulo de proveedores.
- Modelo `Proveedor` (pendiente de crear e integrar).

## Métodos / Funcionalidades

| Método | Acceso | Descripción |
|---|---|---|
| `index()` | Administrador | Verifica rol e incluye la vista de proveedores. No prepara datos. |
| `crear()` | Administrador | Recibe POST pero no procesa ni guarda. Redirige a `admin_proveedores`. |
| `editar()` | Administrador | Recibe POST pero no procesa ni guarda. Redirige a `admin_proveedores`. |
| `eliminar()` | Administrador | No elimina nada. Redirige a `admin_proveedores`. |

## Variables Recibidas / Pasadas
- `$_POST` esperado en `crear()` y `editar()`: campos `nombre`, `telefono`, `correo` (recibidos pero no procesados).
- No se pasan variables a la vista desde este controlador.

## Interacción con la BD
Ninguna. Toda la lógica de BD está marcada como pendiente en comentarios.

## Posibles Fallos
- La vista `proveedores.php` espera las variables `$proveedores` y `$mensaje` que este controlador no provee, causando errores de variable indefinida.
- `eliminar()` no recibe ni valida el ID del proveedor a eliminar (no lee `$_GET`).
- `editar()` no carga los datos actuales del proveedor para pre-rellenar el formulario.
- No hay validación de formato de correo ni de teléfono en `crear()`.
- No existe modelo `Proveedor.php` en la carpeta `models/`.
