-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-05-2026 a las 10:28:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `obmat_control`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Abarrotes'),
(2, 'Lácteos'),
(3, 'Bebidas'),
(4, 'Higiene'),
(5, 'Otros'),
(6, 'Snacks');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_venta`, `producto_id`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 1, 20, 1.80),
(2, 1, 2, 15, 2.50),
(3, 1, 3, 10, 3.00),
(4, 1, 4, 8, 3.00),
(5, 1, 5, 6, 3.30),
(6, 5, 1, 30, 1.80),
(7, 6, 1, 20, 1.80),
(8, 7, 1, 16, 1.80),
(9, 5, 2, 15, 2.50),
(10, 6, 2, 10, 2.50),
(11, 7, 2, 5, 2.50),
(12, 5, 3, 12, 3.00),
(13, 6, 3, 6, 3.00),
(14, 7, 3, 4, 3.00),
(15, 5, 4, 10, 3.00),
(16, 6, 4, 6, 3.00),
(17, 7, 4, 4, 3.00),
(18, 5, 5, 8, 3.30),
(19, 6, 5, 5, 3.30),
(20, 7, 5, 3, 3.30),
(21, 8, 6, 2, 5.50),
(22, 9, 7, 1, 6.00),
(23, 10, 8, 3, 4.50),
(24, 11, 9, 1, 8.00),
(25, 12, 10, 2, 7.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodos_pago`
--

CREATE TABLE `metodos_pago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodos_pago`
--

INSERT INTO `metodos_pago` (`id`, `nombre`) VALUES
(1, 'efectivo'),
(2, 'tarjeta'),
(3, 'yape');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `mensaje` varchar(255) DEFAULT NULL,
  `tipo` enum('alerta','info','venta') DEFAULT NULL,
  `leido` tinyint(1) DEFAULT 0,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `mensaje`, `tipo`, `leido`, `fecha`) VALUES
(1, 'Stock bajo en Arroz', NULL, 0, '2026-05-26 01:30:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `categoria` varchar(50) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `precio_compra` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `stock_minimo` int(11) DEFAULT 0,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `categoria`, `stock`, `categoria_id`, `precio_compra`, `imagen`, `estado`, `stock_minimo`, `descripcion`) VALUES
(1, 'Galletas 25 gr Chocolate', 1.80, 'Snacks', 200, 5, 1.20, 'galletas.png', 1, 0, NULL),
(2, 'Refresco 3L Sabor Uva', 2.50, 'Bebidas', 150, 3, 1.80, 'gaseosa.png', 0, 0, NULL),
(3, 'Arroz Valle del Norte 1kg', 3.00, 'Abarrotes', 100, 1, 2.30, 'arroz.png', 0, 0, NULL),
(4, 'Leche Gloria Entera 1L', 3.00, 'Lácteos', 80, 2, 2.20, 'leche.png', 1, 0, NULL),
(5, 'Aceite Vegetal Primor 1L', 3.30, 'Abarrotes', 60, 1, 2.70, 'aceite.png', 1, 10, NULL),
(6, 'Atún Florida en Aceite 170g', 5.50, 'Abarrotes', 15, 1, 4.20, 'atun.png', 1, 9, NULL),
(7, 'Mayonesa Alacena 200g', 6.00, 'Abarrotes', 8, 1, 4.50, 'mayonesa.png', 0, 0, NULL),
(8, 'Salsa de Tomate 200g', 4.50, 'Abarrotes', 12, 1, 3.20, 'salsa.png', 0, 0, NULL),
(9, 'Papel Higiénico Elite', 8.00, 'Higiene', 6, 4, 5.50, 'papel.png', 1, 0, NULL),
(10, 'Detergente Opal 1kg', 7.50, 'Higiene', 7, 4, 5.80, 'detergente.png', 1, 0, NULL),
(11, 'papas lays', 8.00, 'snacks', 100, NULL, NULL, 'default.png', 0, 10, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','cajero') DEFAULT 'cajero'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `rol`) VALUES
(1, 'Luis Ramos', 'admin', '456LUISRAMOSadmin@obmat/.og', 'admin'),
(2, 'Jhonatan', 'cajero1', 'c1JHONATAN@456OBMAT', 'cajero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `metodo_pago` varchar(20) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `metodo_pago_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `total`, `fecha`, `metodo_pago`, `usuario_id`, `metodo_pago_id`) VALUES
(1, 1248.50, '2026-05-24 12:50:43', 'efectivo', 1, 1),
(2, 0.00, '2026-05-19 00:00:00', 'efectivo', 1, 1),
(3, 0.00, '2026-05-14 00:00:00', 'tarjeta', 1, 2),
(4, 0.00, '2026-05-09 00:00:00', 'yape', 1, 3),
(5, 0.00, '2026-05-19 00:00:00', 'efectivo', 1, 1),
(6, 0.00, '2026-05-14 00:00:00', 'tarjeta', 1, 2),
(7, 0.00, '2026-05-09 00:00:00', 'yape', 1, 3),
(8, 0.00, '2026-05-08 00:00:00', 'efectivo', 1, 1),
(9, 0.00, '2026-05-11 00:00:00', 'efectivo', 1, 1),
(10, 0.00, '2026-05-13 00:00:00', 'efectivo', 1, 1),
(11, 0.00, '2026-05-14 00:00:00', 'efectivo', 1, 1),
(12, 0.00, '2026-05-15 00:00:00', 'efectivo', 1, 1),
(13, 80.00, '2026-05-24 04:00:00', 'efectivo', 1, 1),
(14, 160.00, '2026-05-24 08:00:00', 'tarjeta', 1, 2),
(15, 245.80, '2026-05-24 10:00:00', 'yape', 1, 3),
(16, 320.00, '2026-05-24 12:00:00', 'efectivo', 1, 1),
(17, 400.00, '2026-05-24 16:00:00', 'tarjeta', 1, 2),
(18, 300.00, '2026-05-24 20:00:00', 'yape', 1, 3),
(19, 150.00, '0000-00-00 00:00:00', 'efectivo', 1, 1),
(20, 170.00, '2026-05-26 10:00:00', 'efectivo', 1, 1),
(21, 170.00, '2026-05-26 10:00:00', 'efectivo', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`id_venta`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `metodos_pago`
--
ALTER TABLE `metodos_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
