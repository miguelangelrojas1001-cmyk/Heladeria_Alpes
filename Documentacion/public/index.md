# public/index.php

## Descripción General

**Punto de entrada único** de toda la aplicación. Actúa como **router** — recibe todas las peticiones HTTP, determina qué controlador y método ejecutar según el parámetro `?page=`, captura el output con `ob_start()` y lo inyecta en el layout principal.

## Ubicación

```
public/index.php
```

## Dependencias

- `config/session.php` — siempre cargado primero
- Todos los controladores (cargados dinámicamente según la ruta)
- `views/layouts/main.php` — layout final

## Flujo Lógico

```
1. Activar display_errors (modo desarrollo)
2. Cargar config/session.php (inicia sesión)
3. Leer $page = $_GET['page'] ?? 'home'
4. ob_start() — capturar todo el output del controlador
5. switch($page) → cargar controlador y llamar método
6. $content = ob_get_clean() — obtener el HTML generado
7. Si $content está vacío → exit() (redirect ya ocurrió)
8. Si $page es 'login' o 'register' → echo $content y exit()
9. Para el resto → include views/layouts/main.php (usa $content)
```

## Tabla de Rutas

| `?page=` | Controlador | Método |
|---|---|---|
| `home`, `catalogo` | CatalogoController | `index()` |
| `productos_catalogo` | CatalogoController | `productosPorCatalogo()` |
| `login` | AuthController | `login()` |
| `register` | AuthController | `register()` |
| `logout` | AuthController | `logout()` |
| `checkout_opciones` | CheckoutController | `opciones()` / `guardarOpciones()` |
| `checkout_entrega` | CheckoutController | `entrega()` / `guardarEntrega()` |
| `checkout_pago` | CheckoutController | `pago()` / `confirmar()` |
| `checkout_factura` | CheckoutController | `factura()` |
| `carrito` | CarritoController | `index()` |
| `carrito_agregar` | CarritoController | `agregar()` |
| `carrito_actualizar` | CarritoController | `actualizar()` |
| `carrito_eliminar` | CarritoController | `eliminar()` |
| `carrito_vaciar` | CarritoController | `vaciar()` |
| `admin_productos` | AdminController | `productos()` |
| `admin_inventario` | AdminController | `inventario()` |
| `admin_ventas` | AdminController | `ventas()` |
| `admin_proveedores` | AdminController | `proveedores()` |
| `admin_catalogo` | AdminController | `catalogo()` |
| `admin_usuarios` | AdminController | `usuarios()` |
| `domiciliario_pedidos` | DomiciliarioController | `pedidos()` |
| `chatbot_responder` | ChatbotController | `responder()` |
| `cliente_pedidos` | ClienteController | `pedidos()` |
| `default` | CatalogoController | `index()` |

## Lógica Especial de Rutas

### Domiciliario bloqueado del catálogo
```php
case 'catalogo':
    if (isLoggedIn() && getUserRole() === 'domiciliario') {
        header('Location: index.php?page=domiciliario_pedidos'); exit();
    }
```

### Modo carrito en checkout
```php
case 'checkout_entrega':
    if (isset($_GET['desde']) && $_GET['desde'] === 'carrito') {
        $_SESSION['checkout_modo'] = 'carrito';
        unset($_SESSION['checkout_orden']);
    }
```

## Posibles Fallos

- **`display_errors = 1`**: Debe desactivarse en producción (`ini_set('display_errors', 0)`).
- **Rutas no definidas**: Caen al `default` que muestra el catálogo — comportamiento correcto.
- **Buffer vacío tras redirect**: Manejado con `if ($content === false || trim($content) === '') exit()`.
- **Inyección de `?page=`**: No hay validación de caracteres en `$page`, pero como solo se usa en el `switch`, no hay riesgo de inyección SQL o path traversal.
