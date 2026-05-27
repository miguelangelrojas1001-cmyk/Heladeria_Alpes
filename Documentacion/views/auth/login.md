# views/auth/login.php

## Descripción General
Vista del formulario de inicio de sesión. Diseño de dos columnas: panel izquierdo con branding y panel derecho con el formulario. Tiene su propio HTML completo (no usa el layout principal).

## Ubicación
`views/auth/login.php`

## Variables Recibidas
| Variable | Tipo | Descripción |
|---|---|---|
| `$error` | string\|null | Mensaje de error si el login falló |

## Campos del Formulario
| Campo | Name | Descripción |
|---|---|---|
| Correo | `correo` | Correo electrónico |
| Contraseña | `contrasena` | Con toggle 👁 para mostrar/ocultar |
| Recordar | `recordar` | Checkbox (no implementado en backend) |

## Estructura Visual
Panel izquierdo: gradiente azul con logo, slogan "El sabor que siempre esperas." y badge "Acceso Seguro 🔒".
Panel derecho: formulario blanco con campos, botón "Entrar al Sistema →" y link a registro.

## Responsive
En pantallas < 680px el panel izquierdo se oculta.

## Posibles Fallos
- "Recordar sesión": checkbox sin implementación en backend.
- "¿Olvidaste tu contraseña?": apunta a `#`, no implementado.
- Ruta del logo `img/logo.png` es relativa a `public/`.
