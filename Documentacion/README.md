# Los Alpes Heladería — Documentación Técnica

## Descripción del Proyecto

**Los Alpes** es una aplicación web de e-commerce para una heladería, desarrollada en **PHP 8.2** bajo el patrón **MVC (Modelo-Vista-Controlador)**. Permite a los clientes explorar el catálogo, personalizar productos y realizar pedidos con domicilio. Incluye paneles diferenciados para administradores, domiciliarios y clientes.

---

## Stack Tecnológico

| Componente | Tecnología |
|---|---|
| Backend | PHP 8.2+ |
| Base de datos | MySQL / MariaDB 10.4 (PDO) |
| Frontend | HTML5 + CSS3 + JavaScript vanilla |
| Tipografía | Google Fonts — Nunito |
| Servidor local | XAMPP / WAMP (puerto 3320) |

---

## Estructura del Proyecto

```
Alpes/
├── config/
│   ├── database.php          # Conexión PDO a MySQL
│   └── session.php           # Gestión de sesiones y helpers de autenticación
├── controllers/
│   ├── AdminController.php   # Panel de administración
│   ├── AuthController.php    # Login y registro
│   ├── CarritoController.php # Carrito de compras
│   ├── CatalogoController.php# Catálogo público
│   ├── ChatbotController.php # Asistente virtual
│   ├── CheckoutController.php# Proceso de compra (4 pasos)
│   ├── ClienteController.php # Panel del cliente
│   └── DomiciliarioController.php # Panel del domiciliario
├── models/
│   ├── Domiciliario.php      # Asignación automática de domiciliarios
│   ├── Persona.php           # Login y registro de usuarios
│   └── Producto.php          # CRUD de productos e insumos
├── public/
│   ├── index.php             # Router principal (único punto de entrada)
│   └── img/                  # Imágenes del sistema
├── sql/
│   └── bdalpes.sql           # Script completo de la base de datos
├── views/
│   ├── auth/                 # Login y registro
│   ├── carrito/              # Vista del carrito
│   ├── catalogo/             # Catálogo y productos
│   ├── checkout/             # 4 pasos del proceso de compra
│   ├── dashboard/
│   │   ├── admin/            # Vistas del administrador
│   │   ├── cliente/          # Vistas del cliente
│   │   └── domiciliario/     # Vistas del domiciliario
│   └── layouts/
│       └── main.php          # Layout principal con sidebar y chatbot
└── docs/                     # Esta documentación
```

---

## Roles del Sistema

| Rol | Acceso | Página inicial |
|---|---|---|
| `administrador` | Panel admin completo + catálogo (solo vista) | `admin_productos` |
| `cliente` | Catálogo, carrito, pedidos | `catalogo` |
| `domiciliario` | Solo panel de entregas | `domiciliario_pedidos` |

---

## Flujo Principal de Compra

```
Catálogo → Seleccionar producto → Personalizar (step1)
→ Datos de entrega (step2) → Método de pago (step3)
→ Factura generada (step4)
```

---

## Índice de Documentación

### Configuración
- [config/database.php](config/database.md)
- [config/session.php](config/session.md)

### Punto de Entrada
- [public/index.php](public/index.md)

### Modelos
- [models/Producto.php](models/Producto.md)
- [models/Persona.php](models/Persona.md)
- [models/Domiciliario.php](models/Domiciliario.md)

### Controladores
- [controllers/AuthController.php](controllers/AuthController.md)
- [controllers/AdminController.php](controllers/AdminController.md)
- [controllers/CarritoController.php](controllers/CarritoController.md)
- [controllers/CheckoutController.php](controllers/CheckoutController.md)
- [controllers/CatalogoController.php](controllers/CatalogoController.md)
- [controllers/ClienteController.php](controllers/ClienteController.md)
- [controllers/DomiciliarioController.php](controllers/DomiciliarioController.md)
- [controllers/ChatbotController.php](controllers/ChatbotController.md)

### Vistas
- [views/layouts/main.php](views/layouts/main.md)
- [views/auth/login.php](views/auth/login.md)
- [views/catalogo/productos.php](views/catalogo/productos.md)
- [views/checkout/step1_opciones.php](views/checkout/step1_opciones.md)
- [views/checkout/step4_factura.php](views/checkout/step4_factura.md)
- [views/dashboard/admin/](views/dashboard/admin.md)
- [views/dashboard/cliente/pedidos.php](views/dashboard/cliente/pedidos.md)
- [views/dashboard/domiciliario/pedidos.php](views/dashboard/domiciliario/pedidos.md)

---

## Base de Datos

El archivo `sql/bdalpes.sql` contiene:
- **Sección A**: Instalación completa desde cero (DROP + CREATE + datos base)
- **Sección B**: Solo insertar datos nuevos sin borrar nada existente

### Tablas principales

| Tabla | Descripción |
|---|---|
| `persona` | Usuarios del sistema con rol |
| `roles` | administrador, domiciliario, cliente |
| `catalogo` | Categorías de productos |
| `producto` | Productos con precio e imagen |
| `pedido` | Pedidos realizados |
| `detalle_pedido` | Productos de cada pedido |
| `factura` | Facturas generadas |
| `envios` | Asignación de domiciliarios a pedidos |
| `insumo` | Insumos del inventario |
| `inventario` | Movimientos de stock |
