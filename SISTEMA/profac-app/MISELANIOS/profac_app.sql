-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-03-2022 a las 23:31:35
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
  `estado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`id`, `nombre`, `direccion`, `created_at`, `updated_at`, `encargado_bodega`, `estado_id`) VALUES
(1, 'Bodega 1', 'Tegucigalpa', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1);

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
(2, 'inactivo', '2022-03-10 23:55:11', '2022-03-10 23:54:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estante`
--

CREATE TABLE `estante` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_bodega` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estante`
--

INSERT INTO `estante` (`id`, `nombre`, `created_at`, `updated_at`, `id_bodega`, `estado_id`) VALUES
(1, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 1, 1),
(2, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 1, 1),
(3, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 1, 1);

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
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre_producto` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repisa`
--

CREATE TABLE `repisa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_estante` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `repisa`
--

INSERT INTO `repisa` (`id`, `nombre`, `created_at`, `updated_at`, `id_estante`, `estado_id`) VALUES
(2, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 1, 1),
(3, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 1, 1),
(4, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 1, 1),
(5, '4', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 1, 1),
(6, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1),
(7, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1),
(8, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1),
(9, '4', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1),
(10, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 3, 1),
(11, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 3, 1),
(12, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 3, 1),
(13, '4', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 3, 1);

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
  `nombre` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `repisa_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id`, `nombre`, `created_at`, `updated_at`, `repisa_id`, `estado_id`) VALUES
(1, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1),
(2, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1),
(3, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1),
(4, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1),
(5, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1),
(6, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 2, 1),
(7, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 3, 1),
(8, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 3, 1),
(9, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 3, 1),
(10, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 3, 1),
(11, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 3, 1),
(12, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 3, 1),
(13, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 4, 1),
(14, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 4, 1),
(15, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 4, 1),
(16, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 4, 1),
(17, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 4, 1),
(18, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 4, 1),
(19, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 5, 1),
(20, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 5, 1),
(21, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 5, 1),
(22, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 5, 1),
(23, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 5, 1),
(24, '1', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 5, 1),
(25, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 6, 1),
(26, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 6, 1),
(27, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 6, 1),
(28, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 6, 1),
(29, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 6, 1),
(30, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 6, 1),
(31, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 7, 1),
(32, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 7, 1),
(33, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 7, 1),
(34, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 7, 1),
(35, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 7, 1),
(36, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 7, 1),
(37, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 8, 1),
(38, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 8, 1),
(39, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 8, 1),
(40, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 8, 1),
(41, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 8, 1),
(42, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 8, 1),
(43, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 9, 1),
(44, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 9, 1),
(45, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 9, 1),
(46, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 9, 1),
(47, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 9, 1),
(48, '2', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 9, 1),
(49, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 10, 1),
(50, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 10, 1),
(51, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 10, 1),
(52, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 10, 1),
(53, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 10, 1),
(54, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 10, 1),
(55, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 11, 1),
(56, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 11, 1),
(57, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 11, 1),
(58, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 11, 1),
(59, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 11, 1),
(60, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 11, 1),
(61, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 12, 1),
(62, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 12, 1),
(63, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 12, 1),
(64, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 12, 1),
(65, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 12, 1),
(66, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 12, 1),
(67, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 13, 1),
(68, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 13, 1),
(69, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 13, 1),
(70, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 13, 1),
(71, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 13, 1),
(72, '3', '2022-03-13 04:30:45', '2022-03-13 04:30:45', 13, 1);

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
('jl9upa6vEkidUhH4nYCQruiAglhgjd1cLZ0upCj1', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRHZDeWhrb1FEc2d1MDlmZkx0TFFYak42ZVVEb2ZxN1Nkb01WSURPbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm92ZWVkb3JlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkc0xSbEpoMWVtTjA4Wml2TER3a0dSdWNUdE1FczhHYjNNSS5sUmFEVmZvei54L3BxbXRDQkMiO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkc0xSbEpoMWVtTjA4Wml2TER3a0dSdWNUdE1FczhHYjNNSS5sUmFEVmZvei54L3BxbXRDQkMiO30=', 1647127816);

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
(2, 3, 'Luis\'s Team', 1, '2022-03-07 12:42:26', '2022-03-07 12:42:26');

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
-- Estructura de tabla para la tabla `tipo_user`
--

CREATE TABLE `tipo_user` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `tipo_usuario_id` int(11) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `identidad`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `id_tipo_user`, `tipo_usuario_id`, `fecha_nacimiento`, `telefono`) VALUES
(2, NULL, 'Yefry Ortiz', 'yefryyo@gmail.com', NULL, '$2y$10$YgQRCumSehYxcGqjPKYL9e6hPVN.V8NmhwbFT6CqyWoF4bHGIf8Be', NULL, NULL, NULL, 1, NULL, '2022-03-02 09:05:40', '2022-03-02 09:05:41', NULL, 0, NULL, NULL),
(3, NULL, 'Luis Aviles', 'luisfaviles18@gmail.com', NULL, '$2y$10$sLRlJh1emN08ZivLDwkGRucTtMEs8Gb3MI.lRaDVfoz.x/pqmtCBC', NULL, NULL, NULL, 2, NULL, '2022-03-07 12:42:26', '2022-03-10 12:52:37', NULL, 0, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bodega_users1_idx` (`encargado_bodega`),
  ADD KEY `fk_bodega_estado1_idx` (`estado_id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estante`
--
ALTER TABLE `estante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estante_bodega1_idx` (`id_bodega`),
  ADD KEY `fk_estante_estado1_idx` (`estado_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
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
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `repisa`
--
ALTER TABLE `repisa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_repisa_estante1_idx` (`id_estante`),
  ADD KEY `fk_repisa_estado1_idx` (`estado_id`);

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
  ADD KEY `fk_seccion_repisa1_idx` (`repisa_id`),
  ADD KEY `fk_seccion_estado1_idx` (`estado_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estante`
--
ALTER TABLE `estante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `repisa`
--
ALTER TABLE `repisa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_user`
--
ALTER TABLE `tipo_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD CONSTRAINT `fk_bodega_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bodega_users1` FOREIGN KEY (`encargado_bodega`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `estante`
--
ALTER TABLE `estante`
  ADD CONSTRAINT `fk_estante_bodega1` FOREIGN KEY (`id_bodega`) REFERENCES `bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estante_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `repisa`
--
ALTER TABLE `repisa`
  ADD CONSTRAINT `fk_repisa_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_repisa_estante1` FOREIGN KEY (`id_estante`) REFERENCES `estante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `fk_seccion_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_seccion_repisa1` FOREIGN KEY (`repisa_id`) REFERENCES `repisa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
