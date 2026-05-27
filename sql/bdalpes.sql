-- ============================================================
-- BASE DE DATOS: bdalpes  —  Archivo único consolidado
-- ============================================================
-- Incluye: esquema, datos de catálogo, productos, insumos
--          y vínculos de recetas (detalle_insumo).
-- Ejecutar completo para instalación desde cero.
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ============================================================
-- DROP TABLE IF EXISTS (orden inverso de dependencias FK)
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `notificacion`;
DROP TABLE IF EXISTS `inventario`;
DROP TABLE IF EXISTS `detalle_insumo`;
DROP TABLE IF EXISTS `detalle_factura`;
DROP TABLE IF EXISTS `factura`;
DROP TABLE IF EXISTS `envios`;
DROP TABLE IF EXISTS `detalle_pedido`;
DROP TABLE IF EXISTS `detalle_carrito`;
DROP TABLE IF EXISTS `pedido`;
DROP TABLE IF EXISTS `carrito`;
DROP TABLE IF EXISTS `producto`;
DROP TABLE IF EXISTS `catalogo`;
DROP TABLE IF EXISTS `insumo`;
DROP TABLE IF EXISTS `proveedor`;
DROP TABLE IF EXISTS `administrador`;
DROP TABLE IF EXISTS `domiciliario`;
DROP TABLE IF EXISTS `cliente`;
DROP TABLE IF EXISTS `direccion`;
DROP TABLE IF EXISTS `persona`;
DROP TABLE IF EXISTS `roles`;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- CREATE TABLE
-- ============================================================

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `idrol` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `administrador` (
  `idadministrador` int(11) NOT NULL,
  `idpersona` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `idpersona` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `domiciliario` (
  `iddomiciliario` int(11) NOT NULL,
  `idpersona` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `direccion` (
  `iddireccion` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `catalogo` (
  `idcatalogo` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `idcatalogo` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` decimal(10,0) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `insumo` (
  `idinsumo` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `stock_actual` decimal(10,2) DEFAULT NULL,
  `stock_minimo` decimal(10,2) DEFAULT NULL,
  `unidad_medida` varchar(255) DEFAULT NULL,
  `categoria` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `proveedor` (
  `idproveedor` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `carrito` (
  `idcarrito` int(11) NOT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detalle_carrito` (
  `iddetallecarrito` int(11) NOT NULL,
  `idcarrito` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tamano` varchar(255) DEFAULT NULL,
  `sabores` varchar(255) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `precio_unitario` decimal(10,0) DEFAULT NULL,
  `subtotal` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pedido` (
  `idpedido` int(11) NOT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detalle_pedido` (
  `iddetalle` int(11) NOT NULL,
  `idpedido` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tamano` varchar(255) DEFAULT NULL,
  `sabores` varchar(255) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `precio_unitario` decimal(10,0) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `factura` (
  `idfactura` int(11) NOT NULL,
  `idpedido` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `metodopago` varchar(255) DEFAULT NULL,
  `totalfactura` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detalle_factura` (
  `iddetalle` int(11) NOT NULL,
  `idfactura` int(11) DEFAULT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,0) DEFAULT NULL,
  `total` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- NOTA: idadministrador es nullable para permitir pedidos sin admin registrado
CREATE TABLE `envios` (
  `idenvio` int(11) NOT NULL,
  `idpedido` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `idadministrador` int(11) DEFAULT NULL,
  `iddomiciliario` int(11) DEFAULT NULL,
  `iddireccion` int(11) DEFAULT NULL,
  `telefono_contacto` varchar(255) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `detalle_insumo` (
  `iddetalle` int(11) NOT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `idinsumo` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `inventario` (
  `idinventario` int(11) NOT NULL,
  `idinsumo` int(11) DEFAULT NULL,
  `idadministrador` int(11) DEFAULT NULL,
  `idproveedor` int(11) DEFAULT NULL,
  `tipo_entrada` tinyint(1) DEFAULT NULL,
  `tipo_salida` tinyint(1) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `notificacion` (
  `idnotificacion` int(11) NOT NULL,
  `idpersona` int(11) DEFAULT NULL,
  `idinsumo` int(11) DEFAULT NULL,
  `tipo_stock_minimo` tinyint(1) DEFAULT NULL,
  `tipo_nuevo_pedido` tinyint(1) DEFAULT NULL,
  `tipo_cambio_estado` tinyint(1) DEFAULT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- Índices y AUTO_INCREMENT
-- ============================================================

ALTER TABLE `administrador`   ADD PRIMARY KEY (`idadministrador`), ADD KEY `idpersona` (`idpersona`);
ALTER TABLE `carrito`         ADD PRIMARY KEY (`idcarrito`),        ADD KEY `idcliente` (`idcliente`);
ALTER TABLE `catalogo`        ADD PRIMARY KEY (`idcatalogo`);
ALTER TABLE `cliente`         ADD PRIMARY KEY (`idcliente`),        ADD KEY `idpersona` (`idpersona`);
ALTER TABLE `detalle_carrito` ADD PRIMARY KEY (`iddetallecarrito`), ADD KEY `idcarrito` (`idcarrito`), ADD KEY `idproducto` (`idproducto`);
ALTER TABLE `detalle_factura` ADD PRIMARY KEY (`iddetalle`),        ADD KEY `idfactura` (`idfactura`), ADD KEY `idproducto` (`idproducto`);
ALTER TABLE `detalle_insumo`  ADD PRIMARY KEY (`iddetalle`),        ADD KEY `idproducto` (`idproducto`), ADD KEY `idinsumo` (`idinsumo`);
ALTER TABLE `detalle_pedido`  ADD PRIMARY KEY (`iddetalle`),        ADD KEY `idpedido` (`idpedido`), ADD KEY `idproducto` (`idproducto`);
ALTER TABLE `direccion`       ADD PRIMARY KEY (`iddireccion`);
ALTER TABLE `domiciliario`    ADD PRIMARY KEY (`iddomiciliario`),   ADD KEY `idpersona` (`idpersona`);
ALTER TABLE `envios`          ADD PRIMARY KEY (`idenvio`),          ADD KEY `idpedido` (`idpedido`), ADD KEY `idcliente` (`idcliente`), ADD KEY `idadministrador` (`idadministrador`), ADD KEY `iddomiciliario` (`iddomiciliario`), ADD KEY `iddireccion` (`iddireccion`);
ALTER TABLE `factura`         ADD PRIMARY KEY (`idfactura`),        ADD KEY `idpedido` (`idpedido`);
ALTER TABLE `insumo`          ADD PRIMARY KEY (`idinsumo`);
ALTER TABLE `inventario`      ADD PRIMARY KEY (`idinventario`),     ADD KEY `idinsumo` (`idinsumo`), ADD KEY `idadministrador` (`idadministrador`), ADD KEY `idproveedor` (`idproveedor`);
ALTER TABLE `notificacion`    ADD PRIMARY KEY (`idnotificacion`),   ADD KEY `idpersona` (`idpersona`), ADD KEY `idinsumo` (`idinsumo`);
ALTER TABLE `pedido`          ADD PRIMARY KEY (`idpedido`),         ADD KEY `idcliente` (`idcliente`);
ALTER TABLE `persona`         ADD PRIMARY KEY (`idpersona`),        ADD KEY `idrol` (`idrol`);
ALTER TABLE `producto`        ADD PRIMARY KEY (`idproducto`),       ADD KEY `idcatalogo` (`idcatalogo`);
ALTER TABLE `proveedor`       ADD PRIMARY KEY (`idproveedor`);
ALTER TABLE `roles`           ADD PRIMARY KEY (`idrol`);

ALTER TABLE `administrador`   MODIFY `idadministrador`  int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `carrito`         MODIFY `idcarrito`         int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `catalogo`        MODIFY `idcatalogo`        int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `cliente`         MODIFY `idcliente`         int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `detalle_carrito` MODIFY `iddetallecarrito`  int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `detalle_factura` MODIFY `iddetalle`         int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `detalle_insumo`  MODIFY `iddetalle`         int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `detalle_pedido`  MODIFY `iddetalle`         int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `direccion`       MODIFY `iddireccion`       int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `domiciliario`    MODIFY `iddomiciliario`    int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `envios`          MODIFY `idenvio`           int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `factura`         MODIFY `idfactura`         int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `insumo`          MODIFY `idinsumo`          int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `inventario`      MODIFY `idinventario`      int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `notificacion`    MODIFY `idnotificacion`    int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pedido`          MODIFY `idpedido`          int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `persona`         MODIFY `idpersona`         int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `producto`        MODIFY `idproducto`        int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `proveedor`       MODIFY `idproveedor`       int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `roles`           MODIFY `idrol`             int(11) NOT NULL AUTO_INCREMENT;

-- ============================================================
-- Foreign keys
-- NOTA: envios.idadministrador usa FK nullable (sin ON DELETE)
-- ============================================================

ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`);

ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`);

ALTER TABLE `detalle_carrito`
  ADD CONSTRAINT `detalle_carrito_ibfk_1` FOREIGN KEY (`idcarrito`) REFERENCES `carrito` (`idcarrito`),
  ADD CONSTRAINT `detalle_carrito_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`);

ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `detalle_factura_ibfk_1` FOREIGN KEY (`idfactura`) REFERENCES `factura` (`idfactura`),
  ADD CONSTRAINT `detalle_factura_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`);

ALTER TABLE `detalle_insumo`
  ADD CONSTRAINT `detalle_insumo_ibfk_1` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`),
  ADD CONSTRAINT `detalle_insumo_ibfk_2` FOREIGN KEY (`idinsumo`) REFERENCES `insumo` (`idinsumo`);

ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`idpedido`) REFERENCES `pedido` (`idpedido`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`idproducto`) REFERENCES `producto` (`idproducto`);

ALTER TABLE `domiciliario`
  ADD CONSTRAINT `domiciliario_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`);

ALTER TABLE `envios`
  ADD CONSTRAINT `envios_ibfk_1` FOREIGN KEY (`idpedido`)        REFERENCES `pedido`        (`idpedido`),
  ADD CONSTRAINT `envios_ibfk_2` FOREIGN KEY (`idcliente`)       REFERENCES `cliente`       (`idcliente`),
  ADD CONSTRAINT `envios_ibfk_3` FOREIGN KEY (`idadministrador`) REFERENCES `administrador` (`idadministrador`),
  ADD CONSTRAINT `envios_ibfk_4` FOREIGN KEY (`iddomiciliario`)  REFERENCES `domiciliario`  (`iddomiciliario`),
  ADD CONSTRAINT `envios_ibfk_5` FOREIGN KEY (`iddireccion`)     REFERENCES `direccion`     (`iddireccion`);

ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`idpedido`) REFERENCES `pedido` (`idpedido`);

ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`idinsumo`)        REFERENCES `insumo`        (`idinsumo`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`idadministrador`) REFERENCES `administrador` (`idadministrador`),
  ADD CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`idproveedor`)     REFERENCES `proveedor`     (`idproveedor`);

ALTER TABLE `notificacion`
  ADD CONSTRAINT `notificacion_ibfk_1` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`),
  ADD CONSTRAINT `notificacion_ibfk_2` FOREIGN KEY (`idinsumo`)  REFERENCES `insumo`  (`idinsumo`);

ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`);

ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`idrol`) REFERENCES `roles` (`idrol`);

ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idcatalogo`) REFERENCES `catalogo` (`idcatalogo`);

-- ============================================================
-- Roles
-- ============================================================

INSERT IGNORE INTO `roles` (`idrol`, `nombre`) VALUES
(1, 'administrador'),
(2, 'domiciliario'),
(3, 'cliente');

COMMIT;

-- ============================================================
-- Catálogos y Productos
-- ============================================================

START TRANSACTION;

INSERT IGNORE INTO `catalogo` (`nombre`, `descripcion`, `estado`) VALUES
('Helado de Yogurt',    'Helado de yogurt bajo en grasa y en azúcar',                    'activo'),
('Ensaladas de Frutas', 'Ensaladas frescas de frutas naturales',                          'activo'),
('Malteadas',           'Malteadas artesanales de distintos sabores',                     'activo'),
('Canastas',            'Canastas de frutas frescas',                                     'activo'),
('Waffles',             'Waffles artesanales belgas, crujientes por fuera y suaves por dentro', 'activo');

SET @id_yogurt   = (SELECT idcatalogo FROM catalogo WHERE nombre = 'Helado de Yogurt'    LIMIT 1);
SET @id_ensalada = (SELECT idcatalogo FROM catalogo WHERE nombre = 'Ensaladas de Frutas' LIMIT 1);
SET @id_malt     = (SELECT idcatalogo FROM catalogo WHERE nombre = 'Malteadas'           LIMIT 1);
SET @id_canasta  = (SELECT idcatalogo FROM catalogo WHERE nombre = 'Canastas'            LIMIT 1);
SET @id_waffle   = (SELECT idcatalogo FROM catalogo WHERE nombre = 'Waffles'             LIMIT 1);

-- ── Helado de Yogurt ─────────────────────────────────────────────────────────

INSERT IGNORE INTO `producto` (`idcatalogo`, `nombre`, `descripcion`, `precio`, `imagen`, `disponible`) VALUES
(@id_yogurt, 'Cono',             'Cono de helado de yogurt',                                                                                                                                    6000,  '', 1),
(@id_yogurt, 'Ice Pequeño',      'Precio de la base. Adicionalmente cada acompañamiento que desees por $2.500 o $3.000 si es topping Premium. 9 onz',                                           9000,  '', 1),
(@id_yogurt, 'Ice Mediano',      'Precio de la base. Adicionalmente cada acompañamiento que desees por $2.500 o $3.000 si es topping Premium. 12 onz',                                          11000, '', 1),
(@id_yogurt, 'Ice Grande',       'Precio de la base. Adicionalmente cada acompañamiento que desees por $2.500 o $3.000 si es topping Premium. 22 onz',                                          18000, '', 1),
(@id_yogurt, 'Moon Ice',         'La base + 4 acompañamientos (Toppings Premium tienen recargo de $1.000). 16 onz',                                                                             17000, 'img/1777493398_moonice.jpeg', 1),
(@id_yogurt, 'Ice Fit',          'La base + Arándanos + Granola + Fresa + Nueces. 16 onz',                                                                                                     18000, '', 1),
(@id_yogurt, 'Chocoencanto',     'Base de helado + Chokis + Chocmelos + Chocolatina jet + chips de chocolate + jarabe Hershey\'s de chocolate. 16 onz',                                        19000, '', 1),
(@id_yogurt, 'Yogojet',          'Base de helado + Jet crema + Jet chocolatina + Jet gool + Jet wafer + jet burbuja cookies and cream. 16 onz',                                                 21000, '', 1),
(@id_yogurt, '7 Deseos',         'Precio de la base + 7 acompañamientos, puede escoger 2 acompañamientos premium. 22 onz',                                                                     26000, '', 1),
(@id_yogurt, 'Parfait',          'Base de helado + 3 tipos de fruta. 12 onz',                                                                                                                  14000, '', 1),
(@id_yogurt, 'Nucilover',        'Base de helado + galleta nucita + crema nucita + choc. Nucita. 12 onz',                                                                                      16000, '', 1),
(@id_yogurt, 'Quesoy',           'Base de helado + 2 capas de queso doble crema. 9 onz',                                                                                                       13000, '', 1),
(@id_yogurt, 'Poping',           'Base de helado + 2 sabores de caviar. 9 onz',                                                                                                                13000, '', 1),
(@id_yogurt, 'Oreo',             'Base de helado + oreo triturada. 9 onz',                                                                                                                     11000, '', 1),
(@id_yogurt, 'Brownie',          'Base de helado + trozos de Brownie. 9 onz',                                                                                                                  11000, '', 1),
(@id_yogurt, 'Macflurry',        'Base de helado + M&M. 9 onz',                                                                                                                                11000, '', 1),
(@id_yogurt, 'Macflurry de Milo','Base de helado + Milo + Nuggets de milo. 9 onz',                                                                                                             12000, '', 1),
(@id_yogurt, 'Yoguramo',         'Base de helado + chocorramo. 9 onz',                                                                                                                         11000, '', 1),
(@id_yogurt, 'Sundae Chocolate', 'Base de helado con salsa de chocolate. 9 onz',                                                                                                               11000, '', 1),
(@id_yogurt, 'Sundae Maracuyá',  'Base de helado con salsa de maracuyá. 9 onz',                                                                                                                11000, '', 1),
(@id_yogurt, 'Sundae Caramelo',  'Base de helado con salsa de caramelo. 9 onz',                                                                                                                11000, '', 1),
(@id_yogurt, 'Sundae Mora',      'Base de helado con salsa de mora. 9 onz',                                                                                                                    11000, '', 1),
(@id_yogurt, 'Sundae Fresa',     'Base de helado con salsa de fresa. 9 onz',                                                                                                                   11000, '', 1),
(@id_yogurt, 'Sundae Arequipe',  'Base de helado con salsa de arequipe. 9 onz',                                                                                                                11000, '', 1);

-- ── Ensaladas de Frutas ───────────────────────────────────────────────────────

INSERT IGNORE INTO `producto` (`idcatalogo`, `nombre`, `descripcion`, `precio`, `imagen`, `disponible`) VALUES
(@id_ensalada, 'Super Especial', '3 sabores de helado, fruta fresca, acompañado de salsa, crema chantilly, galletas y queso doble crema.', 25000, 'img/1778029281_EnsaladaESP.jpg', 1),
(@id_ensalada, 'Especial',       '2 sabores de helado, fruta fresca, acompañado de salsa, galleta y queso doble crema.',                   19000, 'img/1778029281_EnsaladaESP.jpg', 1),
(@id_ensalada, 'Mini',           '1 sabor de helado, fruta fresca, acompañado de salsa, galletas y queso doble crema.',                    15000, 'img/1778029281_EnsaladaESP.jpg', 1);

-- ── Waffles ───────────────────────────────────────────────────────────────────

INSERT IGNORE INTO `producto` (`idcatalogo`, `nombre`, `descripcion`, `precio`, `imagen`, `disponible`) VALUES
(@id_waffle, 'Waffle Clasico',          'Waffle dorado, crujiente por fuera y suave por dentro, un toque de azucar glass y untable de tu preferencia.',                                    13500, '', 1),
(@id_waffle, 'Waffle Jamon y Queso',    'Waffle doradito, Jamon, queso doble crema. De sal.',                                                                                              16500, '', 1),
(@id_waffle, 'Waffle Quesudo',          'Waffle doradito, cargado con abundante queso doble crema, untable opcional. De sal.',                                                             17000, '', 1),
(@id_waffle, 'Waffle con Helado',       'Waffle doradito, 3 sabores de helado a tu eleccion, untable de tu preferencia.',                                                                  17000, '', 1),
(@id_waffle, 'Waffle Fresura',          'Crema de la casa o crema chantilly, fresas, syrup de fresa Hersheys y helado a tu eleccion.',                                                     19900, '', 1),
(@id_waffle, 'Waffle Frutal',           'Crema chantilly o crema de la casa, 4 tipos de fruta, untable de tu preferencia y helado a tu eleccion.',                                         19900, '', 1),
(@id_waffle, 'Waffle Frutos Amarillos', 'Crema de la casa o crema chantilly, Pina, durazno, mango, pulpa de maracuya, untable de tu preferencia y helado a tu eleccion.',                  19900, '', 1),
(@id_waffle, 'Waffle Frutos Rojos',     'Crema de la casa o crema chantilly, fresas, uvas, arandanos, cerezas, mermelada de mora o fresa y helado a tu eleccion.',                         19900, '', 1),
(@id_waffle, 'Waffle Banana Fest',      'Arequipe, crema chantilly, banano, untable de tu preferencia y helado a tu eleccion.',                                                            18900, '', 1),
(@id_waffle, 'Waffle Tropical Fit',     'Syrup de miel, kiwi, arandanos, fresas, granola y helado de yogurt.',                                                                            19900, '', 1),
(@id_waffle, 'Waffle Chocoso',          'Nutella, oreo, chocorramo, chokis, chocolatina cookies and crema, y helado a tu eleccion.',                                                       25900, '', 1),
(@id_waffle, 'Waffle Alpes',            'Nutella, arequipe, Brownies, 2 sabores de caviar, barquillos, delicioso helado de yogurt.',                                                       22900, '', 1),
(@id_waffle, 'Waffle Oreo',             'Nutella, Galletas oreo, fideos de chocolate, salsa de chocolate y helado a tu eleccion.',                                                         18900, '', 1),
(@id_waffle, 'Waffle Chocorramo',       'Nutella, chocorramo, chips de chocolate, salsa de chocolate y helado a tu eleccion.',                                                             18900, '', 1),
(@id_waffle, 'Waffle Milo',             'Arequipe, milo en polvo, nuggets de milo, salsa de chocolate y helado a tu eleccion.',                                                            18900, '', 1),
(@id_waffle, 'Waffle Nutella',          'Nutella, chocobreak, fresas, chocmelos, chips de chocolate y helado a tu eleccion.',                                                              23900, '', 1),
(@id_waffle, 'Waffle Hersheys',         'Nutella, chocolatina Hersheys, chokis, fideos de chocolate, syrup Hershey a tu eleccion y helado a tu eleccion.',                                23900, '', 1),
(@id_waffle, 'Waffle Jet',              'Chocolatina jet, jet gool, jet wafer, pepitas de chocolate, salsa de chocolate y helado a tu eleccion.',                                          23900, '', 1),
(@id_waffle, 'Waffle Kinder',           'Nutella, chocolatina kinder, chokis, pepitas de chocolate y helado a tu eleccion.',                                                               23900, '', 1),
(@id_waffle, 'Waffle Nucita',           'Crema nucita, galletas nucita, chocolatinas nucita, chips de chocolate, salsa de chocolate y helado a tu eleccion.',                              23900, '', 1),
(@id_waffle, 'Waffle Entero',           'Clasico waffle belga entero. Elige 1-2 untables, 4 toppings y 1 sabor de helado. Adicion bola de helado extra: $4.000.',                         23000, '', 1),
(@id_waffle, 'Waffle Medio',            'Clasico waffle belga mitad. Elige 1-2 untables, 2 toppings y 1 sabor de helado. Adicion bola de helado extra: $4.000.',                          16000, '', 1);

COMMIT;

-- ============================================================
-- Insumos
-- ============================================================

START TRANSACTION;

INSERT IGNORE INTO insumo (nombre, stock_actual, stock_minimo, unidad_medida, categoria) VALUES
-- Sabores de helado
('Helado Frutos rojos',    10, 1, 'litros', 'Helado'),
('Helado Maracuya',        10, 1, 'litros', 'Helado'),
('Helado Chicle',          10, 1, 'litros', 'Helado'),
('Helado Tres Leches',     10, 1, 'litros', 'Helado'),
('Helado Coffe Delight',   10, 1, 'litros', 'Helado'),
('Helado Crema con Mani',  10, 1, 'litros', 'Helado'),
('Helado Chocolate',       10, 1, 'litros', 'Helado'),
('Helado Vainilla Chips',  10, 1, 'litros', 'Helado'),
('Helado Brownie',         10, 1, 'litros', 'Helado'),
('Helado Arequipe',        10, 1, 'litros', 'Helado'),
('Helado Uva Vainilla',    10, 1, 'litros', 'Helado'),
('Helado Lulo',            10, 1, 'litros', 'Helado'),
('Helado Nucita',          10, 1, 'litros', 'Helado'),
('Helado Ron con pasas',   10, 1, 'litros', 'Helado'),
('Helado Mandarina Limon', 10, 1, 'litros', 'Helado'),
('Helado Acid Mix',        10, 1, 'litros', 'Helado'),
('Helado Napolitano',      10, 1, 'litros', 'Helado'),
('Helado Unicornio',       10, 1, 'litros', 'Helado'),
('Helado Sandia',          10, 1, 'litros', 'Helado'),
('Helado Yogurt',          10, 1, 'litros', 'Helado'),
('Helado Nutella',         10, 1, 'litros', 'Helado'),
('Helado Kiwi',            10, 1, 'litros', 'Helado'),
-- Frutas
('Kiwi',              50, 5, 'unidad', 'Fruta'),
('Fresas',            50, 5, 'unidad', 'Fruta'),
('Cerezas',           50, 5, 'unidad', 'Fruta'),
('Duraznos',          50, 5, 'unidad', 'Fruta'),
('Mango',             50, 5, 'unidad', 'Fruta'),
('Pina',              50, 5, 'unidad', 'Fruta'),
('Banano',            50, 5, 'unidad', 'Fruta'),
('Pulpa de maracuya', 50, 5, 'unidad', 'Fruta'),
('Uvas',              50, 5, 'unidad', 'Fruta'),
('Melon',             50, 5, 'unidad', 'Fruta'),
('Papaya',            50, 5, 'unidad', 'Fruta'),
('Manzana',           50, 5, 'unidad', 'Fruta'),
-- Toppings Premium
('Arandanos',        30, 3, 'unidad', 'Topping Premium'),
('Nueces',           30, 3, 'unidad', 'Topping Premium'),
('Almendras',        30, 3, 'unidad', 'Topping Premium'),
('Granola',          30, 3, 'unidad', 'Topping Premium'),
('Queso doble crema',30, 3, 'unidad', 'Topping Premium'),
('Caviar',           20, 2, 'unidad', 'Topping Premium'),
-- Toppings Dulces
('Chokis',                    30, 3, 'unidad', 'Topping Dulce'),
('Galletas oreo',             30, 3, 'unidad', 'Topping Dulce'),
('Chocorramo',                30, 3, 'unidad', 'Topping Dulce'),
('Gol',                       30, 3, 'unidad', 'Topping Dulce'),
('Barquillos',                30, 3, 'unidad', 'Topping Dulce'),
('Chocolatina nucita',        30, 3, 'unidad', 'Topping Dulce'),
('Galletas nucita',           30, 3, 'unidad', 'Topping Dulce'),
('Brownie',                   30, 3, 'unidad', 'Topping Dulce'),
('Jet cookies and cream',     30, 3, 'unidad', 'Topping Dulce'),
('Jet barras',                30, 3, 'unidad', 'Topping Dulce'),
('Jet wafer',                 30, 3, 'unidad', 'Topping Dulce'),
('Jet gool',                  30, 3, 'unidad', 'Topping Dulce'),
('Chips de chocolate',        30, 3, 'unidad', 'Topping Dulce'),
('M&M',                       30, 3, 'unidad', 'Topping Dulce'),
('Fideos de chocolate',       30, 3, 'unidad', 'Topping Dulce'),
('Pepitas de chocolate',      30, 3, 'unidad', 'Topping Dulce'),
('Zucaritas',                 30, 3, 'unidad', 'Topping Dulce'),
('Aros Cereal',               30, 3, 'unidad', 'Topping Dulce'),
('Choco Krispis',             30, 3, 'unidad', 'Topping Dulce'),
('Chocmelos',                 30, 3, 'unidad', 'Topping Dulce'),
('Chocobreak',                30, 3, 'unidad', 'Topping Dulce'),
('Sparkies',                  30, 3, 'unidad', 'Topping Dulce'),
('Golochips',                 30, 3, 'unidad', 'Topping Dulce'),
('Galletas Minichips',        30, 3, 'unidad', 'Topping Dulce'),
('Ositos Trululu',            30, 3, 'unidad', 'Topping Dulce'),
('Gusanos gomitas',           30, 3, 'unidad', 'Topping Dulce'),
('Masmelos',                  30, 3, 'unidad', 'Topping Dulce'),
('Milo',                      30, 3, 'unidad', 'Topping Dulce'),
('Nuggets de Milo',           30, 3, 'unidad', 'Topping Dulce'),
('Pepitas de colores',        30, 3, 'unidad', 'Topping Dulce'),
('Chocolatina kinder bueno',  30, 3, 'unidad', 'Topping Dulce'),
('Chocolatina Hersheys',      30, 3, 'unidad', 'Topping Dulce'),
-- Salsas
('Arequipe',         20, 2, 'unidad', 'Salsa'),
('Relleno de Mora',  20, 2, 'unidad', 'Salsa'),
('Relleno de Fresa', 20, 2, 'unidad', 'Salsa'),
('Salsa de Chocolate',20,2, 'unidad', 'Salsa'),
('Lechera',          20, 2, 'unidad', 'Salsa'),
('Syrup de Fresa',   20, 2, 'unidad', 'Salsa'),
('Syrup de Caramelo',20, 2, 'unidad', 'Salsa'),
('Syrup de Chocolate',20,2, 'unidad', 'Salsa'),
-- Base
('Galleta canasta',  100, 10, 'unidad', 'Base'),
('Crema chantilly',   20,  2, 'unidad', 'Base'),
('Crema de la casa',  20,  2, 'unidad', 'Base'),
('Nutella',           20,  2, 'unidad', 'Base'),
('Mermelada de mora', 20,  2, 'unidad', 'Base'),
('Mermelada de fresa',20,  2, 'unidad', 'Base'),
('Miel maple',        20,  2, 'unidad', 'Base'),
('Waffle belga',     100, 10, 'unidad', 'Base');

COMMIT;

-- ============================================================
-- Vínculos de recetas (detalle_insumo)
-- ============================================================

START TRANSACTION;

-- Variables de insumos
SET @h_frutos    = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Frutos rojos'   LIMIT 1);
SET @h_maracuya  = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Maracuya'       LIMIT 1);
SET @h_chicle    = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Chicle'         LIMIT 1);
SET @h_tres      = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Tres Leches'    LIMIT 1);
SET @h_choco     = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Chocolate'      LIMIT 1);
SET @h_vainilla  = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Vainilla Chips' LIMIT 1);
SET @h_brownie   = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Brownie'        LIMIT 1);
SET @h_arequipe  = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Arequipe'       LIMIT 1);
SET @h_uva       = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Uva Vainilla'   LIMIT 1);
SET @h_lulo      = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Lulo'           LIMIT 1);
SET @h_mandarina = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Mandarina Limon'LIMIT 1);
SET @h_acid      = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Acid Mix'       LIMIT 1);
SET @h_yogurt    = (SELECT idinsumo FROM insumo WHERE nombre = 'Helado Yogurt'         LIMIT 1);

SET @i_galleta    = (SELECT idinsumo FROM insumo WHERE nombre = 'Galleta canasta'         LIMIT 1);
SET @i_chantilly  = (SELECT idinsumo FROM insumo WHERE nombre = 'Crema chantilly'         LIMIT 1);
SET @i_queso      = (SELECT idinsumo FROM insumo WHERE nombre = 'Queso doble crema'       LIMIT 1);
SET @i_fresas     = (SELECT idinsumo FROM insumo WHERE nombre = 'Fresas'                  LIMIT 1);
SET @i_chokis     = (SELECT idinsumo FROM insumo WHERE nombre = 'Chokis'                  LIMIT 1);
SET @i_oreo       = (SELECT idinsumo FROM insumo WHERE nombre = 'Galletas oreo'           LIMIT 1);
SET @i_chocorramo = (SELECT idinsumo FROM insumo WHERE nombre = 'Chocorramo'              LIMIT 1);
SET @i_chips      = (SELECT idinsumo FROM insumo WHERE nombre = 'Chips de chocolate'      LIMIT 1);
SET @i_mm         = (SELECT idinsumo FROM insumo WHERE nombre = 'M&M'                     LIMIT 1);
SET @i_fideos     = (SELECT idinsumo FROM insumo WHERE nombre = 'Fideos de chocolate'     LIMIT 1);
SET @i_chocmelos  = (SELECT idinsumo FROM insumo WHERE nombre = 'Chocmelos'               LIMIT 1);
SET @i_gomitas    = (SELECT idinsumo FROM insumo WHERE nombre = 'Gusanos gomitas'         LIMIT 1);
SET @i_masmelos   = (SELECT idinsumo FROM insumo WHERE nombre = 'Masmelos'                LIMIT 1);
SET @i_pepitas_c  = (SELECT idinsumo FROM insumo WHERE nombre = 'Pepitas de colores'      LIMIT 1);
SET @i_pepitas_ch = (SELECT idinsumo FROM insumo WHERE nombre = 'Pepitas de chocolate'    LIMIT 1);
SET @i_nutella    = (SELECT idinsumo FROM insumo WHERE nombre = 'Nutella'                 LIMIT 1);
SET @i_milo       = (SELECT idinsumo FROM insumo WHERE nombre = 'Milo'                    LIMIT 1);
SET @i_nuggets    = (SELECT idinsumo FROM insumo WHERE nombre = 'Nuggets de Milo'         LIMIT 1);
SET @i_waffle     = (SELECT idinsumo FROM insumo WHERE nombre = 'Waffle belga'            LIMIT 1);
SET @i_arandanos  = (SELECT idinsumo FROM insumo WHERE nombre = 'Arandanos'               LIMIT 1);
SET @i_granola    = (SELECT idinsumo FROM insumo WHERE nombre = 'Granola'                 LIMIT 1);
SET @i_nueces     = (SELECT idinsumo FROM insumo WHERE nombre = 'Nueces'                  LIMIT 1);
SET @i_banano     = (SELECT idinsumo FROM insumo WHERE nombre = 'Banano'                  LIMIT 1);
SET @i_kiwi       = (SELECT idinsumo FROM insumo WHERE nombre = 'Kiwi'                    LIMIT 1);
SET @i_pina       = (SELECT idinsumo FROM insumo WHERE nombre = 'Pina'                    LIMIT 1);
SET @i_s_choco    = (SELECT idinsumo FROM insumo WHERE nombre = 'Salsa de Chocolate'      LIMIT 1);
SET @i_s_fresa    = (SELECT idinsumo FROM insumo WHERE nombre = 'Syrup de Fresa'          LIMIT 1);
SET @i_mora       = (SELECT idinsumo FROM insumo WHERE nombre = 'Relleno de Mora'         LIMIT 1);
SET @i_arequipe   = (SELECT idinsumo FROM insumo WHERE nombre = 'Arequipe'                LIMIT 1);
SET @i_chocobreak = (SELECT idinsumo FROM insumo WHERE nombre = 'Chocobreak'              LIMIT 1);
SET @i_jet_w      = (SELECT idinsumo FROM insumo WHERE nombre = 'Jet wafer'               LIMIT 1);
SET @i_jet_g      = (SELECT idinsumo FROM insumo WHERE nombre = 'Jet gool'                LIMIT 1);
SET @i_jet_c      = (SELECT idinsumo FROM insumo WHERE nombre = 'Jet cookies and cream'   LIMIT 1);
SET @i_barquillos = (SELECT idinsumo FROM insumo WHERE nombre = 'Barquillos'              LIMIT 1);
SET @i_kinder     = (SELECT idinsumo FROM insumo WHERE nombre = 'Chocolatina kinder bueno'LIMIT 1);
SET @i_hersheys   = (SELECT idinsumo FROM insumo WHERE nombre = 'Chocolatina Hersheys'    LIMIT 1);
SET @i_g_nucita   = (SELECT idinsumo FROM insumo WHERE nombre = 'Galletas nucita'         LIMIT 1);
SET @i_c_nucita   = (SELECT idinsumo FROM insumo WHERE nombre = 'Chocolatina nucita'      LIMIT 1);
SET @i_brownie_t  = (SELECT idinsumo FROM insumo WHERE nombre = 'Brownie'                 LIMIT 1);
SET @i_caviar     = (SELECT idinsumo FROM insumo WHERE nombre = 'Caviar'                  LIMIT 1);

-- ── Helados de Yogurt ─────────────────────────────────────────────────────────

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Cono'          LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @h_yogurt, 0.05);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Ice Pequeño'   LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @h_yogurt, 0.10);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Ice Mediano'   LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @h_yogurt, 0.15);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Ice Grande'    LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @h_yogurt, 0.25);

SET @p = (SELECT idproducto FROM producto WHERE nombre LIKE '%Moon%Ice%' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @h_yogurt, 0.20);

SET @p = (SELECT idproducto FROM producto WHERE nombre = '7 Deseos'      LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @h_yogurt, 0.25);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Ice Fit' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.20), (@p, @i_arandanos, 1), (@p, @i_granola, 1), (@p, @i_fresas, 1), (@p, @i_nueces, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Chocoencanto' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.20), (@p, @i_chokis, 1), (@p, @i_chocmelos, 1), (@p, @i_chips, 1), (@p, @i_s_choco, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Yogojet' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.20), (@p, @i_jet_w, 1), (@p, @i_jet_g, 1), (@p, @i_jet_c, 1), (@p, @i_barquillos, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Parfait' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.15), (@p, @i_fresas, 1), (@p, @i_kiwi, 1), (@p, @i_banano, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Nucilover' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.15), (@p, @i_g_nucita, 1), (@p, @i_c_nucita, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Quesoy' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.10), (@p, @i_queso, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Poping' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.10), (@p, @i_caviar, 1);

SET @p = (SELECT idproducto FROM producto p JOIN catalogo c ON p.idcatalogo=c.idcatalogo WHERE p.nombre='Oreo' AND c.nombre='Helado de Yogurt' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.10), (@p, @i_oreo, 1);

SET @p = (SELECT idproducto FROM producto p JOIN catalogo c ON p.idcatalogo=c.idcatalogo WHERE p.nombre='Brownie' AND c.nombre='Helado de Yogurt' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.10), (@p, @i_brownie_t, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Macflurry' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.10), (@p, @i_mm, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Macflurry de Milo' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.10), (@p, @i_milo, 1), (@p, @i_nuggets, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Yoguramo' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_yogurt, 0.10), (@p, @i_chocorramo, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Sundae Chocolate' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @h_yogurt, 0.10), (@p, @i_s_choco, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Sundae Fresa' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @h_yogurt, 0.10), (@p, @i_s_fresa, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Sundae Arequipe' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @h_yogurt, 0.10), (@p, @i_arequipe, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Sundae Mora' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @h_yogurt, 0.10), (@p, @i_mora, 1);

-- ── Ensaladas ─────────────────────────────────────────────────────────────────

SET @cat_ens = (SELECT idcatalogo FROM catalogo WHERE nombre = 'Ensaladas de Frutas' LIMIT 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Mini' AND idcatalogo = @cat_ens LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_vainilla, 0.10), (@p, @i_fresas, 1), (@p, @i_queso, 1), (@p, @i_galleta, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Especial' AND idcatalogo = @cat_ens LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_vainilla, 0.10), (@p, @h_frutos, 0.10), (@p, @i_fresas, 1), (@p, @i_queso, 1), (@p, @i_galleta, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Super Especial' AND idcatalogo = @cat_ens LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @h_vainilla, 0.10), (@p, @h_frutos, 0.10), (@p, @h_chicle, 0.10),
(@p, @i_fresas, 1), (@p, @i_chantilly, 1), (@p, @i_queso, 1), (@p, @i_galleta, 1);

-- ── Waffles ───────────────────────────────────────────────────────────────────

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Clasico' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @i_waffle, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle con Helado' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @i_waffle, 1), (@p, @h_vainilla, 0.30);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Fresura' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_fresas, 1), (@p, @i_chantilly, 1), (@p, @i_fideos, 1), (@p, @i_s_fresa, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Frutal' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_fresas, 1), (@p, @i_kiwi, 1), (@p, @i_banano, 1), (@p, @i_chantilly, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Frutos Amarillos' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_pina, 1), (@p, @i_banano, 1), (@p, @i_chantilly, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Frutos Rojos' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_fresas, 1), (@p, @i_arandanos, 1), (@p, @i_chantilly, 1), (@p, @i_mora, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Banana Fest' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_banano, 1), (@p, @i_arequipe, 1), (@p, @i_chantilly, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Tropical Fit' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_kiwi, 1), (@p, @i_arandanos, 1), (@p, @i_fresas, 1), (@p, @i_granola, 1), (@p, @h_yogurt, 0.10);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Chocoso' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_nutella, 1), (@p, @i_oreo, 1), (@p, @i_chocorramo, 1), (@p, @i_chokis, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Alpes' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_nutella, 1), (@p, @i_arequipe, 1), (@p, @i_brownie_t, 1), (@p, @i_caviar, 1), (@p, @i_barquillos, 1), (@p, @h_yogurt, 0.10);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Oreo' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_nutella, 1), (@p, @i_oreo, 1), (@p, @i_fideos, 1), (@p, @i_s_choco, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Chocorramo' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_nutella, 1), (@p, @i_chocorramo, 1), (@p, @i_chips, 1), (@p, @i_s_choco, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Milo' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_arequipe, 1), (@p, @i_milo, 1), (@p, @i_nuggets, 1), (@p, @i_s_choco, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Nutella' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_nutella, 1), (@p, @i_chocobreak, 1), (@p, @i_fresas, 1), (@p, @i_chocmelos, 1), (@p, @i_chips, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Hersheys' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_nutella, 1), (@p, @i_hersheys, 1), (@p, @i_chokis, 1), (@p, @i_fideos, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Jet' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_jet_g, 1), (@p, @i_jet_w, 1), (@p, @i_pepitas_ch, 1), (@p, @i_s_choco, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Kinder' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_nutella, 1), (@p, @i_kinder, 1), (@p, @i_chokis, 1), (@p, @i_pepitas_ch, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Nucita' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES
(@p, @i_waffle, 1), (@p, @i_g_nucita, 1), (@p, @i_c_nucita, 1), (@p, @i_chips, 1), (@p, @i_s_choco, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Entero' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @i_waffle, 1);

SET @p = (SELECT idproducto FROM producto WHERE nombre = 'Waffle Medio' LIMIT 1);
INSERT IGNORE INTO detalle_insumo (idproducto, idinsumo, cantidad) VALUES (@p, @i_waffle, 1);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- ============================================================
-- FIN — bdalpes.sql
-- ============================================================

-- ============================================================
-- MIGRACIÓN: Hacer idadministrador nullable en envios
-- Ejecutar una sola vez en bases de datos existentes
-- ============================================================

-- Eliminar la FK que impide NULL en idadministrador
SET FOREIGN_KEY_CHECKS = 0;
ALTER TABLE `envios` DROP FOREIGN KEY IF EXISTS `envios_ibfk_3`;
SET FOREIGN_KEY_CHECKS = 1;

-- Asegurar que la columna acepta NULL (ya debería, pero por si acaso)
ALTER TABLE `envios`
  MODIFY `idadministrador` int(11) DEFAULT NULL;

-- Poblar tabla administrador con los usuarios que tienen rol administrador
-- (si aún no tienen registro en esa tabla)
INSERT IGNORE INTO administrador (idpersona)
SELECT p.idpersona
FROM persona p
JOIN roles r ON p.idrol = r.idrol
WHERE r.nombre = 'administrador';

SELECT 'Migración completada' AS resultado;

-- ============================================================
-- REPARACIÓN: Sincronizar tablas de perfil con persona
-- Ejecutar una sola vez para reparar datos existentes.
-- Crea los registros faltantes en domiciliario, administrador
-- y cliente para usuarios que ya tienen el rol asignado.
-- ============================================================

INSERT IGNORE INTO domiciliario (idpersona)
SELECT p.idpersona FROM persona p
JOIN roles r ON p.idrol = r.idrol
WHERE r.nombre = 'domiciliario'
  AND p.idpersona NOT IN (SELECT idpersona FROM domiciliario WHERE idpersona IS NOT NULL);

INSERT IGNORE INTO administrador (idpersona)
SELECT p.idpersona FROM persona p
JOIN roles r ON p.idrol = r.idrol
WHERE r.nombre = 'administrador'
  AND p.idpersona NOT IN (SELECT idpersona FROM administrador WHERE idpersona IS NOT NULL);

INSERT IGNORE INTO cliente (idpersona)
SELECT p.idpersona FROM persona p
JOIN roles r ON p.idrol = r.idrol
WHERE r.nombre = 'cliente'
  AND p.idpersona NOT IN (SELECT idpersona FROM cliente WHERE idpersona IS NOT NULL);

SELECT 'Reparación de perfiles completada' AS resultado;
