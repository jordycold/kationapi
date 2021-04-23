-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 23-04-2021 a las 00:26:03
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kationtest`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `remember_token` text,
  `last_login` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lname`, `pwd`, `email`, `remember_token`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Kation', 'kations', '63e964e854c98d143e7c10ada34224e7b4c1ba9cb8a1d21c4f97514ceb22a869', 'kation@kations.com', '$2y$10$EinFcdR3Sn3KhFPQ4nHdIuqwdPTy.dywDu9pWCkDMp9LOws7aamRe', '2021-04-20', '2021-04-21 02:19:25', '2021-04-21 21:48:29', NULL),
(2, 'Prueba', 'Test', '20f45c82a9c965b98a594308af0fe5ebf28f187c079d3b6717151af262c81383', '123@123.com', '', '2021-04-10', '2021-04-21 00:17:23', '2021-04-23 02:26:50', NULL),
(4, 'Jordy', 'Frías', '6bbf776b94e18d0b892d5002fa5f6bf512a155dddb4b4d6026da576a0a621b9c', 'jordy@jordy.com', NULL, '2021-04-22', '2021-04-23 02:09:04', '2021-04-23 03:59:13', '2021-04-23 03:59:13'),
(5, 'Test', 'Test', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'test@gmail.com', NULL, '2021-04-22', '2021-04-23 03:17:55', '2021-04-23 03:17:55', NULL),
(6, 'Jordy', 'Frías', '49b7e4c36b542ddcea3b35d75a5238186dafd62f831fdae96786b463336b1276', 'jordhy@jordy.com', NULL, '2021-04-22', '2021-04-23 03:43:29', '2021-04-23 03:59:29', NULL),
(7, 'Jordy', 'Friasí', '324fbd3a9c7100837b90b3351e53e97050a22c85678b9226386bd7066ed2ca0c', 'jordhy@frias.com', NULL, '2021-04-22', '2021-04-23 03:59:13', '2021-04-23 03:59:13', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
