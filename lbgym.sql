-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2025 a las 00:42:43
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
-- Base de datos: `lbgym`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrenadores`
--

CREATE TABLE `entrenadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `horario_trabajo` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrenadores`
--

INSERT INTO `entrenadores` (`id`, `nombre`, `especialidad`, `telefono`, `email`, `horario_trabajo`, `foto`, `estado`) VALUES
(1, 'Equipo Mañana', 'Entrenamiento General', '379-4556677', 'mañana@lbgym.com', 'Lunes a Viernes 6:00-12:00', 'personal.jpg', 'activo'),
(2, 'Nina Williams', 'Crossfit', '379-4556678', 'nina@lbgym.com', 'Lunes a Sábado 8:00-16:00', 'entrenador1.jpg', 'activo'),
(3, 'Roque Medina', 'Musculación', '379-4556679', 'roque@lbgym.com', 'Martes a Domingo 14:00-22:00', 'entrenador2.jpg', 'activo'),
(4, 'Jazmin Lopez', 'Pilates', '379-4556680', 'jazmin@lbgym.com', 'Lunes a Viernes 7:00-13:00', 'entrenador3.jpg', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros`
--

CREATE TABLE `miembros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('activo','inactivo','suspendido') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `miembros`
--

INSERT INTO `miembros` (`id`, `nombre`, `email`, `telefono`, `fecha_nacimiento`, `direccion`, `fecha_registro`, `estado`) VALUES
(6, 'ricardo', 'ricar@gmail.com', '3794772233', '1998-06-15', 'montaña', '2025-11-21 22:47:48', 'activo'),
(9, 'lucas', 'rodriguez@gmail.com', '3794558877', '1998-12-13', '3 de abril', '2025-11-21 23:05:01', 'activo'),
(11, 'lucas', 'lucas@gmail.com', '3794887799', '2000-02-18', 'caba', '2025-11-21 23:34:27', 'activo'),
(12, 'rodolfo', 'rodolfo@gmail.com', '3798854477', '1998-05-12', 'catamarca', '2025-11-21 23:36:43', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `miembro_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp(),
  `metodo_pago` enum('efectivo','tarjeta','transferencia','mercadopago') DEFAULT NULL,
  `estado` enum('pendiente','aprobado','rechazado','cancelado') DEFAULT 'pendiente',
  `codigo_transaccion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `miembro_id`, `plan_id`, `monto`, `fecha_pago`, `metodo_pago`, `estado`, `codigo_transaccion`) VALUES
(6, 6, 3, 60000.00, '2025-11-21 22:47:48', 'tarjeta', 'aprobado', 'PAGO_1763765268_6'),
(7, 9, 2, 40000.00, '2025-11-21 23:05:01', 'efectivo', 'aprobado', 'PAGO_1763766301_9'),
(9, 11, 2, 40000.00, '2025-11-21 23:34:27', 'mercadopago', 'aprobado', 'PAGO_1763768067_11'),
(10, 12, 1, 20000.00, '2025-11-21 23:36:43', 'efectivo', 'aprobado', 'PAGO_1763768203_12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `duracion_meses` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `beneficios` text DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`id`, `nombre`, `precio`, `duracion_meses`, `descripcion`, `beneficios`, `estado`) VALUES
(1, 'Básico', 20000.00, 3, 'Plan ideal para comenzar', 'crossfit,yoga,clases particulares', 'activo'),
(2, 'Estándar', 40000.00, 6, 'Plan más completo', 'crossfit,yoga,clases particulares,asesoria personalizacion,plan de alimentacion', 'activo'),
(3, 'Familiar', 60000.00, 9, 'Plan para toda la familia', 'crossfit,yoga,clases particulares,asesoria personalizacion,plan de alimentacion,acceso a toda la familia', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `miembros`
--
ALTER TABLE `miembros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `miembro_id` (`miembro_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `entrenadores`
--
ALTER TABLE `entrenadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `miembros`
--
ALTER TABLE `miembros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`miembro_id`) REFERENCES `miembros` (`id`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `planes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
