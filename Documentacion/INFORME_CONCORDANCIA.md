# Informe de concordancia — Prototipo vs. Documentación
**Proyecto:** Heladería Los Alpes · **Fecha de revisión:** 14/08/2026

Documentos contrastados:

- `REQ.SOFT Alpes.docx` (requerimientos de software, 17 REQ)
- `CASOS_D_USO_Alpes.pdf` (20 casos de uso, CU-01 a CU-20)
- `HDU Alpes ACT.7 1.xlsx` (20 historias de usuario, HU-001 a HU-020)
- `DISEÑO DEL SISTEMA.docx` (SDD, vistas 4+1)
- `alpes.sql` (modelo de datos)
- Código del prototipo en `C:\laragon\www\Heladeria_Alpes`

---

## 1. Resumen ejecutivo

| Nivel | Grado de concordancia |
|---|---|
| Modelo de datos (`alpes.sql` ↔ `sql/bdalpes.sql`) | **Alto** — 20/20 tablas idénticas |
| Casos de uso e historias de usuario (flujo funcional) | **Medio-alto** — ~15 de 20 implementados completos |
| Requerimientos funcionales (REQ.SOFT) | **Medio** — 12 de 17 completos o casi |
| Documento de diseño (SDD) | **Bajo** — arquitectura, clases y controladores no corresponden |
| Stack tecnológico declarado | **Bajo** — Laravel, JWT, pasarela de pago y SMTP no existen |

En una frase: **lo que el usuario ve funcionando coincide bastante bien con los casos de uso y las historias, pero las validaciones "alternas" (los caminos de error) y todo el documento de diseño/stack no coinciden con el prototipo.**

---

## 2. En qué SÍ concuerdan

### 2.1 Modelo de datos
El `alpes.sql` entregado y el `sql/bdalpes.sql` del proyecto definen **las mismas 20 tablas con las mismas columnas y llaves foráneas**: `persona`, `roles`, `administrador`, `cliente`, `domiciliario`, `catalogo`, `producto`, `insumo`, `detalle_insumo`, `inventario`, `proveedor`, `carrito`, `detalle_carrito`, `pedido`, `detalle_pedido`, `factura`, `detalle_factura`, `direccion`, `envios`, `notificacion`.

Única diferencia menor: `catalogo.imagen` existe en `alpes.sql` pero no en el script del proyecto (columna no usada por el código).

### 2.2 Casos de uso / historias implementados correctamente

| CU / HU / REQ | Evidencia en el código |
|---|---|
| **CU-01 / HU-001** Visualizar catálogo sin sesión | `CatalogoController::index()` es la ruta por defecto de `public/index.php`, no exige login; filtra `disponible = 1` |
| **CU-02 / HU-002 / REQ 1** Registrar usuario | `AuthController::register()` + `Persona::registrar()`: valida campos vacíos, correo duplicado y asigna rol `cliente` automáticamente. Contraseña con `password_hash(BCRYPT)` |
| **CU-03 / HU-003 / REQ 2** Iniciar sesión | `Persona::login()` compara con `password_verify()`; `AuthController` redirige por rol: admin → `admin_productos`, domiciliario → `domiciliario_pedidos`, cliente → `catalogo`. Coincide exactamente con el detalle del CU-03 |
| **CU-04 / HU-004** Personalización y carrito | `CheckoutController::guardarOpciones()` implementa yogurt / malteada sencilla ($13.000 fijo) / malteada especial / canasta / ensalada, tal como el CU-04. Carrito en sesión, como dice el documento |
| **CU-05 / HU-005 / REQ 9** Datos de entrega | `step2_entrega.php` pide destinatario, dirección, barrio, teléfono e instrucciones con `required`; ciudad fija `Campoalegre`; domicilio $2.000. Redirige al catálogo si el carrito está vacío |
| **CU-08 / HU-008** Confirmar pedido | `CheckoutController::confirmar()` inserta en `pedido` + `detalle_pedido` con estado `'pendiente'`, dentro de una transacción |
| **CU-09 / HU-009 / REQ 12** Generar factura | Inserta `factura` + `detalle_factura` en la misma transacción y redirige a `step4_factura.php`; el cliente puede imprimirla desde "Mis Pedidos" (`imprimirFactura()`) |
| **CU-07** Descuento de inventario y creación de envío | `Producto::descontarInsumos()` descuenta y registra movimiento; `Domiciliario::asignarPedido()` crea el registro en `envios` |
| **CU-10 / HU-010 / REQ 10 (parcial)** Consultar pedidos | `ClienteController::pedidos()` filtra por `idcliente` del usuario en sesión → cada cliente solo ve los suyos, como exige el CU-10 |
| **CU-13 / HU-013 / REQ 4** Gestionar productos | `AdminController::productos()` + `Producto::crearProducto/actualizarProducto` con insumos en `detalle_insumo` y borrado transaccional |
| **CU-15 / HU-015 / REQ 14 (parcial)** Inventario | Entradas y salidas registran en `inventario` con `tipo_entrada = 1` / `tipo_salida = 1` y actualizan `stock_actual`, tal cual lo documentado |
| **Alerta de stock mínimo** | `Producto::descontarInsumos()` inserta en `notificacion` (`tipo_stock_minimo = 1`) para todos los administradores, con anti-duplicado de 24 h; el panel muestra la alerta |
| **CU-16 / HU-016 / REQ 13 (parcial)** Proveedores | `AdminController::proveedores()` crea, edita y elimina |
| **CU-17 / HU-017** Gestión de pedidos por admin | `AdminController::ventas()` lista con cliente, estado, fecha y domiciliario; filtra por estado; al pasar a `pendiente`/`en proceso` invoca `Domiciliario::asignarOActualizar()` (asignación automática al domiciliario con menos pedidos activos) |
| **CU-18 / HU-018** Gestionar usuarios | Cambio de rol validando `idpersona > 0 && idrol > 0` y creación automática del perfil en `domiciliario` / `administrador` / `cliente` con `INSERT IGNORE`. Coincide literalmente con el CU-18 |
| **CU-19 / HU-019** Panel del domiciliario | Pedidos activos (`pendiente`,`en proceso`), historial (`completado`,`cancelado`), total de entregas y total del día; botones "en camino" → `en proceso` y "entregado" → `completado` |
| **CU-20 / HU-020** Chatbot | `ChatbotController` exige sesión, personaliza por rol y responde exactamente lo documentado: domicilio **$2.000**, entrega **30–45 min**, cobertura **solo Campoalegre**, métodos **Nequi / Daviplata / tarjeta** y **no efectivo** |
| **Control de acceso por rol** | `requireRole()` en todos los módulos admin y del domiciliario; el domiciliario es expulsado del catálogo desde el router |
| Estados de pedido | `pendiente → en proceso → completado / cancelado` se usan de forma consistente en BD, admin, cliente y domiciliario |

---

## 3. En qué NO concuerdan

### 3.1 Funcionalidad documentada que NO existe en el prototipo

| # | Documento | Lo que dice | Lo que hay en el código |
|---|---|---|---|
| 1 | **REQ 7 / CU-11 / HU-011 — Cancelar pedido (cliente)** | El cliente cancela su pedido en estado "pendiente" desde "Mis Pedidos" | **No existe.** No hay ruta en `public/index.php`, ni método en `ClienteController`, ni botón en `views/dashboard/cliente/pedidos.php`. Solo el administrador puede poner estado `cancelado` desde `admin_ventas` |
| 2 | **CU-06 / HU-006 esc. 2 — Validación de datos de pago** | "El cliente ingresa los datos requeridos… el sistema valida los datos"; "Datos de tarjeta inválidos → error indicando los campos incorrectos" | `step3_pago.php` solo tiene **tres radio buttons**. No se piden ni validan datos de tarjeta. Nunca puede darse el escenario de "pago rechazado" (HU-007 esc. 2) |
| 3 | **REQ 8 — Método de entrega** | "domicilio **o retiro en tienda**", costo de envío que se actualiza | Solo existe domicilio con costo fijo $2.000 (`'costo_domicilio' => 2000`). No hay opción de retiro |
| 4 | **REQ 15 / REQ 10 — Notificaciones al cliente** | Notificar al cliente en cada cambio de estado y cuando el domiciliario envía el pedido | La tabla `notificacion` solo se usa para stock mínimo. `tipo_nuevo_pedido` y `tipo_cambio_estado` **nunca se ponen en 1** |
| 5 | **HU-002 esc. 1** | "El sistema envía un correo con sus credenciales" | No hay ningún envío de correo en el proyecto (sin `mail()`, sin PHPMailer, sin SMTP) |
| 6 | **REQ 10** | El sistema muestra la **fecha estimada de entrega** | No se calcula ni se muestra en ninguna vista |
| 7 | **REQ 14** | "Los insumos pueden asociarse a un proveedor registrado" | `inventario.idproveedor` **nunca se escribe**: las entradas se insertan sin proveedor. El reporte hace `LEFT JOIN proveedor` que siempre devuelve NULL |

### 3.2 Validaciones documentadas (secuencias alternas) que faltan

| # | Documento | Regla documentada | Comportamiento real |
|---|---|---|---|
| 8 | **CU-01 / HU-001 esc. 3 / CU-12** | "Las categorías inactivas no se muestran en el catálogo público" | `views/catalogo/index.php` línea 13: `SELECT * FROM catalogo ORDER BY nombre` — **sin filtrar `estado = 'activo'`**. El toggle activo/inactivo del admin no tiene ningún efecto visible |
| 9 | **CU-04 / HU-004 esc. 2** | "Producto sin stock → mensaje de error por falta de disponibilidad" | No hay validación de stock al agregar al carrito. `Producto::descontarInsumos()` incluso comenta explícitamente *"no bloquear el pedido, solo dejar el stock en negativo"* |
| 10 | **CU-15 / HU-015 esc. 4** | "Cantidad negativa o cero → mensaje de validación"; "Stock insuficiente para salida → error" | `AdminController::inventario()` acepta cualquier cantidad y resta sin verificar stock |
| 11 | **CU-14 / HU-014 esc. 4** | "Insumo asociado a producto activo → el sistema **bloquea** la eliminación" | El código hace lo contrario: borra `inventario`, borra `detalle_insumo` y borra el insumo, sin validar nada |
| 12 | **CU-12 / HU-012 esc. 3 y 4** | Eliminar categoría solo si no tiene productos; validar nombre duplicado | `AdminController::catalogo()` inserta sin verificar duplicados y ejecuta `DELETE FROM catalogo` directo → con productos asociados lanza un error de llave foránea **no capturado** (pantalla de error PDO) |
| 13 | **CU-13 / HU-013 esc. 4** | "El sistema no guarda el producto sin imagen válida" | No se valida tipo ni tamaño del archivo; el producto se guarda igual aunque no se suba imagen |
| 14 | **REQ 13** | "Puede eliminar un proveedor **que no tenga insumos activos asociados**" | `DELETE FROM proveedor` sin validación previa |
| 15 | **CU-17** | "Pedido ya entregado al intentar cancelar → el sistema deniega la cancelación" | El `<select>` de `admin_ventas` permite pasar de `completado` a `cancelado` sin restricción |
| 16 | **CU-19** | "Pedido inválido → el sistema no realiza ninguna acción" | `DomiciliarioController::pedidos()` actualiza `pedido` por `idpedido` **sin verificar que el envío pertenezca a ese domiciliario**: un `idpedido` ajeno enviado por POST se actualiza igual |
| 17 | **HU-018 esc. 2 / CU-18** | Solo se documenta el cambio de rol | El código además **crea y elimina usuarios** (`crear_usuario`, `?eliminar=`). Funcionalidad real no documentada en ningún CU/HU |

### 3.3 Documento de Diseño (SDD) — no corresponde al prototipo

| # | El SDD dice | El código tiene |
|---|---|---|
| 18 | Controladores: `UsuarioController`, `ProductoController`, `PedidoController`, `NotificacionController`, `PagoController`, `InventarioController` | `AdminController`, `AuthController`, `CarritoController`, `CatalogoController`, `ChatbotController`, `CheckoutController`, `ClienteController`, `DomiciliarioController`. **`PedidoController`, `NotificacionController` y `PagoController` no existen.** `UsuarioController`, `ProductoController`, `InventarioController` y `ProveedorController` sí existen pero son **cascarones muertos** con comentarios "Luego conectamos con modelo…" y **no están enrutados** en `index.php` |
| 19 | Modelos: `Usuario`, `Producto`, `DetallePedido`, `Envio`, `Factura`, `Pedido`, `Inventario`, `Pago`, `Insumo`, `Proveedor` | Solo existen **3 modelos**: `Persona`, `Producto`, `Domiciliario`. Toda la lógica de pedidos, facturas, inventario y envíos vive dentro de los controladores (SQL directo), lo que rompe el MVC dibujado en el diagrama de paquetes |
| 20 | Clase `Pago` en el diagrama de clases | No existe clase ni tabla `pago`; el método de pago es un `varchar` en `factura.metodopago` |
| 21 | Vista de procesos: **"Diagrama de actividad Buscar Ruta"** (Ilustración 6) | El sistema no tiene ninguna funcionalidad de rutas ni mapas. Parece contenido copiado de otro proyecto (igual que las referencias a *Android Developers* y *Heroku*) |
| 22 | Sección **"Modelado de datos para MongoDB (JSON)"** | El sistema es 100 % MySQL relacional. Contradice al propio REQ.SOFT, que exige MySQL |
| 23 | Clase `Cliente` con `realizarPago()`, `Domiciliario` con `consultarEnvios()` | Ninguna de esas clases de dominio existe |

### 3.4 Stack tecnológico declarado vs. real

| # | REQ.SOFT §9.3 / §10 | Realidad del prototipo |
|---|---|---|
| 24 | **Backend: PHP 8.x con framework Laravel** | PHP plano con MVC artesanal y un router `switch` en `public/index.php`. **No hay Laravel** (sin `composer.json`, sin `artisan`, sin `vendor/`) |
| 25 | **Autenticación con JWT** | Sesiones nativas de PHP (`$_SESSION`) en `config/session.php`. No hay tokens |
| 26 | **Pasarela de pagos PayU o MercadoPago**, "pagos electrónicos con cifrado TLS/SSL" | El pago está **simulado**: se elige un radio button y se inserta la factura. No hay integración con ninguna pasarela |
| 27 | **Correo SMTP (Gmail o SendGrid)** | No implementado |
| 28 | **Servidor Linux Ubuntu Server LTS**, HTTPS | Entorno de desarrollo Laragon en Windows, HTTP local, `root` sin contraseña en `config/database.php` |
| 29 | REQ.SOFT §11: intercambio **JSON** con servicios externos | El único JSON es la respuesta del chatbot |

### 3.5 Funcionalidad implementada que NO está documentada

| # | En el código | Falta en |
|---|---|---|
| 30 | **Módulo de Reportes y contabilidad** (`admin_reportes`, 36 KB de vista): KPIs, ingresos por día, métodos de pago, top productos, ventas por categoría, rendimiento de domiciliarios, tendencia mensual, ganancia estimada | No aparece en ningún REQ, CU ni HU. Tampoco tiene `.md` en `Documentacion/views/dashboard/admin/` |
| 31 | **Chatbot** | Sí está en HU-020 y CU-20, pero **no aparece** en la lista de funcionalidades del REQ.SOFT §4 ni en el SDD |
| 32 | **Migración de contraseñas en texto plano** al vuelo en `Persona::login()` | No documentada (y es una regla de negocio sensible) |
| 33 | **Precios diferenciados para "Moon Ice"** (toppings a $1.000 y frutas gratis) | El CU-04 solo documenta $3.000 premium / $2.500 normales / $3.000 Hersheys |
| 34 | **Creación y eliminación de usuarios** desde el panel admin | Los CU/HU solo documentan el cambio de rol |
| 35 | Tablas `carrito` y `detalle_carrito` en el modelo de datos | Existen en la BD pero **nunca se usan**: el carrito vive solo en `$_SESSION`. El modelo de datos documenta una persistencia que el código no implementa |

### 3.6 Documentación técnica interna (`Documentacion/`)

| # | Observación |
|---|---|
| 36 | El `README.md` lista 8 controladores; el proyecto tiene 14 (6 de ellos muertos, no documentados ni enrutados) |
| 37 | No hay `.md` para `views/dashboard/admin/reportes.php`, la vista más grande del sistema |
| 38 | El README describe la carpeta como `docs/` cuando en disco se llama `Documentacion/`, y menciona XAMPP/WAMP cuando el entorno real es Laragon |

---

## 4. Recomendaciones priorizadas

**Para que el prototipo alcance a la documentación** (más rápido que reescribir los documentos):

1. Filtrar `estado = 'activo'` en la consulta de categorías del catálogo público — una línea, cierra el hallazgo #8.
2. Implementar la cancelación de pedido por el cliente (ruta + método que valide `estado = 'pendiente'` y pertenencia al cliente) — cierra REQ 7, CU-11 y HU-011.
3. Añadir las validaciones de las secuencias alternas: cantidad > 0 en inventario, stock suficiente en salidas, bloqueo de borrado de insumos/categorías/proveedores en uso, y validación de imagen. Son los hallazgos #10 a #14 y son los que un evaluador revisa primero.
4. Verificar en `DomiciliarioController` que el `idpedido` recibido pertenezca al domiciliario en sesión (#16).
5. Guardar `idproveedor` en las entradas de inventario (#7) y emitir notificaciones de cambio de estado al cliente (#4).

**Para que la documentación alcance al prototipo:**

6. Corregir el REQ.SOFT §9.3: PHP nativo (no Laravel), sesiones PHP (no JWT), pago simulado (no PayU/MercadoPago), sin SMTP. Si el pago simulado es intencional en un prototipo académico, decláralo explícitamente como "fuera de alcance de la v1.0".
7. Rehacer el SDD: diagrama de paquetes con los controladores reales, diagrama de clases con los 3 modelos reales, eliminar la sección de MongoDB y el diagrama "Buscar Ruta".
8. Agregar CU/HU para el módulo de Reportes, la creación/eliminación de usuarios y el chatbot en el REQ.SOFT §4.
9. Eliminar los controladores muertos (`UsuarioController`, `ProductoController`, `InventarioController`, `ProveedorController`, `CompraController`) o implementarlos; hoy contradicen tanto al SDD como al README.
10. Documentar en el modelo de datos que `carrito`/`detalle_carrito` no se usan, o persistir el carrito en BD como sugiere el diseño.
