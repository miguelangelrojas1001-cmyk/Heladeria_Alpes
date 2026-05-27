# step_layout.php

## Descripción General
Layout reutilizable del flujo de checkout. Renderiza el shell visual del proceso de compra en 4 pasos: un stepper de progreso en la parte superior y una tarjeta de contenido donde se inyecta el contenido específico de cada paso. Es incluido por los archivos `step1_opciones.php`, `step2_entrega.php`, `step3_pago.php` y `step4_factura.php`.

## Ubicación
`views/checkout/step_layout.php`

## Estado
✅ Implementado y funcional.

## Dependencias
- No incluye archivos PHP externos.
- Asume que la fuente `Nunito` está cargada en el layout principal (`views/layouts/main.php`).
- Requiere que las variables `$step`, `$step_title`, `$step_content` y `$producto` estén definidas por el archivo que lo incluye.

## Métodos / Funcionalidades

Este archivo es una vista pura, no define funciones. Sus secciones son:

| Sección | Descripción |
|---|---|
| Estilos CSS inline | Define todos los estilos del checkout: `.ck-wrap`, `.ck-steps`, `.ck-step`, `.ck-card`, `.btn-next`, `.btn-back`, `.option-grid`, `.option-btn`, `.prod-summary`. |
| Stepper de progreso | Bucle `for` que itera los 4 pasos (`Personaliza`, `Entrega`, `Pago`, `Confirmación`). Aplica clases `done`, `active` o `todo` según el valor de `$step`. Muestra `✓` en pasos completados. |
| Botón "Atrás" | Se muestra condicionalmente si `$step > 1`. Usa `history.back()` para navegar. |
| Título del paso | Renderiza `$step_title` dentro de `.ck-title`. |
| Contenido del paso | Imprime `$step_content` con `echo` sin escapar (se asume HTML seguro generado internamente). |

## Variables Recibidas / Pasadas

| Variable | Tipo | Descripción |
|---|---|---|
| `$step` | `int` (1–4) | Número del paso actual. Controla el estado del stepper. |
| `$step_title` | `string` | Título mostrado en la cabecera de la tarjeta. |
| `$step_content` | `string` | HTML del contenido del paso, generado con output buffering en el archivo que incluye este layout. |
| `$producto` | `array` | Datos del producto seleccionado. Disponible para uso en `$step_content` pero no se usa directamente en este layout. |

## Interacción con la BD
Ninguna. Es una vista de presentación pura.

## Posibles Fallos
- `$step_content` se imprime con `echo` sin `htmlspecialchars()`. Si el contenido proviene de datos de usuario sin sanitizar, existe riesgo de XSS.
- El botón "Atrás" usa `history.back()` (JavaScript), lo que puede llevar a un paso incorrecto si el usuario llegó desde una URL externa o recargó la página.
- Los estilos están definidos inline en el archivo, lo que puede causar conflictos si el layout se incluye múltiples veces en la misma página.
- No hay validación de que `$step` esté en el rango 1–4; un valor fuera de rango puede romper el stepper visualmente.
- La variable `$producto` se declara como requerida en el comentario pero no se usa en el layout, lo que puede generar confusión.
