# Arquitectura y Flujo MVC — Heladería Alpes

El sistema **Heladería Alpes** está diseñado siguiendo el patrón arquitectónico **Modelo - Vista - Controlador (MVC)**, garantizando la separación de responsabilidades entre la lógica de negocio, el acceso a datos y la interfaz de usuario.

---

## 🏛️ Estructura del Patrón MVC

```
Heladeria_Alpes/
│
├── config/                  # Configuraciones globales y base de datos
│   ├── database.php         # Conexión PDO a MySQL
│   └── session.php          # Manejo de sesiones y control de roles
│
├── models/                  # [M] MODELO: Lógica de datos y consultas SQL
│   ├── Persona.php          # Consultas para usuarios y autenticación
│   ├── Producto.php         # Consultas para catálogo, recetas y productos
│   └── Domiciliario.php     # Consultas para despachos y pedidos asignados
│
├── controllers/             # [C] CONTROLADOR: Orquestación y reglas de negocio
│   ├── AdminController.php  # Lógica del panel administrativo
│   ├── AuthController.php   # Login, registro y cierre de sesión
│   ├── CarritoController.php# Operaciones de compra y carrito
│   ├── ChatbotController.php# Asistente virtual automatizado
│   └── ProductoController.php
│
├── views/                   # [V] VISTA: Interfaces gráficas de usuario
│   ├── auth/                # Vistas de login y registro
│   ├── catalogos/           # Vistas de la tienda y catálogo público
│   └── dashboard/           # Paneles por rol (admin, domiciliario, cliente)
│
└── public/                  # Punto de entrada público (Assets, CSS, JS, index.php)
```

---

## 🔄 Flujo de una Solicitud (Request Lifecycle)

1. **Entrada:** El usuario realiza una petición web a `public/index.php?page=...`.
2. **Enrutamiento y Sesión:** Se validan las credenciales y el rol en `config/session.php`.
3. **Controlador:** El controlador correspondiente recibe los parámetros (`$_GET` o `$_POST`), aplica validaciones y solicita los datos al Modelo.
4. **Modelo:** El modelo ejecuta consultas preparadas mediante PDO sobre la base de datos `bdalpes` y retorna los registros en arreglos asociativos.
5. **Vista:** El controlador incluye la vista correspondiente pasando las variables necesarias para renderizar el HTML final al usuario.
