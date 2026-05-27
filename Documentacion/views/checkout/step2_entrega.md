# views/checkout/step2_entrega.php

## Descripción General
Vista del Paso 2 del proceso de compra. Formulario para ingresar los datos de entrega a domicilio.

## Ubicación
`views/checkout/step2_entrega.php`

## Variables de Sesión Usadas
| Variable | Descripción |
|---|---|
| `$_SESSION['checkout_orden']` | Datos del paso 1 |
| `$_SESSION['checkout_entrega']` | Pre-llena campos si ya se ingresaron |

## Campos del Formulario
| Campo | Name | Tipo | Descripción |
|---|---|---|---|
| Destinatario | `destinatario` | text | Pre-llenado con nombre del usuario |
| Dirección | `direccion` | text | Calle y número |
| Barrio/Sector | `barrio` | text | Barrio de entrega |
| Ciudad | `ciudad` | hidden | Fijo: Campoalegre |
| Teléfono | `telefono` | tel | Contacto para el domiciliario |
| Instrucciones | `instrucciones` | textarea | Opcional |

## Ciudades Disponibles
Solo Campoalegre (campo oculto fijo).

## Banner Informativo
Muestra un banner azul con "🛵 Entrega a domicilio — Tiempo estimado: 30–45 minutos".

## Posibles Fallos
- No valida que la dirección sea real o esté dentro de la ciudad seleccionada.
- El campo "instrucciones" no tiene límite de caracteres en el frontend.
