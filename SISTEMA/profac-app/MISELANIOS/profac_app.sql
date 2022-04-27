-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-04-2022 a las 05:52:42
-- Versión del servidor: 5.7.33
-- Versión de PHP: 8.0.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `profac_app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `encargado_bodega` bigint(20) UNSIGNED NOT NULL,
  `estado_id` int(11) NOT NULL,
  `municipio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`id`, `nombre`, `direccion`, `created_at`, `updated_at`, `encargado_bodega`, `estado_id`, `municipio_id`) VALUES
(1, 'Bodega 1', 'Tegucigalpa', '2022-04-03 01:21:42', '2022-04-05 22:04:40', 4, 1, 110),
(2, 'Bodega 50', 'Comayagua', '2022-04-08 06:10:17', '2022-04-08 06:10:17', 2, 1, 110);

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
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
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
  `created_at` timestamp NOT NULL,
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
  `numero_orden` varchar(45) NOT NULL,
  `monto_retencion` double DEFAULT NULL,
  `retenciones_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `numero_factura`, `fecha_vencimiento`, `fecha_emision`, `fecha_recepcion`, `isv_compra`, `sub_total`, `total`, `debito`, `proveedores_id`, `users_id`, `tipo_compra_id`, `numero_orden`, `monto_retencion`, `retenciones_id`, `created_at`, `updated_at`) VALUES
(1, '20', '2022-04-30', '2022-04-21', '2022-04-21', 2250, 12750, 15000, 15000, 1, 3, 1, '21', NULL, NULL, '2022-03-27 20:06:48', '2022-03-27 20:04:35'),
(2, '21', '2022-03-28', '2022-04-21', '2022-04-21', 3000, 17000, 20000, 0, 4, 3, 2, '22', NULL, NULL, '2022-03-27 20:27:55', '2022-03-27 20:16:58'),
(12, '1', '2022-04-22', '2022-04-22', '2022-04-30', 1725, 11500, 13225, 13225, 1, 3, 2, '3', 132.25, 2, '2022-04-22 07:27:09', '2022-04-22 07:27:09'),
(13, '2', '2022-04-22', '2022-04-22', '2022-04-30', 4350, 29000, 33350, 33350, 2, 3, 2, '4', 0, 2, '2022-04-22 07:29:53', '2022-04-22 07:29:53'),
(14, '3', '2022-05-29', '2022-04-22', '2022-04-30', 7627.95, 50853, 58480.95, 0, 5, 3, 1, '5', 584.81, 2, '2022-04-22 07:45:47', '2022-04-27 11:41:46'),
(15, '5', '2022-04-29', '2022-04-22', '2022-04-28', 16500, 110000, 126500, 126500, 1, 3, 1, '6', 1265, 2, '2022-04-22 07:52:56', '2022-04-22 07:52:56'),
(16, '6', '2022-04-22', '2022-04-22', '2022-04-23', 5670, 37800, 43470, 43470, 7, 3, 2, '7', 434.7, 2, '2022-04-22 07:53:57', '2022-04-22 07:53:57'),
(17, '7', '2022-05-20', '2022-04-22', '2022-04-26', 13032, 86880, 99912, 99912, 9, 3, 1, '8', 999.12, 2, '2022-04-22 08:00:26', '2022-04-22 08:00:26'),
(18, '9', '2022-04-27', '2022-04-22', '2022-04-28', 40188, 267920, 308108, 308108, 8, 3, 1, '9', 3081.08, 2, '2022-04-22 08:02:09', '2022-04-22 08:02:09'),
(19, '10', '2022-04-22', '2022-04-22', '2022-04-27', 11843.4, 78956, 90799.4, 90799.4, 5, 3, 2, '10', 0, 2, '2022-04-22 08:04:27', '2022-04-22 08:04:27'),
(20, '10', '2022-04-22', '2022-04-22', '2022-04-27', 4825.2, 32168, 36993.2, 36993.2, 5, 3, 2, '11', 0, 2, '2022-04-22 08:04:40', '2022-04-22 08:04:40'),
(21, '13', '2022-04-22', '2022-04-22', '2022-04-24', 19560.75, 130405, 149965.75, 149965.75, 1, 3, 2, '12', 0, 2, '2022-04-22 08:09:31', '2022-04-22 08:09:31'),
(22, '13', '2022-04-22', '2022-04-22', '2022-04-23', 1233, 8220, 9453, 9453, 2, 3, 2, '13', 94.53, 2, '2022-04-22 08:12:36', '2022-04-22 08:12:36'),
(23, '15', '2022-04-22', '2022-04-22', '2022-04-27', 1500, 10000, 11500, 11500, 8, 3, 2, '14', 115, 2, '2022-04-22 08:14:35', '2022-04-22 08:14:35'),
(25, '16', '2022-04-22', '2022-04-22', '2022-04-23', 510, 3400, 3910, 3910, 5, 3, 2, '15', 0, 2, '2022-04-22 08:17:57', '2022-04-22 08:17:57'),
(26, '17', '2022-04-22', '2022-04-22', '2022-04-27', 2430, 16200, 18630, 18630, 4, 3, 2, '16', 0, 2, '2022-04-22 08:20:17', '2022-04-22 08:20:17'),
(27, '18', '2022-04-22', '2022-04-22', '2022-04-29', 2212.5, 14750, 16962.5, 16962.5, 8, 3, 2, '17', 0, 2, '2022-04-22 08:39:41', '2022-04-22 08:39:41'),
(28, '19', '2022-04-30', '2022-04-22', '2022-04-30', 1893, 12620, 14513, 14513, 4, 3, 1, '18', 145.13, 2, '2022-04-22 08:48:50', '2022-04-22 08:48:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_has_producto`
--

CREATE TABLE `compra_has_producto` (
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `precio_unidad` double NOT NULL,
  `cantidad_ingresada` int(11) NOT NULL,
  `sub_total_producto` double NOT NULL,
  `isv` double NOT NULL,
  `precio_total` double NOT NULL,
  `cantidad_disponible` int(11) NOT NULL,
  `fecha_recibido` timestamp NULL DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `seccion_id` int(11) DEFAULT NULL,
  `estado_recibido` int(11) NOT NULL,
  `recibido_por` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra_has_producto`
--

INSERT INTO `compra_has_producto` (`compra_id`, `producto_id`, `precio_unidad`, `cantidad_ingresada`, `sub_total_producto`, `isv`, `precio_total`, `cantidad_disponible`, `fecha_recibido`, `fecha_expiracion`, `seccion_id`, `estado_recibido`, `recibido_por`, `updated_at`, `created_at`) VALUES
(1, 1, 125, 102, 0, 0, 0, 102, NULL, NULL, 1, 3, NULL, '2022-03-27 20:07:14', '2022-03-27 20:09:07'),
(2, 1, 100, 170, 0, 0, 0, 170, NULL, NULL, 1, 3, NULL, '2022-03-28 20:21:41', '2022-03-27 20:24:44'),
(12, 1, 55, 100, 5500, 825, 6325, 100, NULL, '2022-04-30', 1, 3, NULL, '2022-04-22 07:27:09', '2022-04-22 07:27:09'),
(12, 5, 100, 60, 6000, 900, 6900, 60, NULL, NULL, 1, 3, NULL, '2022-04-22 07:27:09', '2022-04-22 07:27:09'),
(13, 1, 450, 20, 9000, 1350, 10350, 20, NULL, NULL, 1, 3, NULL, '2022-04-22 07:29:53', '2022-04-22 07:29:53'),
(13, 6, 100, 50, 5000, 750, 5750, 50, NULL, NULL, 1, 3, NULL, '2022-04-22 07:29:53', '2022-04-22 07:29:53'),
(13, 19, 250, 60, 15000, 2250, 17250, 60, NULL, '2022-07-30', 1, 3, NULL, '2022-04-22 07:29:53', '2022-04-22 07:29:53'),
(14, 5, 300, 30, 9000, 1350, 10350, 30, NULL, NULL, 1, 3, NULL, '2022-04-22 07:45:47', '2022-04-22 07:45:47'),
(14, 6, 150, 45, 6750, 1012.5, 7762.5, 45, NULL, NULL, 1, 3, NULL, '2022-04-22 07:45:47', '2022-04-22 07:45:47'),
(14, 7, 189, 27, 5103, 765.45, 5868.45, 27, NULL, NULL, 1, 3, NULL, '2022-04-22 07:45:47', '2022-04-22 07:45:47'),
(14, 8, 300, 80, 24000, 3600, 27600, 80, NULL, NULL, 1, 3, NULL, '2022-04-22 07:45:47', '2022-04-22 07:45:47'),
(14, 19, 100, 60, 6000, 900, 6900, 60, NULL, NULL, 1, 3, NULL, '2022-04-22 07:45:47', '2022-04-22 07:45:47'),
(15, 8, 100, 200, 20000, 3000, 23000, 200, NULL, NULL, 1, 3, NULL, '2022-04-22 07:52:56', '2022-04-22 07:52:56'),
(15, 12, 200, 450, 90000, 13500, 103500, 450, NULL, NULL, 1, 3, NULL, '2022-04-22 07:52:56', '2022-04-22 07:52:56'),
(16, 13, 189, 200, 37800, 5670, 43470, 200, NULL, NULL, 1, 3, NULL, '2022-04-22 07:53:57', '2022-04-22 07:53:57'),
(17, 15, 896, 30, 26880, 4032, 30912, 30, NULL, NULL, 1, 3, NULL, '2022-04-22 08:00:26', '2022-04-22 08:00:26'),
(17, 18, 500, 120, 60000, 9000, 69000, 120, NULL, NULL, 1, 3, NULL, '2022-04-22 08:00:26', '2022-04-22 08:00:26'),
(18, 6, 796, 20, 15920, 2388, 18308, 20, NULL, NULL, 1, 3, NULL, '2022-04-22 08:02:09', '2022-04-22 08:02:09'),
(18, 7, 400, 630, 252000, 37800, 289800, 630, NULL, NULL, 1, 3, NULL, '2022-04-22 08:02:09', '2022-04-22 08:02:09'),
(19, 1, 50, 300, 15000, 2250, 17250, 300, NULL, NULL, 1, 3, NULL, '2022-04-22 08:04:27', '2022-04-22 08:04:27'),
(19, 2, 78, 200, 15600, 2340, 17940, 200, NULL, NULL, 1, 3, NULL, '2022-04-22 08:04:27', '2022-04-22 08:04:27'),
(19, 5, 69, 452, 31188, 4678.2, 35866.2, 452, NULL, NULL, 1, 3, NULL, '2022-04-22 08:04:27', '2022-04-22 08:04:27'),
(19, 8, 58, 296, 17168, 2575.2, 19743.2, 296, NULL, '2022-11-30', 1, 3, NULL, '2022-04-22 08:04:27', '2022-04-22 08:04:27'),
(20, 1, 50, 300, 15000, 2250, 17250, 300, NULL, NULL, 1, 3, NULL, '2022-04-22 08:04:40', '2022-04-22 08:04:40'),
(20, 8, 58, 296, 17168, 2575.2, 19743.2, 296, NULL, '2022-11-30', 1, 3, NULL, '2022-04-22 08:04:40', '2022-04-22 08:04:40'),
(21, 1, 85, 785, 66725, 10008.75, 76733.75, 785, NULL, NULL, 1, 3, NULL, '2022-04-22 08:09:31', '2022-04-22 08:09:31'),
(21, 2, 100, 230, 23000, 3450, 26450, 230, NULL, NULL, 1, 3, NULL, '2022-04-22 08:09:31', '2022-04-22 08:09:31'),
(21, 5, 90, 452, 40680, 6102, 46782, 452, NULL, NULL, 1, 3, NULL, '2022-04-22 08:09:31', '2022-04-22 08:09:31'),
(22, 1, 44, 5, 220, 33, 253, 5, NULL, NULL, 1, 3, NULL, '2022-04-22 08:12:36', '2022-04-22 08:12:36'),
(22, 6, 100, 20, 2000, 300, 2300, 20, NULL, NULL, 1, 3, NULL, '2022-04-22 08:12:36', '2022-04-22 08:12:36'),
(22, 7, 200, 30, 6000, 900, 6900, 30, NULL, NULL, 1, 3, NULL, '2022-04-22 08:12:36', '2022-04-22 08:12:36'),
(23, 1, 20, 50, 1000, 150, 1150, 50, NULL, NULL, 1, 3, NULL, '2022-04-22 08:14:35', '2022-04-22 08:14:35'),
(23, 13, 30, 100, 3000, 450, 3450, 100, NULL, NULL, 1, 3, NULL, '2022-04-22 08:14:35', '2022-04-22 08:14:35'),
(23, 17, 40, 150, 6000, 900, 6900, 150, NULL, NULL, 1, 3, NULL, '2022-04-22 08:14:35', '2022-04-22 08:14:35'),
(25, 5, 50, 10, 500, 75, 575, 10, NULL, NULL, 1, 3, NULL, '2022-04-22 08:17:57', '2022-04-22 08:17:57'),
(25, 12, 60, 15, 900, 135, 1035, 15, NULL, NULL, 1, 3, NULL, '2022-04-22 08:17:57', '2022-04-22 08:17:57'),
(25, 14, 80, 25, 2000, 300, 2300, 25, NULL, NULL, 1, 3, NULL, '2022-04-22 08:17:57', '2022-04-22 08:17:57'),
(26, 6, 150, 10, 1500, 225, 1725, 10, NULL, NULL, 1, 3, NULL, '2022-04-22 08:20:17', '2022-04-22 08:20:17'),
(26, 11, 200, 45, 9000, 1350, 10350, 45, NULL, NULL, 1, 3, NULL, '2022-04-22 08:20:17', '2022-04-22 08:20:17'),
(26, 15, 114, 50, 5700, 855, 6555, 50, NULL, NULL, 1, 3, NULL, '2022-04-22 08:20:17', '2022-04-22 08:20:17'),
(27, 5, 40, 100, 4000, 600, 4600, 100, NULL, NULL, NULL, 3, NULL, '2022-04-22 08:39:41', '2022-04-22 08:39:41'),
(27, 17, 30, 225, 6750, 1012.5, 7762.5, 225, NULL, NULL, NULL, 3, NULL, '2022-04-22 08:39:41', '2022-04-22 08:39:41'),
(27, 18, 20, 200, 4000, 600, 4600, 200, NULL, NULL, NULL, 3, NULL, '2022-04-22 08:39:41', '2022-04-22 08:39:41'),
(28, 14, 100, 44, 4400, 660, 5060, 44, NULL, NULL, NULL, 3, NULL, '2022-04-22 08:48:50', '2022-04-22 08:48:50'),
(28, 19, 411, 20, 8220, 1233, 9453, 20, NULL, NULL, NULL, 3, NULL, '2022-04-22 08:48:50', '2022-04-22 08:48:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
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
  `created_at` timestamp NOT NULL,
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
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `img_producto`
--

INSERT INTO `img_producto` (`id`, `url_img`, `created_at`, `updated_at`, `producto_id`, `users_id`) VALUES
(1, 'IMG_1649274533_0.jpg', '2022-04-07 01:48:53', NULL, 1, 3),
(2, 'IMG_1649274533_1.jpg', '2022-04-07 01:48:53', NULL, 1, 3),
(3, 'IMG_1649274533_2.png', '2022-04-07 01:48:53', NULL, 1, 3),
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
(25, 'IMG_1650476706-0.jpg', '2022-04-20 23:45:06', NULL, 35, 3);

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
  `created_at` timestamp NOT NULL,
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
  `fecha` date NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `compra_id` int(11) NOT NULL,
  `users_id_elimina` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_eliminado` timestamp NULL DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pago_compra`
--

INSERT INTO `pago_compra` (`id`, `monto`, `fecha`, `users_id`, `compra_id`, `users_id_elimina`, `fecha_eliminado`, `estado_id`, `created_at`, `updated_at`) VALUES
(1, 19493.33, '2022-04-25', 3, 14, NULL, NULL, 1, '2022-04-25 17:46:28', '2022-04-25 06:00:00'),
(2, 19493.33, '2022-04-26', 4, 14, NULL, NULL, 1, '2022-04-26 17:44:54', '2022-04-26 17:40:13'),
(3, 19493.33, '2022-04-27', 2, 14, NULL, NULL, 1, '2022-04-27 17:45:28', '2022-04-27 17:40:13'),
(7, 0.96, '2022-04-29', 3, 14, 3, '2022-04-27 11:36:23', 2, '2022-04-27 10:50:54', '2022-04-27 11:36:23'),
(10, 0.96, '2022-04-29', 3, 14, 3, '2022-04-27 11:40:50', 2, '2022-04-27 11:40:41', '2022-04-27 11:40:50'),
(11, 0.96, '2022-04-30', 3, 14, NULL, NULL, 1, '2022-04-27 11:41:46', '2022-04-27 11:41:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
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
  `created_at` timestamp NOT NULL,
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
(86, 55, '2022-04-20 23:45:06', '2022-04-20 23:45:06', 35, 3);

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
  `codigo_barra` varchar(13) DEFAULT NULL,
  `codigo_estatal` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `unidad_medida_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `isv`, `precio_base`, `codigo_barra`, `codigo_estatal`, `created_at`, `updated_at`, `categoria_id`, `unidad_medida_id`, `users_id`) VALUES
(1, 'producto1', 'Producto', 15, 100, '111', '111', '2022-03-25 04:42:55', '2022-03-25 04:42:55', 1, 1, 3),
(2, 'producto2', 'Producto', 15, 100, '111', '111', '2022-03-27 21:38:28', '2022-03-25 04:44:01', 1, 1, 3),
(5, 'producto3', 'Producto', 15, 100, '111', '111', '2022-03-27 21:38:35', '2022-03-25 04:47:04', 1, 1, 3),
(6, 'producto 4', 'producto 4, registro de prueba', 15, 100, '111', '111', '2022-03-30 04:38:55', '2022-03-30 04:38:55', 1, 1, 3),
(7, 'producto 7', 'Prueba con imagenes', 15, 100, '1001', '1000', '2022-04-05 23:28:30', '2022-04-05 23:28:30', 1, 1, 3),
(8, 'producto 8', 'prueba de imagenes', 15, 100, '1004', '504', '2022-04-05 23:31:52', '2022-04-05 23:31:52', 2, 1, 3),
(11, 'producto 10', 'imagenes', 15, 100, '100', '244', '2022-04-05 23:49:44', '2022-04-05 23:49:44', 1, 1, 3),
(12, 'producto 12', 'imagenes', 15, 100, '2', '4', '2022-04-05 23:50:55', '2022-04-05 23:50:55', 1, 1, 3),
(13, 'producto 4', 'vvv', 15, 100, '44', '22', '2022-04-06 00:07:35', '2022-04-06 00:07:35', 1, 1, 3),
(14, 'producto 44', 'ddd', 15, 100, '22', '55', '2022-04-06 00:09:41', '2022-04-06 00:09:41', 1, 1, 3),
(15, 'Imagenes', 'Imagenes', 15, NULL, '1000', '12011', '2022-04-07 01:48:53', '2022-04-07 01:48:53', 1, 1, 3),
(16, 'producto prueba espera', 'espera', 15, NULL, '4455', '777', '2022-04-20 22:49:11', '2022-04-20 22:49:11', 1, 1, 3),
(17, 'producto prueba espera 2', 'prueba', 15, 100, '44', '55', '2022-04-20 22:55:39', '2022-04-20 22:55:39', 1, 1, 3),
(18, 'prueba espera 3', 'prueba', 15, 100, '444', '555', '2022-04-20 22:59:01', '2022-04-20 22:59:01', 2, 1, 3),
(19, 'prueab espera 5', 'prueba', 15, 100, '44', '55', '2022-04-20 23:01:43', '2022-04-20 23:01:43', 1, 2, 3),
(20, 'prueba 6 espera', 'ff', 15, 100, '4455', '555', '2022-04-20 23:05:15', '2022-04-20 23:05:15', 1, 1, 3),
(21, 'producto 66', 'prueba', 15, 100, '44', '55', '2022-04-20 23:06:08', '2022-04-20 23:06:08', 1, 2, 3),
(22, 'producto 10 prueba espera', 'prueba', 15, 425, '44', '55', '2022-04-20 23:08:15', '2022-04-20 23:08:15', 1, 1, 3),
(23, 'producto 10 prueba', 'prueba', 15, 444, '444', '555', '2022-04-20 23:09:35', '2022-04-20 23:09:35', 1, 1, 3),
(24, 'producto 12 espera', 'prueba', 15, 555, '555', '444', '2022-04-20 23:10:43', '2022-04-20 23:10:43', 2, 1, 3),
(25, 'producto 4', 'fff', 15, 4444, '45', '444', '2022-04-20 23:12:03', '2022-04-20 23:12:03', 1, 1, 3),
(26, 'producto 13 espera', 'prueba', 15, 555, '44', '55', '2022-04-20 23:16:55', '2022-04-20 23:16:55', 1, 1, 3),
(27, 'prueba 14 espera', 'prueba', 15, 100, '44', '55', '2022-04-20 23:19:39', '2022-04-20 23:19:39', 1, 1, 3),
(28, 'prueba 15', 'prueba', 15, 22, '555', '55', '2022-04-20 23:20:53', '2022-04-20 23:20:53', 1, 1, 3),
(29, 'prueba espera 16', 'prueba', 15, 100, '111', '222', '2022-04-20 23:22:02', '2022-04-20 23:22:02', 1, 1, 3),
(30, 'producto 4', 'ppp', 15, 111, '444', '44', '2022-04-20 23:22:52', '2022-04-20 23:22:52', 1, 1, 3),
(31, 'producto 17 prueba espera', 'producto', 15, 100, '4444', '55', '2022-04-20 23:33:59', '2022-04-20 23:33:59', 1, 1, 3),
(32, 'producto 18 prueba espera', 'prueba', 15, 100, '455', '555', '2022-04-20 23:35:20', '2022-04-20 23:35:20', 1, 1, 3),
(33, 'producto 18 prueba espera', 'prueba', 15, 555, '445', '555', '2022-04-20 23:42:04', '2022-04-20 23:42:04', 1, 1, 3),
(34, 'prueba producto 19', 'prueba', 15, 222, '4455', '555', '2022-04-20 23:43:16', '2022-04-20 23:43:16', 1, 1, 3),
(35, 'producto 19 prueba espera', 'prueba', 15, 222, '1000', '111', '2022-04-20 23:45:06', '2022-04-20 23:45:06', 1, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
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
  `created_at` timestamp NOT NULL,
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
(9, '663', 'Proveedor 8', 'Tegucigalpa', 'Juan Perez', '88996655', NULL, 'proveedor@gmail.com', NULL, '08011990568971', 3, 1, 10, 1, 1, '2022-03-15 12:23:56', '2022-03-15 13:02:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retenciones`
--

CREATE TABLE `retenciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `valor` double DEFAULT NULL,
  `created_at` timestamp NOT NULL,
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
(2, 9, '2022-03-15 12:23:56', '2022-03-15 12:23:56');

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
  `created_at` timestamp NOT NULL,
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
(17, 'Seccion A 3', 3, 1, 5, '2022-04-08 06:10:17', '2022-04-08 06:10:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `segmento`
--

CREATE TABLE `segmento` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `bodega_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
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
(5, 'A', 2, '2022-04-08 06:10:17', '2022-04-08 06:10:17');

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
('PMGL2HYWuXsLgzrzJHQqEI3lYTutDqrwmHoDpmP2', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.127 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoieFZMRGY5ZkZUREFBWWo3TU1qZ1hpVDB2bFhJV2lOYmdxbnN3cFNIVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0by9jb21wcmFzL2RldGFsbGUvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkc0xSbEpoMWVtTjA4Wml2TER3a0dSdWNUdE1FczhHYjNNSS5sUmFEVmZvei54L3BxbXRDQkMiO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkc0xSbEpoMWVtTjA4Wml2TER3a0dSdWNUdE1FczhHYjNNSS5sUmFEVmZvei54L3BxbXRDQkMiO30=', 1651038727);

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
(3, 4, 'Usuario\'s Team', 1, '2022-03-16 01:01:19', '2022-03-16 01:01:19');

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
-- Estructura de tabla para la tabla `tipo_compra`
--

CREATE TABLE `tipo_compra` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
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
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_personalidad`
--

CREATE TABLE `tipo_personalidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
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
  `created_at` timestamp NOT NULL,
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
-- Estructura de tabla para la tabla `tipo_user`
--

CREATE TABLE `tipo_user` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_user`
--

INSERT INTO `tipo_user` (`id`, `nombre`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '2022-03-15 17:17:08', NULL),
(2, 'Vendedor', '2022-03-15 17:17:08', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `id` int(11) NOT NULL,
  `unidad` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `simbolo` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`id`, `unidad`, `nombre`, `simbolo`, `created_at`, `updated_at`) VALUES
(1, 1, 'unidad', 'un', '2022-03-24 01:16:22', '2022-03-24 01:08:57'),
(2, 1, 'yarda', 'yd', '2022-03-24 01:15:54', '2022-03-24 01:08:57');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_tipo_user` int(11) DEFAULT NULL,
  `tipo_usuario_id` int(11) DEFAULT '1',
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `identidad`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `id_tipo_user`, `tipo_usuario_id`, `fecha_nacimiento`, `telefono`) VALUES
(2, '0801199612356', 'Yefry Ortiz', 'yefryyo@gmail.com', NULL, '$2y$10$YgQRCumSehYxcGqjPKYL9e6hPVN.V8NmhwbFT6CqyWoF4bHGIf8Be', NULL, NULL, NULL, 1, NULL, '2022-03-02 09:05:40', '2022-03-02 09:05:41', 1, 1, '1996-04-01', '22336699'),
(3, '0822199500082', 'Luis Aviles', 'luisfaviles18@gmail.com', NULL, '$2y$10$sLRlJh1emN08ZivLDwkGRucTtMEs8Gb3MI.lRaDVfoz.x/pqmtCBC', NULL, NULL, '0CYWkjVskLW5jM2xpfilUFfjBF3bZwK0OomxWBO7HLXYF7lvXfxHZCp2yaPs', 2, 'profile-photos/oNdajTCAvTsuuRD76t4ognTdmhWLIOy9nEszULmY.jpg', '2022-03-07 12:42:26', '2022-03-24 11:52:49', 1, 1, '1995-03-16', '89282146'),
(4, '0801199036544', 'Usuario', 'usuario.prueba@distribucionesvalencia.hn', NULL, '$2y$10$KQ3DjX8eDhNcDN7qXhgTDuzMcgNL5B5RzAoRKKeL58i5c4tMcJg2O', NULL, NULL, NULL, 3, NULL, '2022-03-16 01:01:19', '2022-03-16 01:01:20', 1, 1, '2022-03-15', '88996655');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bodega_users1_idx` (`encargado_bodega`),
  ADD KEY `fk_bodega_estado1_idx` (`estado_id`),
  ADD KEY `fk_bodega_municipio1_idx` (`municipio_id`);

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
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compra_proveedores1_idx` (`proveedores_id`),
  ADD KEY `fk_compra_users1_idx` (`users_id`),
  ADD KEY `fk_compra_tipo_compra1_idx` (`tipo_compra_id`),
  ADD KEY `fk_compra_retenciones1_idx` (`retenciones_id`);

--
-- Indices de la tabla `compra_has_producto`
--
ALTER TABLE `compra_has_producto`
  ADD PRIMARY KEY (`compra_id`,`producto_id`),
  ADD KEY `fk_compra_has_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_compra_has_producto_compra1_idx` (`compra_id`),
  ADD KEY `fk_compra_has_producto_seccion1_idx` (`seccion_id`),
  ADD KEY `fk_compra_has_producto_estado1_idx` (`estado_recibido`),
  ADD KEY `fk_compra_has_producto_users1_idx` (`recibido_por`);

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
  ADD KEY `fk_producto_users1_idx` (`users_id`);

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
-- Indices de la tabla `tipo_user`
--
ALTER TABLE `tipo_user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
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
  ADD KEY `fk_users_Tipo_user` (`id_tipo_user`),
  ADD KEY `fk_users_tipo_usuario1_idx` (`tipo_usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bodega`
--
ALTER TABLE `bodega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `img_producto`
--
ALTER TABLE `img_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `retenciones`
--
ALTER TABLE `retenciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `segmento`
--
ALTER TABLE `segmento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT de la tabla `tipo_user`
--
ALTER TABLE `tipo_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_proveedores1` FOREIGN KEY (`proveedores_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_retenciones1` FOREIGN KEY (`retenciones_id`) REFERENCES `retenciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_tipo_compra1` FOREIGN KEY (`tipo_compra_id`) REFERENCES `tipo_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compra_has_producto`
--
ALTER TABLE `compra_has_producto`
  ADD CONSTRAINT `fk_compra_has_producto_compra1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_has_producto_estado1` FOREIGN KEY (`estado_recibido`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_has_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_has_producto_seccion1` FOREIGN KEY (`seccion_id`) REFERENCES `seccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_has_producto_users1` FOREIGN KEY (`recibido_por`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria_producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_unidad_medida1` FOREIGN KEY (`unidad_medida_id`) REFERENCES `unidad_medida` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_proveedores_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_municipio1` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_tipo_personalidad1` FOREIGN KEY (`tipo_personalidad_id`) REFERENCES `tipo_personalidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_users1` FOREIGN KEY (`registrado_por`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `retenciones`
--
ALTER TABLE `retenciones`
  ADD CONSTRAINT `fk_retenciones_tipo_retencion1` FOREIGN KEY (`tipo_retencion_id`) REFERENCES `tipo_retencion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_retenciones_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `retenciones_has_proveedores`
--
ALTER TABLE `retenciones_has_proveedores`
  ADD CONSTRAINT `fk_retenciones_proveedor_has_proveedores_proveedores1` FOREIGN KEY (`proveedores_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_retenciones_proveedor_has_proveedores_retenciones_proveedor1` FOREIGN KEY (`retenciones_id`) REFERENCES `retenciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `fk_estante_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_seccion_segmento1` FOREIGN KEY (`segmento_id`) REFERENCES `segmento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `segmento`
--
ALTER TABLE `segmento`
  ADD CONSTRAINT `fk_segmento_bodega1` FOREIGN KEY (`bodega_id`) REFERENCES `bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_Tipo_user` FOREIGN KEY (`id_tipo_user`) REFERENCES `tipo_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_tipo_usuario1` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tipo_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
