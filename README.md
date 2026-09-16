# Los Alpes Heladería — Documentación Técnica

## Descripción del Proyecto

**Los Alpes** es una aplicación web de e-commerce para una heladería, desarrollada en **PHP 8.2 nativo** bajo el patrón **MVC (Modelo-Vista-Controlador)**, sin framework. Permite a los clientes explorar el catálogo, personalizar productos y realizar pedidos con domicilio. Incluye paneles diferenciados para administradores, domiciliarios y clientes, además de un chatbot de atención y un módulo de reportes.

---

## Stack Tecnológico

| Componente | Tecnología |
|---|---|
| Backend | PHP 8.2+ nativo (MVC propio, sin framework) |
| Base de datos | MySQL 8.0 mediante PDO |
| Frontend | HTML5 + CSS3 + JavaScript vanilla |
| Tipografía | Google Fonts — Nunito |
| Autenticación | Sesiones nativas de PHP + hash bcrypt |
| Servidor local | Laragon (Apache 2.4 + PHP 8.2 + MySQL en el puerto 3320) |

---

## Estructura del Proyecto

```
Heladeria_Alpes/
├── config/
│   ├── database.php          # Conexión PDO a MySQL
│   ├── database.example.php  # Plantilla de configuración
│   └── session.php           # Gestión de sesiones y helpers de autenticación
├── controllers/
│   ├── AdminController.php        # Panel de administración (productos, inventario,
│   │                                ventas, proveedores, catálogo, usuarios, reportes)
│   ├── AuthController.php         # Login, registro y cierre de sesión
│   ├── CarritoController.php      # Carrito de compras
│   ├── CatalogoController.php     # Catálogo público
│   ├── ChatbotController.php      # Asistente virtual
│   ├── CheckoutController.php     # Proceso de compra (4 pasos)
│   ├── ClienteController.php      # Panel del cliente ("Mis Pedidos")
│   ├── DomiciliarioController.php # Panel del domiciliario
│   │
│   │   # Controladores legacy: esqueletos sin implementar y sin ruta en index.php.
│   │   # Se conservan como referencia histórica; la lógica real está en AdminController.
│   ├── CompraController.php       # (legacy)
│   ├── InventarioController.php   # (legacy)
│   ├── ProductoController.php     # (legacy)
│   ├── ProveedorController.php    # (legacy)
│   └── UsuarioController.php      # (legacy)
├── models/
│   ├── Domiciliario.php      # Asignación automática de domiciliarios
│   ├── Persona.php           # Login y registro de usuarios
│   └── Producto.php          # CRUD de productos, insumos y descuento de inventario
├── public/
│   ├── index.php             # Router principal (único punto de entrada)
│   └── img/                  # Imágenes del sistema
├── sql/
│   └── bdalpes.sql           # Script completo de la base de datos
├── views/
│   ├── auth/                 # Login y registro
│   ├── carrito/              # Vista del carrito
│   ├── catalogo/             # Catálogo por categorías
│   ├── checkout/             # 4 pasos del proceso de compra
│   ├── dashboard/
│   │   ├── admin/            # Vistas del administrador (incluye reportes.php)
│   │   ├── cliente/          # Vistas del cliente
│   │   └── domiciliario/     # Vistas del domiciliario
│   └── layouts/
│       └── main.php          # Layout principal con sidebar, notificaciones y chatbot
└── Documentacion/            # Esta documentación
```

---

## Roles del Sistema

| Rol | Acceso | Página inicial |
|---|---|---|
| `administrador` | Panel admin completo + catálogo (solo vista) | `admin_productos` |
| `cliente` | Catálogo, carrito, checkout, "Mis Pedidos" | `catalogo` |
| `domiciliario` | Solo panel de entregas | `domiciliario_pedidos` |

El control de acceso se aplica con `requireLogin()` y `requireRole()` de `config/session.php`. Un usuario que intenta entrar a un módulo que no le corresponde es redirigido a la página inicial de su propio rol.

---

## Flujo Principal de Compra

```
Catálogo → Seleccionar producto → Personalizar (step1)
→ Datos de entrega (step2) → Método de pago (step3)
→ Confirmación transaccional → Factura generada (step4)
```

Al confirmar, el sistema registra en una sola transacción la dirección, el pedido, su detalle,
la factura y su detalle; descuenta los insumos de cada producto y, tras el commit, asigna
automáticamente el domiciliario con menos pedidos activos creando el registro en `envios`.

---

## Estados del Pedido

```
pendiente → en proceso → completado
     └──────→ cancelado
```

| Estado | Quién lo asigna |
|---|---|
| `pendiente` | El sistema, al confirmar el pedido |
| `en proceso` | El domiciliario ("Marcar en camino") o el administrador |
| `completado` | El domiciliario ("Marcar como entregado") o el administrador |
| `cancelado` | El administrador desde el módulo de ventas |

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

### Controladores activos

- [controllers/AuthController.php](controllers/AuthController.md)
- [controllers/AdminController.php](controllers/AdminController.md)
- [controllers/CarritoController.php](controllers/CarritoController.md)
- [controllers/CheckoutController.php](controllers/CheckoutController.md)
- [controllers/CatalogoController.php](controllers/CatalogoController.md)
- [controllers/ClienteController.php](controllers/ClienteController.md)
- [controllers/DomiciliarioController.php](controllers/DomiciliarioController.md)
- [controllers/ChatbotController.php](controllers/ChatbotController.md)

### Controladores legacy (sin implementar, sin ruta)

- [controllers/CompraController.php](controllers/CompraController.md)
- [controllers/InventarioController.php](controllers/InventarioController.md)
- [controllers/ProductoController.php](controllers/ProductoController.md)
- [controllers/ProveedorController.php](controllers/ProveedorController.md)
- [controllers/UsuarioController.php](controllers/UsuarioController.md)

### Vistas

- [views/layouts/main.php](views/layouts/main.md)
- [views/auth/login.php](views/auth/login.md)
- [views/auth/register.php](views/auth/register.md)
- [views/catalogo/index.php](views/catalogo/index.md)
- [views/catalogo/productos.php](views/catalogo/productos.md)
- [views/carrito/index.php](views/carrito/index.md)
- [views/checkout/step_layout.php](views/checkout/step_layout.md)
- [views/checkout/step1_opciones.php](views/checkout/step1_opciones.md)
- [views/checkout/step2_entrega.php](views/checkout/step2_entrega.md)
- [views/checkout/step3_pago.php](views/checkout/step3_pago.md)
- [views/checkout/step4_factura.php](views/checkout/step4_factura.md)
- [views/dashboard/admin/](views/dashboard/admin.md)
- [views/dashboard/admin/reportes.php](views/dashboard/admin/reportes.md)
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
| `persona` | Usuarios del sistema con su rol |
| `roles` | administrador, domiciliario, cliente |
| `cliente` / `administrador` / `domiciliario` | Perfiles asociados a una persona |
| `catalogo` | Categorías de productos |
| `producto` | Productos con precio, imagen y disponibilidad |
| `insumo` | Insumos con stock actual, stock mínimo y unidad de medida |
| `detalle_insumo` | Insumos que consume cada producto |
| `inventario` | Movimientos de stock (entradas y salidas) |
| `proveedor` | Proveedores de insumos |
| `pedido` / `detalle_pedido` | Pedidos y sus líneas con personalización |
| `factura` / `detalle_factura` | Facturas y sus líneas |
| `direccion` | Direcciones de entrega registradas |
| `envios` | Asignación de domiciliarios a pedidos |
| `notificacion` | Alertas de stock mínimo dirigidas al administrador |

> **Nota:** las tablas `carrito` y `detalle_carrito` existen en el esquema pero no se utilizan
> en esta versión: el carrito se gestiona en `$_SESSION` y se materializa en `pedido` y
> `detalle_pedido` al confirmar la compra.

---

## Notas de la versión 1.0

- El pago está **simulado**: el sistema registra el método elegido (Nequi, Daviplata o tarjeta)
  y lo asocia a la factura. No hay integración con pasarela de pago ni captura de datos de tarjeta.
- No hay envío de correo electrónico. Las notificaciones se registran en la tabla `notificacion`
  y se consultan dentro del sistema.
- El costo de domicilio es fijo ($2.000) y la cobertura es únicamente Campoalegre.
- El estado detallado de cada requerimiento está en la sección 13 del documento
  *REQ.SOFT Alpes*.
