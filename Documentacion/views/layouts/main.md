# views/layouts/main.php

## Descripción General

Layout principal de la aplicación. Renderiza el sidebar de navegación, la topbar, el contenido de la página (`$content`) y el chatbot flotante. Es el último archivo que se carga en `public/index.php`.

## Ubicación

```
views/layouts/main.php
```

## Dependencias

- `config/session.php` (ya cargado, usa sus funciones)
- Variable `$content` inyectada desde `public/index.php`

## Estructura HTML

```
<html>
  <head> — Nunito font, CSS variables, estilos del layout </head>
  <body>
    <div class="layout">
      <aside class="sidebar">     — Navegación lateral fija
      <div class="main">
        <div class="topbar">      — Barra superior con buscador
        <div class="page-content"> — $content aquí
      </div>
    </div>
    <!-- Chatbot flotante (solo si isLoggedIn()) -->
  </body>
</html>
```

## Navegación por Rol

| Rol | Links visibles |
|---|---|
| No logueado | Catálogo, Iniciar sesión, Registrarse |
| `cliente` | Catálogo, Mi Carrito, Mis Pedidos |
| `administrador` | Ver catálogo, Productos, Inventario, Ventas, Proveedores, Categorías, Usuarios |
| `domiciliario` | Pedidos asignados (sin catálogo) |

## Chatbot Flotante

Solo visible para usuarios logueados. Incluye:
- Botón FAB con logo en esquina inferior derecha
- Badge rojo que aparece a los 3 segundos
- Ventana de chat con header, mensajes, sugerencias y campo de texto
- Comunicación asíncrona con `fetch()` al endpoint `chatbot_responder`
- Sugerencias rápidas diferenciadas por rol

## Variables CSS

```css
:root {
    --blue: #2563EB;
    --blue-dark: #1D4ED8;
    --dark-panel: #1E3A5F;  /* sidebar */
    --sidebar-w: 260px;
    --gray-bg: #F1F5F9;
}
```

## Posibles Fallos

- **`$content` vacío**: Si un controlador no genera output, la página queda en blanco. Manejado en `index.php` con `if (trim($content) === '') exit()`.
- **Chatbot en páginas de checkout**: El chatbot aparece en todas las páginas incluyendo el checkout, lo que puede distraer al usuario.
- **Ruta de imagen del logo**: Usa `img/logo.png` (relativa). Si la URL base cambia, la imagen no carga.
