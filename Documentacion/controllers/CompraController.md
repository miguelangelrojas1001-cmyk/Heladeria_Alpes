# CompraController.php

## Descripción General
Controlador legacy que agrupa las rutas del flujo de compra (carrito, gestión de pedido, entrega, pago y factura). Cada método simplemente incluye la vista correspondiente sin lógica de negocio ni conexión a base de datos. Actualmente es un esqueleto sin implementar.

## Ubicación
`controllers/CompraController.php`

## Estado
⚠️ **Legacy / Sin implementar.** Todos los métodos se limitan a hacer `include` de vistas que no existen en la ruta indicada (`views/compra/`). No hay validación de datos, ni interacción con modelos, ni manejo de errores.

## Dependencias
- `config/session.php` — provee `requireLogin()` para proteger rutas autenticadas.
- `views/compra/carrito.php` — vista del carrito (referenciada pero no confirmada su existencia).
- `views/compra/gestionar_pedido.php`
- `views/compra/entrega.php`
- `views/compra/pago.php`
- `views/compra/factura.php`

## Métodos / Funcionalidades

| Método | Acceso | Descripción |
|---|---|---|
| `carrito()` | Público | Incluye la vista del carrito. No requiere login. |
| `gestionarPedido()` | Autenticado | Llama `requireLogin()` e incluye la vista de gestión de pedido. |
| `entrega()` | Autenticado | Llama `requireLogin()` e incluye la vista de entrega. |
| `pago()` | Autenticado | Llama `requireLogin()` e incluye la vista de pago. |
| `factura()` | Autenticado | Llama `requireLogin()` e incluye la vista de factura. |

## Variables Recibidas / Pasadas
Ninguna. Los métodos no preparan ni pasan variables a las vistas.

## Interacción con la BD
Ninguna. No instancia modelos ni ejecuta consultas.

## Posibles Fallos
- Las vistas en `views/compra/` no existen (la carpeta está vacía), por lo que cualquier llamada a estos métodos generará un error fatal de PHP (`include` fallido).
- `carrito()` no requiere login, lo que podría exponer la vista a usuarios no autenticados si la vista asume sesión activa.
- No hay manejo de errores ni redirecciones de fallback.
- El flujo real de compra está implementado en `CheckoutController.php`, no aquí.
