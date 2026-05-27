# controllers/AdminController.php

## Descripción General

Controlador principal del panel de administración. Gestiona productos, inventario, ventas, proveedores, categorías y usuarios. Todos sus métodos requieren rol `administrador`.

## Ubicación

```
controllers/AdminController.php
```

## Dependencias

- `config/session.php`
- `models/Producto.php`
- `config/database.php`
- `models/Persona.php` (solo en `usuarios()`)
- `models/Domiciliario.php` (solo en `ventas()`)

## Métodos

| Método | Ruta | Descripción |
|---|---|---|
| `productos()` | `admin_productos` | CRUD de productos |
| `inventario()` | `admin_inventario` | Gestión de insumos y movimientos |
| `ventas()` | `admin_ventas` | Historial de pedidos y cambio de estado |
| `proveedores()` | `admin_proveedores` | CRUD de proveedores |
| `catalogo()` | `admin_catalogo` | CRUD de categorías |
| `usuarios()` | `admin_usuarios` | Gestión de usuarios y roles |

---

### `productos()`

**Acciones:**
- `GET ?eliminar=id` → elimina producto y sus `detalle_insumo` (transacción)
- `GET ?editar=id` → carga datos del producto para editar
- `POST` sin `_editar` → crea nuevo producto
- `POST` con `_editar` → actualiza producto existente

**Subida de imágenes:**
```
Destino: ../public/img/{timestamp}_{nombre_original}
Ruta guardada en BD: img/{timestamp}_{nombre_original}
```

---

### `inventario()`

**Acciones POST según `$_POST['accion']`:**

| accion | Descripción |
|---|---|
| `agregar_insumo` | INSERT en tabla `insumo` |
| `entrada` | UPDATE stock_actual + INSERT inventario (tipo_entrada=1) |
| `salida` | UPDATE stock_actual - INSERT inventario (tipo_salida=1) |
| `editar_insumo` | UPDATE nombre, stock_minimo, unidad_medida |

**Eliminar insumo** (`GET ?eliminar_insumo=id`):
```
Transacción:
1. DELETE FROM inventario WHERE idinsumo = id
2. DELETE FROM detalle_insumo WHERE idinsumo = id
3. DELETE FROM insumo WHERE idinsumo = id
```

---

### `ventas()`

**POST** (cambiar estado):
```
1. UPDATE pedido SET estado = :estado WHERE idpedido = :id
2. Si estado IN ('pendiente','en proceso'):
   → Domiciliario::asignarOActualizar($idpedido)
3. redirect(admin_ventas)
```

**Query de pedidos** (incluye domiciliario asignado):
```sql
SELECT p.*, pe.nombre AS cliente, pd.nombre AS domiciliario
FROM pedido p
LEFT JOIN cliente c ON p.idcliente = c.idcliente
LEFT JOIN persona pe ON c.idpersona = pe.idpersona
LEFT JOIN envios e ON e.idpedido = p.idpedido
LEFT JOIN domiciliario d ON e.iddomiciliario = d.iddomiciliario
LEFT JOIN persona pd ON d.idpersona = pd.idpersona
ORDER BY p.fecha DESC
```

---

### `usuarios()`

**Acciones:**
- `POST accion=cambiar_rol` → UPDATE persona SET idrol
- `GET ?eliminar=id` → elimina cliente/domiciliario/persona (transacción)
- `POST accion=crear_usuario` → usa `Persona::registrar()` con rol seleccionable

## Tablas SQL Involucradas

`producto`, `catalogo`, `detalle_insumo`, `insumo`, `inventario`, `pedido`, `detalle_pedido`, `factura`, `proveedor`, `persona`, `roles`, `cliente`, `domiciliario`, `envios`

## Posibles Fallos

- **Eliminar usuario con pedidos**: Si el cliente tiene pedidos, el DELETE fallará por FK. El error se captura pero el mensaje puede no ser claro.
- **Imágenes huérfanas**: Al eliminar un producto, la imagen en `public/img/` no se borra del servidor.
- **Sin paginación en ventas**: Con muchos pedidos la tabla puede ser lenta.
