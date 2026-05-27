# views/auth/register.php

## Descripción General
Vista del formulario de registro de nuevos usuarios. Diseño simple centrado. Tiene su propio HTML completo (no usa el layout principal). Solo permite registrar usuarios con rol `cliente`.

## Ubicación
`views/auth/register.php`

## Variables Recibidas
| Variable | Tipo | Descripción |
|---|---|---|
| `$error` | string\|null | Mensaje de error de validación |
| `$success` | string\|null | Mensaje de éxito (no usado actualmente) |

## Campos del Formulario
| Campo | Name | Validación |
|---|---|---|
| Nombre | `nombre` | Requerido |
| Correo | `correo` | Email, requerido |
| Contraseña | `contrasena` | Mínimo 6 caracteres |
| Confirmar contraseña | `contrasena2` | Debe coincidir con contrasena |

## Validaciones en Backend (AuthController)
1. Todos los campos obligatorios
2. Las contraseñas deben coincidir
3. Contraseña mínimo 6 caracteres
4. Correo no debe estar registrado

## Posibles Fallos
- Solo crea usuarios con rol `cliente`. Para otros roles usar el panel de Usuarios del admin.
- Sin validación de formato de nombre (acepta cualquier string).
