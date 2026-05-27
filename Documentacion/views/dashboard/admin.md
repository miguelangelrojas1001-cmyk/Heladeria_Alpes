# views/dashboard/admin/

## Descripción General
Carpeta con todas las vistas del panel de administración. Cada vista es HTML puro (sin lógica PHP) — toda la lógica está en `AdminController.php`.

## Ubicación
`views/dashboard/admin/`

## Archivos

### productos.php
Gestión de productos. Formulario de creación/edición a la izquierda, grid de productos a la derecha.
- Detecta `$productoEditar` para cambiar entre modo "Nuevo" y modo "Editar"
- Muestra insumos con sus cantidades actuales
- Botones ✏️ Editar y Eliminar por producto

### inventario.php
Gestión de insumos y movimientos de stock.
- Formulario para agregar insumos
- Formulario para registrar entradas (▲) y salidas (▼)
- Tabla de insumos con estado (OK / Stock bajo / Sin stock)
- Historial de últimos 30 movimientos

### ventas.php
Historial de pedidos con estadísticas.
- 3 tarjetas: Total pedidos, Ingresos totales, Completados
- Tabla con cliente, total, domiciliario asignado, estado
- Selector de estado por pedido (submit automático al cambiar)

### proveedores.php
CRUD de proveedores (nombre, teléfono, correo).

### catalogo.php
CRUD de categorías con toggle activo/inactivo y contador de productos.

### usuarios.php
Gestión de usuarios del sistema.
- Tabla con todos los usuarios y su rol actual
- Selector de rol por fila con botón "Guardar"
- Formulario para crear nuevos usuarios con cualquier rol
- Botón eliminar con confirmación

## Variables Comunes Recibidas
Cada vista recibe las variables preparadas por `AdminController`. Ninguna hace queries directas a la BD.
