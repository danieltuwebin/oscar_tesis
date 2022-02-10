-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-01-2022 a las 05:46:09
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: dbcreditos
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla amortizacion
--

CREATE TABLE IF NOT EXISTS amortizacion (
idamortizacion int(11) NOT NULL,
  idcliente int(11) NOT NULL,
  tipo_doc varchar(20) NOT NULL,
  num_doc varchar(20) NOT NULL,
  fecha_emi date NOT NULL,
  fecha_ven date NOT NULL,
  moneda varchar(5) NOT NULL,
  total decimal(11,2) NOT NULL,
  condicion tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla amortizacion
--

INSERT INTO amortizacion (idamortizacion, idcliente, tipo_doc, num_doc, fecha_emi, fecha_ven, moneda, total, condicion) VALUES
(1, 0, '$tipo_doc', '$num_doc', '0000-00-00', '0000-00-00', '$mone', '0.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla cheques
--

CREATE TABLE IF NOT EXISTS cheques (
idcheques int(11) NOT NULL,
  idcliente int(11) NOT NULL,
  tipo_cheque varchar(20) NOT NULL,
  bco_cheque varchar(20) NOT NULL,
  doc_pago varchar(20) NOT NULL,
  num_docpago varchar(20) NOT NULL,
  fecha_emi date NOT NULL,
  fecha_ven date NOT NULL,
  moneda varchar(5) NOT NULL,
  monto decimal(11,2) NOT NULL,
  imagen varchar(50) NOT NULL,
  condicion tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla letras
--

CREATE TABLE IF NOT EXISTS letras (
idletra int(11) NOT NULL,
  idcliente int(11) NOT NULL,
  tipo_letra varchar(20) CHARACTER SET utf8 NOT NULL,
  num_letra varchar(20) CHARACTER SET utf8 NOT NULL,
  num_factura varchar(20) CHARACTER SET utf8 NOT NULL,
  lugar_giro varchar(20) CHARACTER SET utf8 NOT NULL,
  fecha_emi date DEFAULT NULL,
  fecha_ven date DEFAULT NULL,
  num_unico varchar(20) CHARACTER SET utf8 NOT NULL,
  moneda char(5) CHARACTER SET utf8 NOT NULL,
  total decimal(11,2) NOT NULL,
  condicion tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla pago_amortiz
--

CREATE TABLE IF NOT EXISTS pago_amortiz (
idpago_amort int(11) NOT NULL,
  idamortizacion int(11) NOT NULL,
  num_recivo varchar(20) NOT NULL,
  nump_op varchar(50) NOT NULL,
  descrip varchar(100) NOT NULL,
  fecha_pago date NOT NULL,
  total_pago decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla pago_cheque
--

CREATE TABLE IF NOT EXISTS pago_cheque (
idpcheque int(11) NOT NULL,
  idcheques int(11) NOT NULL,
  num_pago varchar(20) NOT NULL,
  fecha_pago date NOT NULL,
  total_pago decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla pago_letra
--

CREATE TABLE IF NOT EXISTS pago_letra (
idpagole int(11) NOT NULL,
  idletra int(11) NOT NULL,
  num_pago varchar(20) NOT NULL,
  fecha_pago date NOT NULL,
  total_pago decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla permiso
--

CREATE TABLE IF NOT EXISTS permiso (
  idpermiso int(11) NOT NULL,
  nombre varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla permiso
--

INSERT INTO permiso (idpermiso, nombre) VALUES
(1, 'Escritorio'),
(2, 'asociado'),
(3, 'acceso'),
(4, 'registro'),
(5, 'cobranza'),
(6, 'amortizacion'),
(7, 'letrabco'),
(8, 'letracartera'),
(9, 'cheque');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla persona
--

CREATE TABLE IF NOT EXISTS persona (
idpersona int(11) NOT NULL,
  tipo_persona varchar(20) NOT NULL,
  nombre varchar(100) NOT NULL,
  tipo_documento varchar(20) DEFAULT NULL,
  num_documento varchar(20) DEFAULT NULL,
  contacto varchar(50) DEFAULT NULL,
  direccion varchar(70) DEFAULT NULL,
  telefono varchar(20) DEFAULT NULL,
  email varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla persona
--

INSERT INTO persona (idpersona, tipo_persona, nombre, tipo_documento, num_documento, contacto, direccion, telefono, email) VALUES
(1, 'Proveedor', 'ALREX', 'RUC', '1007776385', 'CAREN LA BB', 'SAN LUIS LIMA', '013260796', 'vantas@alrex.com.pe'),
(2, 'Cliente', 'test', 'DNI', '12345678', 't', 'i c', '5555003', 'daniel@t.com'),
(3, 'Cliente', 'Elber Cruzado Torres', 'RUC', '40107316', NULL, 'Av. Manuel Villaran 965 Surquillolima', '987087371', 'flowers_ramos125@outlook.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla ptotesto
--

CREATE TABLE IF NOT EXISTS ptotesto (
idprotesto int(11) NOT NULL,
  idletra int(11) NOT NULL,
  fecha_protesto date NOT NULL,
  comi_protesto decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla renovacion
--

CREATE TABLE IF NOT EXISTS renovacion (
  idrenovacion int(11) NOT NULL,
  idletra int(11) NOT NULL,
  fecha_reno date NOT NULL,
  fecha_ven date NOT NULL,
  total reno decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla usuario
--

CREATE TABLE IF NOT EXISTS usuario (
idusuario int(11) NOT NULL,
  nombre varchar(100) NOT NULL,
  tipo_documento varchar(20) NOT NULL,
  num_documento varchar(20) NOT NULL,
  direccion varchar(70) DEFAULT NULL,
  telefono varchar(20) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  cargo varchar(20) DEFAULT NULL,
  login varchar(20) NOT NULL,
  clave varchar(64) NOT NULL,
  imagen varchar(50) NOT NULL,
  condicion tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla usuario
--

INSERT INTO usuario (idusuario, nombre, tipo_documento, num_documento, direccion, telefono, email, cargo, login, clave, imagen, condicion) VALUES
(1, 'Marleni Chuquizuta Ramos', 'DNI', '73351882', 'Jr.  La unión sn', '918714350', 'mar.97.ramos@gmail.com', 'Desarrollador', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1587507328.jpg', 1),
(2, 'Yanet Espinoza Ramos', 'DNI', '43534675', 'Jr. tripulantes s/n', '956743554', 'yanet.00.espinoza@gmail.com', 'Secretaria', 'yanet', '89d0cbe4746346bee766e2332b5f8f3a969353de2bf9ceed046999b27652ee7f', '1589320150.jpg', 1),
(3, 'Oscar Ramos Chavarri', 'DNI', '70805900', 'las flores', '987087371', 'ocar@jij.com', 'Ing. de Sistemas', 'deco', '54ca7b83a424aed496ef5ef4f0ddf94222949e097b7d8683f2bd58165e0823dd', '1502689919.jpg', 1),
(4, 'CASTILLO SANDOVAL MELQUI', 'RUC', '40107316693', 'Av. Manuel Villaran 965 Surquillolima', '981254608', 'racso.r.ch@gmail.com', 'cliente', 'melqui', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '1611551009.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla usuario_permiso
--

CREATE TABLE IF NOT EXISTS usuario_permiso (
idusuario_permiso int(11) NOT NULL,
  idusuario int(11) NOT NULL,
  idpermiso int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla usuario_permiso
--

INSERT INTO usuario_permiso (idusuario_permiso, idusuario, idpermiso) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(32, 6, 1),
(33, 6, 2),
(34, 5, 1),
(35, 5, 2),
(36, 5, 3),
(37, 5, 4),
(38, 5, 5),
(39, 5, 6),
(40, 5, 7),
(41, 5, 8),
(42, 5, 9),
(65, 3, 1),
(66, 3, 2),
(67, 3, 3),
(68, 3, 4),
(69, 3, 5),
(70, 3, 6),
(71, 3, 7),
(72, 3, 8),
(73, 3, 9),
(75, 4, 7);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla amortizacion
--
ALTER TABLE amortizacion
 ADD PRIMARY KEY (idamortizacion);

--
-- Indices de la tabla cheques
--
ALTER TABLE cheques
 ADD PRIMARY KEY (idcheques);

--
-- Indices de la tabla letras
--
ALTER TABLE letras
 ADD PRIMARY KEY (idletra);

--
-- Indices de la tabla pago_amortiz
--
ALTER TABLE pago_amortiz
 ADD PRIMARY KEY (idpago_amort);

--
-- Indices de la tabla pago_cheque
--
ALTER TABLE pago_cheque
 ADD PRIMARY KEY (idpcheque);

--
-- Indices de la tabla pago_letra
--
ALTER TABLE pago_letra
 ADD PRIMARY KEY (idpagole);

--
-- Indices de la tabla permiso
--
ALTER TABLE permiso
 ADD PRIMARY KEY (idpermiso);

--
-- Indices de la tabla persona
--
ALTER TABLE persona
 ADD PRIMARY KEY (idpersona);

--
-- Indices de la tabla ptotesto
--
ALTER TABLE ptotesto
 ADD PRIMARY KEY (idprotesto);

--
-- Indices de la tabla usuario
--
ALTER TABLE usuario
 ADD PRIMARY KEY (idusuario);

--
-- Indices de la tabla usuario_permiso
--
ALTER TABLE usuario_permiso
 ADD PRIMARY KEY (idusuario_permiso), ADD KEY fk_usuario_permiso_permiso_idx (idpermiso), ADD KEY fk_usuario_permiso_usuario_idx (idusuario);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla amortizacion
--
ALTER TABLE amortizacion
MODIFY idamortizacion int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla cheques
--
ALTER TABLE cheques
MODIFY idcheques int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla letras
--
ALTER TABLE letras
MODIFY idletra int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla pago_amortiz
--
ALTER TABLE pago_amortiz
MODIFY idpago_amort int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla pago_cheque
--
ALTER TABLE pago_cheque
MODIFY idpcheque int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla pago_letra
--
ALTER TABLE pago_letra
MODIFY idpagole int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla persona
--
ALTER TABLE persona
MODIFY idpersona int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla ptotesto
--
ALTER TABLE ptotesto
MODIFY idprotesto int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla usuario
--
ALTER TABLE usuario
MODIFY idusuario int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla usuario_permiso
--
ALTER TABLE usuario_permiso
MODIFY idusuario_permiso int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- test
-- test -2



-- *****************************************************
-- ADICIONES Y CAMBIOS EN LS BD - NUEVA VERSION 04042022
-- *****************************************************


ALTER TABLE amortizacion CHANGE idamortizacion idamortizacion INT(11) NOT NULL AUTO_INCREMENT, CHANGE tipo_doc tipo_doc VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL, CHANGE num_doc num_doc VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL, CHANGE moneda moneda VARCHAR(5) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL;

-- CAMBIAR COTEJAMIENTO DE LA TABLA amortizacion

CREATE TABLE tipoDocumento (
id int AUTO_INCREMENT NOT NULL PRIMARY KEY,
nombre VARCHAR(20) NOT NULL,
estado INT COMMENT '1-ACTIVO : 0-INACTIVO');

TRUNCATE TABLE tipoDocumento;
INSERT INTO tipoDocumento(id, nombre, estado) 
VALUES 
 (NULL,'FACTURA',1)
,(NULL,'CONTADO',1)
,(NULL,'RECIBO',1)
,(NULL,'OTROS',1)
;


INSERT INTO amortizacion(idamortizacion, idcliente, tipo_doc, num_doc, fecha_emi, fecha_ven, moneda, total, condicion) 
VALUES (	null,1,1,'DOC001','2022-02-05','2022-04-05','SOLES','1500',1)


ALTER TABLE persona ADD estado INT NOT NULL COMMENT '1-activo - 2:inactivo' AFTER email;

ALTER TABLE persona CHANGE estado estado INT(11) NULL COMMENT '1-activo - 2:inactivo';

update persona set estado = 1

ALTER TABLE amortizacion ADD fechagrabacion DATETIME NOT NULL AFTER condicion;



ALTER TABLE pago_amortiz ADD fechagrabacion DATETIME NOT NULL AFTER total_pago;

ALTER TABLE pago_amortiz CHANGE num_recivo num_recivo VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL, CHANGE nump_op nump_op VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL, CHANGE descrip descrip VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL;


ALTER TABLE `letras` ADD `fechagrabacion` INT NOT NULL AFTER `condicion`;
ALTER TABLE `letras` CHANGE `fechagrabacion` `fechagrabacion` DATETIME NOT NULL;


DELIMITER $$
DROP TABLE IF EXISTS detalle_letras$$
CREATE TABLE detalle_letras(
	detalleLetra INT AUTO_INCREMENT NOT NULL PRIMARY KEY
    ,idletra INT
    ,tipoDetalleLetra INT COMMENT '1 PAGO LETRA - 2 RENOVACION - 3 PROTESTO'
    ,tipo1_numeroPago VARCHAR(20)
    ,tipo1_FechaPago DATE
    ,tipo2_FechaRenovacion DATE
    ,tipo2_FechaVencimiento DATE
    ,tipo3_Comision DOUBLE
    ,total DOUBLE
)$$


ALTER TABLE `detalle_letras` CHANGE `tipo1_FechaPago` `tipo1_FechaPago` DATE NULL DEFAULT '1900-01-01', CHANGE `tipo2_FechaRenovacion` `tipo2_FechaRenovacion` DATE NULL DEFAULT '1900-01-01', CHANGE `tipo2_FechaVencimiento` `tipo2_FechaVencimiento` DATE NULL DEFAULT '1900-01-01';