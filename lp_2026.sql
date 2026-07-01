-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 01-07-2026 a las 15:41:13
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
-- Base de datos: `lp_2026`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Herramientas Eléctricas'),
(2, 'Herramientas Manuales'),
(12, 'Herramientas Pesadas'),
(3, 'Materiales de Construcción'),
(4, 'Pinturería');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `razon_social` varchar(150) DEFAULT NULL,
  `cuit` varchar(20) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `domicilio` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `tipo`, `apellido`, `nombres`, `dni`, `razon_social`, `cuit`, `telefono`, `correo`, `domicilio`, `estado`) VALUES
(1, 'Empresa', '', '', '', 'La Serenisima', '20-3454343-2', '2975207103', 'serenisima@gmail.com', 'Buenos Aires', 0),
(2, 'Particular', 'Esquivel', 'Solange', '33124321', '', '', '2974232132', 'Solange@gmail.com', 'Perito Moreno', 1),
(3, 'Empresa', '', '', '', 'Distrigas', '20-78788787-2', '297892736', 'distrigas@gmail.com', 'Av las Carretas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo` varchar(25) NOT NULL,
  `descripcion` text NOT NULL,
  `categoriaId` int(10) UNSIGNED NOT NULL,
  `precio` float(12,2) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `codigo`, `descripcion`, `categoriaId`, `precio`, `stock`) VALUES
(9, 'Cemento', 'CEM-01', 'Bolsa de cemento de 25 kg \nMarca loma negra ', 3, 8000.00, 800),
(10, 'Martillo', 'MAR-01', 'martillo', 2, 123.00, 455),
(11, 'Pincel', 'PIN-01', 'Pincel', 4, 123.00, 120),
(20, 'Palet de Ladrillos', 'PAL-LAD01', 'Palet de ladrillos para construccuión', 3, 20000.00, 9992);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `cuenta` varchar(20) NOT NULL,
  `perfil` enum('Administrador','Operador') NOT NULL,
  `clave` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fechaAlta` date NOT NULL,
  `resetPass` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `apellido`, `nombres`, `cuenta`, `perfil`, `clave`, `correo`, `estado`, `fechaAlta`, `resetPass`) VALUES
(4, 'Pozzo', 'Benjamin', 'benja.pozzo', 'Administrador', '$2y$10$v7FFXRLK8NlYqCwjPsksCedOBktUyxrkb95qIHeWWBQybVMFLlpzq', 'bepoamhu.2016@gmail.com', 1, '2026-06-28', 0),
(12, 'Decima', 'Oriana', 'Ori.Decima', 'Operador', '$2y$10$M4bsf.DLITW2FL5NRNMwNOayhaTGeIDzsVxjgVR2B67rw3BY/afsm', 'ori@gmail.com', 1, '2026-06-30', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `numero_venta` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `cliente` varchar(150) NOT NULL,
  `forma_pago` varchar(50) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `usuarioId` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `numero_venta`, `fecha`, `cliente`, `forma_pago`, `total`, `usuarioId`, `estado`) VALUES
(9, 9, '2026-07-01 09:05:18', 'Distrigas', 'Efectivo', 24000.00, 4, 0),
(10, 10, '2026-07-01 09:07:03', 'Consumidor Final', 'Efectivo', 32000.00, 4, 0),
(11, 11, '2026-07-01 09:09:22', 'Distrigas', 'Transferencia', 8000.00, 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_detalle`
--

CREATE TABLE `ventas_detalle` (
  `id` int(11) NOT NULL,
  `ventaId` int(11) NOT NULL,
  `productoId` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas_detalle`
--

INSERT INTO `ventas_detalle` (`id`, `ventaId`, `productoId`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(14, 9, 9, 3, 8000.00, 24000.00),
(15, 10, 9, 4, 8000.00, 32000.00),
(16, 11, 9, 1, 8000.00, 8000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_numeracion`
--

CREATE TABLE `ventas_numeracion` (
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas_numeracion`
--

INSERT INTO `ventas_numeracion` (`numero`) VALUES
(12);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorias_unique` (`nombre`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productos_unique` (`codigo`),
  ADD UNIQUE KEY `productos_nombre_IDX` (`nombre`,`categoriaId`) USING BTREE,
  ADD KEY `productos_categorias_FK` (`categoriaId`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuarios_unique` (`cuenta`),
  ADD UNIQUE KEY `usuarios_unique_1` (`correo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_venta` (`numero_venta`);

--
-- Indices de la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ventas_detalle_venta` (`ventaId`),
  ADD KEY `fk_ventas_detalle_producto` (`productoId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categorias_FK` FOREIGN KEY (`categoriaId`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  ADD CONSTRAINT `fk_ventas_detalle_producto` FOREIGN KEY (`productoId`) REFERENCES `productos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ventas_detalle_venta` FOREIGN KEY (`ventaId`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
