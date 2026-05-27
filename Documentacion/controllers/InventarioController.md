# InventarioController.php

## Descripción General
Controlador del módulo de inventario de insumos del panel de administración. Gestiona la visualización del inventario y el registro de movimientos (entradas/salidas de stock). Actualmente es un esqueleto parcialmente implementado: la lógica de persistencia está pendiente de conectar con el modelo `Inventario`.

## Ubicación
`controllers/InventarioController.php`

## Estado
⚠️ **Parcialmente implementado.** El método `registrarMovimiento()` recibe el POST pero no procesa los datos ni los guarda; simplemente redirige de vuelta a la misma página. La lógica real está en `AdminController.php`, que sí conecta con la BD.

## Dependencias
- `config/session.php` — provee `requireRole()` para restringir acceso a administradores.
- `views/dashboard/admin/inventario.php` — vista del módulo de inventario.
- Modelo `Inventario` (pendiente de integrar, referenciado en comentario).

## Métodos / Funcionalidades

| Método | Acceso | Descripción |
|---|---|---|
| `index()` | Administrador | Verifica rol e incluye la vista de inventario. No prepara datos. |
| `registrarMovimiento()` | Administrador | Recibe POST, pero no procesa ni guarda nada. Redirige a `admin_inventario`. |

## Variables Recibidas / Pasadas
- `$_POST` esperado en `registrarMovimiento()`: datos del movimiento (insumo, cantidad, tipo). No se procesan actualmente.
- No se pasan variables a la vista desde este controlador.

## Interacción con la BD
Ninguna actualmente. El comentario `// Luego conectamos con modelo Inventario` indica integración pendiente.

## Posibles Fallos
- La vista `inventario.php` espera variables `$insumos`, `$movimientos` y `$mensaje` que este controlador no provee, causando errores de variable indefinida (`Undefined variable`).
- `registrarMovimiento()` acepta POST sin validar ni sanitizar ningún campo.
- No hay distinción entre entrada y salida en el método; la lógica de tipo de movimiento no está implementada.
- Doble inclusión de vista en `registrarMovimiento()` (rama POST redirige, pero la rama sin POST incluye la vista sin datos).
