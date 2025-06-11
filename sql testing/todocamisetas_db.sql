-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2025 a las 07:30:56
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
-- Base de datos: `todocamisetas_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camisetas`
--

CREATE TABLE `camisetas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `club` varchar(100) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `detalles` text DEFAULT NULL,
  `codigo_producto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camisetas`
--

INSERT INTO `camisetas` (`id`, `titulo`, `club`, `pais`, `tipo`, `color`, `precio`, `detalles`, `codigo_producto`) VALUES
(1, 'C78', 'EjeC', 'Esp7676a878ña', 'Ofi', 'Az7676ul y R8787ojo', 875.50, 'Camise7676ta oficial temporad87897a 2024', 'BA7676R-208798724'),
(2, 'Ca7869876mise7676ta Oficial Barce8787lona 2024', 'Barc789698767676elo8787na', 'Esp879698767676a878ña', 'Ofi9876987676ci8787al', 'Az789769786676ul y R8787ojo', 875.88, 'Camise789697867676ta oficial temporad87897a 2024', 'BA787969876676R-208798724'),
(3, 'C878mis909879878790879987990988889897788878799eta Ejemplo', 'Ejempl099870987870909787900o FC', 'Esp879667698767676a878ña', 'Ofi87870098798798709879098787cial', 'Az78976976786676ul y R8787ojo', 875.88, 'Camise78967697867676ta oficial temporad87897a 2024', 'BA78796769876676R-208798724'),
(5, 'Camiseta Retro Manchester United', 'Manchester United', 'Inglaterra', 'Retro', 'Rojo', 65.00, 'Camiseta retro temporada 1999', 'MNU-R99'),
(6, 'Camiseta Local Argentina', 'Argentina', 'Argentina', 'Oficial', 'Celeste y Blanco', 80.00, 'Camiseta oficial selección argentina', 'ARG-LOC'),
(9, 'Camiseta Ejemplo1', 'Ejemplo FC1', 'EjemploLandia1', 'Oficial1', 'Verde1', 99.99, 'Camiseta edición especial1', 'EJEMPLO-0011'),
(10, 'Camiseta Ejemplo19', 'Ejemplo FC19', 'EjemploLandia19', 'Oficial19', 'Verde19', 100.00, 'Camiseta edición especial91', 'EJEMPLO-00191'),
(11, 'Camiseta Ejemplo1564659', 'Ejemplo FC19654', 'EjemploLandia16549', 'Oficial16549', 'Verde16549', 99.99, 'Camiseta edición especial96541', 'EJEMPLO-00196541'),
(12, 'Camiseta Ejemplo876876', 'Ejemplo FC876876', 'EjemploLandia876876', 'Oficial876876', 'Verde876876', 99.97, 'Camiseta edición especial78687', 'EJEMPLO-087687601'),
(13, 'Camiseta Ejem9898plo', 'Ejempl9898o FC', 'Ejempl9898oLandia', 'Ofic9898ial', 'V989erde', 9989.99, 'Camiset9898a edición especial', 'EJEMP9898LO-001'),
(15, 'Cami98798seta Ejem9898plo', 'Eje79879mpl9898o FC', 'Ejempl879879898oLandia', 'Of987987ic9898ial', 'V987987989erde', 99789.99, 'Camiset9987987898a edición especial', 'EJEM987987P9898LO-001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camiseta_talla`
--

CREATE TABLE `camiseta_talla` (
  `camiseta_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `camiseta_talla`
--

INSERT INTO `camiseta_talla` (`camiseta_id`, `talla_id`) VALUES
(1, 1),
(2, 1),
(3, 3),
(5, 3),
(5, 4),
(5, 5),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(9, 1),
(9, 2),
(11, 1),
(11, 2),
(12, 3),
(13, 1),
(13, 2),
(13, 3),
(15, 1),
(15, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre_comercial` varchar(100) NOT NULL,
  `rut` varchar(15) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `categoria` enum('Regular','Preferencial') DEFAULT 'Regular',
  `contacto_nombre` varchar(100) DEFAULT NULL,
  `contacto_email` varchar(100) DEFAULT NULL,
  `porcentaje_oferta` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre_comercial`, `rut`, `direccion`, `categoria`, `contacto_nombre`, `contacto_email`, `porcentaje_oferta`) VALUES
(1, 'Deportes Fut987897uro Actualizado', '12.345.69879877', 'N09090909090909ueva direcci09i09ón 123', '', 'Ana Gó987987mez', 'ana@fut987987uro.com', 20.00),
(3, 'Ropa Sport', '11223344-5', 'Boulevard Central 789', 'Regular', 'Marta Ruiz', 'marta@ropasport.com', 0.00),
(4, 'Fashion Team', '55667788-0', 'Av. Moda 321', 'Preferencial', 'Carlos Soto', 'carlos@fashionteam.com', 8.50),
(5, 'Deportes Activos', '99887766-3', 'Calle Deportes 654', 'Regular', 'Sofia Vega', 'sofia@deportesactivos.com', 2.00),
(6, 'Elite Camisetas', '44556677-8', 'Av. Elite 987', 'Preferencial', 'Pedro Martinez', 'pedro@elitecamisetas.com', 12.00),
(7, 'Deportes Futuro', '12.345.678-9', 'Av. Siempre Viva 123', '', 'Juan Pérez', 'juan@futuro.com', 10.00),
(10, 'Deportes Futuro', '12.34578907987.', 'Av. Siempre Viva 123', '', 'Juan Pérez', 'juan@futuro.com', 10.00),
(13, 'Deportes Futuro', '12.345789090909', 'Av. Siempre Viva 123', '', 'Juan Pérez', 'juan@futuro.com', 0.00),
(14, 'Deportes Futuro', '12.3457890790-8', 'Av. Siempre Viva 123', '', 'Juan Pérez', 'juan@futuro.com', 0.00),
(16, 'Deportes Futuro', '19898982', 'Av. Siempre Viva 123', '', 'Juan Pérez', 'juan@futuro.com', 12.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `camiseta_id` int(11) DEFAULT NULL,
  `precio_oferta` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`id`, `cliente_id`, `camiseta_id`, `precio_oferta`) VALUES
(1, 1, 1, 80.00),
(3, 3, 5, 60.00),
(4, 4, 2, 65.00),
(5, 5, 6, 75.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tallas`
--

CREATE TABLE `tallas` (
  `id` int(11) NOT NULL,
  `talla` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tallas`
--

INSERT INTO `tallas` (`id`, `talla`) VALUES
(3, 'L'),
(2, 'M'),
(1, 'S'),
(4, 'XL'),
(5, 'XXL'),
(6, 'XXXL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `camisetas`
--
ALTER TABLE `camisetas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_producto` (`codigo_producto`);

--
-- Indices de la tabla `camiseta_talla`
--
ALTER TABLE `camiseta_talla`
  ADD PRIMARY KEY (`camiseta_id`,`talla_id`),
  ADD KEY `talla_id` (`talla_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rut` (`rut`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `camiseta_id` (`camiseta_id`);

--
-- Indices de la tabla `tallas`
--
ALTER TABLE `tallas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `talla` (`talla`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `camisetas`
--
ALTER TABLE `camisetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tallas`
--
ALTER TABLE `tallas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `camiseta_talla`
--
ALTER TABLE `camiseta_talla`
  ADD CONSTRAINT `camiseta_talla_ibfk_1` FOREIGN KEY (`camiseta_id`) REFERENCES `camisetas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `camiseta_talla_ibfk_2` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD CONSTRAINT `ofertas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ofertas_ibfk_2` FOREIGN KEY (`camiseta_id`) REFERENCES `camisetas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
