# config/session.php

## Descripción General

Archivo de configuración y gestión de sesiones PHP. Define todas las funciones helper de autenticación, autorización y redirección usadas en todo el sistema. Es el primer archivo que se carga en `public/index.php`.

## Ubicación

```
config/session.php
```

## Dependencias

- Ninguna dependencia externa
- Es requerido por todos los controladores

## Responsabilidades

- Iniciar la sesión PHP con configuración segura
- Proveer funciones helper para verificar autenticación
- Proteger rutas según rol
- Guardar y destruir sesiones
- Redirigir limpiando el output buffer

## Variables de Sesión

| Variable | Tipo | Descripción |
|---|---|---|
| `$_SESSION['idpersona']` | int | ID del usuario logueado |
| `$_SESSION['nombre']` | string | Nombre completo del usuario |
| `$_SESSION['correo']` | string | Correo electrónico |
| `$_SESSION['rol']` | string | Rol: `administrador`, `domiciliario`, `cliente` |

## Funciones

| Función | Parámetros | Retorna | Descripción |
|---|---|---|---|
| `isLoggedIn()` | — | `bool` | Verifica si hay sesión activa |
| `getUserId()` | — | `int\|null` | Retorna el ID del usuario |
| `getUserName()` | — | `string\|null` | Retorna el nombre del usuario |
| `getUserRole()` | — | `string\|null` | Retorna el rol del usuario |
| `requireLogin()` | — | `void` | Redirige al login si no está autenticado |
| `requireRole($rol)` | `string` | `void` | Verifica rol; redirige si no coincide |
| `loginUser($usuario)` | `array` | `void` | Guarda los datos del usuario en sesión |
| `logoutUser()` | — | `void` | Destruye la sesión y redirige al inicio |
| `redirect($url)` | `string` | `void` | Redirige limpiando el output buffer |

## Flujo de `requireRole()`

```
1. Llama a requireLogin() — si no está logueado, va al login
2. Compara getUserRole() con el $rol requerido
3. Si no coincide, redirige según el rol actual:
   - administrador → admin_productos
   - domiciliario  → domiciliario_pedidos
   - otro          → catalogo
```

## Configuración de Sesión

```php
ini_set('session.cookie_httponly', 1);  // Cookie no accesible por JS
ini_set('session.use_strict_mode', 1);  // Previene session fixation
ini_set('session.cookie_samesite', 'Lax'); // Protección CSRF básica
```

## Función `redirect()` — Detalle Importante

```php
function redirect(string $url): void {
    while (ob_get_level() > 0) {
        ob_end_clean(); // Limpia TODOS los niveles del output buffer
    }
    header("Location: $url");
    exit();
}
```

**Por qué es crítica**: `public/index.php` usa `ob_start()` para capturar el output. Si se llama `header()` directamente sin limpiar el buffer, el redirect puede fallar o el layout puede renderizarse después del redirect. Esta función resuelve ese problema.

## Posibles Fallos

- **Sesión perdida entre páginas**: Puede ocurrir si `session.cookie_path` no está configurado correctamente en XAMPP. La configuración actual con `cookie_samesite=Lax` mitiga esto.
- **`requireRole` redirige en bucle**: Si el rol en BD no coincide exactamente con el string esperado (ej: mayúsculas), puede causar bucles. Los roles válidos son exactamente: `administrador`, `domiciliario`, `cliente`.
