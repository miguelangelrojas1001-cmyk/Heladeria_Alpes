# controllers/AuthController.php

## Descripción General

Controlador de autenticación. Maneja el login, registro y logout de usuarios. Redirige a la página correcta según el rol tras el login.

## Ubicación

```
controllers/AuthController.php
```

## Dependencias

- `models/Persona.php`
- `config/session.php`

## Métodos

### `login()`

**Ruta**: `?page=login`

**Flujo GET** (mostrar formulario):
```
→ include views/auth/login.php
```

**Flujo POST** (procesar login):
```
1. Obtiene correo y contraseña del POST
2. Llama a Persona::login($correo, $contrasena)
3. Si es válido:
   - loginUser($usuario) → guarda en sesión
   - administrador → redirect(admin_productos)
   - domiciliario  → redirect(domiciliario_pedidos)
   - cliente       → redirect(catalogo)
4. Si falla → $error = 'Correo o contraseña incorrectos'
5. include views/auth/login.php con $error
```

---

### `register()`

**Ruta**: `?page=register`

**Validaciones:**
- Todos los campos obligatorios
- Las contraseñas deben coincidir
- Contraseña mínimo 6 caracteres

**Flujo POST:**
```
1. Valida los campos
2. Llama a Persona::registrar($nombre, $correo, $contrasena, 'cliente')
3. Si éxito → redirect(login)
4. Si falla → $error = 'El correo ya está registrado'
```

---

### `logout()`

**Ruta**: `?page=logout`

```
→ logoutUser() → session_destroy() → redirect(index.php)
```

## Sesión

| Acción | Variables afectadas |
|---|---|
| Login exitoso | `$_SESSION['idpersona']`, `['nombre']`, `['correo']`, `['rol']` |
| Logout | Todas destruidas |

## Posibles Fallos

- **Registro siempre como cliente**: El rol está hardcodeado como `'cliente'`. Para crear admins o domiciliarios usar el panel de Usuarios.
- **Sin rate limiting**: No hay protección contra ataques de fuerza bruta.
- **Sin CSRF token**: Los formularios no tienen token CSRF.
