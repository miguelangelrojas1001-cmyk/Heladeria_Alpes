# Matriz de Roles y Permisos — Heladería Alpes

Este documento especifica los privilegios de acceso y operaciones permitidas para cada tipo de actor dentro del sistema de información **Heladería Alpes**.

---

## 👥 Definición de Roles

| Rol | Código BD | Descripción |
| :--- | :---: | :--- |
| **Visitante / Anónimo** | `N/A` | Usuario no autenticado que navega por el catálogo público. |
| **Cliente** | `cliente` | Usuario registrado que realiza compras, pedidos y seguimiento. |
| **Domiciliario** | `domiciliario` | Personal encargado de la logística y entrega de pedidos. |
| **Administrador** | `administrador`| Encargado del control total del negocio, inventario, ventas y recetas. |

---

## 🔐 Matriz de Permisos por Módulo

| Módulo / Funcionalidad | Visitante | Cliente | Domiciliario | Administrador |
| :--- | :---: | :---: | :---: | :---: |
| **Ver catálogo de productos** | ✅ | ✅ | ✅ | ✅ |
| **Registrar cuenta / Iniciar sesión** | ✅ | ✅ | ✅ | ✅ |
| **Agregar al carrito de compras** | ❌ | ✅ | ❌ | ❌ |
| **Confirmar pedido y pagar** | ❌ | ✅ | ❌ | ❌ |
| **Historial de pedidos propios** | ❌ | ✅ | ❌ | ❌ |
| **Uso de Chatbot asistente** | ✅ | ✅ | ❌ | ❌ |
| **Ver lista de envíos asignados** | ❌ | ❌ | ✅ | ✅ |
| **Actualizar estado de entrega (Entregado)** | ❌ | ❌ | ✅ | ✅ |
| **Gestión de productos (CRUD)** | ❌ | ❌ | ❌ | ✅ |
| **Gestión de categorías / catálogos** | ❌ | ❌ | ❌ | ✅ |
| **Gestión de insumos y recetas** | ❌ | ❌ | ❌ | ✅ |
| **Control de inventario (Entradas/Salidas)**| ❌ | ❌ | ❌ | ✅ |
| **Gestión de proveedores** | ❌ | ❌ | ❌ | ✅ |
| **Reportes y estadísticas globales** | ❌ | ❌ | ❌ | ✅ |

---

## 🛡️ Seguridad y Control de Sesiones

El control de acceso se valida en el servidor mediante la función `requireRole('nombre_rol')` en `config/session.php`:
* Si un usuario sin privilegios intenta acceder a una ruta protegida (ej: `views/dashboard/admin/`), el sistema redirige automáticamente al login o al catálogo con un mensaje de advertencia.
