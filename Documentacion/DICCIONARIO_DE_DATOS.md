# Diccionario de Datos — Heladería Alpes (`bdalpes`)

Este documento describe la estructura técnica de la base de datos relacional `bdalpes`, incluyendo sus tablas, campos, tipos de datos, llaves primarias, llaves foráneas y descripciones funcionales.

---

## 1. Módulo de Usuarios y Autenticación

### Tabla: `roles`
Define los tipos de usuarios y sus niveles de acceso dentro del sistema.

| Campo | Tipo | Nulo | Clave | Descripción |
| :--- | :--- | :---: | :---: | :--- |
| `idrol` | INT(11) | NO | PK | Identificador único del rol. |
| `nombre` | VARCHAR(255) | SÍ | | Nombre descriptivo del rol (ej: `administrador`, `cliente`, `domiciliario`). |

---

### Tabla: `persona`
Entidad principal que almacena los datos de identidad y credenciales de acceso.

| Campo | Tipo | Nulo | Clave | Descripción |
| :--- | :--- | :---: | :---: | :--- |
| `idpersona` | INT(11) | NO | PK | Identificador único de la persona. |
| `idrol` | INT(11) | SÍ | FK | Referencia al rol asignado (`roles.idrol`). |
| `nombre` | VARCHAR(255) | SÍ | | Nombre completo del usuario. |
| `correo` | VARCHAR(255) | SÍ | | Correo electrónico institucional o personal (login). |
| `contrasena` | VARCHAR(255) | SÍ | | Contraseña cifrada del usuario. |

---

### Tabla: `administrador`
Extensión de persona con privilegios administrativos.

| Campo | Tipo | Nulo | Clave | Descripción |
| :--- | :--- | :---: | :---: | :--- |
| `idadministrador` | INT(11) | NO | PK | Identificador único del registro administrativo. |
| `idpersona` | INT(11) | SÍ | FK | Referencia a la persona (`persona.idpersona`). |

---

### Tabla: `cliente`
Extensión de persona para clientes de la tienda virtual.

| Campo | Tipo | Nulo | Clave | Descripción |
| :--- | :--- | :---: | :---: | :--- |
| `idcliente` | INT(11) | NO | PK | Identificador único del cliente. |
| `idpersona` | INT(11) | SÍ | FK | Referencia a la persona (`persona.idpersona`). |

---

### Tabla: `domiciliario`
Extensión de persona para el personal encargado de entregas.

| Campo | Tipo | Nulo | Clave | Descripción |
| :--- | :--- | :---: | :---: | :--- |
| `iddomiciliario` | INT(11) | NO | PK | Identificador único del domiciliario. |
| `idpersona` | INT(11) | SÍ | FK | Referencia a la persona (`persona.idpersona`). |

---

## 2. Módulo de Catálogo y Productos

### Tabla: `catalogo`
Categorías en las que se clasifican los productos de la heladería.

| Campo | Tipo | Nulo | Clave | Descripción |
| :--- | :--- | :---: | :---: | :--- |
| `idcatalogo` | INT(11) | NO | PK | Identificador único de la categoría. |
| `nombre` | VARCHAR(255) | SÍ | | Nombre de la categoría (ej: Helados, Conos, Paletas, Bebidas). |
| `descripcion` | VARCHAR(255) | SÍ | | Breve descripción de la categoría. |
| `estado` | VARCHAR(255) | SÍ | | Estado actual de la categoría (Activo / Inactivo). |

---

### Tabla: `producto`
Almacena el catálogo de productos disponibles para la venta.

| Campo | Tipo | Nulo | Clave | Descripción |
| :--- | :--- | :---: | :---: | :--- |
| `idproducto` | INT(11) | NO | PK | Identificador único del producto. |
| `idcatalogo` | INT(11) | SÍ | FK | Categoría a la que pertenece (`catalogo.idcatalogo`). |
| `nombre` | VARCHAR(255) | SÍ | | Nombre comercial del producto. |
| `descripcion` | VARCHAR(255) | SÍ | | Descripción detallada del producto. |
| `precio` | DECIMAL(10,0) | SÍ | | Precio de venta en moneda local. |
| `imagen` | VARCHAR(255) | SÍ | | Ruta relativa de la imagen del producto. |
| `disponible` | TINYINT(1) | SÍ | | Indicador de disponibilidad (1 = Disponible, 0 = Agotado). |

---

## 3. Módulo de Inventario e Insumos

### Tabla: `insumo`
Materias primas e ingredientes utilizados en las recetas.

| Campo | Tipo | Nulo | Clave | Descripción |
| :--- | :--- | :---: | :---: | :--- |
| `idinsumo` | INT(11) | NO | PK | Identificador único del insumo. |
| `nombre` | VARCHAR(255) | SÍ | | Nombre de la materia prima (ej: Leche, Azúcar, Conos). |
| `stock_actual` | DECIMAL(10,3) | SÍ | | Cantidad disponible en bodega. |
| `stock_minimo` | DECIMAL(10,3) | SÍ | | Umbral de alerta para reabastecimiento. |
| `unidad_medida`| VARCHAR(50) | SÍ | | Unidad de medida (kg, litros, unidades, gramos). |
| `categoria` | VARCHAR(100) | SÍ | | Categoría del insumo (Lácteos, Frutas, Empaques, etc.). |

---

### Tabla: `detalle_insumo` (Recetas)
Relación entre productos e insumos requeridos para su preparación.

| Campo | Tipo | Nulo | Clave | Descripción |
| :--- | :--- | :---: | :---: | :--- |
| `iddetalle_insumo` | INT(11) | NO | PK | Identificador único del registro de receta. |
| `idproducto` | INT(11) | SÍ | FK | Producto asociado (`producto.idproducto`). |
| `idinsumo` | INT(11) | SÍ | FK | Insumo requerido (`insumo.idinsumo`). |
| `cantidad_necesaria`| DECIMAL(10,3) | SÍ | | Cantidad de insumo que descuenta una porción. |

---

### Tabla: `inventario`
Registro histórico de movimientos de bodega (entradas y salidas).

| Campo | Tipo | Nulo | Clave | Descripción |
| :--- | :--- | :---: | :---: | :--- |
| `idinventario` | INT(11) | NO | PK | Identificador único del movimiento. |
| `idinsumo` | INT(11) | SÍ | FK | Insumo afectado (`insumo.idinsumo`). |
| `tipo_entrada` | TINYINT(1) | SÍ | | 1 si corresponde a ingreso de stock. |
| `tipo_salida` | TINYINT(1) | SÍ | | 1 si corresponde a egreso o consumo. |
| `cantidad` | DECIMAL(10,3) | SÍ | | Cantidad involucrada en el movimiento. |
| `fecha` | DATETIME | SÍ | | Fecha y hora del registro. |

---

## 4. Módulo de Ventas, Pedidos y Carrito

### Tabla: `carrito` y `detalle_carrito`
Almacenan los productos seleccionados temporalmente por el cliente antes de confirmar compra.

### Tabla: `pedido` y `detalle_pedido`
Almacenan las órdenes confirmadas, el estado del pedido, total a pagar y desglose de productos solicitados.

### Tabla: `factura` y `detalle_factura`
Registro legal de facturación electrónica y comprobantes de compra.

### Tabla: `envios`
Control de despacho, asignación de domiciliario y seguimiento del estado de entrega.
