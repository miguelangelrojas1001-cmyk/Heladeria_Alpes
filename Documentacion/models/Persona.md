# models/Persona.php

## Descripción General

Modelo que gestiona la autenticación y registro de usuarios. Interactúa con las tablas `persona` y `roles` de la base de datos.

## Ubicación

```
models/Persona.php
```

## Dependencias

- `config/database.php` — conexión PDO

## Métodos

### `login($correo, $contrasena)`

| Parámetro | Tipo | Descripción |
|---|---|---|
| `$correo` | string | Correo del usuario |
| `$contrasena` | string | Contraseña en texto plano |
| **Retorna** | `array\|null` | Datos del usuario o `null` si falla |

**Flujo:**
```
1. Busca en persona JOIN roles WHERE correo = :correo
2. Si no existe → retorna null
3. Verifica si la contraseña está hasheada (bcrypt) o en texto plano (legacy)
4. Si es bcrypt → password_verify()
5. Si es texto plano → comparación directa (legacy)
6. Si es válida → retorna array con idpersona, nombre, correo, rol
7. Si no → retorna null
```

**Datos retornados:**
```php
[
    'idpersona' => 1,
    'nombre'    => 'Angel Rodriguez',
    'correo'    => 'angel@correo.com',
    'contrasena'=> '$2y$10$...',  // hash bcrypt
    'rol'       => 'administrador'
]
```

---

### `registrar($nombre, $correo, $contrasena, $rolNombre = 'cliente')`

| Parámetro | Tipo | Descripción |
|---|---|---|
| `$nombre` | string | Nombre completo |
| `$correo` | string | Correo electrónico |
| `$contrasena` | string | Contraseña en texto plano |
| `$rolNombre` | string | Nombre del rol (default: `'cliente'`) |
| **Retorna** | `bool` | `true` si se registró, `false` si falló |

**Flujo:**
```
1. Verifica si el correo ya existe → retorna false si existe
2. Busca el idrol por nombre en tabla roles
3. Si el rol no existe → retorna false
4. Hashea la contraseña con PASSWORD_BCRYPT
5. Inserta en tabla persona
6. Retorna true si el INSERT fue exitoso
```

## Tablas SQL Involucradas

| Tabla | Operación | Descripción |
|---|---|---|
| `persona` | SELECT, INSERT | Datos del usuario |
| `roles` | SELECT | Obtener idrol por nombre |

## Posibles Fallos

- **Correo duplicado**: Manejado — retorna `false`.
- **Rol inexistente**: Manejado — retorna `false`. Roles válidos: `administrador`, `domiciliario`, `cliente`.
- **Contraseña en texto plano (legacy)**: El sistema soporta contraseñas sin hash por compatibilidad. En producción migrar todas a bcrypt.
- **Sin validación de formato de correo**: La validación se hace en el controlador, no en el modelo.
