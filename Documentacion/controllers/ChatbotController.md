# controllers/ChatbotController.php

## Descripción General

Controlador del asistente virtual integrado en el sistema. Procesa mensajes de texto del usuario y retorna respuestas en JSON basadas en coincidencia de palabras clave. Responde de forma diferenciada según el rol del usuario.

## Ubicación

```
controllers/ChatbotController.php
```

## Dependencias

- `config/session.php`
- `config/database.php`

## Métodos

### `responder()`

**Ruta**: `?page=chatbot_responder` (POST)  
**Requiere**: Usuario logueado (`requireLogin()`)

**Flujo:**
```
1. Lee $_POST['mensaje'] y lo convierte a minúsculas
2. Llama a procesar($msg, $rol)
3. Retorna JSON: {"respuesta": "..."}
```

### `procesar($msg, $rol)` — privado

Evalúa el mensaje contra una serie de condiciones ordenadas por prioridad:

| Prioridad | Palabras clave | Respuesta |
|---|---|---|
| 1 | hola, buenas, hey | Saludo personalizado con nombre |
| 2 | como hago, como pedir, proceso de compra | Pasos para hacer un pedido |
| 3 | ver mis pedidos, estado del pedido | Cómo ver pedidos (según rol) |
| 4 | pedido, pedidos, orden | Información general de pedidos |
| 5 | carrito, agregar al carrito | Cómo usar el carrito |
| 6 | pago, nequi, daviplata, tarjeta | Métodos de pago |
| 7 | domicilio, envio, tiempo | Costo y tiempo de entrega |
| 8 | ciudad, campoalegre | Cobertura geográfica |
| 9 | producto, catalogo, que tienen | Categorías disponibles |
| 10 | waffle | Info de waffles |
| 11 | malteada | Info de malteadas |
| 12 | yogurt, moon ice | Info de helado de yogurt |
| 13 | canasta | Info de canastas |
| 14 | ensalada, fruta | Info de ensaladas |
| 15 | topping, sabor | Precios de toppings |
| 16 | factura, imprimir | Cómo ver/imprimir facturas |
| 17 | registrar, cuenta | Cómo crear cuenta |
| 18+ | (admin) agregar producto, inventario, ventas, usuarios | Ayuda específica para admin |
| 19+ | (domiciliario) asignado, entregar | Ayuda para domiciliario |
| 20 | precio, cuanto, costo | Precios de referencia |
| 21 | ayuda, como, que puedo | Menú de ayuda general |
| default | — | Respuesta genérica con opciones |

### `contiene($texto, $palabras)` — privado

```php
// Retorna true si el texto contiene alguna de las palabras
foreach ($palabras as $p) {
    if (str_contains($texto, $p)) return true;
}
return false;
```

## Respuestas Diferenciadas por Rol

El chatbot adapta sus respuestas según `getUserRole()`:

- **cliente**: Explica cómo hacer pedidos, ver historial, imprimir facturas
- **administrador**: Explica gestión de productos, inventario, ventas, usuarios
- **domiciliario**: Explica cómo marcar entregas, ver pedidos asignados

## Integración en el Frontend

El chatbot está integrado en `views/layouts/main.php` como widget flotante:
- Botón 🍦 en esquina inferior derecha
- Ventana de chat con animación de "escribiendo..."
- Sugerencias rápidas según rol
- Comunicación via `fetch()` al endpoint `chatbot_responder`

## Posibles Fallos y Limitaciones

- **Coincidencia por palabras clave**: No usa NLP ni IA. Si el usuario escribe de forma muy diferente a las palabras clave, no encontrará respuesta.
- **Orden de evaluación**: Las condiciones se evalúan en orden. "¿Cómo hago un pedido?" debe evaluarse ANTES que "pedido" genérico para dar la respuesta correcta.
- **Sin historial de conversación**: Cada mensaje es independiente, no recuerda el contexto anterior.
- **Solo en español**: No soporta otros idiomas.

## Mejoras Recomendadas

- Agregar más sinónimos a las palabras clave
- Implementar un sistema de intenciones más robusto
- Conectar con la BD para responder preguntas dinámicas (ej: "¿Cuánto cuesta el Moon Ice?")
