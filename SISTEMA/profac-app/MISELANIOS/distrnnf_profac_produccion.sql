-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-06-2022 a las 04:13:12
-- Versión del servidor: 5.7.23-23
-- Versión de PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `distrnnf_profac`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `municipio_id` int(11) NOT NULL,
  `encargado_bodega` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`id`, `nombre`, `direccion`, `estado_id`, `municipio_id`, `encargado_bodega`, `created_at`, `updated_at`) VALUES
(1, 'Bodega 1', 'Tegucigalpa', 1, 110, 2, '2022-04-28 04:25:49', '2022-04-05 22:04:40'),
(2, 'Bodega 2', 'Comayagua', 1, 110, 4, '2022-04-28 04:25:55', '2022-04-08 06:10:17'),
(3, 'Bodega Central 1', 'Colonia Godoy', 2, 110, 5, '2022-05-18 20:39:43', '2022-05-18 14:39:43'),
(4, 'BODEGA CENTRAL 1', 'COLONIA GODOY', 1, 110, 5, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(5, 'BODEGA CENTRAL 2', 'COLONIA GODOY', 1, 110, 5, '2022-05-18 15:09:23', '2022-05-18 15:09:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cai`
--

CREATE TABLE `cai` (
  `id` int(11) NOT NULL,
  `cai` varchar(37) NOT NULL,
  `punto_de_emision` varchar(45) NOT NULL,
  `cantidad_solicitada` int(11) NOT NULL,
  `cantidad_otorgada` int(11) NOT NULL,
  `cantidad_actual` int(11) NOT NULL,
  `cantidad_no_utilizada` int(11) NOT NULL,
  `numero_inicial` varchar(19) NOT NULL,
  `numero_final` varchar(19) NOT NULL,
  `numero_base` varchar(19) NOT NULL,
  `fecha_limite_emision` date NOT NULL,
  `tipo_documento_fiscal_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Mayorista Nacional ', '2022-03-15 00:53:07', '2022-03-15 00:53:07'),
(2, 'Mayorista Inscrito                 ', '2022-03-15 00:53:07', '2022-03-15 00:53:07'),
(3, 'Exportador', '2022-03-15 00:53:21', '2022-03-15 00:53:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

CREATE TABLE `categoria_producto` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria_producto`
--

INSERT INTO `categoria_producto` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Oficina', '2022-03-24 01:06:03', NULL),
(2, 'Hogar', '2022-03-24 01:06:03', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `direccion` text NOT NULL,
  `RTN` varchar(14) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `latitud` varchar(45) DEFAULT NULL,
  `longitud` varchar(45) DEFAULT NULL,
  `url_imagen` varchar(250) DEFAULT NULL,
  `credito` double NOT NULL,
  `clientecol` varchar(45) DEFAULT NULL,
  `tipo_cliente_id` int(11) NOT NULL,
  `tipo_personalidad_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `vendedor` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `numero_factura` varchar(90) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `fecha_emision` date NOT NULL DEFAULT '2022-04-21',
  `fecha_recepcion` date NOT NULL DEFAULT '2022-04-21',
  `isv_compra` double NOT NULL,
  `sub_total` double NOT NULL,
  `total` double NOT NULL,
  `debito` double NOT NULL,
  `proveedores_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_compra_id` int(11) NOT NULL,
  `estado_compra_id` int(11) NOT NULL,
  `numero_orden` varchar(45) NOT NULL,
  `monto_retencion` double NOT NULL,
  `retenciones_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `numero_factura`, `fecha_vencimiento`, `fecha_emision`, `fecha_recepcion`, `isv_compra`, `sub_total`, `total`, `debito`, `proveedores_id`, `users_id`, `tipo_compra_id`, `estado_compra_id`, `numero_orden`, `monto_retencion`, `retenciones_id`, `created_at`, `updated_at`) VALUES
(1, '1', '2022-05-31', '2022-04-21', '2022-04-21', 15, 100, 115, 15, 4, 3, 1, 1, '1', 1, 2, '2022-04-30 20:58:49', '2022-05-04 03:39:22'),
(4, '2', '2022-05-02', '2022-05-02', '2022-05-15', 2250, 15000, 17250, 7050, 1, 3, 2, 1, '2022-2', 172.5, 2, '2022-05-03 03:38:44', '2022-05-11 01:43:23'),
(5, '6', '2022-05-10', '2022-05-10', '2022-05-11', 6010.08, 40067.2, 46077.28, 46077.28, 1, 3, 2, 1, '2022-3', 0, 2, '2022-05-11 02:01:43', '2022-05-11 02:31:54'),
(6, '20202', '2022-05-19', '2022-05-10', '2022-05-18', 66.6, 444, 510.6, 0, 11, 2, 1, 1, '2022-4', 4.44, 2, '2022-05-18 03:22:07', '2022-05-17 21:22:07'),
(7, '33-222', '2022-05-17', '2022-05-17', '2022-05-20', 15, 200, 215, 215, 1, 3, 2, 1, '2022-5', 0, 2, '2022-05-17 22:07:17', '2022-05-17 22:07:17'),
(8, '255', '2022-05-18', '2022-05-18', '2022-05-18', 8632.26, 57548.4, 66180.66, 66180.66, 15, 5, 2, 1, '2022-6', 0, 2, '2022-05-18 14:28:52', '2022-05-18 14:28:52'),
(9, '128301', '2022-05-18', '2022-05-18', '2022-05-18', 698.05, 4653.67, 5351.72, 5351.72, 11, 5, 1, 1, '2022-7', 0, 2, '2022-05-18 15:39:27', '2022-05-18 15:39:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_has_producto`
--

CREATE TABLE `compra_has_producto` (
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `precio_unidad` double NOT NULL,
  `cantidad_ingresada` int(11) NOT NULL,
  `cantidad_sin_asignar` int(11) DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `sub_total_producto` double NOT NULL,
  `isv` double NOT NULL,
  `precio_total` double NOT NULL,
  `cantidad_disponible` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra_has_producto`
--

INSERT INTO `compra_has_producto` (`compra_id`, `producto_id`, `precio_unidad`, `cantidad_ingresada`, `cantidad_sin_asignar`, `fecha_expiracion`, `sub_total_producto`, `isv`, `precio_total`, `cantidad_disponible`, `updated_at`, `created_at`) VALUES
(1, 1, 1, 100, 0, '2022-05-31', 100, 15, 115, 100, '2022-04-30 21:00:37', '2022-04-30 21:01:55'),
(4, 1, 500, 30, 0, '2022-05-02', 15000, 2250, 17250, 30, '2022-05-03 03:38:44', '2022-05-03 03:38:44'),
(5, 1, 233, 80, 75, NULL, 18640, 2796, 21436, 80, '2022-05-11 02:01:43', '2022-05-11 02:01:43'),
(5, 6, 178.56, 120, 120, NULL, 21427.2, 3214.08, 24641.28, 120, '2022-05-11 02:01:43', '2022-05-11 02:01:43'),
(6, 16, 222, 2, 0, '2022-05-04', 444, 66.6, 510.6, 2, '2022-05-17 21:13:39', '2022-05-17 21:13:39'),
(7, 1, 100, 1, 0, NULL, 100, 15, 115, 1, '2022-05-17 22:07:17', '2022-05-17 22:07:17'),
(7, 36, 100, 1, 0, NULL, 100, 0, 100, 1, '2022-05-17 22:07:17', '2022-05-17 22:07:17'),
(8, 40, 7.28, 7905, 0, '2022-09-18', 57548.4, 8632.26, 66180.66, 7905, '2022-05-18 14:28:52', '2022-05-18 14:28:52'),
(9, 45, 45.9236, 96, 0, '2022-05-18', 4408.67, 661.3, 5069.97, 96, '2022-05-18 15:39:27', '2022-05-18 15:39:27'),
(9, 46, 4.9, 50, 0, '2022-05-18', 245, 36.75, 281.75, 50, '2022-05-18 15:39:27', '2022-05-18 15:39:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pais_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id`, `nombre`, `created_at`, `updated_at`, `pais_id`) VALUES
(1, 'ATLÁNTIDA', '2021-01-11 10:56:47', NULL, 1),
(2, 'COLÓN', '2021-01-11 10:56:55', NULL, 1),
(3, 'COMAYAGUA', '2021-01-11 09:57:53', NULL, 1),
(4, 'COPÁN', '2021-01-11 10:57:06', NULL, 1),
(5, 'CORTÉS', '2021-01-11 10:57:16', NULL, 1),
(6, 'CHOLUTECA', '2021-01-11 09:57:53', NULL, 1),
(7, 'EL PARAÍSO', '2021-01-11 10:57:34', NULL, 1),
(8, 'FRANCISCO MORAZÁN', '2021-01-11 10:57:47', NULL, 1),
(9, 'GRACIAS A DIOS', '2021-01-11 09:57:53', NULL, 1),
(10, 'INTIBUCÁ', '2021-01-11 10:58:01', NULL, 1),
(11, 'ISLAS DE LA BAHÍA', '2021-01-11 10:58:17', NULL, 1),
(12, 'LA PAZ', '2021-01-11 09:57:53', NULL, 1),
(13, 'LEMPIRA', '2021-01-11 09:57:53', NULL, 1),
(14, 'OCOTEPEQUE', '2021-01-11 09:57:53', NULL, 1),
(15, 'OLANCHO', '2021-01-11 09:57:53', NULL, 1),
(16, 'SANTA BÁRBARA', '2021-01-11 10:58:41', NULL, 1),
(17, 'VALLE', '2021-01-11 09:57:53', NULL, 1),
(18, 'YORO', '2021-01-11 09:57:53', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'activo', '2022-03-10 23:55:11', '2022-03-10 23:54:42'),
(2, 'inactivo', '2022-03-10 23:55:11', '2022-03-10 23:54:42'),
(3, 'pendiente de recibir', '2022-04-21 06:00:00', '2022-04-21 06:00:00'),
(4, 'recibido', '2022-04-21 06:00:00', '2022-04-21 06:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_compra`
--

CREATE TABLE `estado_compra` (
  `id` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_compra`
--

INSERT INTO `estado_compra` (`id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'activo', '2022-05-10 06:00:00', '2022-05-10 06:00:00'),
(2, 'anulado', '2022-05-10 06:00:00', '2022-05-10 06:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_producto`
--

CREATE TABLE `estado_producto` (
  `id` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_producto`
--

INSERT INTO `estado_producto` (`id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Activado', '2022-05-11 02:18:52', '2022-05-11 02:18:11'),
(2, 'Inactivo', '2022-05-11 02:18:52', '2022-05-11 02:18:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `img_producto`
--

CREATE TABLE `img_producto` (
  `id` int(11) NOT NULL,
  `url_img` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `img_producto`
--

INSERT INTO `img_producto` (`id`, `url_img`, `created_at`, `updated_at`, `producto_id`, `users_id`) VALUES
(4, 'IMG_1649274533_3.jpg', '2022-04-07 01:48:53', NULL, 1, 3),
(5, 'IMG_1649274533_4.jpg', '2022-04-07 01:48:53', NULL, 1, 3),
(6, 'IMG_1650473351-0.jpg', '2022-04-20 22:49:11', NULL, 16, 3),
(7, 'IMG_1650473739-0.png', '2022-04-20 22:55:39', NULL, 17, 3),
(8, 'IMG_1650473941-0.jpg', '2022-04-20 22:59:01', NULL, 18, 3),
(9, 'IMG_1650474103-0.jpg', '2022-04-20 23:01:43', NULL, 19, 3),
(10, 'IMG_1650474315-0.jpg', '2022-04-20 23:05:15', NULL, 20, 3),
(11, 'IMG_1650474368-0.jpg', '2022-04-20 23:06:08', NULL, 21, 3),
(12, 'IMG_1650474495-0.jpg', '2022-04-20 23:08:15', NULL, 22, 3),
(13, 'IMG_1650474575-0.jpg', '2022-04-20 23:09:35', NULL, 23, 3),
(14, 'IMG_1650474643-0.jpg', '2022-04-20 23:10:43', NULL, 24, 3),
(15, 'IMG_1650474723-0.png', '2022-04-20 23:12:03', NULL, 25, 3),
(16, 'IMG_1650475015-0.jpg', '2022-04-20 23:16:55', NULL, 26, 3),
(17, 'IMG_1650475179-0.jpg', '2022-04-20 23:19:39', NULL, 27, 3),
(18, 'IMG_1650475253-0.jpg', '2022-04-20 23:20:53', NULL, 28, 3),
(19, 'IMG_1650475322-0.jpg', '2022-04-20 23:22:02', NULL, 29, 3),
(20, 'IMG_1650475372-0.png', '2022-04-20 23:22:52', NULL, 30, 3),
(21, 'IMG_1650476039-0.jpg', '2022-04-20 23:33:59', NULL, 31, 3),
(22, 'IMG_1650476120-0.jpg', '2022-04-20 23:35:20', NULL, 32, 3),
(23, 'IMG_1650476524-0.jpg', '2022-04-20 23:42:04', NULL, 33, 3),
(24, 'IMG_1650476596-0.png', '2022-04-20 23:43:16', NULL, 34, 3),
(25, 'IMG_1650476706-0.jpg', '2022-04-20 23:45:06', NULL, 35, 3),
(26, 'IMG_1651352184-0.jpg', '2022-05-01 02:56:24', NULL, 14, 3),
(27, 'IMG_1652903971-0.jpg', '2022-05-18 13:59:31', NULL, 38, 2),
(28, 'IMG_1652904134-0.jpg', '2022-05-18 14:02:14', NULL, 39, 2),
(29, 'IMG_1652904644-0.jpg', '2022-05-18 14:10:44', NULL, 40, 5),
(30, 'IMG_1652904707-0.jpg', '2022-05-18 14:11:47', NULL, 41, 3),
(31, 'IMG_1652905858-0.jpg', '2022-05-18 14:30:58', NULL, 44, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

CREATE TABLE `incidencia` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `url_img` varchar(250) DEFAULT NULL,
  `recibido_bodega_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `incidencia`
--

INSERT INTO `incidencia` (`id`, `descripcion`, `url_img`, `recibido_bodega_id`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'caja dañada', 'IMG_1651864885-.jpg', 1, 3, '2022-05-06 19:21:25', '2022-05-06 19:21:25'),
(2, 'Dañado al almacenar', 'IMG_1652202658-.jpg', 7, 3, '2022-05-10 17:10:58', '2022-05-10 17:10:58'),
(3, 'PRODUCTO DAÑADO', 'IMG_1652843811.jpg', 28, 2, '2022-05-17 21:16:51', '2022-05-17 21:16:51'),
(4, 'La caja esta abierta', NULL, 30, 3, '2022-05-17 22:09:18', '2022-05-17 22:09:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia_compra`
--

CREATE TABLE `incidencia_compra` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `url_img` varchar(250) DEFAULT NULL,
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `incidencia_compra`
--

INSERT INTO `incidencia_compra` (`id`, `descripcion`, `url_img`, `compra_id`, `producto_id`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'no se recibio por daño', NULL, 1, 1, 3, '2022-05-10 18:13:09', '2022-05-10 18:13:09'),
(2, 'daño al llegar', NULL, 1, 1, 3, '2022-05-10 18:14:12', '2022-05-10 18:14:12'),
(3, 'producto faltante', 'IMG_1652206496-.png', 1, 1, 3, '2022-05-10 18:14:56', '2022-05-10 18:14:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_estado`
--

CREATE TABLE `log_estado` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `estado_anterior_compra` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_translado`
--

CREATE TABLE `log_translado` (
  `id` int(11) NOT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `log_translado`
--

INSERT INTO `log_translado` (`id`, `origen`, `destino`, `cantidad`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 1, 9, 10, 3, '2022-05-11 22:32:21', '2022-05-11 22:32:21'),
(2, 2, 10, 10, 3, '2022-05-12 12:30:40', '2022-05-12 12:30:40'),
(3, 1, 11, 10, 3, '2022-05-12 12:31:24', '2022-05-12 12:31:24'),
(4, 2, 12, 10, 3, '2022-05-12 12:33:54', '2022-05-12 12:33:54'),
(5, 2, 13, 10, 3, '2022-05-12 12:37:09', '2022-05-12 12:37:09'),
(6, 13, 14, 10, 3, '2022-05-12 12:38:52', '2022-05-12 12:38:52'),
(7, 12, 15, 10, 3, '2022-05-12 12:42:54', '2022-05-12 12:42:54'),
(8, 15, 16, 10, 3, '2022-05-12 12:46:06', '2022-05-12 12:46:06'),
(9, 11, 17, 10, 3, '2022-05-12 12:48:00', '2022-05-12 12:48:00'),
(10, 10, 18, 10, 3, '2022-05-12 12:52:10', '2022-05-12 12:52:10'),
(11, 4, 19, 10, 3, '2022-05-12 13:00:01', '2022-05-12 13:00:01'),
(12, 9, 20, 10, 3, '2022-05-12 13:02:47', '2022-05-12 13:02:47'),
(13, 20, 21, 10, 3, '2022-05-12 13:06:59', '2022-05-12 13:06:59'),
(14, 19, 22, 10, 3, '2022-05-12 13:07:53', '2022-05-12 13:07:53'),
(15, 18, 23, 10, 3, '2022-05-12 13:11:27', '2022-05-12 13:11:27'),
(16, 17, 24, 10, 3, '2022-05-12 13:15:54', '2022-05-12 13:15:54'),
(17, 3, 25, 10, 3, '2022-05-12 13:17:00', '2022-05-12 13:17:00'),
(18, 16, 26, 3, 3, '2022-05-12 13:18:18', '2022-05-12 13:18:18'),
(19, 28, 29, 1, 2, '2022-05-17 21:23:36', '2022-05-17 21:23:36'),
(20, 31, 32, 1, 3, '2022-05-17 22:10:31', '2022-05-17 22:10:31'),
(21, 33, 34, 7905, 5, '2022-05-18 14:45:58', '2022-05-18 14:45:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `icon` varchar(45) NOT NULL,
  `nombre_menu` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `departamento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`id`, `nombre`, `created_at`, `updated_at`, `departamento_id`) VALUES
(1, 'La Ceiba', '2021-01-11 10:08:15', NULL, 1),
(2, 'Tela', '2021-01-11 10:08:15', NULL, 1),
(3, 'Jutiapa', '2021-01-11 10:08:15', NULL, 1),
(4, 'La Masica', '2021-01-11 10:08:16', NULL, 1),
(5, 'San Francisco', '2021-01-11 10:08:16', NULL, 1),
(6, 'Arizona', '2021-01-11 10:08:16', NULL, 1),
(7, 'Esparta', '2021-01-11 10:08:16', NULL, 1),
(8, 'El Porvenir', '2021-01-11 10:08:16', NULL, 1),
(9, 'TRUJILLO', '2021-01-11 10:12:40', NULL, 2),
(10, 'BALFATE', '2021-01-11 10:12:40', NULL, 2),
(11, 'IRIONA', '2021-01-11 10:12:40', NULL, 2),
(12, 'LIMÓN', '2021-01-11 10:31:02', NULL, 2),
(13, 'SABÁ', '2021-01-11 10:31:36', NULL, 2),
(14, 'SANTA FE', '2021-01-11 10:12:40', NULL, 2),
(15, 'SANTA ROSA DE AGUÁN', '2021-01-11 10:12:40', NULL, 2),
(16, 'SONAGUERA', '2021-01-11 10:12:40', NULL, 2),
(17, 'TOCOA', '2021-01-11 10:12:41', NULL, 2),
(18, 'BONITO ORIENTAL', '2021-01-11 10:12:41', NULL, 2),
(19, 'COMAYAGUA', '2021-01-11 10:21:27', NULL, 3),
(20, 'AJUTERIQUE', '2021-01-11 10:21:27', NULL, 3),
(21, 'EL ROSARIO', '2021-01-11 10:21:27', NULL, 3),
(22, 'ESQUÍAS', '2021-01-11 10:21:27', NULL, 3),
(23, 'HUMUYA', '2021-01-11 10:21:27', NULL, 3),
(24, 'LA LIBERTAD', '2021-01-11 10:21:27', NULL, 3),
(25, 'LAMANÍ', '2021-01-11 10:21:27', NULL, 3),
(26, 'LA TRINIDAD', '2021-01-11 10:21:27', NULL, 3),
(27, 'LEJAMANI', '2021-01-11 10:21:27', NULL, 3),
(28, 'MEAMBAR', '2021-01-11 10:21:27', NULL, 3),
(29, 'MINAS DE ORO', '2021-01-11 10:21:27', NULL, 3),
(30, 'OJOS DE AGUA', '2021-01-11 10:21:27', NULL, 3),
(31, 'SAN JERÓNIMO (HONDURAS)', '2021-01-11 10:21:27', NULL, 3),
(32, 'SAN JOSÉ DE COMAYAGUA', '2021-01-11 10:21:27', NULL, 3),
(33, 'SAN JOSÉ DEL POTRERO', '2021-01-11 10:21:27', NULL, 3),
(34, 'SAN LUIS', '2021-01-11 10:21:27', NULL, 3),
(35, 'SAN SEBASTIÁN', '2021-01-11 10:21:27', NULL, 3),
(36, 'SIGUATEPEQUE', '2021-01-11 10:21:27', NULL, 3),
(37, 'VILLA DE SAN ANTONIO', '2021-01-11 10:21:27', NULL, 3),
(38, 'LAS LAJAS', '2021-01-11 10:21:27', NULL, 3),
(39, 'TAULABÉ', '2021-01-11 10:21:27', NULL, 3),
(40, 'SANTA ROSA DE COPÁN', '2021-01-11 10:24:20', NULL, 4),
(41, 'CABAÑAS', '2021-01-11 10:24:20', NULL, 4),
(42, 'CONCEPCIÓN', '2021-01-11 10:24:20', NULL, 4),
(43, 'COPÁN RUINAS', '2021-01-11 10:24:20', NULL, 4),
(44, 'CORQUÍN', '2021-01-11 10:24:20', NULL, 4),
(45, 'CUCUYAGUA', '2021-01-11 10:24:20', NULL, 4),
(46, 'DOLORES', '2021-01-11 10:24:21', NULL, 4),
(47, 'DULCE NOMBRE', '2021-01-11 10:24:21', NULL, 4),
(48, 'EL PARAÍSO', '2021-01-11 10:24:21', NULL, 4),
(49, 'FLORIDA', '2021-01-11 10:24:21', NULL, 4),
(50, 'LA JIGUA', '2021-01-11 10:24:21', NULL, 4),
(51, 'LA UNIÓN', '2021-01-11 10:24:21', NULL, 4),
(52, 'NUEVA ARCADIA', '2021-01-11 10:24:21', NULL, 4),
(53, 'SAN AGUSTÍN', '2021-01-11 10:24:21', NULL, 4),
(54, 'SAN ANTONIO', '2021-01-11 10:24:21', NULL, 4),
(55, 'SAN JERÓNIMO', '2021-01-11 10:24:21', NULL, 4),
(56, 'SAN JOSÉ', '2021-01-11 10:24:21', NULL, 4),
(57, 'SAN JUAN DE OPOA', '2021-01-11 10:24:21', NULL, 4),
(58, 'SAN NICOLÁS', '2021-01-11 10:24:21', NULL, 4),
(59, 'SAN PEDRO', '2021-01-11 10:24:21', NULL, 4),
(60, 'SANTA RITA', '2021-01-11 10:24:21', NULL, 4),
(61, 'TRINIDAD DE COPÁN', '2021-01-11 10:24:21', NULL, 4),
(62, 'VERACRUZ', '2021-01-11 10:24:21', NULL, 4),
(63, 'SAN PEDRO SULA', '2021-01-11 10:26:38', NULL, 5),
(64, 'CHOLOMA', '2021-01-11 10:26:38', NULL, 5),
(65, 'OMOA', '2021-01-11 10:26:38', NULL, 5),
(66, 'PIMIENTA', '2021-01-11 10:26:38', NULL, 5),
(67, 'POTRERILLOS', '2021-01-11 10:26:38', NULL, 5),
(68, 'PUERTO CORTÉS', '2021-01-11 10:26:38', NULL, 5),
(69, 'SAN ANTONIO DE CORTÉS', '2021-01-11 10:26:38', NULL, 5),
(70, 'SAN FRANCISCO DE YOJOA', '2021-01-11 10:26:38', NULL, 5),
(71, 'SAN MANUEL', '2021-01-11 10:26:38', NULL, 5),
(72, 'SANTA CRUZ DE YOJOA', '2021-01-11 10:26:38', NULL, 5),
(73, 'VILLANUEVA', '2021-01-11 10:26:38', NULL, 5),
(74, 'LA LIMA', '2021-01-11 10:26:38', NULL, 5),
(75, 'CHOLUTECA', '2021-01-11 10:29:31', NULL, 6),
(76, 'APACILAGUA', '2021-01-11 10:29:31', NULL, 6),
(77, 'CONCEPCIÓN DE MARÍA', '2021-01-11 10:29:31', NULL, 6),
(78, 'DUYURE', '2021-01-11 10:29:31', NULL, 6),
(79, 'EL CORPUS', '2021-01-11 10:29:31', NULL, 6),
(80, 'EL TRIUNFO', '2021-01-11 10:29:31', NULL, 6),
(81, 'MARCOVIA', '2021-01-11 10:29:32', NULL, 6),
(82, 'MOROLICA', '2021-01-11 10:29:32', NULL, 6),
(83, 'NAMASIGUE', '2021-01-11 10:29:32', NULL, 6),
(84, 'OROCUINA', '2021-01-11 10:29:32', NULL, 6),
(85, 'PESPIRE', '2021-01-11 10:29:32', NULL, 6),
(86, 'SAN ANTONIO DE FLORES', '2021-01-11 10:29:32', NULL, 6),
(87, 'SAN ISIDRO', '2021-01-11 10:29:32', NULL, 6),
(88, 'SAN JOSÉ', '2021-01-11 10:29:32', NULL, 6),
(89, 'SAN MARCOS DE COLÓN', '2021-01-11 10:29:32', NULL, 6),
(90, 'SANTA ANA DE YUSGUARE', '2021-01-11 10:29:32', NULL, 6),
(91, 'YUSCARÁN', '2021-01-11 10:35:04', NULL, 7),
(92, 'ALAUCA', '2021-01-11 10:35:04', NULL, 7),
(93, 'DANLÍ', '2021-01-11 10:35:04', NULL, 7),
(94, 'EL PARAÍSO', '2021-01-11 10:35:04', NULL, 7),
(95, 'GÜINOPE', '2021-01-11 10:35:04', NULL, 7),
(96, 'JACALEAPA', '2021-01-11 10:35:04', NULL, 7),
(97, 'LIURE', '2021-01-11 10:35:04', NULL, 7),
(98, 'MOROCELÍ', '2021-01-11 10:35:04', NULL, 7),
(99, 'OROPOLÍ', '2021-01-11 10:35:04', NULL, 7),
(100, 'POTRERILLOS', '2021-01-11 10:35:04', NULL, 7),
(101, 'SAN ANTONIO DE FLORES', '2021-01-11 10:35:04', NULL, 7),
(102, 'SAN LUCAS', '2021-01-11 10:35:04', NULL, 7),
(103, 'SAN MATÍAS', '2021-01-11 10:35:05', NULL, 7),
(104, 'SOLEDAD', '2021-01-11 10:35:05', NULL, 7),
(105, 'TEUPASENTI', '2021-01-11 10:35:05', NULL, 7),
(106, 'TEXIGUAT', '2021-01-11 10:35:05', NULL, 7),
(107, 'VADO ANCHO', '2021-01-11 10:35:05', NULL, 7),
(108, 'YAUYUPE', '2021-01-11 10:35:05', NULL, 7),
(109, 'TROJES', '2021-01-11 10:35:05', NULL, 7),
(110, 'DISTRITO CENTRAL', '2021-01-11 10:37:39', NULL, 8),
(111, 'ALUBARÉN', '2021-01-11 10:37:39', NULL, 8),
(112, 'CEDROS', '2021-01-11 10:37:39', NULL, 8),
(113, 'CURARÉN', '2021-01-11 10:37:39', NULL, 8),
(114, 'EL PORVENIR', '2021-01-11 10:37:39', NULL, 8),
(115, 'GUAIMACA', '2021-01-11 10:37:39', NULL, 8),
(116, 'LA LIBERTAD', '2021-01-11 10:37:39', NULL, 8),
(117, 'LA VENTA', '2021-01-11 10:37:39', NULL, 8),
(118, 'LEPATERIQUE', '2021-01-11 10:37:39', NULL, 8),
(119, 'MARAITA', '2021-01-11 10:37:39', NULL, 8),
(120, 'MARALE', '2021-01-11 10:37:39', NULL, 8),
(121, 'NUEVA ARMENIA', '2021-01-11 10:37:39', NULL, 8),
(122, 'OJOJONA', '2021-01-11 10:37:39', NULL, 8),
(123, 'ORICA', '2021-01-11 10:37:39', NULL, 8),
(124, 'REITOCA', '2021-01-11 10:37:39', NULL, 8),
(125, 'SABANAGRANDE', '2021-01-11 10:37:39', NULL, 8),
(126, 'SAN ANTONIO DE ORIENTE', '2021-01-11 10:37:39', NULL, 8),
(127, 'SAN BUENAVENTURA', '2021-01-11 10:37:39', NULL, 8),
(128, 'SAN IGNACIO', '2021-01-11 10:37:39', NULL, 8),
(129, 'SAN JUAN DE FLORES', '2021-01-11 10:37:39', NULL, 8),
(130, 'SAN MIGUELITO', '2021-01-11 10:37:39', NULL, 8),
(131, 'SANTA ANA', '2021-01-11 10:37:39', NULL, 8),
(132, 'SANTA LUCÍA', '2021-01-11 10:37:39', NULL, 8),
(133, 'TALANGA', '2021-01-11 10:37:39', NULL, 8),
(134, 'TATUMBLA', '2021-01-11 10:37:39', NULL, 8),
(135, 'VALLE DE ÁNGELES', '2021-01-11 10:37:39', NULL, 8),
(136, 'VILLA DE SAN FRANCISCO', '2021-01-11 10:37:39', NULL, 8),
(137, 'VALLECILLO', '2021-01-11 10:37:39', NULL, 8),
(138, 'PUERTO LEMPIRA', '2021-01-11 10:40:22', NULL, 9),
(139, 'BRUS LAGUNA', '2021-01-11 10:40:22', NULL, 9),
(140, 'AHUAS', '2021-01-11 10:40:22', NULL, 9),
(141, 'JUAN FRANCISCO BULNES', '2021-01-11 10:40:22', NULL, 9),
(142, 'RAMÓN VILLEDA MORALES', '2021-01-11 10:40:22', NULL, 9),
(143, 'WAMPUSIRPE', '2021-01-11 10:40:22', NULL, 9),
(144, 'LA ESPERANZA', '2021-01-11 10:42:37', NULL, 10),
(145, 'CAMASCA', '2021-01-11 10:42:37', NULL, 10),
(146, 'COLOMONCAGUA', '2021-01-11 10:42:37', NULL, 10),
(147, 'CONCEPCIÓN', '2021-01-11 10:42:37', NULL, 10),
(148, 'DOLORES', '2021-01-11 10:42:37', NULL, 10),
(149, 'INTIBUCÁ', '2021-01-11 10:42:37', NULL, 10),
(150, 'JESÚS DE OTORO', '2021-01-11 10:42:37', NULL, 10),
(151, 'MAGDALENA', '2021-01-11 10:42:37', NULL, 10),
(152, 'MASAGUARA', '2021-01-11 10:42:37', NULL, 10),
(153, 'SAN ANTONIO', '2021-01-11 10:42:37', NULL, 10),
(154, 'SAN ISIDRO', '2021-01-11 10:42:37', NULL, 10),
(155, 'SAN JUAN', '2021-01-11 10:42:37', NULL, 10),
(156, 'SAN MARCOS DE LA SIERRA', '2021-01-11 10:42:37', NULL, 10),
(157, 'SAN MIGUEL GUANCAPLA', '2021-01-11 10:42:37', NULL, 10),
(158, 'SANTA LUCÍA', '2021-01-11 10:42:37', NULL, 10),
(159, 'YAMARANGUILA', '2021-01-11 10:42:38', NULL, 10),
(160, 'SAN FRANCISCO DE OPALACA', '2021-01-11 10:42:38', NULL, 10),
(161, 'ROATÁN', '2021-01-11 10:43:50', NULL, 11),
(162, 'GUANAJA', '2021-01-11 10:43:50', NULL, 11),
(163, 'JOSÉ SANTOS GUARDIOLA', '2021-01-11 10:43:50', NULL, 11),
(164, 'UTILA', '2021-01-11 10:43:50', NULL, 11),
(165, 'LA PAZ', '2021-01-11 10:45:32', NULL, 12),
(166, 'AGUANQUETERIQUE', '2021-01-11 10:45:32', NULL, 12),
(167, 'CABAÑAS', '2021-01-11 10:45:32', NULL, 12),
(168, 'CANE', '2021-01-11 10:45:32', NULL, 12),
(169, 'CHINACLA', '2021-01-11 10:45:32', NULL, 12),
(170, 'GUAJIQUIRO', '2021-01-11 10:45:32', NULL, 12),
(171, 'LAUTERIQUE', '2021-01-11 10:45:32', NULL, 12),
(172, 'MARCALA', '2021-01-11 10:45:32', NULL, 12),
(173, 'MERCEDES DE ORIENTE', '2021-01-11 10:45:32', NULL, 12),
(174, 'OPATORO', '2021-01-11 10:45:32', NULL, 12),
(175, 'SAN ANTONIO DEL NORTE', '2021-01-11 10:45:32', NULL, 12),
(176, 'SAN JOSÉ', '2021-01-11 10:45:32', NULL, 12),
(177, 'SAN JUAN', '2021-01-11 10:45:32', NULL, 12),
(178, 'SAN PEDRO DE TUTULE', '2021-01-11 10:45:32', NULL, 12),
(179, 'SANTA ANA', '2021-01-11 10:45:33', NULL, 12),
(180, 'SANTA ELENA', '2021-01-11 10:45:33', NULL, 12),
(181, 'SANTA MARÍA', '2021-01-11 10:45:33', NULL, 12),
(182, 'SANTIAGO DE PURINGLA', '2021-01-11 10:45:33', NULL, 12),
(183, 'YARULA', '2021-01-11 10:45:33', NULL, 12),
(184, 'GRACIAS', '2021-01-11 10:47:09', NULL, 13),
(185, 'BELÉN', '2021-01-11 10:47:09', NULL, 13),
(186, 'CANDELARIA', '2021-01-11 10:47:09', NULL, 13),
(187, 'COLOLACA', '2021-01-11 10:47:09', NULL, 13),
(188, 'ERANDIQUE', '2021-01-11 10:47:10', NULL, 13),
(189, 'GUALCINCE', '2021-01-11 10:47:10', NULL, 13),
(190, 'GUARITA', '2021-01-11 10:47:10', NULL, 13),
(191, 'LA CAMPA', '2021-01-11 10:47:10', NULL, 13),
(192, 'LA IGUALA', '2021-01-11 10:47:10', NULL, 13),
(193, 'LAS FLORES', '2021-01-11 10:47:10', NULL, 13),
(194, 'LA UNIÓN', '2021-01-11 10:47:10', NULL, 13),
(195, 'LA VIRTUD', '2021-01-11 10:47:10', NULL, 13),
(196, 'LEPAERA', '2021-01-11 10:47:10', NULL, 13),
(197, 'MAPULACA', '2021-01-11 10:47:10', NULL, 13),
(198, 'PIRAERA', '2021-01-11 10:47:10', NULL, 13),
(199, 'SAN ANDRÉS', '2021-01-11 10:47:10', NULL, 13),
(200, 'SAN FRANCISCO', '2021-01-11 10:47:10', NULL, 13),
(201, 'SAN JUAN GUARITA', '2021-01-11 10:47:10', NULL, 13),
(202, 'SAN MANUEL COLOHETE', '2021-01-11 10:47:10', NULL, 13),
(203, 'SAN RAFAEL', '2021-01-11 10:47:10', NULL, 13),
(204, 'SAN SEBASTIÁN', '2021-01-11 10:47:10', NULL, 13),
(205, 'SANTA CRUZ', '2021-01-11 10:47:10', NULL, 13),
(206, 'TALGUA', '2021-01-11 10:47:10', NULL, 13),
(207, 'TAMBLA', '2021-01-11 10:47:10', NULL, 13),
(208, 'TOMALÁ', '2021-01-11 10:47:10', NULL, 13),
(209, 'VALLADOLID', '2021-01-11 10:47:10', NULL, 13),
(210, 'VIRGINIA', '2021-01-11 10:47:10', NULL, 13),
(211, 'SAN MARCOS DE CAIQUÍN', '2021-01-11 10:47:10', NULL, 13),
(212, 'OCOTEPEQUE', '2021-01-11 10:48:46', NULL, 14),
(213, 'BELÉN GUALCHO', '2021-01-11 10:48:46', NULL, 14),
(214, 'CONCEPCIÓN', '2021-01-11 10:48:46', NULL, 14),
(215, 'DOLORES MERENDÓN', '2021-01-11 10:48:46', NULL, 14),
(216, 'FRATERNIDAD', '2021-01-11 10:48:46', NULL, 14),
(217, 'LA ENCARNACIÓN', '2021-01-11 10:48:46', NULL, 14),
(218, 'LA LABOR', '2021-01-11 10:48:46', NULL, 14),
(219, 'LUCERNA', '2021-01-11 10:48:46', NULL, 14),
(220, 'MERCEDES', '2021-01-11 10:48:46', NULL, 14),
(221, 'SAN FERNANDO', '2021-01-11 10:48:46', NULL, 14),
(222, 'SAN FRANCISCO DEL VALLE', '2021-01-11 10:48:46', NULL, 14),
(223, 'SAN JORGE', '2021-01-11 10:48:46', NULL, 14),
(224, 'SAN MARCOS', '2021-01-11 10:48:46', NULL, 14),
(225, 'SANTA FE', '2021-01-11 10:48:46', NULL, 14),
(226, 'SENSENTI', '2021-01-11 10:48:46', NULL, 14),
(227, 'SINUAPA', '2021-01-11 10:48:46', NULL, 14),
(228, 'JUTICALPA', '2021-01-11 10:50:30', NULL, 15),
(229, 'CAMPAMENTO', '2021-01-11 10:50:30', NULL, 15),
(230, 'CATACAMAS', '2021-01-11 10:50:30', NULL, 15),
(231, 'CONCORDIA', '2021-01-11 10:50:30', NULL, 15),
(232, 'DULCE NOMBRE DE CULMÍ', '2021-01-11 10:50:30', NULL, 15),
(233, 'EL ROSARIO', '2021-01-11 10:50:30', NULL, 15),
(234, 'ESQUIPULAS DEL NORTE', '2021-01-11 10:50:30', NULL, 15),
(235, 'GUALACO', '2021-01-11 10:50:30', NULL, 15),
(236, 'GUARIZAMA', '2021-01-11 10:50:30', NULL, 15),
(237, 'GUATA', '2021-01-11 10:50:30', NULL, 15),
(238, 'GUAYAPE', '2021-01-11 10:50:30', NULL, 15),
(239, 'JANO', '2021-01-11 10:50:30', NULL, 15),
(240, 'LA UNIÓN', '2021-01-11 10:50:30', NULL, 15),
(241, 'MANGULILE', '2021-01-11 10:50:30', NULL, 15),
(242, 'MANTO', '2021-01-11 10:50:30', NULL, 15),
(243, 'SALAMÁ', '2021-01-11 10:50:30', NULL, 15),
(244, 'SAN ESTEBAN', '2021-01-11 10:50:30', NULL, 15),
(245, 'SAN FRANCISCO DE BECERRA', '2021-01-11 10:50:30', NULL, 15),
(246, 'SAN FRANCISCO DE LA PAZ', '2021-01-11 10:50:31', NULL, 15),
(247, 'SANTA MARÍA DEL REAL', '2021-01-11 10:50:31', NULL, 15),
(248, 'SILCA', '2021-01-11 10:50:31', NULL, 15),
(249, 'YOCÓN', '2021-01-11 10:50:31', NULL, 15),
(250, 'PATUCA', '2021-01-11 10:50:31', NULL, 15),
(251, 'SANTA BÁRBARA', '2021-01-11 10:53:10', NULL, 16),
(252, 'ARADA', '2021-01-11 10:53:10', NULL, 16),
(253, 'ATIMA', '2021-01-11 10:53:10', NULL, 16),
(254, 'AZACUALPA', '2021-01-11 10:53:10', NULL, 16),
(255, 'CEGUACA', '2021-01-11 10:53:10', NULL, 16),
(256, 'CONCEPCIÓN DEL NORTE', '2021-01-11 10:53:10', NULL, 16),
(257, 'CONCEPCIÓN DEL SUR', '2021-01-11 10:53:10', NULL, 16),
(258, 'CHINDA', '2021-01-11 10:53:10', NULL, 16),
(259, 'EL NÍSPERO', '2021-01-11 10:53:10', NULL, 16),
(260, 'GUALALA', '2021-01-11 10:53:10', NULL, 16),
(261, 'ILAMA', '2021-01-11 10:53:10', NULL, 16),
(262, 'LAS VEGAS', '2021-01-11 10:53:10', NULL, 16),
(263, 'MACUELIZO', '2021-01-11 10:53:10', NULL, 16),
(264, 'NARANJITO', '2021-01-11 10:53:10', NULL, 16),
(265, 'NUEVO CELILAC', '2021-01-11 10:53:11', NULL, 16),
(266, 'NUEVA FRONTERA', '2021-01-11 10:53:11', NULL, 16),
(267, 'PETOA', '2021-01-11 10:53:11', NULL, 16),
(268, 'PROTECCIÓN', '2021-01-11 10:53:11', NULL, 16),
(269, 'QUIMISTÁN', '2021-01-11 10:53:11', NULL, 16),
(270, 'SAN FRANCISCO DE OJUERA', '2021-01-11 10:53:11', NULL, 16),
(271, 'SAN JOSÉ DE LAS COLINAS', '2021-01-11 10:53:11', NULL, 16),
(272, 'SAN LUIS', '2021-01-11 10:53:11', NULL, 16),
(273, 'SAN MARCOS', '2021-01-11 10:53:11', NULL, 16),
(274, 'SAN NICOLÁS', '2021-01-11 10:53:11', NULL, 16),
(275, 'SAN PEDRO ZACAPA', '2021-01-11 10:53:11', NULL, 16),
(276, 'SAN VICENTE CENTENARIO', '2021-01-11 10:53:11', NULL, 16),
(277, 'SANTA RITA', '2021-01-11 10:53:11', NULL, 16),
(278, 'TRINIDAD', '2021-01-11 10:53:11', NULL, 16),
(279, 'NACAOME', '2021-01-11 10:54:24', NULL, 17),
(280, 'ALIANZA', '2021-01-11 10:54:24', NULL, 17),
(281, 'AMAPALA', '2021-01-11 10:54:24', NULL, 17),
(282, 'ARAMECINA', '2021-01-11 10:54:24', NULL, 17),
(283, 'CARIDAD', '2021-01-11 10:54:24', NULL, 17),
(284, 'GOASCORÁN', '2021-01-11 10:54:24', NULL, 17),
(285, 'LANGUE', '2021-01-11 10:54:24', NULL, 17),
(286, 'SAN FRANCISCO DE CORAY', '2021-01-11 10:54:24', NULL, 17),
(287, 'SAN LORENZO', '2021-01-11 10:54:24', NULL, 17),
(288, 'YORO', '2021-01-11 10:55:56', NULL, 18),
(289, 'ARENAL', '2021-01-11 10:55:56', NULL, 18),
(290, 'EL NEGRITO', '2021-01-11 10:55:56', NULL, 18),
(291, 'EL PROGRESO', '2021-01-11 10:55:56', NULL, 18),
(292, 'JOCÓN', '2021-01-11 10:55:56', NULL, 18),
(293, 'MORAZÁN', '2021-01-11 10:55:56', NULL, 18),
(294, 'OLANCHITO', '2021-01-11 10:55:56', NULL, 18),
(295, 'SANTA RITA', '2021-01-11 10:55:56', NULL, 18),
(296, 'SULACO', '2021-01-11 10:55:56', NULL, 18),
(297, 'VICTORIA', '2021-01-11 10:55:56', NULL, 18),
(298, 'YORITO', '2021-01-11 10:55:56', NULL, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_compra`
--

CREATE TABLE `pago_compra` (
  `id` int(11) NOT NULL,
  `monto` double NOT NULL,
  `url_img` varchar(250) NOT NULL,
  `fecha` date NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `compra_id` int(11) NOT NULL,
  `users_id_elimina` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_eliminado` timestamp NULL DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pago_compra`
--

INSERT INTO `pago_compra` (`id`, `monto`, `url_img`, `fecha`, `users_id`, `compra_id`, `users_id_elimina`, `fecha_eliminado`, `estado_id`, `created_at`, `updated_at`) VALUES
(2, 10200, 'IMG_1651531165-.pdf', '2022-05-04', 3, 4, NULL, NULL, 1, '2022-05-03 04:39:25', '2022-05-03 04:39:25'),
(14, 100, 'IMG_1651613962-.png', '2022-05-04', 3, 1, NULL, NULL, 1, '2022-05-04 03:39:22', '2022-05-04 03:39:22'),
(15, 300.6, 'IMG_1652844037-.png', '2022-05-17', 2, 6, 2, '2022-05-17 21:21:46', 2, '2022-05-17 21:20:37', '2022-05-17 21:21:46'),
(16, 210, 'IMG_1652844077-.png', '2022-05-17', 2, 6, NULL, NULL, 1, '2022-05-17 21:21:17', '2022-05-17 21:21:17'),
(17, 300.6, 'IMG_1652844127-.png', '2022-05-17', 2, 6, NULL, NULL, 1, '2022-05-17 21:22:07', '2022-05-17 21:22:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Honduras', '2022-03-14 21:56:05', '2022-03-14 21:55:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios_venta`
--

CREATE TABLE `precios_venta` (
  `id` int(11) NOT NULL,
  `precio` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `precios_venta`
--

INSERT INTO `precios_venta` (`id`, `precio`, `created_at`, `updated_at`, `producto_id`, `users_id`) VALUES
(1, 100, '2022-03-25 04:42:55', '2022-03-25 04:42:55', 1, 3),
(2, 200, '2022-03-25 04:42:55', '2022-03-25 04:42:55', 1, 3),
(3, 300, '2022-03-25 04:42:55', '2022-03-25 04:42:55', 1, 3),
(4, 100, '2022-03-25 04:44:01', '2022-03-25 04:44:01', 2, 3),
(5, 200, '2022-03-25 04:44:01', '2022-03-25 04:44:01', 2, 3),
(6, 300, '2022-03-25 04:44:01', '2022-03-25 04:44:01', 2, 3),
(13, 100, '2022-03-25 04:47:04', '2022-03-25 04:47:04', 5, 3),
(14, 200, '2022-03-25 04:47:04', '2022-03-25 04:47:04', 5, 3),
(15, 300, '2022-03-25 04:47:04', '2022-03-25 04:47:04', 5, 3),
(16, 1, '2022-03-30 04:38:55', '2022-03-30 04:38:55', 6, 3),
(17, 2, '2022-03-30 04:38:55', '2022-03-30 04:38:55', 6, 3),
(18, 3, '2022-03-30 04:38:55', '2022-03-30 04:38:55', 6, 3),
(19, 100, '2022-04-05 23:28:30', '2022-04-05 23:28:30', 7, 3),
(20, 200, '2022-04-05 23:28:30', '2022-04-05 23:28:30', 7, 3),
(21, 300, '2022-04-05 23:28:30', '2022-04-05 23:28:30', 7, 3),
(22, 100, '2022-04-05 23:31:52', '2022-04-05 23:31:52', 8, 3),
(23, 200, '2022-04-05 23:31:52', '2022-04-05 23:31:52', 8, 3),
(24, 300, '2022-04-05 23:31:52', '2022-04-05 23:31:52', 8, 3),
(31, 10, '2022-04-05 23:49:44', '2022-04-05 23:49:44', 11, 3),
(32, 20, '2022-04-05 23:49:44', '2022-04-05 23:49:44', 11, 3),
(33, 30, '2022-04-05 23:49:44', '2022-04-05 23:49:44', 11, 3),
(34, 100, '2022-04-05 23:50:55', '2022-04-05 23:50:55', 12, 3),
(35, 200, '2022-04-05 23:50:55', '2022-04-05 23:50:55', 12, 3),
(36, 300, '2022-04-05 23:50:55', '2022-04-05 23:50:55', 12, 3),
(37, 100, '2022-04-06 00:07:35', '2022-04-06 00:07:35', 13, 3),
(38, 4, '2022-04-06 00:07:35', '2022-04-06 00:07:35', 13, 3),
(39, 2, '2022-04-06 00:07:35', '2022-04-06 00:07:35', 13, 3),
(40, 100, '2022-04-06 00:09:41', '2022-04-06 00:09:41', 14, 3),
(41, 200, '2022-04-06 00:09:41', '2022-04-06 00:09:41', 14, 3),
(42, 300, '2022-04-06 00:09:41', '2022-04-06 00:09:41', 14, 3),
(43, 100, '2022-04-07 01:48:53', '2022-04-07 01:48:53', 15, 3),
(44, 200, '2022-04-07 01:48:53', '2022-04-07 01:48:53', 15, 3),
(45, 500, '2022-04-07 01:48:53', '2022-04-07 01:48:53', 15, 3),
(46, 100, '2022-04-20 22:49:11', '2022-04-20 22:49:11', 16, 3),
(47, 200, '2022-04-20 22:49:11', '2022-04-20 22:49:11', 16, 3),
(48, 300, '2022-04-20 22:49:11', '2022-04-20 22:49:11', 16, 3),
(49, 22, '2022-04-20 22:55:39', '2022-04-20 22:55:39', 17, 3),
(50, 55, '2022-04-20 22:55:39', '2022-04-20 22:55:39', 17, 3),
(51, 22, '2022-04-20 22:59:01', '2022-04-20 22:59:01', 18, 3),
(52, 55, '2022-04-20 22:59:01', '2022-04-20 22:59:01', 18, 3),
(53, 22, '2022-04-20 23:01:43', '2022-04-20 23:01:43', 19, 3),
(54, 55, '2022-04-20 23:01:43', '2022-04-20 23:01:43', 19, 3),
(55, 22, '2022-04-20 23:05:15', '2022-04-20 23:05:15', 20, 3),
(56, 555, '2022-04-20 23:05:15', '2022-04-20 23:05:15', 20, 3),
(57, 55, '2022-04-20 23:06:08', '2022-04-20 23:06:08', 21, 3),
(58, 55, '2022-04-20 23:06:08', '2022-04-20 23:06:08', 21, 3),
(59, 55, '2022-04-20 23:08:15', '2022-04-20 23:08:15', 22, 3),
(60, 55, '2022-04-20 23:08:15', '2022-04-20 23:08:15', 22, 3),
(61, 55, '2022-04-20 23:09:35', '2022-04-20 23:09:35', 23, 3),
(62, 88, '2022-04-20 23:09:35', '2022-04-20 23:09:35', 23, 3),
(63, 88, '2022-04-20 23:10:43', '2022-04-20 23:10:43', 24, 3),
(64, 55, '2022-04-20 23:10:43', '2022-04-20 23:10:43', 24, 3),
(65, 55, '2022-04-20 23:12:03', '2022-04-20 23:12:03', 25, 3),
(66, 777, '2022-04-20 23:12:03', '2022-04-20 23:12:03', 25, 3),
(67, 55, '2022-04-20 23:16:55', '2022-04-20 23:16:55', 26, 3),
(68, 555, '2022-04-20 23:16:55', '2022-04-20 23:16:55', 26, 3),
(69, 200, '2022-04-20 23:19:39', '2022-04-20 23:19:39', 27, 3),
(70, 300, '2022-04-20 23:19:39', '2022-04-20 23:19:39', 27, 3),
(71, 55, '2022-04-20 23:20:53', '2022-04-20 23:20:53', 28, 3),
(72, 55, '2022-04-20 23:20:53', '2022-04-20 23:20:53', 28, 3),
(73, 200, '2022-04-20 23:22:02', '2022-04-20 23:22:02', 29, 3),
(74, 300, '2022-04-20 23:22:02', '2022-04-20 23:22:02', 29, 3),
(75, 55, '2022-04-20 23:22:52', '2022-04-20 23:22:52', 30, 3),
(76, 55, '2022-04-20 23:22:52', '2022-04-20 23:22:52', 30, 3),
(77, 22, '2022-04-20 23:33:59', '2022-04-20 23:33:59', 31, 3),
(78, 200, '2022-04-20 23:33:59', '2022-04-20 23:33:59', 31, 3),
(79, 200, '2022-04-20 23:35:20', '2022-04-20 23:35:20', 32, 3),
(80, 300, '2022-04-20 23:35:20', '2022-04-20 23:35:20', 32, 3),
(81, 88, '2022-04-20 23:42:04', '2022-04-20 23:42:04', 33, 3),
(82, 55, '2022-04-20 23:42:04', '2022-04-20 23:42:04', 33, 3),
(83, 555, '2022-04-20 23:43:16', '2022-04-20 23:43:16', 34, 3),
(84, 55, '2022-04-20 23:43:16', '2022-04-20 23:43:16', 34, 3),
(85, 555, '2022-04-20 23:45:06', '2022-04-20 23:45:06', 35, 3),
(86, 55, '2022-04-20 23:45:06', '2022-04-20 23:45:06', 35, 3),
(87, 100.4, '2022-05-17 22:06:31', '2022-05-17 22:06:31', 36, 3),
(88, 100.5, '2022-05-17 22:06:31', '2022-05-17 22:06:31', 36, 3),
(89, 4545, '2022-05-18 13:59:31', '2022-05-18 13:59:31', 38, 2),
(90, 45, '2022-05-18 13:59:31', '2022-05-18 13:59:31', 38, 2),
(91, 57575, '2022-05-18 14:02:14', '2022-05-18 14:02:14', 39, 2),
(92, 7555, '2022-05-18 14:02:14', '2022-05-18 14:02:14', 39, 2),
(93, 14, '2022-05-18 14:10:44', '2022-05-18 14:10:44', 40, 5),
(94, 16, '2022-05-18 14:10:44', '2022-05-18 14:10:44', 40, 5),
(95, 100.4, '2022-05-18 14:11:47', '2022-05-18 14:11:47', 41, 3),
(96, 100.5, '2022-05-18 14:11:47', '2022-05-18 14:11:47', 41, 3),
(97, 69.85, '2022-05-18 15:26:47', '2022-05-18 15:26:47', 45, 5),
(98, 80.33, '2022-05-18 15:26:47', '2022-05-18 15:26:47', 45, 5),
(99, 7.45, '2022-05-18 15:33:21', '2022-05-18 15:33:21', 46, 5),
(100, 8.57, '2022-05-18 15:33:21', '2022-05-18 15:33:21', 46, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `isv` int(11) NOT NULL,
  `precio_base` double DEFAULT NULL,
  `codigo_barra` varchar(100) DEFAULT NULL,
  `codigo_estatal` varchar(45) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `unidad_medida_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado_producto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `isv`, `precio_base`, `codigo_barra`, `codigo_estatal`, `categoria_id`, `unidad_medida_id`, `users_id`, `created_at`, `updated_at`, `estado_producto_id`) VALUES
(1, 'producto1', 'Producto', 15, 100, '111', '111', 1, 1, 3, '2022-03-25 04:42:55', '2022-03-25 04:42:55', 0),
(2, 'producto2', 'Producto', 15, 100, '111', '111', 1, 1, 3, '2022-03-27 21:38:28', '2022-03-25 04:44:01', 0),
(5, 'producto3', 'Producto', 15, 100, '111', '111', 1, 1, 3, '2022-03-27 21:38:35', '2022-03-25 04:47:04', 0),
(6, 'producto 4', 'producto 4, registro de prueba', 15, 100, '111', '111', 1, 1, 3, '2022-03-30 04:38:55', '2022-03-30 04:38:55', 0),
(7, 'producto 7', 'Prueba con imagenes', 15, 100, '1001', '1000', 1, 1, 3, '2022-04-05 23:28:30', '2022-04-05 23:28:30', 0),
(8, 'producto 8', 'prueba de imagenes', 15, 100, '1004', '504', 2, 1, 3, '2022-04-05 23:31:52', '2022-04-05 23:31:52', 0),
(11, 'producto 10', 'imagenes', 15, 100, '100', '244', 1, 1, 3, '2022-04-05 23:49:44', '2022-04-05 23:49:44', 0),
(12, 'producto 12', 'imagenes', 15, 100, '2', '4', 1, 1, 3, '2022-04-05 23:50:55', '2022-04-05 23:50:55', 0),
(13, 'producto 4', 'vvv', 15, 100, '44', '22', 1, 1, 3, '2022-04-06 00:07:35', '2022-04-06 00:07:35', 0),
(14, 'producto 44', 'ddd', 15, 100, '22', '55', 1, 1, 3, '2022-04-06 00:09:41', '2022-04-06 00:09:41', 0),
(15, 'Imagenes', 'Imagenes', 15, NULL, '1000', '12011', 1, 1, 3, '2022-04-07 01:48:53', '2022-04-07 01:48:53', 0),
(16, 'producto prueba espera', 'espera', 15, NULL, '4455', '777', 1, 1, 3, '2022-04-20 22:49:11', '2022-04-20 22:49:11', 0),
(17, 'producto prueba espera 2', 'prueba', 15, 100, '44', '55', 1, 1, 3, '2022-04-20 22:55:39', '2022-04-20 22:55:39', 0),
(18, 'prueba espera 3', 'prueba', 15, 100, '444', '555', 2, 1, 3, '2022-04-20 22:59:01', '2022-04-20 22:59:01', 0),
(19, 'prueab espera 5', 'prueba', 15, 100, '44', '55', 1, 2, 3, '2022-04-20 23:01:43', '2022-04-20 23:01:43', 0),
(20, 'prueba 6 espera', 'ff', 15, 100, '4455', '555', 1, 1, 3, '2022-04-20 23:05:15', '2022-04-20 23:05:15', 0),
(21, 'producto 66', 'prueba', 15, 100, '44', '55', 1, 2, 3, '2022-04-20 23:06:08', '2022-04-20 23:06:08', 0),
(22, 'producto 10 prueba espera', 'prueba', 15, 425, '44', '55', 1, 1, 3, '2022-04-20 23:08:15', '2022-04-20 23:08:15', 0),
(23, 'producto 10 prueba', 'prueba', 15, 444, '444', '555', 1, 1, 3, '2022-04-20 23:09:35', '2022-04-20 23:09:35', 0),
(24, 'producto 12 espera', 'prueba', 15, 555, '555', '444', 2, 1, 3, '2022-04-20 23:10:43', '2022-04-20 23:10:43', 0),
(25, 'producto 4', 'fff', 15, 4444, '45', '444', 1, 1, 3, '2022-04-20 23:12:03', '2022-04-20 23:12:03', 0),
(26, 'producto 13 espera', 'prueba', 15, 555, '44', '55', 1, 1, 3, '2022-04-20 23:16:55', '2022-04-20 23:16:55', 0),
(27, 'prueba 14 espera', 'prueba', 15, 100, '44', '55', 1, 1, 3, '2022-04-20 23:19:39', '2022-04-20 23:19:39', 0),
(28, 'prueba 15', 'prueba', 15, 22, '555', '55', 1, 1, 3, '2022-04-20 23:20:53', '2022-04-20 23:20:53', 0),
(29, 'prueba espera 16', 'prueba', 15, 100, '111', '222', 1, 1, 3, '2022-04-20 23:22:02', '2022-04-20 23:22:02', 0),
(30, 'producto 4', 'ppp', 15, 111, '444', '44', 1, 1, 3, '2022-04-20 23:22:52', '2022-04-20 23:22:52', 0),
(31, 'producto 17 prueba espera', 'producto', 15, 100, '4444', '55', 1, 1, 3, '2022-04-20 23:33:59', '2022-04-20 23:33:59', 0),
(32, 'producto 18 prueba espera', 'prueba', 15, 100, '455', '555', 1, 1, 3, '2022-04-20 23:35:20', '2022-04-20 23:35:20', 0),
(33, 'producto 18 prueba espera', 'prueba', 15, 555, '445', '555', 1, 1, 3, '2022-04-20 23:42:04', '2022-04-20 23:42:04', 0),
(34, 'prueba producto 19', 'prueba', 15, 222, '4455', '555', 1, 1, 3, '2022-04-20 23:43:16', '2022-04-20 23:43:16', 0),
(35, 'producto 19 prueba espera', 'prueba', 15, 222, '1000', '111', 1, 1, 3, '2022-04-20 23:45:06', '2022-04-20 23:45:06', 0),
(36, 'Sin Impuesto', 'Sin Impuesto', 0, 100.3, '33312', '33312', 1, 1, 3, '2022-05-17 22:06:31', '2022-05-17 22:06:31', 1),
(38, 'pruebafallo', 'uiioio', 18, 54, '465', '45', 2, 15, 2, '2022-05-18 13:59:31', '2022-05-18 13:59:31', 1),
(39, 'pruebafallo_', 'lñlñ', 15, 7575, '457', '75', 1, 8, 2, '2022-05-18 14:02:14', '2022-05-18 14:02:14', 1),
(40, 'Separadores', 'Separadores Para Carpeta Pointer T/Carta (5 Divisiones) A05', 15, 12, '7453010085452', '01', 1, 23, 5, '2022-05-18 20:20:21', '2022-05-18 14:20:21', 1),
(41, 'Prueba de producto 18-05', 'Prueba de registro de producto con el sistema en face de produccion', 15, 100.3, '1111111111111111111111', '1111111111111111111111', 1, 1, 3, '2022-05-18 14:11:47', '2022-05-18 14:11:47', 1),
(44, 'producto sin precios opcionales', 'producto sin precios opcionales, ni codigos de barra', 15, 100.68, '123456789123456789', '123456789', 1, 1, 3, '2022-05-18 14:30:58', '2022-05-18 14:30:58', 1),
(45, 'Candado', 'Candado ch 45MM De Hierro Hermex', 15, 60.74, '12345678910', '756', 1, 1, 5, '2022-05-18 15:26:47', '2022-05-18 15:26:47', 1),
(46, 'LIJA', 'Lija Para Metal A99-400A 9x11plg. Papel Uso C/Agua', 15, 6.48, '1245863747588', '578', 2, 4, 5, '2022-05-18 15:33:21', '2022-05-18 15:33:21', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) NOT NULL,
  `direccion` text NOT NULL,
  `contacto` varchar(45) NOT NULL,
  `telefono_1` varchar(45) NOT NULL,
  `telefono_2` varchar(45) DEFAULT NULL,
  `correo_1` varchar(45) NOT NULL,
  `correo_2` varchar(45) DEFAULT NULL,
  `rtn` varchar(45) NOT NULL,
  `registrado_por` bigint(20) UNSIGNED NOT NULL,
  `estado_id` int(11) NOT NULL,
  `municipio_id` int(11) NOT NULL,
  `tipo_personalidad_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `codigo`, `nombre`, `direccion`, `contacto`, `telefono_1`, `telefono_2`, `correo_1`, `correo_2`, `rtn`, `registrado_por`, `estado_id`, `municipio_id`, `tipo_personalidad_id`, `categoria_id`, `created_at`, `updated_at`) VALUES
(1, '11101', 'Proveedor 1', 'comayaguela', 'Pedro', '+50489282146', '5569874', 'luisfaviles18@gmail.com', 'luisfaviles18@gmail.com', '08011990568971', 3, 1, 110, 1, 1, '2022-03-15 09:31:28', '2022-03-29 09:29:54'),
(2, '11101', 'Proveedor 2', 'comayaguela', 'Pedro', '+50489282146', NULL, 'luisfaviles18@gmail.com', NULL, '08011990568971', 3, 1, 110, 1, 1, '2022-03-15 09:32:42', '2022-03-29 09:18:04'),
(4, '12', 'Proveedor 3', 'TEGUCIGALPA\r\nTEGUCIGALPA', 'Pedro', '89282146', NULL, 'luisfaviles18@gmail.com', NULL, '08011990568971', 3, 1, 110, 1, 1, '2022-03-15 09:53:24', '2022-03-29 09:18:17'),
(5, '12', 'Proveedor 4', 'TEGUCIGALPA\r\nTEGUCIGALPA', 'Pedro', '89282146', NULL, 'luisfaviles18@gmail.com', NULL, '08011990568971', 3, 1, 110, 1, 1, '2022-03-15 09:53:41', '2022-03-29 09:18:26'),
(6, '66', 'Proveedor 5', 'TEGUCIGALPA\r\nTEGUCIGALPA', 'Pedro', '99885522', '223355669', 'proveedor1@gmail.com', NULL, '08011990568971', 3, 1, 110, 2, 1, '2022-03-15 12:21:54', '2022-03-15 12:21:54'),
(7, '66', 'Proveedor 6', 'TEGUCIGALPA\r\nTEGUCIGALPA', 'Pedro', '99885522', '223355669', 'proveedor1@gmail.com', NULL, '08011990568971', 3, 1, 110, 2, 1, '2022-03-15 12:22:04', '2022-03-29 09:18:36'),
(8, '66', 'Proveedor 7', 'TEGUCIGALPA\r\nTEGUCIGALPA', 'Pedro', '99885522', '223355669', 'proveedor1@gmail.com', NULL, '08011990568971', 3, 1, 110, 2, 1, '2022-03-15 12:22:07', '2022-03-29 09:18:43'),
(9, '663', 'Proveedor 8', 'Tegucigalpa', 'Juan Perez', '88996655', NULL, 'proveedor@gmail.com', NULL, '08011990568971', 3, 1, 10, 1, 1, '2022-03-15 12:23:56', '2022-03-15 13:02:28'),
(10, '20', 'Proveedor 20', 'comayaguela, col Policarpo Paz García, casa 204, color amarillo', 'Pedro', '89282146', NULL, 'luisfaviles18@gmail.com', 'luisfaviles18@gmail.com', '082219950082544', 3, 1, 110, 1, 1, '2022-05-05 02:39:01', '2022-05-05 02:39:01'),
(11, '01', 'LARACH&CIA S. DE R.L. DE C.V.', 'Colonia Miramontes, Calle La Salud #1347 M.D.C. F.M', 'Yimi', '2290-1100', '2237-8171', 'lcruz@larachycia.com', NULL, '08019000235234', 5, 1, 110, 2, 1, '2022-05-17 08:29:22', '2022-05-17 08:29:22'),
(12, '02', 'PAPELERIA HONDURAS S. DE R.L.', 'Barrio Morazán, Frente Al Antiguo Centro Social  Universitario, Casa No. 1338,Tegucigalpa M.D.C.', 'Don Rene', '2235-6315', '2239-5782', 'papeleriahonduras@yahoo.com', NULL, '08019998391040', 5, 1, 110, 2, 1, '2022-05-17 08:37:04', '2022-05-17 08:37:04'),
(13, '03', 'DISTRIBUIDORA UNIVERSAL S. DE R.L.', 'Colonia 15 Bloque Q #6004 Tegucigalpa M.D.C. Atrás De La Parroquia Santa Teresa de Jesús.', 'Yasmin, Angel', '2228-2195', '2246-3242', 'ventas_didtuniversal@hotmail.com', NULL, '08019013578169', 5, 1, 110, 2, 1, '2022-05-17 09:00:53', '2022-05-17 09:00:53'),
(14, '04', 'PAPELERA MONICA S. DE R.L.', 'Esquina Opuesta Delikatessen. Blvd. Morazán Francisco Morazan, D.c. Honduras C.A.', 'Monica', '22396828', '2237-6077', 'papeleramonicahn@gmail.com', NULL, '08019015753539', 5, 1, 110, 2, 1, '2022-05-17 14:00:16', '2022-05-17 14:00:16'),
(15, '05', 'Prueba', 'dffgmmsjh', 'sdf', '45276', '42566', 'fggdghghhhghgd', NULL, '1282646', 5, 1, 110, 1, 1, '2022-05-18 14:22:13', '2022-05-18 14:22:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibido_bodega`
--

CREATE TABLE `recibido_bodega` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `seccion_id` int(11) NOT NULL,
  `cantidad_compra_lote` int(11) NOT NULL,
  `cantidad_inicial_seccion` int(11) NOT NULL,
  `cantidad_disponible` int(11) NOT NULL,
  `fecha_recibido` date NOT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `estado_recibido` int(11) NOT NULL,
  `recibido_por` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `recibido_bodega`
--

INSERT INTO `recibido_bodega` (`id`, `compra_id`, `producto_id`, `seccion_id`, `cantidad_compra_lote`, `cantidad_inicial_seccion`, `cantidad_disponible`, `fecha_recibido`, `fecha_expiracion`, `estado_recibido`, `recibido_por`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 100, 50, 30, '2022-04-30', '2022-05-31', 4, 3, '2022-04-30 21:04:53', '2022-05-12 12:31:24'),
(2, 1, 1, 2, 100, 50, 20, '2022-04-30', '2022-05-31', 4, 4, '2022-04-30 21:06:42', '2022-05-12 12:37:09'),
(3, 4, 1, 2, 30, 10, 0, '2022-05-06', '2022-05-02', 4, 3, '2022-05-06 08:30:36', '2022-05-12 13:17:00'),
(4, 4, 1, 15, 30, 10, 0, '2022-05-06', '2022-05-02', 4, 3, '2022-05-06 08:37:56', '2022-05-12 13:00:01'),
(6, 4, 1, 17, 30, 5, 5, '2022-05-05', '2022-05-02', 4, 3, '2022-05-06 04:26:13', '2022-05-06 04:26:13'),
(7, 1, 1, 16, 100, 10, 10, '2022-05-06', '2022-05-31', 4, 3, '2022-05-06 17:39:26', '2022-05-06 17:39:26'),
(8, 4, 1, 17, 30, 5, 5, '2022-05-11', '2022-05-02', 4, 3, '2022-05-11 20:30:26', '2022-05-11 20:30:26'),
(9, 1, 1, 17, 100, 10, 0, '2022-05-11', '2022-05-31', 4, 3, '2022-05-11 22:32:21', '2022-05-12 13:02:47'),
(10, 1, 1, 16, 100, 10, 0, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 12:30:40', '2022-05-12 12:52:10'),
(11, 1, 1, 15, 100, 10, 0, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 12:31:24', '2022-05-12 12:48:00'),
(12, 1, 1, 17, 100, 10, 0, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 12:33:54', '2022-05-12 12:42:54'),
(13, 1, 1, 17, 100, 10, 0, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 12:37:09', '2022-05-12 12:38:52'),
(14, 1, 1, 1, 100, 10, 10, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 12:38:52', '2022-05-12 12:38:52'),
(15, 1, 1, 17, 100, 10, 0, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 12:42:54', '2022-05-12 12:46:06'),
(16, 1, 1, 8, 100, 10, 7, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 12:46:06', '2022-05-12 13:18:18'),
(17, 1, 1, 8, 100, 10, 0, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 12:48:00', '2022-05-12 13:15:54'),
(18, 1, 1, 4, 100, 10, 0, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 12:52:10', '2022-05-12 13:11:27'),
(19, 4, 1, 13, 30, 10, 0, '2022-05-12', '2022-05-02', 4, 3, '2022-05-12 13:00:01', '2022-05-12 13:07:53'),
(20, 1, 1, 4, 100, 10, 0, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 13:02:47', '2022-05-12 13:06:59'),
(21, 1, 1, 15, 100, 10, 10, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 13:06:59', '2022-05-12 13:06:59'),
(22, 4, 1, 16, 30, 10, 10, '2022-05-12', '2022-05-02', 4, 3, '2022-05-12 13:07:53', '2022-05-12 13:07:53'),
(23, 1, 1, 16, 100, 10, 10, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 13:11:27', '2022-05-12 13:11:27'),
(24, 1, 1, 15, 100, 10, 10, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 13:15:54', '2022-05-12 13:15:54'),
(25, 4, 1, 16, 30, 10, 10, '2022-05-12', '2022-05-02', 4, 3, '2022-05-12 13:17:00', '2022-05-12 13:17:00'),
(26, 1, 1, 17, 100, 3, 3, '2022-05-12', '2022-05-31', 4, 3, '2022-05-12 13:18:18', '2022-05-12 13:18:18'),
(27, 5, 1, 16, 80, 5, 5, '2022-05-16', NULL, 4, 3, '2022-05-16 01:15:15', '2022-05-16 01:15:15'),
(28, 6, 16, 4, 2, 2, 1, '2022-05-17', '2022-05-04', 4, 2, '2022-05-18 03:23:36', '2022-05-17 21:23:36'),
(29, 6, 16, 17, 2, 1, 1, '2022-05-17', '2022-05-04', 4, 2, '2022-05-17 21:23:36', '2022-05-17 21:23:36'),
(30, 7, 1, 16, 1, 1, 1, '2022-05-17', NULL, 4, 3, '2022-05-17 22:08:43', '2022-05-17 22:08:43'),
(31, 7, 36, 15, 1, 1, 0, '2022-05-17', NULL, 4, 3, '2022-05-18 04:10:31', '2022-05-17 22:10:31'),
(32, 7, 36, 14, 1, 1, 1, '2022-05-17', NULL, 4, 3, '2022-05-17 22:10:31', '2022-05-17 22:10:31'),
(33, 8, 40, 35, 7905, 7905, 0, '2022-05-18', '2022-09-18', 4, 5, '2022-05-18 20:45:58', '2022-05-18 14:45:58'),
(34, 8, 40, 21, 7905, 7905, 7905, '2022-05-18', '2022-09-18', 4, 5, '2022-05-18 14:45:58', '2022-05-18 14:45:58'),
(35, 9, 45, 1, 96, 96, 96, '2022-05-18', '2022-05-18', 4, 5, '2022-05-18 15:40:28', '2022-05-18 15:40:28'),
(36, 9, 46, 21, 50, 50, 50, '2022-05-18', '2022-05-18', 4, 5, '2022-05-18 15:40:50', '2022-05-18 15:40:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retenciones`
--

CREATE TABLE `retenciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `valor` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo_retencion_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `retenciones`
--

INSERT INTO `retenciones` (`id`, `nombre`, `valor`, `created_at`, `updated_at`, `tipo_retencion_id`, `users_id`) VALUES
(1, 'No aplica a retencion', 0, '2022-03-29 04:47:17', '2022-03-15 03:20:28', 2, 2),
(2, 'Retencion del 1%', 1, '2022-03-29 04:47:22', '2022-03-15 00:49:57', 2, 2),
(3, 'prueba de registro', 18, '2022-03-30 07:35:36', '2022-03-30 07:35:36', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retenciones_has_proveedores`
--

CREATE TABLE `retenciones_has_proveedores` (
  `retenciones_id` int(11) NOT NULL,
  `proveedores_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `retenciones_has_proveedores`
--

INSERT INTO `retenciones_has_proveedores` (`retenciones_id`, `proveedores_id`, `created_at`, `updated_at`) VALUES
(2, 1, '2022-04-20 06:00:00', '2022-04-20 06:00:00'),
(2, 4, '2022-03-15 09:53:24', '2022-03-15 09:53:24'),
(2, 6, '2022-03-15 12:21:54', '2022-03-15 12:21:54'),
(2, 7, '2022-03-15 12:22:04', '2022-03-15 12:22:04'),
(2, 8, '2022-03-15 12:22:07', '2022-03-15 12:22:07'),
(2, 9, '2022-03-15 12:23:56', '2022-03-15 12:23:56'),
(3, 11, '2022-05-17 08:29:22', '2022-05-17 08:29:22'),
(3, 12, '2022-05-17 08:37:04', '2022-05-17 08:37:04'),
(3, 13, '2022-05-17 09:00:53', '2022-05-17 09:00:53'),
(3, 14, '2022-05-17 14:00:16', '2022-05-17 14:00:16'),
(3, 15, '2022-05-18 14:22:13', '2022-05-18 14:22:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `numeracion` int(11) DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `segmento_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id`, `descripcion`, `numeracion`, `estado_id`, `segmento_id`, `created_at`, `updated_at`) VALUES
(1, 'Seccion A 1', 1, 2, 1, '2022-04-03 01:21:42', '2022-04-05 22:22:27'),
(2, 'Seccion A 2', 2, 1, 1, '2022-04-03 01:21:42', '2022-04-05 22:22:35'),
(3, 'Seccion B 1', 1, 1, 2, '2022-04-03 01:21:42', '2022-04-05 22:22:35'),
(4, 'Seccion B 2', 2, 1, 2, '2022-04-03 01:21:42', '2022-04-05 22:22:35'),
(5, 'Seccion B 3', 3, 1, 2, '2022-04-03 01:21:42', '2022-04-05 22:22:35'),
(6, 'Seccion C 1', 1, 1, 3, '2022-04-03 01:21:42', '2022-04-05 22:22:35'),
(7, 'Seccion C 2', 2, 1, 3, '2022-04-03 01:21:42', '2022-04-05 22:22:35'),
(8, 'Seccion C 3', 3, 1, 3, '2022-04-03 01:21:42', '2022-04-05 22:22:35'),
(9, 'Seccion C 4', 4, 1, 3, '2022-04-03 01:21:42', '2022-04-05 22:22:35'),
(10, 'Seccion D 1', 1, 1, 4, '2022-04-03 01:21:42', '2022-04-05 22:22:35'),
(11, 'Seccion D 2', 2, 1, 4, '2022-04-03 01:21:42', '2022-04-05 22:22:36'),
(12, 'Seccion D 3', 3, 1, 4, '2022-04-03 01:21:42', '2022-04-05 22:22:36'),
(13, 'Seccion D 4', 4, 1, 4, '2022-04-03 01:21:42', '2022-04-05 22:22:36'),
(14, 'Seccion D 5', 5, 1, 4, '2022-04-03 01:21:42', '2022-04-05 22:22:36'),
(15, 'Seccion A 1', 1, 1, 5, '2022-04-08 06:10:17', '2022-04-08 06:10:17'),
(16, 'Seccion A 2', 2, 1, 5, '2022-04-08 06:10:17', '2022-04-08 06:10:17'),
(17, 'Seccion A 3', 3, 1, 5, '2022-04-08 06:10:17', '2022-04-08 06:10:17'),
(18, 'Seccion A 1', 1, 1, 6, '2022-05-18 14:38:18', '2022-05-18 14:38:18'),
(19, 'Seccion A 2', 2, 1, 6, '2022-05-18 14:38:18', '2022-05-18 14:38:18'),
(20, 'Seccion A 3', 3, 1, 6, '2022-05-18 14:38:18', '2022-05-18 14:38:18'),
(21, 'Seccion A 1', 1, 1, 7, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(22, 'Seccion A 2', 2, 1, 7, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(23, 'Seccion A 3', 3, 1, 7, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(24, 'Seccion B 1', 1, 1, 8, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(25, 'Seccion B 2', 2, 1, 8, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(26, 'Seccion B 3', 3, 1, 8, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(27, 'Seccion B 4', 4, 1, 8, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(28, 'Seccion C 1', 1, 1, 9, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(29, 'Seccion C 2', 2, 1, 9, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(30, 'Seccion C 3', 3, 1, 9, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(31, 'Seccion D 1', 1, 1, 10, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(32, 'Seccion D 2', 2, 1, 10, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(33, 'Seccion E 1', 1, 1, 11, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(34, 'Seccion E 2', 2, 1, 11, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(35, 'Seccion E 3', 3, 1, 11, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(36, 'Seccion E 4', 4, 1, 11, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(37, 'Seccion F 1', 1, 1, 12, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(38, 'Seccion F 2', 2, 1, 12, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(39, 'Seccion F 3', 3, 1, 12, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(40, 'Seccion G 1', 1, 1, 13, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(41, 'Seccion G 2', 2, 1, 13, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(42, 'Seccion G 3', 3, 1, 13, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(43, 'Seccion G 4', 4, 1, 13, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(44, 'Seccion A 1', 1, 1, 14, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(45, 'Seccion B 1', 1, 1, 15, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(46, 'Seccion C 1', 1, 1, 16, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(47, 'Seccion D 1', 1, 1, 17, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(48, 'Seccion F 1', 1, 1, 18, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(49, 'Seccion G 1', 1, 1, 19, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(50, 'Seccion H 1', 1, 1, 20, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(51, 'Seccion I 1', 1, 1, 21, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(52, 'Seccion J 1', 1, 1, 22, '2022-05-18 15:09:23', '2022-05-18 15:09:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `segmento`
--

CREATE TABLE `segmento` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `bodega_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `segmento`
--

INSERT INTO `segmento` (`id`, `descripcion`, `bodega_id`, `created_at`, `updated_at`) VALUES
(1, 'A', 1, '2022-04-03 01:21:42', '2022-04-03 01:21:42'),
(2, 'B', 1, '2022-04-03 01:21:42', '2022-04-03 01:21:42'),
(3, 'C', 1, '2022-04-03 01:21:42', '2022-04-03 01:21:42'),
(4, 'D', 1, '2022-04-03 01:21:42', '2022-04-03 01:21:42'),
(5, 'A', 2, '2022-04-08 06:10:17', '2022-04-08 06:10:17'),
(6, 'A', 3, '2022-05-18 14:38:18', '2022-05-18 14:38:18'),
(7, 'A', 4, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(8, 'B', 4, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(9, 'C', 4, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(10, 'D', 4, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(11, 'E', 4, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(12, 'F', 4, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(13, 'G', 4, '2022-05-18 14:42:29', '2022-05-18 14:42:29'),
(14, 'A', 5, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(15, 'B', 5, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(16, 'C', 5, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(17, 'D', 5, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(18, 'F', 5, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(19, 'G', 5, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(20, 'H', 5, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(21, 'I', 5, '2022-05-18 15:09:23', '2022-05-18 15:09:23'),
(22, 'J', 5, '2022-05-18 15:09:23', '2022-05-18 15:09:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1haDucf9kB9IdAOcPdMuBpfFJ5n4sqsxflVW0i4Q', NULL, '18.206.55.48', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiOXFmbkpmOWNTbG5kdExLMWhFV3pGeFE3ODdndzNuMjVOVklBVHhaNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1653364376),
('2A2IjzHIhliYlOBfdxpnMBJlC5qmznIfSLqQUh2l', 3, '190.53.238.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.67 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiaU5LWlZrbVdrdUpDeEdmUjFSZ2RheXBYVWdiSEl1dWZCb3BGRk9NMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4vaW52ZW50YXJpby90cmFuc2xhZG8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJHNMUmxKaDFlbU4wOFppdkxEd2tHUnVjVHRNRXM4R2IzTUkubFJhRFZmb3oueC9wcW10Q0JDIjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJHNMUmxKaDFlbU4wOFppdkxEd2tHUnVjVHRNRXM4R2IzTUkubFJhRFZmb3oueC9wcW10Q0JDIjt9', 1652906115),
('2xzZqpLOCcUmKWUt7BVYStQ1UcjYE9MKVy7WC9Vm', NULL, '205.210.31.142', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid1dIb1Bhc0ZRdEE5NWUwa05NUXpVWWlGSUh6RE1uejFrd2ZPUWNTOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly93d3cudmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1653974960),
('47NMRNThuR4FykRYTUvIqMrAbG8wZUHL7xtqjbsy', NULL, '176.53.222.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieWI1dU5sbHhyQUZ1VUVsOGNja1l3ZXRJUlo2MzRjT3ByUm9GY2p3OCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vd3d3LnZlbnRhcy5kaXN0cmlidWNpb25lc3ZhbGVuY2lhLmhuL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1653510188),
('5QApYRHFuXAj5y9SCNgDoHVXh1sPXRou7Dy2tGLy', 5, '181.115.59.97', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.67 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiR0RCckNuSUI2dXFYd041dWpCSnl1ZHpQT1Y2M1g1MkV4elRuUTMxVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjY6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4vcHJvZHVjdG8vY29tcHJhL3JlY2liaXIvNyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkM2xqTlRsNmlmbWM3dklGanA5S2RDLlRCZWs2NXR4dUpJblJ0VVpTQUwxMENHSHJzOE1WTS4iO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkM2xqTlRsNmlmbWM3dklGanA5S2RDLlRCZWs2NXR4dUpJblJ0VVpTQUwxMENHSHJzOE1WTS4iO30=', 1652904128),
('5XNxncoarV9UGy5sKeI5D9kDwt5oBL63DNbSvZnL', NULL, '198.235.24.138', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieENkcWhGY0lwWG1NSEZkbzlhWklNeHB5T3ZRMmtXWXRocW9YWmcwVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly92ZW50YXMuZGlzdHJpYnVjaW9uZXN2YWxlbmNpYS5obiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1654213263),
('7WTBSdwDOo6UyekLjQ1Gtn1YyOvXHqTeg9w4M352', NULL, '54.227.32.154', 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGkweUlVcmRaMTZDZUhXakpuRW1ndTdLbFFjUFVsYTFRTFowNjhWciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly92ZW50YXMuZGlzdHJpYnVjaW9uZXN2YWxlbmNpYS5obi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1653367342),
('aYsszP5pt0jM6wL5YwaOUip7cYWeFTFCXMs4ycp5', NULL, '198.235.24.34', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoickJSbUl3MmdPekNOZVloUjhTSk9zMHBaeUptaXo1SGlaWTh5RmlmRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1654011008),
('bCbfs8rNKuIpH1eMKTfmD6tda3t7xA9ASHWSXWmk', NULL, '51.158.108.77', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmtPbGF5QXpnMlJaYXJqdlI0WXZyVXp5YnZwNGNGUWpZSnFjcHA3TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LnZlbnRhcy5kaXN0cmlidWNpb25lc3ZhbGVuY2lhLmhuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1653414895),
('bTISzbSndTXn6udHRyeMU9kXG8yu5YmgWQMEYuZ4', NULL, '54.227.32.154', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR3h4aTdrUVFkRFJGZHlGU1I3U2JsU1lNZENsT3BnMTZDS2w0UTUzWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly92ZW50YXMuZGlzdHJpYnVjaW9uZXN2YWxlbmNpYS5obi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1653450962),
('CSVyy6pSVqs4NZggRN00OQDASxocz6htuEUaNMtw', NULL, '198.235.24.17', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjNQWjJIYVB6V1F0emt3S2lQMWVMcVNkeDgwTVdDMFpBRDc3TEZORiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LnZlbnRhcy5kaXN0cmlidWNpb25lc3ZhbGVuY2lhLmhuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1654049196),
('djXZqwOY5FEZX9K7sWi2PHW9nJbxYOGReZLdSCBZ', 4, '181.115.59.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.67 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRzNsMk9NMWJGS3JtSGpMSFl6N0dkVzhnVHBpNlE2VXVVSHppczUyTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4vY2xpZW50ZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJEtRM0RqWDhlRGhOY0RON3FYaGdURHV6TWNnTkw1QjVSekFvUktLZUw1OGk1YzR0TWNKZzJPIjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJEtRM0RqWDhlRGhOY0RON3FYaGdURHV6TWNnTkw1QjVSekFvUktLZUw1OGk1YzR0TWNKZzJPIjt9', 1654013415),
('gGa6W8oEjqyAvXj6vn3EQpA7lkFrVD2ZpBkyRsCp', NULL, '18.206.55.48', 'Apache-HttpClient/5.1.2 (Java/11.0.14.1)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2RyNDhwOGZVbzRqb1BRUTlUaGNlQTdOeUVMVmxtTUdPNnFKazNqWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1653448176),
('Gm7lhlGuqPuSq2yx4CfSE13s9sm0iQpqrSuejfGo', NULL, '205.210.31.13', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ0RXdU8wWTc3bkw1dEhLdXZvdFZVNFBMb1liVUVTa3dNOFBZbFIzWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly92ZW50YXMuZGlzdHJpYnVjaW9uZXN2YWxlbmNpYS5obiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1654019472),
('hTaP3RshNdBCxw9wjocJGDDlwWJmNYrjQveFqAUE', NULL, '18.206.55.48', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRm5obGFuTEFjb0x0cUx4dk9SU1hnSkFCM29XVXl5Z0VZTjQ4RUc3NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly92ZW50YXMuZGlzdHJpYnVjaW9uZXN2YWxlbmNpYS5obi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1653448176),
('jPi6AHbzedD4wP1ieggO19gNFyIkpNC16vXtKkwq', NULL, '18.206.55.48', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiblJYNFhpUTZMeFVmUEhMUFZJQUkyTmo0NXhtbWVaRlo0YjZmZ2k2aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly92ZW50YXMuZGlzdHJpYnVjaW9uZXN2YWxlbmNpYS5obi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1653364377),
('N5eUOo66Jqyc3dGHrFjsUCT8QZYPUr4BXgr1ECoT', 4, '181.115.59.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.67 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZ2V4d3RoNUFZaTJTMngwMklmaEZkWk1mdFJlcjBMaHlHTHoxUzM1ayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4vaW52ZW50YXJpby90cmFuc2xhZG8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJEtRM0RqWDhlRGhOY0RON3FYaGdURHV6TWNnTkw1QjVSekFvUktLZUw1OGk1YzR0TWNKZzJPIjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJEtRM0RqWDhlRGhOY0RON3FYaGdURHV6TWNnTkw1QjVSekFvUktLZUw1OGk1YzR0TWNKZzJPIjt9', 1653749271),
('OaYhCUFmZHcV6d6ZFWV3z5BhU5BF7yxf7XOAs8Lg', NULL, '163.172.180.25', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ1A2U0hwY0dpVERRY09XejVqN0psTlZIM1lxYWxqODd3bDRxc3h5bSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1653915905),
('oqdS7MCFgQa0itzjjw0pvTXBtKN5HZnd5OsT6Ac6', 4, '181.115.59.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.67 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibGVzVHZmZ3NWeXhGU1FMa3lrRGdKM2VDZDBHNGs1OVFzTFlXRnoyQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4vY2xpZW50ZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJEtRM0RqWDhlRGhOY0RON3FYaGdURHV6TWNnTkw1QjVSekFvUktLZUw1OGk1YzR0TWNKZzJPIjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJEtRM0RqWDhlRGhOY0RON3FYaGdURHV6TWNnTkw1QjVSekFvUktLZUw1OGk1YzR0TWNKZzJPIjt9', 1653925283),
('tHSvYcFjNIX0ALIJB5ZbrHiHXLIz29MbNKlELHgF', NULL, '181.115.59.97', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.67 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQXlTZGJKN3lHdkVHd091emFLaWFJeWxKRnJRdXdCdW0wcEdYTTFnMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4vbG9naW4iO319', 1652910537),
('TOVgHccNDN3AINmWhyIZVRhjlbNUpNMFbUzMxOCt', NULL, '18.206.55.48', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiU0tWYWIzd1hzaVpCOEw4aGltOTB6RVNLQUx1ejl6VDhHT1J0YW9XOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1653448176),
('TxTGo2huV8T2yJQPKHGzkLlq4GeUsnbqUZtIrJJP', NULL, '18.206.55.48', 'Apache-HttpClient/5.1.2 (Java/11.0.14.1)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTFlSTTlYV1VZSThya290Q2dEbm1xZU44bEZtMlZPdG82czFydm1nTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1653364376),
('uNTRzh3MJQINPS8ULyJULXJ754hnpRtJzowQOlIf', 4, '181.115.59.33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.63 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWTdQQXZTb3cyWnJUUXV5UVE1bmNBQW1qcW9scktRTTE0dkFxaUg0VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4vZmFjdHVyYXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJEtRM0RqWDhlRGhOY0RON3FYaGdURHV6TWNnTkw1QjVSekFvUktLZUw1OGk1YzR0TWNKZzJPIjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJEtRM0RqWDhlRGhOY0RON3FYaGdURHV6TWNnTkw1QjVSekFvUktLZUw1OGk1YzR0TWNKZzJPIjt9', 1654295447),
('uUMeZqQyJOdKxnn2ZWaConQsXpFhCQIvttSdp1Ee', 2, '190.5.111.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.67 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiOHVoakxBTnpYQjNDVmNnaFlSVjBOWlZ3c1NLbGNtYzBVdGd3VnFNaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4vcHJvZHVjdG8vcmVnaXN0cm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJFlnUVJDdW1TZWhZeGNHcWpQS1lMOWU2aFBWTi5WOE5taHdiRlQ2Q3F5V29GNGJIR0lmOEJlIjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJFlnUVJDdW1TZWhZeGNHcWpQS1lMOWU2aFBWTi5WOE5taHdiRlQ2Q3F5V29GNGJIR0lmOEJlIjt9', 1652904134),
('v78Yp2A4qo5L67P8AFpxfdVKwKRfzNLTMjpn0eRG', NULL, '181.174.127.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.84 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoienA5cUNOelZ3YUZqUWluV3V3VWVpUmRTU0NsNXFLaDdORFJONFIwSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHBzOi8vdmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1653746889),
('wXzua80EHHPdnkwoaKgy60mSRryBTAIBDS5qOMEP', NULL, '205.210.31.143', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3dESTcxSUUwdnJRR2hvRUtiSHBlcGdKd0M3cWxZTzRLaTZCdlpueSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly93d3cudmVudGFzLmRpc3RyaWJ1Y2lvbmVzdmFsZW5jaWEuaG4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1654287835),
('xjYGluf1ZsNlZ9ZbOD8q1n1Ve6L0TuYd60oC5W4a', NULL, '176.113.43.12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVFJ4OXFSSVVScWYzdld2aWlOdGRNempBNGNLbkRkd2VYS0ZjTTFTTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LnZlbnRhcy5kaXN0cmlidWNpb25lc3ZhbGVuY2lhLmhuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1653510187);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id` int(11) NOT NULL,
  `url` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `teams`
--

INSERT INTO `teams` (`id`, `user_id`, `name`, `personal_team`, `created_at`, `updated_at`) VALUES
(1, 2, 'Yefry\'s Team', 1, '2022-03-02 09:05:40', '2022-03-02 09:05:40'),
(2, 3, 'Luis\'s Team', 1, '2022-03-07 12:42:26', '2022-03-07 12:42:26'),
(3, 4, 'Usuario\'s Team', 1, '2022-03-16 01:01:19', '2022-03-16 01:01:19'),
(4, 5, 'Selenia\'s Team', 1, '2022-05-04 02:30:19', '2022-05-04 02:30:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `team_invitations`
--

CREATE TABLE `team_invitations` (
  `id` int(10) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `team_user`
--

CREATE TABLE `team_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cliente`
--

CREATE TABLE `tipo_cliente` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_compra`
--

CREATE TABLE `tipo_compra` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_compra`
--

INSERT INTO `tipo_compra` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Credito', '2022-03-24 01:03:40', NULL),
(2, 'Contado', '2022-03-24 01:03:40', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento_fiscal`
--

CREATE TABLE `tipo_documento_fiscal` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_personalidad`
--

CREATE TABLE `tipo_personalidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_personalidad`
--

INSERT INTO `tipo_personalidad` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Persona Natural', '2022-03-15 00:54:28', NULL),
(2, 'Persona Jurídica', '2022-03-15 00:54:28', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_retencion`
--

CREATE TABLE `tipo_retencion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_retencion`
--

INSERT INTO `tipo_retencion` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Valor real', '2022-03-15 01:02:46', '2022-03-15 01:02:46'),
(2, 'Porcentaje', '2022-03-15 01:02:46', '2022-03-15 01:02:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `id` int(11) NOT NULL,
  `unidad` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `simbolo` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`id`, `unidad`, `nombre`, `simbolo`, `created_at`, `updated_at`) VALUES
(1, 1, 'unidad', 'un', '2022-03-24 01:16:22', '2022-03-24 01:08:57'),
(2, 1, 'yarda', 'yd', '2022-03-24 01:15:54', '2022-03-24 01:08:57'),
(3, 1, ' RESMA', ' RESMA', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(4, 1, ' UNIDAD', ' UNIDAD', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(5, 1, ' GALON', ' GALON', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(6, 1, ' BARRIL', ' BARRIL', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(7, 1, ' FARDO', ' FARDO', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(8, 1, ' DOCENA', ' DOCENA', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(9, 1, ' CUBETA', ' CUBETA', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(10, 1, ' CUARTO', ' CUARTO', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(11, 1, ' CAJA', ' CAJA', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(12, 1, ' BOTE', ' BOTE', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(13, 1, ' BOLSA', ' BOLSA', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(14, 1, ' BLOCK', ' BLOCK', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(15, 1, ' CUBO', ' CUBO', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(16, 1, ' JUEGO', ' JUEGO', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(17, 1, ' KILO', ' KILO', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(18, 1, ' KIT', ' KIT', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(19, 1, ' LANCE', ' LANCE', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(20, 1, ' LATA', ' LATA', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(21, 1, ' LIBRA', ' LIBRA', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(22, 1, ' LITRO', ' LITRO', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(23, 1, ' PAQUETE', ' PAQUETE', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(24, 1, ' PAR', ' PAR', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(25, 1, ' PIEZA', ' PIEZA', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(26, 1, ' PLIEGO', ' PLIEGO', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(27, 1, ' ROLLO', ' ROLLO', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(28, 1, ' SET', ' SET', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(29, 1, ' TONELADA', ' TONELADA', '2022-04-25 06:00:00', '2022-04-25 06:00:00'),
(30, 1, ' YARDA', ' YARDA', '2022-04-25 06:00:00', '2022-04-25 06:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identidad` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `identidad`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `fecha_nacimiento`, `telefono`, `rol_id`, `created_at`, `updated_at`) VALUES
(2, '0801199612356', 'Yefry Ortiz', 'yefryyo@gmail.com', NULL, '$2y$10$YgQRCumSehYxcGqjPKYL9e6hPVN.V8NmhwbFT6CqyWoF4bHGIf8Be', NULL, NULL, NULL, 1, NULL, '1996-04-01', '22336699', NULL, '2022-03-02 09:05:40', '2022-03-02 09:05:41'),
(3, '0822199500082', 'Luis Aviles', 'luisfaviles18@gmail.com', NULL, '$2y$10$sLRlJh1emN08ZivLDwkGRucTtMEs8Gb3MI.lRaDVfoz.x/pqmtCBC', NULL, NULL, 'gxFlleNmKrOC6pDrT2SZ4uF0helBnkvO7NVJxyFofoXHr94PKZZck7o8GHbA', 2, 'profile-photos/oNdajTCAvTsuuRD76t4ognTdmhWLIOy9nEszULmY.jpg', '1995-03-16', '89282146', NULL, '2022-03-07 12:42:26', '2022-03-24 11:52:49'),
(4, '0801199036544', 'Usuario', 'usuario.prueba@distribucionesvalencia.hn', NULL, '$2y$10$KQ3DjX8eDhNcDN7qXhgTDuzMcgNL5B5RzAoRKKeL58i5c4tMcJg2O', NULL, NULL, NULL, 3, NULL, '2022-03-15', '88996655', NULL, '2022-03-16 01:01:19', '2022-03-16 01:01:20'),
(5, NULL, 'Selenia Merlo', 'selenia.merlo@distribucionesvalencia.hn', NULL, '$2y$10$3ljNTl6ifmc7vIFjp9KdC.TBek65txuJInRtUZSAL10CGHrs8MVM.', NULL, NULL, NULL, 4, 'profile-photos/PIzbMjxu7fzd1EoEV9ZKXYhlL7N4RB88Zp9OgFAK.png', NULL, NULL, NULL, '2022-05-04 02:30:19', '2022-05-04 02:30:32');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bodega_estado1_idx` (`estado_id`),
  ADD KEY `fk_bodega_municipio1_idx` (`municipio_id`),
  ADD KEY `fk_bodega_users1_idx` (`encargado_bodega`);

--
-- Indices de la tabla `cai`
--
ALTER TABLE `cai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_CAI_tipo_documento_fiscal1_idx` (`tipo_documento_fiscal_id`),
  ADD KEY `fk_CAI_estado1_idx` (`estado_id`),
  ADD KEY `fk_cai_users1_idx` (`users_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cliente_tipo_cliente1_idx` (`tipo_cliente_id`),
  ADD KEY `fk_cliente_tipo_personalidad1_idx` (`tipo_personalidad_id`),
  ADD KEY `fk_cliente_categoria1_idx` (`categoria_id`),
  ADD KEY `fk_cliente_users1_idx` (`users_id`),
  ADD KEY `fk_cliente_users2_idx` (`vendedor`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compra_proveedores1_idx` (`proveedores_id`),
  ADD KEY `fk_compra_users1_idx` (`users_id`),
  ADD KEY `fk_compra_tipo_compra1_idx` (`tipo_compra_id`),
  ADD KEY `fk_compra_retenciones1_idx` (`retenciones_id`),
  ADD KEY `fk_compra_estado_compra1_idx` (`estado_compra_id`);

--
-- Indices de la tabla `compra_has_producto`
--
ALTER TABLE `compra_has_producto`
  ADD PRIMARY KEY (`compra_id`,`producto_id`),
  ADD KEY `fk_compra_has_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_compra_has_producto_compra1_idx` (`compra_id`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contacto_cliente1_idx` (`cliente_id`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_departamento_pais1_idx` (`pais_id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_compra`
--
ALTER TABLE `estado_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_producto`
--
ALTER TABLE `estado_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `img_producto`
--
ALTER TABLE `img_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_img_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_img_producto_users1_idx` (`users_id`);

--
-- Indices de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_img_UNIQUE` (`url_img`),
  ADD KEY `fk_incidencia_recibido_bodega1_idx` (`recibido_bodega_id`),
  ADD KEY `fk_incidencia_users1_idx` (`users_id`);

--
-- Indices de la tabla `incidencia_compra`
--
ALTER TABLE `incidencia_compra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_img_UNIQUE` (`url_img`),
  ADD KEY `fk_incidencia_compra_compra_has_producto1_idx` (`compra_id`,`producto_id`),
  ADD KEY `fk_incidencia_compra_users1_idx` (`users_id`);

--
-- Indices de la tabla `log_estado`
--
ALTER TABLE `log_estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_estado_compra1_idx` (`compra_id`),
  ADD KEY `fk_log_estado_estado_compra1_idx` (`estado_anterior_compra`),
  ADD KEY `fk_log_estado_users1_idx` (`users_id`);

--
-- Indices de la tabla `log_translado`
--
ALTER TABLE `log_translado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_translado_recibido_bodega1_idx` (`origen`),
  ADD KEY `fk_log_translado_recibido_bodega2_idx` (`destino`),
  ADD KEY `fk_log_translado_users1_idx` (`users_id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_rol1_idx` (`rol_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_municipio_departamento1_idx` (`departamento_id`);

--
-- Indices de la tabla `pago_compra`
--
ALTER TABLE `pago_compra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_img_UNIQUE` (`url_img`),
  ADD KEY `fk_pagos_compra_users1_idx` (`users_id`),
  ADD KEY `fk_pagos_compra_compra1_idx` (`compra_id`),
  ADD KEY `fk_pago_compra_users1_idx` (`users_id_elimina`),
  ADD KEY `fk_pago_compra_estado1_idx` (`estado_id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `precios_venta`
--
ALTER TABLE `precios_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_precios_producto1_idx` (`producto_id`),
  ADD KEY `fk_precios_venta_users1_idx` (`users_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_categoria1_idx` (`categoria_id`),
  ADD KEY `fk_producto_unidad_medida1_idx` (`unidad_medida_id`),
  ADD KEY `fk_producto_users1_idx` (`users_id`),
  ADD KEY `fk_producto_estado_producto1_idx` (`estado_producto_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_proveedores_users1_idx` (`registrado_por`),
  ADD KEY `fk_proveedores_estado1_idx` (`estado_id`),
  ADD KEY `fk_proveedores_municipio1_idx` (`municipio_id`),
  ADD KEY `fk_proveedores_tipo_personalidad1_idx` (`tipo_personalidad_id`),
  ADD KEY `fk_proveedores_categoria1_idx` (`categoria_id`);

--
-- Indices de la tabla `recibido_bodega`
--
ALTER TABLE `recibido_bodega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recibido_bodega_compra_has_producto1_idx` (`compra_id`,`producto_id`),
  ADD KEY `fk_recibido_bodega_seccion1_idx` (`seccion_id`),
  ADD KEY `fk_recibido_bodega_estado1_idx` (`estado_recibido`),
  ADD KEY `fk_recibido_bodega_users1_idx` (`recibido_por`);

--
-- Indices de la tabla `retenciones`
--
ALTER TABLE `retenciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_retenciones_tipo_retencion1_idx` (`tipo_retencion_id`),
  ADD KEY `fk_retenciones_users1_idx` (`users_id`);

--
-- Indices de la tabla `retenciones_has_proveedores`
--
ALTER TABLE `retenciones_has_proveedores`
  ADD PRIMARY KEY (`retenciones_id`,`proveedores_id`),
  ADD KEY `fk_retenciones_proveedor_has_proveedores_proveedores1_idx` (`proveedores_id`),
  ADD KEY `fk_retenciones_proveedor_has_proveedores_retenciones_provee_idx` (`retenciones_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estante_estado1_idx` (`estado_id`),
  ADD KEY `fk_seccion_segmento1_idx` (`segmento_id`);

--
-- Indices de la tabla `segmento`
--
ALTER TABLE `segmento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_segmento_bodega1_idx` (`bodega_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sub_menu_menu1_idx` (`menu_id`);

--
-- Indices de la tabla `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `team_invitations`
--
ALTER TABLE `team_invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_cliente`
--
ALTER TABLE `tipo_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_compra`
--
ALTER TABLE `tipo_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_documento_fiscal`
--
ALTER TABLE `tipo_documento_fiscal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_personalidad`
--
ALTER TABLE `tipo_personalidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_retencion`
--
ALTER TABLE `tipo_retencion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_rol1_idx` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bodega`
--
ALTER TABLE `bodega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_compra`
--
ALTER TABLE `estado_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_producto`
--
ALTER TABLE `estado_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `img_producto`
--
ALTER TABLE `img_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `incidencia_compra`
--
ALTER TABLE `incidencia_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `log_estado`
--
ALTER TABLE `log_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log_translado`
--
ALTER TABLE `log_translado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- AUTO_INCREMENT de la tabla `pago_compra`
--
ALTER TABLE `pago_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `precios_venta`
--
ALTER TABLE `precios_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `recibido_bodega`
--
ALTER TABLE `recibido_bodega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `retenciones`
--
ALTER TABLE `retenciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `segmento`
--
ALTER TABLE `segmento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_compra`
--
ALTER TABLE `tipo_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_personalidad`
--
ALTER TABLE `tipo_personalidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_retencion`
--
ALTER TABLE `tipo_retencion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD CONSTRAINT `fk_bodega_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bodega_municipio1` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bodega_users1` FOREIGN KEY (`encargado_bodega`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cai`
--
ALTER TABLE `cai`
  ADD CONSTRAINT `fk_CAI_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CAI_tipo_documento_fiscal1` FOREIGN KEY (`tipo_documento_fiscal_id`) REFERENCES `tipo_documento_fiscal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cai_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_tipo_cliente1` FOREIGN KEY (`tipo_cliente_id`) REFERENCES `tipo_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_tipo_personalidad1` FOREIGN KEY (`tipo_personalidad_id`) REFERENCES `tipo_personalidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_users2` FOREIGN KEY (`vendedor`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_estado_compra1` FOREIGN KEY (`estado_compra_id`) REFERENCES `estado_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_proveedores1` FOREIGN KEY (`proveedores_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_retenciones1` FOREIGN KEY (`retenciones_id`) REFERENCES `retenciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_tipo_compra1` FOREIGN KEY (`tipo_compra_id`) REFERENCES `tipo_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compra_has_producto`
--
ALTER TABLE `compra_has_producto`
  ADD CONSTRAINT `fk_compra_has_producto_compra1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_has_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `fk_contacto_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `fk_departamento_pais1` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `img_producto`
--
ALTER TABLE `img_producto`
  ADD CONSTRAINT `fk_img_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_img_producto_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `fk_incidencia_recibido_bodega1` FOREIGN KEY (`recibido_bodega_id`) REFERENCES `recibido_bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_incidencia_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `incidencia_compra`
--
ALTER TABLE `incidencia_compra`
  ADD CONSTRAINT `fk_incidencia_compra_compra_has_producto1` FOREIGN KEY (`compra_id`,`producto_id`) REFERENCES `compra_has_producto` (`compra_id`, `producto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_incidencia_compra_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `log_estado`
--
ALTER TABLE `log_estado`
  ADD CONSTRAINT `fk_log_estado_compra1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_estado_estado_compra1` FOREIGN KEY (`estado_anterior_compra`) REFERENCES `estado_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_estado_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `log_translado`
--
ALTER TABLE `log_translado`
  ADD CONSTRAINT `fk_log_translado_recibido_bodega1` FOREIGN KEY (`origen`) REFERENCES `recibido_bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_recibido_bodega2` FOREIGN KEY (`destino`) REFERENCES `recibido_bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_menu_rol1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `fk_municipio_departamento1` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pago_compra`
--
ALTER TABLE `pago_compra`
  ADD CONSTRAINT `fk_pago_compra_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_compra_users1` FOREIGN KEY (`users_id_elimina`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pagos_compra_compra1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pagos_compra_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `precios_venta`
--
ALTER TABLE `precios_venta`
  ADD CONSTRAINT `fk_precios_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_precios_venta_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_proveedores_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_municipio1` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_tipo_personalidad1` FOREIGN KEY (`tipo_personalidad_id`) REFERENCES `tipo_personalidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_users1` FOREIGN KEY (`registrado_por`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
