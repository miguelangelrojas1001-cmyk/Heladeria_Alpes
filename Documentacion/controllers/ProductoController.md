# ProductoController.php

## Descripción General
Controlador del módulo de productos del panel de administración. Define los métodos CRUD (listar, crear, editar, eliminar) para productos de la heladería. Es un esqueleto sin implementar: ningún método conecta con la base de datos ni con el modelo `Producto`.

## Ubicación
`controllers/ProductoController.php`

## Estado
⚠️ **Legacy / Sin implementar.** Todos los métodos tienen comentarios `// Luego conectamos con modelo Producto`. La lógica real de productos está en `AdminController.php`.

## Dependencias
- `config/session.php` — provee `requireRole()` para restringir acceso a administradores.
- `views/dashboard/admin/productos.php` — vista del módulo de productos.
- Modelo `Producto` (pendiente de integrar).

## Métodos / Funcionalidades

| Método | Acceso | Descripción |
|---|---|---|
| `index()` | Administrador | Verifica rol e incluye la vista de productos. No prepara datos. |
| `crear()` | Administrador | Recibe POST pero no procesa ni guarda. Redirige a `admin_productos`. |
| `editar()` | Administrador | Lee `$_GET['id']`, recibe POST pero no procesa. Redirige a `admin_productos`. |
| `eliminar()` | Administrador | Lee `$_GET['id']` pero no elimina nada. Redirige a `admin_productos`. |

## Variables Recibidas / Pasadas
- `$_GET['id']` — ID del producto a editar o eliminar (leído pero no usado).
- `$_POST` — datos del formulario de creación/edición (recibidos pero no procesados).
- No se pasan variables a la vista desde este controlador.

## Interacción con la BD
Ninguna. Todos los métodos tienen la lógica de BD comentada como pendiente.

## Posibles Fallos
- La vista `productos.php` espera variables `$productos`, `$catalogos`, `$insumos`, `$productoEditar`, `$insumosProducto` y `$mensaje` que este controlador no provee, causando errores de variable indefinida.
- `eliminar()` no valida que el ID exista antes de intentar la operación.
- `crear()` no valida ni sanitiza los campos del formulario (nombre, precio, imagen).
- No hay manejo de subida de archivos (`enctype="multipart/form-data"` en la vista).
- El método `editar()` declara `$idproducto` pero nunca la usa.
