-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2021 a las 05:33:30
-- Versión del servidor: 8.0.27
-- Versión de PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `const_db_3`
--

DELIMITER $$
--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `initcap` (`x` LONGTEXT) RETURNS LONGTEXT CHARSET utf8mb3 READS SQL DATA
    DETERMINISTIC
BEGIN
SET @str='';
SET @l_str='';
WHILE x REGEXP ' ' DO
SELECT SUBSTRING_INDEX(x, ' ', 1) INTO @l_str;
SELECT SUBSTRING(x, LOCATE(' ', x)+1) INTO x;
SELECT CONCAT(@str, ' ', CONCAT(UPPER(SUBSTRING(@l_str,1,1)),LOWER(SUBSTRING(@l_str,2)))) INTO @str;
END WHILE;
RETURN LTRIM(CONCAT(@str, ' ', CONCAT(UPPER(SUBSTRING(x,1,1)),LOWER(SUBSTRING(x,2)))));
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `com_docs_det`
--

CREATE TABLE `com_docs_det` (
  `ID` bigint NOT NULL,
  `COMMENT_ID` bigint NOT NULL,
  `FILE_NAME` longtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `com_docs_det`
--

INSERT INTO `com_docs_det` (`ID`, `COMMENT_ID`, `FILE_NAME`) VALUES
(1, 1, 'Aadamsoo_Anne-Mai.pdf'),
(2, 2, 'Constru App  Solicitudes.pdf'),
(3, 3, ''),
(4, 4, ''),
(5, 5, ''),
(6, 6, 'Screen Shot 2021-09-14 at 11.54.14 PM.png'),
(7, 7, 'Constru App  Agregar Nuevo Material.pdf'),
(8, 8, 'Materiales.txt'),
(9, 9, ''),
(10, 10, ''),
(11, 11, ''),
(12, 12, ''),
(13, 13, ''),
(14, 14, ''),
(15, 15, ''),
(16, 16, ''),
(17, 17, ''),
(18, 18, ''),
(19, 19, ''),
(20, 20, ''),
(21, 21, 'Materiales.txt'),
(22, 22, ''),
(23, 23, ''),
(24, 24, ''),
(25, 25, ''),
(26, 26, ''),
(27, 27, ''),
(28, 28, ''),
(29, 29, ''),
(30, 30, ''),
(31, 31, ''),
(32, 32, 'Materiales.txt'),
(33, 33, 'Materiales.txt'),
(34, 34, ''),
(35, 35, ''),
(36, 36, ''),
(37, 37, ''),
(38, 38, ''),
(39, 39, 'Materiales.txt'),
(40, 40, ''),
(41, 41, 'INSPECCION_.pdf'),
(42, 42, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `com_docs_mst`
--

CREATE TABLE `com_docs_mst` (
  `COMMENT_ID` bigint NOT NULL,
  `COMMENT_DESC` longtext NOT NULL,
  `COMMENT_BY` int NOT NULL,
  `ENT_DATE` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `com_docs_mst`
--

INSERT INTO `com_docs_mst` (`COMMENT_ID`, `COMMENT_DESC`, `COMMENT_BY`, `ENT_DATE`) VALUES
(1, ' It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 4, '2021-08-22 12:14:09'),
(2, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia', 5, '2021-10-05 09:23:17'),
(3, 'Nuevo comentario acerca de la obra', 5, '2021-10-05 17:35:31'),
(4, 'Nuevo comentario acerca de la obra', 5, '2021-10-05 17:35:36'),
(5, 'Prueba de comentario', 5, '2021-10-05 17:44:31'),
(6, 'location ', 5, '2021-10-05 17:45:57'),
(7, 'Ausente por tres dias adjunto certificado medico', 5, '2021-10-06 19:17:49'),
(8, 'HOLA MUNDO', 10, '2021-10-29 02:41:03'),
(9, '', 10, '2021-11-02 16:37:35'),
(10, '', 10, '2021-11-02 16:43:55'),
(11, '', 10, '2021-11-02 16:54:51'),
(12, '', 10, '2021-11-02 16:57:50'),
(13, '', 10, '2021-11-02 16:57:57'),
(14, '', 10, '2021-11-04 14:18:45'),
(15, '', 4, '2021-11-05 00:27:43'),
(16, '', 10, '2021-11-05 00:31:58'),
(17, '', 10, '2021-11-05 00:32:03'),
(18, '', 10, '2021-11-05 00:32:08'),
(19, '', 10, '2021-11-05 00:32:14'),
(20, '', 10, '2021-11-05 00:32:22'),
(21, 'hola', 4, '2021-11-05 01:56:44'),
(22, '', 11, '2021-11-05 19:26:36'),
(23, '', 11, '2021-11-05 19:29:01'),
(24, '', 11, '2021-11-05 19:31:26'),
(25, '', 11, '2021-11-05 19:31:41'),
(26, '', 11, '2021-11-05 19:36:54'),
(27, '', 11, '2021-11-05 19:37:04'),
(28, '', 11, '2021-11-05 19:41:41'),
(29, '', 11, '2021-11-05 19:45:18'),
(30, '', 11, '2021-11-05 19:45:28'),
(31, 'Hola', 11, '2021-11-05 19:53:03'),
(32, 'Hola', 11, '2021-11-05 19:59:14'),
(33, 'Validación de comentarios funcionando', 11, '2021-11-05 19:59:47'),
(34, '', 4, '2021-11-12 15:42:22'),
(35, '', 4, '2021-11-12 15:43:55'),
(36, '', 4, '2021-11-12 15:54:05'),
(37, '', 4, '2021-11-12 15:58:36'),
(38, '', 4, '2021-11-12 15:58:51'),
(39, 'Test bodeguero 1', 4, '2021-11-12 16:02:56'),
(40, '', 4, '2021-11-13 19:26:30'),
(41, 'Test 2 comentarios', 4, '2021-11-13 19:35:21'),
(42, '', 10, '2021-11-16 05:57:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `construction`
--

CREATE TABLE `construction` (
  `CONSTRUCTION_ID` bigint NOT NULL,
  `CONST_NAME` varchar(500) NOT NULL,
  `SUPERVISOR` int NOT NULL,
  `COORDINATES` varchar(500) NOT NULL,
  `ADDRESS` longtext NOT NULL,
  `BUSINESS` varchar(350) NOT NULL,
  `BUS_CONDITION` varchar(500) DEFAULT NULL,
  `QTY` bigint NOT NULL,
  `START_DT` varchar(20) NOT NULL,
  `END_DT` varchar(20) NOT NULL,
  `ENT_DATE` timestamp NULL DEFAULT NULL,
  `IMG_NAME` varchar(500) DEFAULT NULL,
  `SIGNED_STATUS` varchar(1) DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `construction`
--

INSERT INTO `construction` (`CONSTRUCTION_ID`, `CONST_NAME`, `SUPERVISOR`, `COORDINATES`, `ADDRESS`, `BUSINESS`, `BUS_CONDITION`, `QTY`, `START_DT`, `END_DT`, `ENT_DATE`, `IMG_NAME`, `SIGNED_STATUS`) VALUES
(9, 'INTEL COMPUTERS', 5, '123123123,123123123123', 'NEQUE PORRO QUISQUAM EST QUI DOLOREM IPSUM QUIA DOLO', 'INTEL BUILDING SITE', 'GOOD', 20000, '2021-09-20', '2021-09-30', '2021-09-20 17:25:29', '9.png', 'N'),
(10, 'ESTADIO', 5, '1231312,11231321', 'PRESIDENTE AVENUE', 'NEW', '12', 100, '06/02/2021', '05/02/2023', '2021-10-05 18:26:55', '10.png', 'Y'),
(11, 'ESTADIO OLIMPICO', 5, '14241252,-83958', 'AVENIDA PRESIDENCIAL 13', 'CONSTRUCCIONESMW SA', 'LIC', 101000, '2021-10-07', '2024-07-17', '2021-10-06 19:16:53', '11.jpg', 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `construction_stage`
--

CREATE TABLE `construction_stage` (
  `ID` int NOT NULL,
  `CONSTRUCTION_ID` int NOT NULL,
  `STAGE_ID` int NOT NULL,
  `STAGE_STATUS` varchar(250) DEFAULT NULL,
  `STAGE_NOTE` varchar(500) DEFAULT NULL,
  `STAGE_PERCENTAGE` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `construction_stage`
--

INSERT INTO `construction_stage` (`ID`, `CONSTRUCTION_ID`, `STAGE_ID`, `STAGE_STATUS`, `STAGE_NOTE`, `STAGE_PERCENTAGE`) VALUES
(1, 9, 1, 'Preparacion', 'Trabajando', 77.4),
(2, 10, 2, 'Construcción', 'Trabajando', 52.7),
(3, 11, 3, 'Finalizando', 'Proyecto en proceso de finalización', 90.8),
(4, 9, 4, 'Terminado', 'Proceso de entrega a clientes', 100),
(6, 10, 5, 'Preparación de casa', 'tttt', 77.9),
(7, 11, 6, 'Prueba 1', 'Probando registro', 99.9),
(8, 11, 7, 'Prueba 2', 'Probando registro 2', 100),
(9, 10, 8, 'prueba 3', 'test numero 3', 66.9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `construction_stages`
--

CREATE TABLE `construction_stages` (
  `CONSTRUCTION_ID` int NOT NULL,
  `STAGE_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `construction_stages`
--

INSERT INTO `construction_stages` (`CONSTRUCTION_ID`, `STAGE_ID`) VALUES
(9, 1),
(10, 2),
(11, 3),
(9, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delivery_det`
--

CREATE TABLE `delivery_det` (
  `FK_DELIVER_ID` int NOT NULL,
  `MATERIAL_ID` int NOT NULL,
  `AMOUNT` bigint NOT NULL,
  `UNIT` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `delivery_det`
--

INSERT INTO `delivery_det` (`FK_DELIVER_ID`, `MATERIAL_ID`, `AMOUNT`, `UNIT`) VALUES
(4, 11100110, 50, 'Kg'),
(5, 11100110, 35, 'Kg'),
(6, 11100110, 440, 'Kg'),
(7, 11100110, 30, 'Kg'),
(8, 12100211, 1, 'Mt'),
(9, 10100311, 1, 'Mt'),
(10, 12100211, 40, 'Mt'),
(11, 12100211, 200, 'Mt'),
(12, 12100211, 40, 'Mt'),
(13, 12100211, 100, 'Mt'),
(14, 12100211, 300, 'Mt'),
(15, 10100311, 5, 'Mt'),
(15, 12100211, 200, 'Mt'),
(16, 12100211, 100, 'Mt'),
(17, 10100311, 5, 'Mt'),
(18, 12100211, 100, 'Mt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `delivery_mst`
--

CREATE TABLE `delivery_mst` (
  `ID` bigint NOT NULL,
  `ENT_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DELIVER_BY` int NOT NULL,
  `REQUEST_ID` int NOT NULL,
  `DELIVERED_TO` int NOT NULL,
  `VIEWER` varchar(250) DEFAULT NULL,
  `IMPORTANCE` varchar(1) DEFAULT NULL,
  `OBSERVATION` longtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `delivery_mst`
--

INSERT INTO `delivery_mst` (`ID`, `ENT_DATE`, `DELIVER_BY`, `REQUEST_ID`, `DELIVERED_TO`, `VIEWER`, `IMPORTANCE`, `OBSERVATION`) VALUES
(4, '2021-10-15 17:16:07', 9, 1, 4, 'Delrio', NULL, NULL),
(5, '2021-11-13 22:57:58', 4, 6, 4, 'Matias', NULL, NULL),
(6, '2021-11-13 22:58:57', 4, 4, 4, 'Delrio', NULL, NULL),
(7, '2021-11-17 00:03:10', 4, 8, 4, 'Matias', NULL, NULL),
(8, '2021-11-17 02:45:41', 4, 3, 4, 'Matias', NULL, NULL),
(9, '2021-11-17 02:49:16', 4, 9, 4, 'Matias', NULL, NULL),
(10, '2021-11-17 03:08:56', 4, 13, 4, 'Delrio', NULL, NULL),
(11, '2021-11-17 03:14:50', 4, 5, 4, 'Matias', NULL, NULL),
(12, '2021-11-17 03:19:39', 4, 15, 4, 'Delrio', NULL, NULL),
(13, '2021-11-17 03:25:06', 4, 16, 4, 'Delrio', NULL, NULL),
(14, '2021-11-17 03:35:22', 4, 17, 4, 'Delrio', NULL, NULL),
(15, '2021-11-17 03:37:56', 4, 18, 4, 'Delrio', NULL, NULL),
(16, '2021-11-17 03:44:30', 4, 19, 4, 'Delrio', NULL, NULL),
(17, '2021-11-17 03:46:08', 4, 20, 4, 'Delrio', NULL, NULL),
(18, '2021-11-17 03:48:09', 4, 21, 4, 'Delrio', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docs_table`
--

CREATE TABLE `docs_table` (
  `DOC_ID` bigint NOT NULL,
  `DOC_NAME` varchar(500) NOT NULL,
  `ENT_TIME` varchar(250) NOT NULL,
  `ENT_DATE` varchar(250) NOT NULL,
  `DESCRIPTION` longtext,
  `CONST_ID` bigint NOT NULL,
  `UPLOADED_BY` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `docs_table`
--

INSERT INTO `docs_table` (`DOC_ID`, `DOC_NAME`, `ENT_TIME`, `ENT_DATE`, `DESCRIPTION`, `CONST_ID`, `UPLOADED_BY`) VALUES
(2, 'Lorem Ipsum', '02:00 AM', '2021-09-30', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33.\nAll the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 9, 5),
(3, 'Edicto contrato', '09:00 AM', '2021-10-27', 'Se registra el acto', 10, 5),
(4, 'Test1', '10:00 AM', '2021-11-03', 'Test registrado', 11, 5),
(5, 'Hola', '01:00 AM', '2021-11-04', 'Hola a todos, prueba n°1.', 10, 4),
(6, 'Excel', '01:00 AM', '2021-11-16', 'prueba 1', 10, 4),
(7, 'asdasdas', '02:00 AM', '12121-02-11', 'asdasdas', 10, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documents`
--

CREATE TABLE `documents` (
  `D_ID` int NOT NULL,
  `UPLOAD_BY` int NOT NULL,
  `UPLOAD_DATE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_categories`
--

CREATE TABLE `doc_categories` (
  `ID` int NOT NULL,
  `DOC_DESC` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `doc_categories`
--

INSERT INTO `doc_categories` (`ID`, `DOC_DESC`) VALUES
(1, 'Certificados de trabajadores'),
(2, 'Evidencia de avance de partidas'),
(3, 'Certificados de la obra Permiso'),
(4, 'Certificados de la obra topografía'),
(5, 'Certificados de la obra Plano'),
(6, 'Certificados de la obra Patentes'),
(7, 'Cubicaciones Obra'),
(8, 'Cubicaciones  Partida'),
(9, 'Multas Trabajadores'),
(10, 'Multas Externas'),
(11, 'Multas Obra'),
(12, 'Multas Atraso de partidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fines_obra`
--

CREATE TABLE `fines_obra` (
  `FINE_ID` bigint NOT NULL,
  `DEPARTURE` varchar(350) NOT NULL,
  `FINE_TYPE` varchar(250) NOT NULL,
  `FINE_DESC` longtext NOT NULL,
  `FINE_ENTER_BY` int NOT NULL,
  `ENT_DATE` timestamp NULL DEFAULT NULL,
  `CONSTRUCTION_ID` bigint NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fines_obra`
--

INSERT INTO `fines_obra` (`FINE_ID`, `DEPARTURE`, `FINE_TYPE`, `FINE_DESC`, `FINE_ENTER_BY`, `ENT_DATE`, `CONSTRUCTION_ID`) VALUES
(1, 'Neque porro quisquam', 'General', 'many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)', 5, '2021-09-20 18:47:01', 9),
(2, 'Neque porro quisquam', 'Lorem Ipsum', 'many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)', 5, '2021-10-05 09:58:02', 9),
(3, 'Neque porro quisquam', 'General', 'asdasdasd', 5, '2021-10-05 18:02:08', 9),
(4, 'TEST', 'TEZT', 'TEST', 5, '2021-10-05 18:28:29', 10),
(5, 'TEST', 'TEZT', 'TEST', 5, '2021-10-05 18:28:30', 10),
(6, 'TEST', 'TEZT', 'TEST', 5, '2021-10-05 18:28:33', 10),
(7, 'NUEVA', 'NUEVA', 'NUEVA', 5, '2021-10-05 18:29:43', 10),
(8, 'Intel', 'Test1', 'Prueba de multa 1', 5, '2021-11-15 02:06:00', 11),
(9, 'Preparacion', 'inasistencia', 'no asiste a reunion boris aguayo', 5, '2021-11-16 13:16:09', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fine_obra_docs`
--

CREATE TABLE `fine_obra_docs` (
  `ID` bigint NOT NULL,
  `FINE_ID` bigint NOT NULL,
  `DOCUMENT_NAME` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fine_obra_docs`
--

INSERT INTO `fine_obra_docs` (`ID`, `FINE_ID`, `DOCUMENT_NAME`) VALUES
(5, 1, 'final.pdf'),
(6, 2, 'Constru App  Solicitudes.pdf'),
(7, 3, 'a.txt'),
(8, 4, 'Screen Shot 2021-09-14 at 9.38.37 PM.png'),
(9, 4, 'Authorize.auz'),
(10, 4, 'SCAN ME.pdf'),
(11, 5, 'Screen Shot 2021-09-14 at 9.38.37 PM.png'),
(12, 5, 'Authorize.auz'),
(13, 5, 'SCAN ME.pdf'),
(14, 6, 'Screen Shot 2021-09-14 at 9.38.37 PM.png'),
(15, 6, 'Authorize.auz'),
(16, 6, 'SCAN ME.pdf'),
(17, 7, 'Screen Shot 2021-09-14 at 9.38.37 PM.png'),
(18, 7, 'Authorize.auz'),
(19, 7, 'SCAN ME.pdf'),
(20, 9, 'Materiales.txt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material`
--

CREATE TABLE `material` (
  `ID` int NOT NULL,
  `WAREHOUSE_ID` int DEFAULT NULL,
  `AVAILABLE_STATUS` varchar(1) DEFAULT NULL,
  `AMOUNT` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materials`
--

CREATE TABLE `materials` (
  `MAT_ID` int NOT NULL,
  `MAT_NAME` varchar(250) NOT NULL,
  `UNIT_ID` int NOT NULL,
  `ITMCODE` varchar(8) NOT NULL,
  `MAIN_ID` int DEFAULT NULL,
  `OPENING_STK` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `materials`
--

INSERT INTO `materials` (`MAT_ID`, `MAT_NAME`, `UNIT_ID`, `ITMCODE`, `MAIN_ID`, `OPENING_STK`) VALUES
(1001, 'Lucky Cement', 10, '11100110', 11, 90),
(1002, 'Tabla Encofrado', 11, '12100211', 12, 100),
(1003, 'Tubo PVC', 11, '10100311', 10, 100),
(1004, 'Pintura Blanca Exteriores', 12, '10100412', 10, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mat_main`
--

CREATE TABLE `mat_main` (
  `ID` int NOT NULL,
  `DESCRIPTION` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mat_main`
--

INSERT INTO `mat_main` (`ID`, `DESCRIPTION`) VALUES
(10, 'general'),
(11, 'Cemento'),
(12, 'madera'),
(13, 'Hormigón'),
(14, 'Ladrillos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mat_units`
--

CREATE TABLE `mat_units` (
  `UNIT_ID` int NOT NULL,
  `UNIT_DESC` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mat_units`
--

INSERT INTO `mat_units` (`UNIT_ID`, `UNIT_DESC`) VALUES
(10, 'KG'),
(11, 'MT'),
(12, 'L');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modules`
--

CREATE TABLE `modules` (
  `ID` bigint NOT NULL,
  `NAME` varchar(500) NOT NULL,
  `LINK` longtext,
  `ENT_DATE` timestamp NULL DEFAULT NULL,
  `CATEGORY_ID` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `modules`
--

INSERT INTO `modules` (`ID`, `NAME`, `LINK`, `ENT_DATE`, `CATEGORY_ID`) VALUES
(1, 'Nueva Entrega', 'material-delivery.html', '2021-09-16 07:23:34', 8),
(2, 'Ver Entregas', 'material-deliveries.html', '2021-09-16 07:24:09', 8),
(3, 'Recibir material', 'materials-receive-supplier.html', '2021-09-19 08:17:51', 10),
(4, 'Solicitudes de material', 'requests.html', '2021-09-19 08:18:51', 1),
(5, 'Nuevo material', 'new-material.html', '2021-09-19 08:24:55', 0),
(6, 'Stock de material', 'inventory-stock.html', '2021-09-19 08:24:55', 11),
(7, 'Reembolso', 'supplier-refund.html', '2021-09-19 08:24:55', 10),
(8, 'Módulos De Usuario', 'user-modules.html', '2021-09-19 09:39:01', 0),
(9, 'Nueva Solicitud', 'new-request.html', '2021-09-19 10:08:35', 1),
(10, 'MIS Solicitudes', 'requests.html', '2021-09-19 10:10:05', 0),
(11, 'Comentarios', 'comments.html', '2021-09-19 18:54:27', 2),
(12, 'Construcciones', 'constructions.html', '2021-09-20 15:36:54', 3),
(13, 'Multas De Construcción', 'construction-fines.html', '2021-09-20 16:23:31', 4),
(14, 'Trabajadores', 'workers.html', '2021-09-20 16:23:31', 5),
(15, 'Amonestaciones Trabajadores', 'workers-fines.html', '2021-09-20 16:23:31', 4),
(16, 'Ver Documentos', 'documents.html', '2021-09-20 16:23:31', 6),
(17, 'Nuevo Trabajador', 'new-worker.html', '2021-09-20 16:23:31', 5),
(18, 'Nueva Amonestaciones Trabajador', 'fine-worker.html', '2021-09-20 16:23:31', 4),
(19, 'Nueva Obra', 'new-construction.html', '2021-09-20 16:44:56', 3),
(20, 'Registro Evidencia', 'special-document.html', '2021-09-20 18:44:58', 6),
(21, 'Nueva Multa De Construccion', 'fine_construction.html', '2021-09-22 18:05:35', 4),
(22, 'Ver Entregas', 'material-deliveries.html', '2021-10-04 18:09:31', 8),
(23, 'Nuevo Material', 'new-material.html', '2021-10-04 18:22:55', 9),
(24, 'Recibo De Material', 'material_receipt.html', '2021-10-05 08:36:23', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module_category`
--

CREATE TABLE `module_category` (
  `C_ID` bigint NOT NULL,
  `CAT_NAME` varchar(250) DEFAULT NULL,
  `CAT_ICON` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `module_category`
--

INSERT INTO `module_category` (`C_ID`, `CAT_NAME`, `CAT_ICON`) VALUES
(1, 'Solicitudes', 'fas fa-cart-plus'),
(2, 'Comentarios', 'fas fa-comments'),
(3, 'Construcciones', 'fas fa-laptop-house'),
(4, 'Multas', 'fas fa-tags'),
(5, 'Trabajadores', 'fas fa-users'),
(6, 'Documentos', 'fas fa-paste'),
(7, 'Ingresos', 'fas fa-dolly'),
(8, 'Entregas', 'fas fa-shipping-fast'),
(9, 'Materiales', 'fas fa-cubes\"'),
(10, 'Proveedor', 'fas fa-truck-moving'),
(11, 'Inventario', 'fas fa-store');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obra_documents`
--

CREATE TABLE `obra_documents` (
  `ID` bigint NOT NULL,
  `OBRA_ID` int NOT NULL,
  `FILE_NAME` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `obra_documents`
--

INSERT INTO `obra_documents` (`ID`, `OBRA_ID`, `FILE_NAME`) VALUES
(5, 9, 'Construapp Errors Feedback.docx'),
(6, 10, 'Constru App  Agregar Nuevo Material.pdf'),
(7, 11, 'Construapp documento en proceso.docx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receipt_det_inv`
--

CREATE TABLE `receipt_det_inv` (
  `FK_RECEIPT_ID` bigint NOT NULL,
  `MATERIAL_ID` int NOT NULL,
  `UNIT` varchar(2) NOT NULL,
  `AMOUNT` bigint NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `receipt_det_inv`
--

INSERT INTO `receipt_det_inv` (`FK_RECEIPT_ID`, `MATERIAL_ID`, `UNIT`, `AMOUNT`) VALUES
(44, 11100110, 'Kg', 500),
(45, 10100311, 'Mt', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receipt_frm_sup_det`
--

CREATE TABLE `receipt_frm_sup_det` (
  `FK_RECEIPT_ID` bigint NOT NULL,
  `MATERIAL_ID` int NOT NULL,
  `AMOUNT` bigint NOT NULL,
  `UNIT` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `receipt_frm_sup_det`
--

INSERT INTO `receipt_frm_sup_det` (`FK_RECEIPT_ID`, `MATERIAL_ID`, `AMOUNT`, `UNIT`) VALUES
(1, 11100110, 200, 'Kg'),
(2, 11100110, 800, 'Kg'),
(3, 10100311, 10, 'Mt'),
(4, 10100412, 660, 'L'),
(5, 10100412, 880, 'L'),
(6, 12100211, 333, 'Mt'),
(7, 12100211, 5000, 'Mt'),
(8, 12100211, 600, 'Mt'),
(9, 11100110, 400, 'Kg'),
(9, 12100211, 400, 'Mt'),
(10, 10100311, 50, 'Mt'),
(11, 12100211, 500, 'Mt'),
(12, 12100211, 600, 'Mt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receipt_frm_sup_mst`
--

CREATE TABLE `receipt_frm_sup_mst` (
  `RECEIPT_ID` bigint NOT NULL,
  `SUPPLIER_ID` int NOT NULL,
  `MATERIAL_DOC` varchar(20) DEFAULT NULL,
  `TIPO_DOC` varchar(20) DEFAULT NULL,
  `OBSERVATION` longtext,
  `RECEIVER` int NOT NULL,
  `ENT_DATE` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `receipt_frm_sup_mst`
--

INSERT INTO `receipt_frm_sup_mst` (`RECEIPT_ID`, `SUPPLIER_ID`, `MATERIAL_DOC`, `TIPO_DOC`, `OBSERVATION`, `RECEIVER`, `ENT_DATE`) VALUES
(1, 7, '123123', '12312323', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 4, '2021-09-19 07:35:16'),
(2, 7, '2021008', '2021008', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.', 4, '2021-09-19 07:44:47'),
(3, 7, '1', '1', '', 4, '2021-10-06 19:49:36'),
(4, 7, '2', '2', 'h', 4, '2021-10-06 19:50:50'),
(5, 7, '3', '3', '3', 9, '2021-10-06 19:53:47'),
(6, 7, '5', '5', 'F', 9, '2021-10-07 08:04:45'),
(7, 7, '2021111', '2021111', 'Receive from supplier to inventroy', 9, '2021-10-07 08:16:43'),
(8, 7, '1', '2', 'Se necesitan amteriales', 4, '2021-11-04 22:09:56'),
(9, 7, '4', '4', 'HOLA mundo', 4, '2021-11-05 00:18:20'),
(10, 7, '5', 'W', 'Quiero materiales urgente!', 4, '2021-11-12 22:39:43'),
(11, 7, '10', 'Excel', 'Materiales recibidos', 4, '2021-11-12 22:44:36'),
(12, 7, '5', 'Pdf', 'materiales recibidos', 4, '2021-11-16 22:42:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receipt_mst_inv`
--

CREATE TABLE `receipt_mst_inv` (
  `ID` bigint NOT NULL,
  `RECEIPT_BY` int NOT NULL,
  `RECEIPT_FRM` int NOT NULL,
  `RECEIPT_DT` timestamp NULL DEFAULT NULL,
  `IMG` longtext,
  `RUT_SUP` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `receipt_mst_inv`
--

INSERT INTO `receipt_mst_inv` (`ID`, `RECEIPT_BY`, `RECEIPT_FRM`, `RECEIPT_DT`, `IMG`, `RUT_SUP`) VALUES
(44, 9, 7, '2021-10-05 15:05:20', '', NULL),
(45, 9, 7, '2021-10-07 08:05:18', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `request`
--

CREATE TABLE `request` (
  `REQUEST_ID` bigint NOT NULL,
  `REQUESTED_BY` int DEFAULT NULL,
  `REQUEST_TO` int DEFAULT NULL,
  `CONSTRUCTION_ID` int DEFAULT NULL,
  `REQ_DATE` date DEFAULT NULL,
  `REQ_STATUS` varchar(1) DEFAULT NULL,
  `REQ_TITLE` varchar(500) DEFAULT NULL,
  `REQ_DESCRIP` varchar(500) DEFAULT NULL,
  `SUPERVISOR_ID` int DEFAULT NULL,
  `REQUEST_TYPE` varchar(1) DEFAULT NULL,
  `REQ_APPLICANT` varchar(250) DEFAULT NULL,
  `REQ_IMPORTANCE` varchar(1) DEFAULT NULL,
  `APPROVAL_DT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `APPROVED_BY` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `request`
--

INSERT INTO `request` (`REQUEST_ID`, `REQUESTED_BY`, `REQUEST_TO`, `CONSTRUCTION_ID`, `REQ_DATE`, `REQ_STATUS`, `REQ_TITLE`, `REQ_DESCRIP`, `SUPERVISOR_ID`, `REQUEST_TYPE`, `REQ_APPLICANT`, `REQ_IMPORTANCE`, `APPROVAL_DT`, `APPROVED_BY`) VALUES
(1, 4, 6, 9, '2021-10-03', 'A', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters', NULL, 'E', NULL, 'N', '2021-10-06 19:35:07', 6),
(2, 4, 5, 9, '2021-10-22', 'P', 'Lorem Ipsum', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters', NULL, 'E', NULL, 'N', '2021-10-22 15:58:53', NULL),
(3, 4, 5, 11, '2021-10-23', 'A', 'Request for Wood', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.', NULL, 'E', NULL, 'N', '2021-10-23 17:09:35', NULL),
(4, 4, 6, 10, '2021-10-25', 'A', 'Request for turbo pc ', 'lorem ipsum', NULL, 'E', NULL, 'N', '2021-10-25 16:41:49', 6),
(5, 4, 5, 9, '2021-11-04', 'A', 'Hola', 'Hola a todos', NULL, 'E', NULL, 'N', '2021-11-05 00:05:36', NULL),
(6, 4, 5, 10, '2021-11-13', 'A', 'Cemento', 'Necesito cementos', NULL, 'E', NULL, 'U', '2021-11-13 19:51:01', NULL),
(7, 4, 6, 9, '2021-11-14', 'P', 'Materiales', 'Materiales', NULL, 'E', NULL, 'U', '2021-11-14 16:10:23', NULL),
(8, 4, 5, 9, '2021-11-16', 'A', 'test1', 'test 1 urgente', NULL, 'E', NULL, 'U', '2021-11-16 22:01:06', NULL),
(9, 4, 5, 10, '2021-11-16', 'A', 'test2', 'test 2 materiales', NULL, 'E', NULL, 'U', '2021-11-16 22:08:08', NULL),
(10, 4, 5, 9, '2021-11-16', 'E', 'test5', 'test 5 materiales ', NULL, 'E', NULL, 'U', '2021-11-16 22:13:29', NULL),
(11, 4, 5, 9, '2021-11-16', 'P', 'test8', 'test8 materiales', NULL, 'E', NULL, 'U', '2021-11-16 22:21:30', NULL),
(12, 4, 5, 11, '2021-11-16', 'P', 'test 11', 'test 11 materiales', NULL, 'E', NULL, 'N', '2021-11-16 22:22:29', NULL),
(13, 4, 6, 9, '2021-11-16', 'A', 'test6', 'test 6 m', NULL, 'E', NULL, 'U', '2021-11-17 02:59:12', NULL),
(14, 4, 5, 9, '2021-11-17', 'P', 'test2', 'test2', NULL, 'E', NULL, 'U', '2021-11-17 03:16:46', NULL),
(15, 4, 6, 10, '2021-11-17', 'A', 'test6', 'test 6 materiales', NULL, 'E', NULL, 'U', '2021-11-17 03:17:46', NULL),
(16, 4, 6, 10, '2021-11-17', 'A', 'test66', 'test600', NULL, 'E', NULL, 'U', '2021-11-17 03:23:47', NULL),
(17, 4, 6, 9, '2021-11-17', 'A', 'asdasd', 'asdasdasdas', NULL, 'E', NULL, 'U', '2021-11-17 03:34:33', NULL),
(18, 4, 6, 9, '2021-11-17', 'A', 'asdasd', 'asdasd', NULL, 'E', NULL, 'N', '2021-11-17 03:36:27', NULL),
(19, 4, 6, 11, '2021-11-17', 'A', 'asdasdsaasdasdaasda', 'asdasdasd', NULL, 'E', NULL, 'N', '2021-11-17 03:43:03', NULL),
(20, 4, 6, 9, '2021-11-17', 'A', 'erwrwer', 'rererere', NULL, 'E', NULL, 'N', '2021-11-17 03:43:28', NULL),
(21, 4, 6, 10, '2021-11-17', 'A', 'qweqwe', 'qweqweqw', NULL, 'E', NULL, 'N', '2021-11-17 03:47:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `request_det`
--

CREATE TABLE `request_det` (
  `R_ID` int NOT NULL,
  `MATERIAL_ID` int NOT NULL,
  `UNIT` varchar(20) NOT NULL,
  `AMOUNT` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `request_det`
--

INSERT INTO `request_det` (`R_ID`, `MATERIAL_ID`, `UNIT`, `AMOUNT`) VALUES
(1, 11100110, 'Kg', 50),
(2, 10100311, 'Mt', 500),
(3, 12100211, 'Mt', 250),
(4, 10100311, 'Mt', 200),
(4, 11100110, 'Kg', 500),
(5, 12100211, 'Mt', 400),
(6, 11100110, 'Kg', 35),
(7, 11100110, 'Kg', 35),
(8, 11100110, 'Kg', 30),
(9, 10100311, 'Mt', 22),
(10, 12100211, 'Mt', 350),
(11, 10100412, 'L', 25),
(12, 11100110, 'Kg', 20),
(13, 12100211, 'Mt', 150),
(14, 12100211, 'Mt', 175),
(15, 12100211, 'Mt', 150),
(16, 12100211, 'Mt', 700),
(17, 12100211, 'Mt', 300),
(18, 10100311, 'Mt', 600),
(18, 12100211, 'Mt', 600),
(19, 12100211, 'Mt', 200),
(20, 10100311, 'Mt', 5),
(21, 12100211, 'Mt', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `return_det`
--

CREATE TABLE `return_det` (
  `FK_RETURN_ID` bigint NOT NULL,
  `MATERIAL_ID` int NOT NULL,
  `UNIT` varchar(2) NOT NULL,
  `AMOUNT` bigint NOT NULL,
  `COND` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `return_mst`
--

CREATE TABLE `return_mst` (
  `RETURN_ID` int NOT NULL,
  `DELIVER_ID` int NOT NULL,
  `RETURN_DT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `RETURN_BY` int NOT NULL,
  `OBSERVATION` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `return_sup_det`
--

CREATE TABLE `return_sup_det` (
  `FK_RETURN_ID` bigint NOT NULL,
  `MATERIAL_ID` bigint NOT NULL,
  `AMOUNT` bigint NOT NULL,
  `UNIT` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `return_sup_mst`
--

CREATE TABLE `return_sup_mst` (
  `RETURN_ID` bigint NOT NULL,
  `RETURN_TO` int NOT NULL,
  `RETURN_BY` int NOT NULL,
  `RETURN_DT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `MATERIAL_DOC` bigint NOT NULL,
  `UNIT_DOC` bigint NOT NULL,
  `DOCUMENT_NAME` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stages`
--

CREATE TABLE `stages` (
  `STAGE_ID` int NOT NULL,
  `STAGE_DESC` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `stages`
--

INSERT INTO `stages` (`STAGE_ID`, `STAGE_DESC`) VALUES
(1, 'Preparación'),
(2, 'Construcción'),
(3, 'Finalizando'),
(4, 'Terminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `USER_ID` int NOT NULL,
  `RUT` varchar(50) DEFAULT NULL,
  `COMPANY_NAME` varchar(250) DEFAULT NULL,
  `REGION` varchar(250) DEFAULT NULL,
  `COMMON` varchar(250) DEFAULT NULL,
  `FATHER_LN` varchar(250) DEFAULT NULL,
  `MOTHER_LN` varchar(250) DEFAULT NULL,
  `ADDRESS` varchar(500) DEFAULT NULL,
  `BIRTH_DATE` date DEFAULT NULL,
  `GENRE` varchar(250) DEFAULT NULL,
  `PHONE` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(250) DEFAULT NULL,
  `PREVISION` varchar(250) DEFAULT NULL,
  `AFP` varchar(250) DEFAULT NULL,
  `EMERGENCY_CONTACT_NAME` varchar(250) DEFAULT NULL,
  `EMERGENCY_CONTACT_PHONE` varchar(20) DEFAULT NULL,
  `EMERGENCY_REL_DTL` varchar(500) DEFAULT NULL,
  `FIRST_WORKDAY_DATE` date DEFAULT NULL,
  `STATE` varchar(1) DEFAULT NULL,
  `ROLE_ID` int DEFAULT NULL,
  `CONSTRUCTION_ID` int DEFAULT NULL,
  `USER_PASSWORD` varchar(250) DEFAULT NULL,
  `NAME` varchar(250) DEFAULT NULL,
  `DESIGNATION` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`USER_ID`, `RUT`, `COMPANY_NAME`, `REGION`, `COMMON`, `FATHER_LN`, `MOTHER_LN`, `ADDRESS`, `BIRTH_DATE`, `GENRE`, `PHONE`, `EMAIL`, `PREVISION`, `AFP`, `EMERGENCY_CONTACT_NAME`, `EMERGENCY_CONTACT_PHONE`, `EMERGENCY_REL_DTL`, `FIRST_WORKDAY_DATE`, `STATE`, `ROLE_ID`, `CONSTRUCTION_ID`, `USER_PASSWORD`, `NAME`, `DESIGNATION`) VALUES
(4, 'ABC-2021001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'qasim@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, 'qasim123', 'Qasim', 'BODEGUERO'),
(5, 'ABC-2021002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'matias@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, 'matias123', 'Matias', 'ADMINISTRATOR OBRA'),
(6, 'ABC-2021003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'delrio@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, 'delrio123', 'Delrio', 'SUPERVISOR'),
(7, 'SUP-2021001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'John@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, NULL, 'JOHN', NULL),
(8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'matiaswertheim@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, 'admin123', 'Matias Wertheim', NULL),
(9, 'OFC2021001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'casamatriz@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, NULL, 'casamatriz123', 'Casa Matriz', NULL),
(10, 'ABC-201020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ins@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, NULL, 'ins123', 'Rois', 'INSPECCIÓN'),
(11, 'ABC-2021008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rrhh@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, 'rrhh123', 'isro', 'RRHH');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_modules`
--

CREATE TABLE `user_modules` (
  `ID` bigint NOT NULL,
  `USER_ID` bigint DEFAULT NULL,
  `MODULE_ID` bigint DEFAULT NULL,
  `ACTIVE_STATUS` varchar(1) DEFAULT 'A',
  `ENT_DATE` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_modules`
--

INSERT INTO `user_modules` (`ID`, `USER_ID`, `MODULE_ID`, `ACTIVE_STATUS`, `ENT_DATE`) VALUES
(14, 4, 9, 'A', '2021-09-19 10:15:00'),
(13, 4, 10, 'A', '2021-09-19 10:14:37'),
(29, 5, 20, 'A', '2021-09-22 18:08:29'),
(5, 9, 1, 'A', '2021-09-19 09:02:19'),
(6, 9, 3, 'A', '2021-09-19 09:02:50'),
(7, 9, 4, 'A', '2021-09-19 09:03:06'),
(8, 9, 5, 'A', '2021-09-19 09:03:24'),
(9, 9, 6, 'A', '2021-09-19 09:03:34'),
(10, 9, 7, 'A', '2021-09-19 09:03:43'),
(11, 8, 8, 'A', '2021-09-19 09:39:16'),
(15, 6, 4, 'A', '2021-09-19 10:20:21'),
(16, 9, 12, 'A', '2021-09-20 15:37:53'),
(28, 5, 21, 'A', '2021-09-22 18:05:57'),
(18, 5, 4, 'A', '2021-09-20 16:28:08'),
(19, 5, 12, 'A', '2021-09-20 16:28:32'),
(20, 5, 18, 'A', '2021-09-20 16:28:50'),
(21, 5, 11, 'A', '2021-09-20 16:29:04'),
(22, 5, 13, 'A', '2021-09-20 16:29:25'),
(23, 5, 14, 'A', '2021-09-20 16:29:41'),
(24, 5, 15, 'A', '2021-09-20 16:29:53'),
(27, 5, 19, 'A', '2021-09-20 17:04:30'),
(26, 5, 17, 'A', '2021-09-20 16:30:17'),
(30, 9, 2, 'A', '2021-10-04 18:12:02'),
(31, 9, 23, 'A', '2021-10-04 18:23:23'),
(32, 9, 24, 'A', '2021-10-05 08:44:44'),
(33, 4, 11, 'A', '2021-10-05 09:07:20'),
(34, 5, 16, 'A', '2021-10-06 19:33:40'),
(35, 6, 11, 'A', '2021-10-06 19:37:49'),
(36, 6, 16, 'A', '2021-10-06 19:38:06'),
(37, 6, 9, 'A', '2021-10-06 19:40:19'),
(38, 6, 10, 'A', '2021-10-06 19:40:35'),
(39, 6, 20, 'A', '2021-10-06 19:42:09'),
(40, 4, 20, 'A', '2021-10-06 19:44:34'),
(41, 4, 4, 'A', '2021-10-06 19:44:53'),
(42, 4, 1, 'A', '2021-10-06 19:45:29'),
(43, 4, 2, 'A', '2021-10-06 19:45:39'),
(44, 4, 3, 'A', '2021-10-06 19:45:49'),
(45, 4, 7, 'A', '2021-10-06 19:46:02'),
(46, 4, 6, 'A', '2021-10-06 19:46:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_roles`
--

CREATE TABLE `user_roles` (
  `ROLE_ID` int NOT NULL,
  `ROLE_DESCRIPTION` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_roles`
--

INSERT INTO `user_roles` (`ROLE_ID`, `ROLE_DESCRIPTION`) VALUES
(1, 'Gerente'),
(2, 'Jefe de operaciones'),
(3, 'Gerente comercial'),
(4, 'Administrador de obra'),
(5, 'Jefe de obra'),
(6, 'RRHH'),
(7, 'Oficina Tecnica'),
(8, 'CalidadAutoControl'),
(9, 'SupervisorSubContratista'),
(10, 'Bodeguero'),
(11, 'Supervisores'),
(12, 'Asistente de bodega'),
(13, 'SUPPLIER'),
(14, 'OFICINA CENTRAL'),
(15, 'Usuario Administrador'),
(16, 'Inspeccion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `warehouse_req_det`
--

CREATE TABLE `warehouse_req_det` (
  `FK_REQUEST_ID` bigint NOT NULL,
  `MATERIAL_ID` int NOT NULL,
  `UNIT` varchar(50) DEFAULT NULL,
  `AMOUNT` bigint NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `worker_det`
--

CREATE TABLE `worker_det` (
  `DOC_ID` bigint NOT NULL,
  `WORKER_ID` bigint NOT NULL,
  `DOC_NAME` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `worker_det`
--

INSERT INTO `worker_det` (`DOC_ID`, `WORKER_ID`, `DOC_NAME`) VALUES
(35, 1, 'Chapter 4.pdf'),
(36, 1, 'final.pdf'),
(37, 1, 'partial-differential-equations-muzammil-tanveer.pdf'),
(38, 2, 'sds.doc'),
(40, 3, 'Materiales.txt'),
(41, 3, 'Materiales.txt'),
(42, 3, 'Materiales.txt'),
(43, 1, 'Materiales.txt'),
(45, 3, 'Materiales.txt'),
(51, 3, 'Materiales.txt'),
(52, 3, 'INSPECCION_.pdf'),
(53, 3, 'Materiales.txt'),
(56, 3, 'INSPECCION_.pdf'),
(58, 3, 'INSPECCION_.pdf'),
(61, 3, 'INSPECCION_.pdf'),
(63, 4, 'INSPECCION_.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `worker_fines`
--

CREATE TABLE `worker_fines` (
  `FINE_ID` bigint NOT NULL,
  `FINE_DATE` varchar(250) NOT NULL,
  `PLACE` varchar(250) NOT NULL,
  `FINE_TIME` varchar(250) NOT NULL,
  `REASON` longtext NOT NULL,
  `APPROVAL_STATUS` varchar(1) DEFAULT NULL,
  `FINE_BY` int NOT NULL,
  `ENT_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `WORKER_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `worker_fines`
--

INSERT INTO `worker_fines` (`FINE_ID`, `FINE_DATE`, `PLACE`, `FINE_TIME`, `REASON`, `APPROVAL_STATUS`, `FINE_BY`, `ENT_DATE`, `WORKER_ID`) VALUES
(1, '2021-10-20', 'asd', '01:00 AM', 'asdasd', 'N', 5, '2021-10-05 18:00:28', 1),
(2, '2021-10-28', 'asd', '01:00 AM', 'asd', 'N', 5, '2021-10-05 18:04:46', 1),
(3, '04/03/2021', 'FABRICA', '05:00 PM', 'NUEVA', 'N', 5, '2021-10-05 18:30:44', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `worker_fine_det`
--

CREATE TABLE `worker_fine_det` (
  `ID` int NOT NULL,
  `FINE_ID` bigint NOT NULL,
  `DOCUMENT_NAME` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `worker_fine_det`
--

INSERT INTO `worker_fine_det` (`ID`, `FINE_ID`, `DOCUMENT_NAME`) VALUES
(1, 1, '2 Administrador de Obra.pdf'),
(2, 2, 'a.txt'),
(3, 3, 'SCAN ME.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `worker_mst`
--

CREATE TABLE `worker_mst` (
  `WORKER_ID` bigint NOT NULL,
  `CONSTRUCTION_ID` bigint NOT NULL,
  `WORKER_RUT` varchar(250) NOT NULL,
  `WORKER_NAME` varchar(350) NOT NULL,
  `WORKER_LNAME` varchar(250) DEFAULT NULL,
  `MOTHER_NAME` varchar(250) DEFAULT NULL,
  `GENDER` varchar(1) NOT NULL,
  `EMAIL` varchar(250) NOT NULL,
  `FORECAST` varchar(500) DEFAULT NULL,
  `REGION` varchar(500) DEFAULT NULL,
  `COMMUNE` varchar(500) DEFAULT NULL,
  `DT_OF_BIRTH` varchar(100) DEFAULT NULL,
  `WORKER_TEL` varchar(20) DEFAULT NULL,
  `AFP` varchar(250) DEFAULT NULL,
  `EMERGENCY_CONTACT_NAME` varchar(500) DEFAULT NULL,
  `RELATION` varchar(250) DEFAULT NULL,
  `EMERGENCY_TEL` varchar(20) DEFAULT NULL,
  `START_DATE` varchar(250) DEFAULT NULL,
  `CONTRACT_TYP` varchar(500) DEFAULT NULL,
  `WORKER_CONDITION` varchar(250) DEFAULT NULL,
  `POST` varchar(250) DEFAULT NULL,
  `PROFILE_IMG` varchar(500) DEFAULT NULL,
  `ENT_DATE` timestamp NULL DEFAULT NULL,
  `ADDRESS` longtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `worker_mst`
--

INSERT INTO `worker_mst` (`WORKER_ID`, `CONSTRUCTION_ID`, `WORKER_RUT`, `WORKER_NAME`, `WORKER_LNAME`, `MOTHER_NAME`, `GENDER`, `EMAIL`, `FORECAST`, `REGION`, `COMMUNE`, `DT_OF_BIRTH`, `WORKER_TEL`, `AFP`, `EMERGENCY_CONTACT_NAME`, `RELATION`, `EMERGENCY_TEL`, `START_DATE`, `CONTRACT_TYP`, `WORKER_CONDITION`, `POST`, `PROFILE_IMG`, `ENT_DATE`, `ADDRESS`) VALUES
(1, 11, 'W-20210001', 'Bumsy', 'Barek', 'Halena', 'F', 'Bumsy@gmail.com', 'Elbasurita', 'Hanly', 'Turkey', '2021-09-23', '03068495235', 'Abc Afp', 'Dogan', 'Suleman', '923012211231', '2021-09-30', 'Indefinido', 'Activo', 'Elbasurita El Mejor Desarrollador', 'pexels-andrea-piacquadio-975250.jpg', '2021-09-22 17:02:31', 'Millat town Millat Road  Faisalabad'),
(2, 9, 'W-202100210', 'Ertugrul', 'Suleman', 'Haima', 'F', 'Ertrugrul@gmail.com', 'Faisalabad', 'Punjab', 'Millat Road Faisalabad Punjab Pakistan', '2021-09-23', '923059911231', 'Abc Afp', 'Dogan', 'Jandar', '923157091149', '2021-09-30', 'Temporary', 'Activo', 'Foreman', '__Bandit02_Attack_007.png', '2021-09-22 17:13:16', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution'),
(3, 10, '20166711-2', 'juan', 'mercedez', 'milo', 'M', 'juan11@gmail.com', 'Fonasa', 'bio-bio', 'Tomé', '2000-11-11', '912638711', 'Provida', 'ronald', 'amigos', '912638733', '2021-11-12', 'indefinido', 'Activo', 'gerente', '', '2021-11-12 18:14:20', 'mercedes 1143'),
(4, 11, '20781777-2', 'Pescado', 'Antipatico', 'Hibrido', 'M', 'Pescadito2921@gmail.com', 'Fonasa', 'Bio-bio', 'Tome', '1999-11-11', '912634444', 'Provida', 'Ronald', 'Amigos', '912635656', '2021-11-12', 'Indefinido', 'Inactivo', 'Supervisor', 'mobius-city-dark-5k-jw-1366x768.jpg', '2021-11-12 18:16:55', 'en el cerro calle holanda 11');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `com_docs_det`
--
ALTER TABLE `com_docs_det`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `com_docs_mst`
--
ALTER TABLE `com_docs_mst`
  ADD PRIMARY KEY (`COMMENT_ID`);

--
-- Indices de la tabla `construction`
--
ALTER TABLE `construction`
  ADD PRIMARY KEY (`CONSTRUCTION_ID`);

--
-- Indices de la tabla `construction_stage`
--
ALTER TABLE `construction_stage`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `delivery_mst`
--
ALTER TABLE `delivery_mst`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `docs_table`
--
ALTER TABLE `docs_table`
  ADD PRIMARY KEY (`DOC_ID`);

--
-- Indices de la tabla `fines_obra`
--
ALTER TABLE `fines_obra`
  ADD PRIMARY KEY (`FINE_ID`);

--
-- Indices de la tabla `fine_obra_docs`
--
ALTER TABLE `fine_obra_docs`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `mat_main`
--
ALTER TABLE `mat_main`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `mat_units`
--
ALTER TABLE `mat_units`
  ADD PRIMARY KEY (`UNIT_ID`);

--
-- Indices de la tabla `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `module_category`
--
ALTER TABLE `module_category`
  ADD PRIMARY KEY (`C_ID`);

--
-- Indices de la tabla `obra_documents`
--
ALTER TABLE `obra_documents`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `receipt_frm_sup_mst`
--
ALTER TABLE `receipt_frm_sup_mst`
  ADD PRIMARY KEY (`RECEIPT_ID`);

--
-- Indices de la tabla `receipt_mst_inv`
--
ALTER TABLE `receipt_mst_inv`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`REQUEST_ID`);

--
-- Indices de la tabla `user_modules`
--
ALTER TABLE `user_modules`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `USER_ID` (`USER_ID`,`MODULE_ID`);

--
-- Indices de la tabla `worker_det`
--
ALTER TABLE `worker_det`
  ADD PRIMARY KEY (`DOC_ID`);

--
-- Indices de la tabla `worker_fines`
--
ALTER TABLE `worker_fines`
  ADD PRIMARY KEY (`FINE_ID`);

--
-- Indices de la tabla `worker_fine_det`
--
ALTER TABLE `worker_fine_det`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `worker_mst`
--
ALTER TABLE `worker_mst`
  ADD PRIMARY KEY (`WORKER_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `com_docs_det`
--
ALTER TABLE `com_docs_det`
  MODIFY `ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `com_docs_mst`
--
ALTER TABLE `com_docs_mst`
  MODIFY `COMMENT_ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `construction`
--
ALTER TABLE `construction`
  MODIFY `CONSTRUCTION_ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `construction_stage`
--
ALTER TABLE `construction_stage`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `delivery_mst`
--
ALTER TABLE `delivery_mst`
  MODIFY `ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `docs_table`
--
ALTER TABLE `docs_table`
  MODIFY `DOC_ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `fine_obra_docs`
--
ALTER TABLE `fine_obra_docs`
  MODIFY `ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `mat_main`
--
ALTER TABLE `mat_main`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `mat_units`
--
ALTER TABLE `mat_units`
  MODIFY `UNIT_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `module_category`
--
ALTER TABLE `module_category`
  MODIFY `C_ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `obra_documents`
--
ALTER TABLE `obra_documents`
  MODIFY `ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `receipt_frm_sup_mst`
--
ALTER TABLE `receipt_frm_sup_mst`
  MODIFY `RECEIPT_ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `receipt_mst_inv`
--
ALTER TABLE `receipt_mst_inv`
  MODIFY `ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `request`
--
ALTER TABLE `request`
  MODIFY `REQUEST_ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `user_modules`
--
ALTER TABLE `user_modules`
  MODIFY `ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `worker_det`
--
ALTER TABLE `worker_det`
  MODIFY `DOC_ID` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `worker_fine_det`
--
ALTER TABLE `worker_fine_det`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
