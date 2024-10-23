-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 06:39:41
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_sade`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`sade`@`localhost` PROCEDURE `ActualizarAlumno` (IN `p_id_alumno` INT, IN `p_codigo_alumno` VARCHAR(10), IN `p_nombre_alumno` VARCHAR(100), IN `p_apellido_alumno` VARCHAR(100), IN `p_fecha_nacimiento` DATE, IN `p_codigo_responsable` INT, IN `p_direccion` VARCHAR(255), IN `p_codigo_departamento` INT, IN `p_codigo_municipio` INT)   BEGIN
    UPDATE tbl_alumnos
    SET
        codigo_alumno = p_codigo_alumno,
        nombre_alumno = p_nombre_alumno,
        apellido_alumno = p_apellido_alumno,
        fecha_nacimiento = p_fecha_nacimiento,
        codigo_responsable = p_codigo_responsable,
        direccion = p_direccion,
        codigo_departamento = p_codigo_departamento,
        codigo_municipio = p_codigo_municipio
    WHERE id_alumno = p_id_alumno;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `ActualizarCiclo` (IN `p_id_ciclo` INT, IN `p_codigo_grado` VARCHAR(15), IN `p_codigo_maestro` VARCHAR(15), IN `p_anio` VARCHAR(10), IN `p_seccion` VARCHAR(5))   BEGIN
    UPDATE tbl_ciclo
    SET codigo_grado = p_codigo_grado,
    codigo_profesor = p_codigo_maestro,
    anio = p_anio,
    seccion = p_seccion
    WHERE codigo_ciclo = p_id_ciclo;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `ActualizarMaestro` (IN `p_id_maestro` VARCHAR(15), IN `p_nombre_maestro` VARCHAR(100), IN `p_apellido_maestro` VARCHAR(100), IN `p_telefono` VARCHAR(10), IN `p_fecha_nacimiento` DATE, IN `p_direccion` VARCHAR(255), IN `p_codigo_departamento` INT, IN `p_codigo_municipio` INT)   BEGIN
    UPDATE tbl_profesores
    SET
        nombre_profesor = p_nombre_maestro,
        apellido_profesor = p_apellido_maestro,
        fecha_nacimiento = p_fecha_nacimiento,
        direccion = p_direccion,
        codigo_departamento = p_codigo_departamento,
        codigo_municipio = p_codigo_municipio
    WHERE codigo_profesor = p_id_maestro;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `ActualizarResponsable` (IN `p_codigo_responsable` INT, IN `dpi` VARCHAR(12), IN `nombre_padre` VARCHAR(50), IN `apellido_padre` VARCHAR(50), IN `codigo_parentezco` INT, IN `telefono` VARCHAR(10))   BEGIN
    UPDATE tbl_responsables
    SET
        dpi_responsable = dpi,
        nombre_responsable = nombre_padre,
        apellido_responsable = apellido_padre,
        codigo_parentezco = codigo_parentezco,
        telefono = telefono
    WHERE codigo_responsable = p_codigo_responsable;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `AsignarAlumno` (IN `p_codigo_ciclo` VARCHAR(15), IN `p_codigo_alumno` VARCHAR(15))   BEGIN
    INSERT INTO tbl_asignacion_alumno(codigo_ciclo, codigo_alumno) 
    VALUES (p_codigo_ciclo, p_codigo_alumno);
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `AsignarMateria` (IN `p_codigo_grado` VARCHAR(15), IN `p_codigo_materia` VARCHAR(15))   BEGIN
    INSERT INTO tbl_asignacion_materia(codigo_materia, codigo_grado) 
    VALUES (p_codigo_materia, p_codigo_grado);
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `HabilitarAlumno` (IN `p_id_alumno` INT)   BEGIN
    UPDATE tbl_alumnos
    SET estado = 1
    WHERE id_alumno = p_id_alumno;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `HabilitarCiclo` (IN `p_id_ciclo` INT)   BEGIN
    UPDATE tbl_ciclo
    SET estado = 1
    WHERE codigo_ciclo = p_id_ciclo;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `HabilitarMaestro` (IN `p_id_maestro` VARCHAR(15))   BEGIN
    UPDATE tbl_profesores
    SET estado = 1
    WHERE codigo_profesor = p_id_maestro;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `InhabilitarAlumno` (IN `p_id_alumno` INT)   BEGIN
    UPDATE tbl_alumnos
    SET estado = 0
    WHERE id_alumno = p_id_alumno;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `InhabilitarCiclo` (IN `p_id_ciclo` INT)   BEGIN
    UPDATE tbl_ciclo
    SET estado = 0
    WHERE codigo_ciclo = p_id_ciclo;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `InhabilitarMaestro` (IN `p_id_maestro` VARCHAR(15))   BEGIN
    UPDATE tbl_profesores
    SET estado = 0
    WHERE codigo_profesor = p_id_maestro;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `InsertarAlumno` (IN `p_codigo_alumno` VARCHAR(10), IN `p_nombre_alumno` VARCHAR(100), IN `p_apellido_alumno` VARCHAR(100), IN `p_fecha_nacimiento` DATE, IN `p_codigo_responsable` INT, IN `p_direccion` VARCHAR(255), IN `p_codigo_departamento` INT, IN `p_codigo_municipio` INT)   BEGIN
    INSERT INTO tbl_alumnos(codigo_alumno, nombre_alumno, apellido_alumno, fecha_nacimiento, codigo_responsable, direccion, codigo_departamento, codigo_municipio) 
    VALUES (p_codigo_alumno, p_nombre_alumno, p_apellido_alumno, p_fecha_nacimiento, p_codigo_responsable, p_direccion, p_codigo_departamento, p_codigo_municipio);
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `InsertarAsistencia` (IN `p_codigo_alumno` INT, IN `p_estado` INT)   BEGIN
    INSERT INTO tbl_asistencias(codigo_alumno, Estado) 
    VALUES (p_codigo_alumno, p_estado);
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `InsertarCiclos` (IN `p_codigo_grado` VARCHAR(15), IN `p_codigo_maestro` VARCHAR(15), IN `p_anio` VARCHAR(10), IN `p_seccion` VARCHAR(5))   BEGIN
    INSERT INTO tbl_ciclo(codigo_grado, codigo_profesor, anio, seccion) 
    VALUES (p_codigo_grado, p_codigo_maestro, p_anio,  p_seccion);
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `InsertarMaestros` (IN `p_codigo_maestro` VARCHAR(15), IN `p_nombre_maestro` VARCHAR(100), IN `p_apellido_maestro` VARCHAR(100), IN `p_telefono_maestro` VARCHAR(10), IN `p_fecha_nacimiento` DATE, IN `p_direccion` VARCHAR(255), IN `p_codigo_departamento` INT, IN `p_codigo_municipio` INT)   BEGIN
    INSERT INTO tbl_profesores(codigo_profesor, nombre_profesor, apellido_profesor, telefono_profesor, fecha_nacimiento, direccion, codigo_departamento, codigo_municipio) 
    VALUES (p_codigo_maestro, p_nombre_maestro, p_apellido_maestro, p_telefono_maestro,  p_fecha_nacimiento, p_direccion, p_codigo_departamento, p_codigo_municipio);
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `InsertarMateria` (IN `p_nombre_materia` VARCHAR(50))   BEGIN
    INSERT INTO tbl_Materias (nombre_materia)
    VALUES (p_nombre_materia);
    SELECT LAST_INSERT_ID() AS codigo_materia;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `InsertarResponsable` (IN `dpi` VARCHAR(12), IN `nombre_padre` VARCHAR(50), IN `apellido_padre` VARCHAR(50), IN `codigo_parentezco` INT, IN `telefono` VARCHAR(10))   BEGIN
    INSERT INTO tbl_responsables (dpi_responsable, nombre_responsable, apellido_responsable, codigo_parentezco, telefono)
    VALUES (dpi, nombre_padre, apellido_padre, codigo_parentezco, telefono);
    
    SELECT LAST_INSERT_ID() AS codigo_responsable;
END$$

CREATE DEFINER=`sade`@`localhost` PROCEDURE `InsertarTareas` (IN `p_tarea` VARCHAR(100), IN `p_descripcion` VARCHAR(100), IN `p_punteo` INT, IN `p_grado` INT, IN `p_materia` INT, IN `p_unidad` INT)   BEGIN
    INSERT INTO tbl_tareas(nombre_tarea, descripcion, punteo, codigo_ciclo, codigo_materia, unidad) 
    VALUES (p_tarea, p_descripcion, p_punteo, p_grado,  p_materia, p_unidad);
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calcular_edad` (`fecha_nacimiento` DATE) RETURNS INT(11)  BEGIN
    DECLARE edad INT;
    SET edad = TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE());
    RETURN edad;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `nextval` (`seq_name` VARCHAR(50)) RETURNS INT(11)  BEGIN
    DECLARE next_value INT;
    UPDATE sequence_table
    SET current_value = current_value + increment_by
    WHERE seq_name = seq_name;
    SELECT current_value INTO next_value
    FROM sequence_table
    WHERE seq_name = seq_name;
    RETURN next_value;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sequence_table`
--

CREATE TABLE `sequence_table` (
  `seq_name` varchar(50) NOT NULL,
  `current_value` int(11) NOT NULL,
  `increment_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_alumnos`
--

CREATE TABLE `tbl_alumnos` (
  `id_alumno` int(11) NOT NULL,
  `codigo_alumno` varchar(20) NOT NULL,
  `nombre_alumno` varchar(100) NOT NULL,
  `apellido_alumno` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `codigo_responsable` int(11) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `codigo_departamento` int(11) NOT NULL,
  `codigo_municipio` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_alumnos`
--

INSERT INTO `tbl_alumnos` (`id_alumno`, `codigo_alumno`, `nombre_alumno`, `apellido_alumno`, `fecha_nacimiento`, `codigo_responsable`, `direccion`, `codigo_departamento`, `codigo_municipio`, `estado`) VALUES
(1, '2820847031', 'Lester Jose', 'Flores Cruz', '1995-10-26', 20, 'San Jorge, Zacapa', 1, 2, 1),
(2, '1190207849', 'Carlos Andres', 'Leon Cruz', '2001-10-10', 3, 'El Jute', 1, 4, 1),
(10, '1234567894', 'Alexis', 'Prado', '2000-09-25', 11, 'Teculutan', 1, 3, 1),
(11, '4567891324', 'Luis', 'Carranza', '2010-09-10', 21, 'EL Jute', 1, 3, 1),
(12, '7894561234', 'Juan Luis', 'Perez Ortiz', '2017-09-15', 22, 'Colonia el Milagro', 1, 3, 1),
(13, '4567891324', 'prueba', 'prueba', '2024-10-19', 23, 'San Jorge Zacapa', 1, 2, 1);

--
-- Disparadores `tbl_alumnos`
--
DELIMITER $$
CREATE TRIGGER `after_alumno_update` AFTER UPDATE ON `tbl_alumnos` FOR EACH ROW BEGIN
    INSERT INTO tbl_audit (tabla, operacion, id_registro, fecha)
    VALUES ('tbl_alumnos', 'UPDATE', NEW.id_alumno, NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asignacion_alumno`
--

CREATE TABLE `tbl_asignacion_alumno` (
  `codigo_asignacion` int(11) NOT NULL,
  `codigo_ciclo` int(11) NOT NULL,
  `codigo_alumno` int(11) NOT NULL,
  `Estado` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_asignacion_alumno`
--

INSERT INTO `tbl_asignacion_alumno` (`codigo_asignacion`, `codigo_ciclo`, `codigo_alumno`, `Estado`) VALUES
(7, 12, 12, 'promovido'),
(8, 12, 1, 'promovido'),
(9, 13, 2, 'no promovido'),
(10, 13, 10, 'no promovido'),
(11, 13, 11, 'no promovido'),
(12, 12, 13, 'no promovido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asignacion_materia`
--

CREATE TABLE `tbl_asignacion_materia` (
  `codigo_asignacion_materia` int(11) NOT NULL,
  `codigo_materia` int(11) NOT NULL,
  `codigo_grado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_asignacion_materia`
--

INSERT INTO `tbl_asignacion_materia` (`codigo_asignacion_materia`, `codigo_materia`, `codigo_grado`) VALUES
(3, 1, 1),
(5, 4, 1),
(6, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_asistencias`
--

CREATE TABLE `tbl_asistencias` (
  `codigo_asistencia` int(11) NOT NULL,
  `codigo_alumno` int(11) NOT NULL,
  `fecha_asistencia` date NOT NULL DEFAULT current_timestamp(),
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_asistencias`
--

INSERT INTO `tbl_asistencias` (`codigo_asistencia`, `codigo_alumno`, `fecha_asistencia`, `Estado`) VALUES
(12, 12, '2024-10-18', 1),
(13, 1, '2024-10-18', 1),
(14, 2, '2024-10-18', 1),
(15, 10, '2024-10-18', 0),
(16, 11, '2024-10-18', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_audit`
--

CREATE TABLE `tbl_audit` (
  `id_audit` int(11) NOT NULL,
  `tabla` varchar(50) NOT NULL,
  `operacion` enum('INSERT','UPDATE','DELETE') NOT NULL,
  `id_registro` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_audit`
--

INSERT INTO `tbl_audit` (`id_audit`, `tabla`, `operacion`, `id_registro`, `fecha`) VALUES
(1, 'tbl_alumnos', 'UPDATE', 1, '2024-09-19 23:13:36'),
(2, 'tbl_alumnos', 'UPDATE', 1, '2024-09-19 23:14:32'),
(3, 'tbl_alumnos', 'UPDATE', 1, '2024-09-19 23:29:47'),
(4, 'tbl_alumnos', 'UPDATE', 1, '2024-09-19 23:30:45'),
(5, 'tbl_alumnos', 'UPDATE', 1, '2024-09-23 21:51:07'),
(6, 'tbl_alumnos', 'UPDATE', 1, '2024-09-23 22:02:21'),
(7, 'tbl_alumnos', 'UPDATE', 1, '2024-09-23 22:13:26'),
(8, 'tbl_alumnos', 'UPDATE', 1, '2024-09-23 22:14:05'),
(9, 'tbl_alumnos', 'UPDATE', 1, '2024-09-23 22:14:11'),
(10, 'tbl_alumnos', 'UPDATE', 2, '2024-09-23 22:30:26'),
(11, 'tbl_alumnos', 'UPDATE', 2, '2024-09-23 22:37:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_ciclo`
--

CREATE TABLE `tbl_ciclo` (
  `codigo_ciclo` int(11) NOT NULL,
  `codigo_grado` int(11) NOT NULL,
  `codigo_profesor` varchar(15) NOT NULL,
  `anio` int(11) NOT NULL,
  `seccion` varchar(5) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_ciclo`
--

INSERT INTO `tbl_ciclo` (`codigo_ciclo`, `codigo_grado`, `codigo_profesor`, `anio`, `seccion`, `estado`) VALUES
(7, 5, '1234567894561', 2024, 'A', 0),
(8, 1, '7894561234567', 2023, 'B', 0),
(9, 2, '1234567894561', 2022, 'A', 0),
(10, 1, '7894561234567', 2023, 'C', 0),
(11, 6, '1234567894561', 2024, 'A', 1),
(12, 1, '789124567892', 2024, 'A', 1),
(13, 2, '4567891234568', 2024, 'A', 1),
(14, 4, '1234567894561', 2024, 'A', 1),
(15, 1, '4567891324567', 2025, 'A', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_departamentos`
--

CREATE TABLE `tbl_departamentos` (
  `codigo_departamento` int(11) NOT NULL,
  `nombre_departamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_departamentos`
--

INSERT INTO `tbl_departamentos` (`codigo_departamento`, `nombre_departamento`) VALUES
(1, 'Zacapa'),
(2, 'Chiquimula');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_grados`
--

CREATE TABLE `tbl_grados` (
  `codigo_grado` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_grados`
--

INSERT INTO `tbl_grados` (`codigo_grado`, `descripcion`) VALUES
(1, 'Primero'),
(2, 'Segundo'),
(3, 'Tercero'),
(4, 'Cuarto'),
(5, 'Quinto'),
(6, 'Sexto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_materias`
--

CREATE TABLE `tbl_materias` (
  `codigo_materia` int(11) NOT NULL,
  `nombre_materia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_materias`
--

INSERT INTO `tbl_materias` (`codigo_materia`, `nombre_materia`) VALUES
(1, 'Matemáticas'),
(2, 'Comunicación y Lenguaje'),
(3, 'Ciencias Naturales'),
(4, 'Ciencias Sociales'),
(5, 'seminario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_municipios`
--

CREATE TABLE `tbl_municipios` (
  `codigo_municipio` int(11) NOT NULL,
  `nombre_municipio` varchar(50) NOT NULL,
  `codigo_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_municipios`
--

INSERT INTO `tbl_municipios` (`codigo_municipio`, `nombre_municipio`, `codigo_departamento`) VALUES
(2, 'San Jorge', 1),
(3, 'Teculutan', 1),
(4, 'Usumatlán', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_nota_tarea`
--

CREATE TABLE `tbl_nota_tarea` (
  `id_nota_tarea` int(11) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `punteo` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_nota_tarea`
--

INSERT INTO `tbl_nota_tarea` (`id_nota_tarea`, `id_tarea`, `id_alumno`, `punteo`) VALUES
(51, 6, 12, 10.00),
(52, 6, 1, 10.00),
(53, 7, 12, 5.00),
(54, 7, 1, 5.00),
(55, 8, 12, 5.00),
(56, 8, 1, 5.00),
(57, 9, 12, 5.00),
(58, 9, 1, 5.00),
(59, 10, 12, 10.00),
(60, 10, 1, 10.00),
(61, 11, 12, 10.00),
(62, 11, 1, 5.00),
(66, 12, 1, 10.00),
(67, 12, 12, 10.00),
(68, 12, 13, 10.00),
(69, 13, 1, 5.00),
(70, 13, 12, 5.00),
(71, 13, 13, 5.00),
(72, 14, 1, 5.00),
(73, 14, 12, 5.00),
(74, 14, 13, 5.00),
(76, 15, 1, 5.00),
(77, 15, 12, 5.00),
(78, 15, 13, 5.00),
(79, 16, 1, 5.00),
(80, 16, 12, 5.00),
(81, 16, 13, 5.00),
(82, 17, 1, 60.00),
(83, 17, 12, 60.00),
(84, 17, 13, 60.00),
(85, 18, 1, 60.00),
(86, 18, 12, 60.00),
(87, 18, 13, 60.00);

--
-- Disparadores `tbl_nota_tarea`
--
DELIMITER $$
CREATE TRIGGER `actualizar_promedio_nota_total` AFTER INSERT ON `tbl_nota_tarea` FOR EACH ROW BEGIN
    DECLARE suma_total DECIMAL(10,2) DEFAULT 0;  -- Inicializar en 0
    DECLARE cantidad_tareas INT DEFAULT 0;  -- Inicializar en 0
    DECLARE cantidad_materias INT DEFAULT 0;  -- Inicializar en 0
    DECLARE promedio DECIMAL(10,2) DEFAULT 0;  -- Inicializar en 0
    DECLARE codigos_materia INT;
    DECLARE ciclo INT;
    DECLARE unidad_tarea VARCHAR(255);
    DECLARE zona_total_anterior DECIMAL(10,2); -- Variable para almacenar el valor anterior de zona_total

    -- Obtener el código de materia, la unidad y el ciclo de la tarea correspondiente
    SELECT codigo_materia, unidad, codigo_ciclo 
    INTO codigos_materia, unidad_tarea, ciclo
    FROM tbl_tareas
    WHERE id_tarea = NEW.id_tarea;

    -- Sumar los punteos de las tareas del alumno en el ciclo actual
    SELECT SUM(nt.punteo), COUNT(*) 
    INTO suma_total, cantidad_tareas
    FROM tbl_nota_tarea nt
    JOIN tbl_tareas t ON nt.id_tarea = t.id_tarea
    WHERE nt.id_alumno = NEW.id_alumno
    AND t.codigo_materia = codigos_materia
      AND t.codigo_ciclo = ciclo
      AND t.unidad = unidad_tarea;

    -- Obtener la cantidad de materias asignadas al alumno
    SELECT COUNT(DISTINCT m.codigo_materia) 
    INTO cantidad_materias
    FROM tbl_asignacion_materia m
    JOIN tbl_ciclo c ON c.codigo_grado = m.codigo_grado
    WHERE c.codigo_ciclo = ciclo;  -- Asegúrate de usar el ciclo correcto

    -- Obtener el valor anterior de zona_total si existe
    SELECT zona_total INTO zona_total_anterior
    FROM tbl_nota_total
    WHERE codigo_materia = codigos_materia AND codigo_alumno = NEW.id_alumno AND Unidad = unidad_tarea
    LIMIT 1;

    -- Si hay un valor anterior, se actualiza, si no, se inserta
    IF zona_total_anterior IS NOT NULL THEN
        -- Actualizar el registro existente
        UPDATE tbl_nota_total
        SET zona_total = suma_total -- Sumar el nuevo total
        WHERE codigo_materia = codigos_materia AND codigo_alumno = NEW.id_alumno AND Unidad = unidad_tarea;
    ELSE
        -- Insertar el nuevo registro
        INSERT INTO tbl_nota_total (codigo_materia, codigo_alumno, unidad, codigo_ciclo, zona_total)
        VALUES (codigos_materia, NEW.id_alumno, unidad_tarea, ciclo, suma_total);
    END IF;
    
    -- Verificar si la zona_total es mayor o igual a 60
    IF suma_total >= 60 THEN
        UPDATE tbl_nota_total
        SET aprobado_no_aprobado = 'aprobado'
        WHERE codigo_materia = codigos_materia AND codigo_alumno = NEW.id_alumno AND Unidad = unidad_tarea;
    ELSE
        UPDATE tbl_nota_total
        SET aprobado_no_aprobado = 'no aprobado'
        WHERE codigo_materia = codigos_materia AND codigo_alumno = NEW.id_alumno AND Unidad = unidad_tarea;
    END IF;

    -- Calcular el nuevo promedio general por alumno
    SET promedio = (SELECT IFNULL(AVG(zona_total), 0)
                    FROM tbl_nota_total
                    WHERE codigo_alumno = NEW.id_alumno);

    -- Actualizar el promedio en tbl_nota_total
    UPDATE tbl_nota_total
    SET promedio = promedio
    WHERE codigo_alumno = NEW.id_alumno;

-- Verificar si el promedio es mayor o igual a 60
    IF promedio >= 60 THEN
        UPDATE tbl_asignacion_alumno
        SET Estado = 'promovido'
        WHERE codigo_alumno = NEW.id_alumno AND codigo_ciclo = ciclo;
    ELSE
        UPDATE tbl_asignacion_alumno
        SET Estado = 'no promovido'
        WHERE codigo_alumno = NEW.id_alumno AND codigo_ciclo = ciclo;
    END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_nota_total`
--

CREATE TABLE `tbl_nota_total` (
  `codigo_nota_total` int(11) NOT NULL,
  `codigo_materia` int(11) NOT NULL,
  `codigo_alumno` int(11) NOT NULL,
  `Unidad` int(11) NOT NULL,
  `codigo_ciclo` int(11) NOT NULL,
  `zona_total` float NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `promedio` float NOT NULL,
  `aprobado_no_aprobado` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_nota_total`
--

INSERT INTO `tbl_nota_total` (`codigo_nota_total`, `codigo_materia`, `codigo_alumno`, `Unidad`, `codigo_ciclo`, `zona_total`, `estado`, `promedio`, `aprobado_no_aprobado`) VALUES
(11, 4, 12, 1, 12, 75, 1, 65, 'aprobado'),
(12, 4, 1, 1, 12, 75, 1, 63.33, 'aprobado'),
(13, 1, 12, 1, 12, 60, 1, 65, 'aprobado'),
(14, 1, 1, 1, 12, 55, 1, 63.33, 'no aprobado'),
(15, 1, 13, 1, 12, 30, 1, 50, 'no aprobado'),
(16, 1, 1, 2, 12, 60, 1, 63.33, 'aprobado'),
(17, 1, 12, 2, 12, 60, 1, 65, 'aprobado'),
(18, 1, 13, 2, 12, 60, 1, 50, 'aprobado'),
(19, 4, 13, 1, 12, 60, 1, 50, 'aprobado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_parentezco`
--

CREATE TABLE `tbl_parentezco` (
  `codigo_parentezco` int(11) NOT NULL,
  `nombre_parentezco` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_parentezco`
--

INSERT INTO `tbl_parentezco` (`codigo_parentezco`, `nombre_parentezco`) VALUES
(1, 'Padre'),
(2, 'Madre'),
(3, 'Tía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_profesores`
--

CREATE TABLE `tbl_profesores` (
  `codigo_profesor` varchar(15) NOT NULL,
  `nombre_profesor` varchar(100) NOT NULL,
  `apellido_profesor` varchar(100) NOT NULL,
  `telefono_profesor` varchar(10) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `codigo_departamento` int(11) NOT NULL,
  `codigo_municipio` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_profesores`
--

INSERT INTO `tbl_profesores` (`codigo_profesor`, `nombre_profesor`, `apellido_profesor`, `telefono_profesor`, `fecha_nacimiento`, `direccion`, `codigo_departamento`, `codigo_municipio`, `estado`) VALUES
('1234567894561', 'Carlos Andres', 'Cruz', '45678912', '1999-12-10', 'Colonia el Milagro', 1, 3, 1),
('4567891234568', 'Albin Miguel', 'Palma Cano', '37028945', '2002-02-17', 'Colonia el Milagro', 1, 3, 1),
('4567891324567', 'prueba', 'prueba', '37562027', '2024-06-04', 'Barrio Santa Rosita, San Jorge, Zacapa', 1, 3, 1),
('789124567892', 'Dilma', 'Perdomo', '45678912', '1990-10-26', 'Colonia el Milagro', 1, 3, 1),
('7894561234567', 'Jorge Luis', 'Flores Cruz', '49067054', '1990-04-30', 'Barrio Santa Rosita', 1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_responsables`
--

CREATE TABLE `tbl_responsables` (
  `codigo_responsable` int(11) NOT NULL,
  `dpi_responsable` varchar(13) NOT NULL,
  `nombre_responsable` varchar(100) NOT NULL,
  `apellido_responsable` varchar(100) NOT NULL,
  `codigo_parentezco` int(11) NOT NULL,
  `telefono` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_responsables`
--

INSERT INTO `tbl_responsables` (`codigo_responsable`, `dpi_responsable`, `nombre_responsable`, `apellido_responsable`, `codigo_parentezco`, `telefono`) VALUES
(1, '1234567891231', 'Luis', 'Flores', 1, '49585456'),
(3, '789456123789', 'Juan', 'Leon', 1, '45781249'),
(5, '456789123456', 'Mario', 'Prado', 1, '45678912'),
(10, '456789123456', 'Mario', 'Prado', 1, '45678912'),
(11, '789456123789', 'Mario', 'Prado', 1, '45678945'),
(19, '254682647913', 'Maritza', 'Cruz', 2, '49585456'),
(20, '280456215641', 'Maritza', 'Cruz', 2, '49585456'),
(21, '456789123456', 'Jorge', 'Prado', 1, '78945612'),
(22, '456789154796', 'Ada Margot', 'Gonzales', 2, '78945614'),
(23, '282084703190', 'Maritza', 'Flores', 3, '45678923');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tareas`
--

CREATE TABLE `tbl_tareas` (
  `id_tarea` int(11) NOT NULL,
  `nombre_tarea` varchar(100) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `punteo` int(11) NOT NULL,
  `codigo_ciclo` int(11) NOT NULL,
  `codigo_materia` int(11) NOT NULL,
  `unidad` varchar(10) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_tareas`
--

INSERT INTO `tbl_tareas` (`id_tarea`, `nombre_tarea`, `descripcion`, `punteo`, `codigo_ciclo`, `codigo_materia`, `unidad`, `estado`) VALUES
(6, 'Protocolos de Mantenimiento', 'Realizar una Investigacion, pasar a exponer', 0, 12, 4, '1', 0),
(7, 'sumas', 'Realizar las sumas', 0, 12, 1, '1', 0),
(8, 'Multiplicacion', 'hacer multiplicaciones', 0, 12, 1, '1', 0),
(9, 'cuerpo humano', 'investigar y exponer sobre el cuerpo humano', 0, 12, 4, '1', 0),
(10, 'division', 'dividir las cantidades', 0, 12, 1, '1', 0),
(11, 'Multiplicacion', 'hacer multiplicaciones', 0, 12, 1, '1', 0),
(12, 'sumas', 'Realizar las sumas', 10, 12, 1, '1', 0),
(13, 'divisiones', 'realizar las divisiones', 5, 12, 1, '1', 0),
(14, 'sumas y restas', 'realiza las operaciones', 10, 12, 1, '1', 0),
(15, 'Multiplicacion', 'hacer multiplicaciones', 5, 12, 1, '1', 0),
(16, 'restas', 'hacer las restas', 5, 12, 1, '1', 0),
(17, 'Protocolos de Mantenimiento', 'Realizar una Investigacion, pasar a exponer', 60, 12, 1, '2', 0),
(18, 'sumas', 'Realizar las sumas', 60, 12, 4, '1', 0),
(19, 'Multiplicacion', 'hacer multiplicaciones', 5, 12, 1, '3', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `codigo_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `contrasena` varchar(200) NOT NULL,
  `estado` int(11) NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`codigo_usuario`, `nombre_usuario`, `correo_electronico`, `contrasena`, `estado`, `rol`) VALUES
(1, 'Carlos Andrés León Cruz', 'candresleon7.1@gmail.com', '$2y$10$pBqTtvXemWGa.VOAaOfMKOcuTW27fIKm4QDm7OYhxx9rFoLdAIdq.', 1, 1),
(2, 'Lester Jose Flores Cruz', 'lestercruz13@gmail.com', '$2y$10$92vd0X3z3nilQugnCdXsnOLTCzFHmq3izCTYCPQhzOp61k0WdS6m2', 1, 2),
(3, 'Rafael Vinicio Zamora', 'rafaelrafa@gmail.com', '$2y$10$pkxs7jgb84lqOuI2vf9Cp.Xf5.a/U6sZFTCssjJmHu2g..5eKncJO', 1, 2),
(4, 'Juan Posadas', 'juan@gmail.com', '$2y$10$5IiE0V8Bsrr2Isw0aCmMT.x2jDQcvISzERg9lJV7xczHvr.mMnCA.', 1, 2),
(5, 'Dilma Perdomo', 'dilma.perdomo@gmail.com', '$2y$10$AxGSzYIcV7xmPRINUzLp0.Oa.zYtWkMc8ISI6U3oJf8JnopP4v5oW', 1, 2),
(6, 'Lester Flores', 'lflores@gmail.com', '$2y$10$.HVL7nV.ntuZ6JDPysL7Nugc6/NWwZ4QIHdshujPKAq1EhIAflndm', 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sequence_table`
--
ALTER TABLE `sequence_table`
  ADD PRIMARY KEY (`seq_name`);

--
-- Indices de la tabla `tbl_alumnos`
--
ALTER TABLE `tbl_alumnos`
  ADD PRIMARY KEY (`id_alumno`),
  ADD KEY `fk_departamento_alumno` (`codigo_departamento`),
  ADD KEY `fk_municipio_alumno` (`codigo_municipio`),
  ADD KEY `fk_responsable_alumno` (`codigo_responsable`);

--
-- Indices de la tabla `tbl_asignacion_alumno`
--
ALTER TABLE `tbl_asignacion_alumno`
  ADD PRIMARY KEY (`codigo_asignacion`),
  ADD KEY `fk_asignacion_ciclo` (`codigo_ciclo`),
  ADD KEY `fk_asignacion_alumno` (`codigo_alumno`);

--
-- Indices de la tabla `tbl_asignacion_materia`
--
ALTER TABLE `tbl_asignacion_materia`
  ADD PRIMARY KEY (`codigo_asignacion_materia`),
  ADD KEY `fk_asignacion_materia` (`codigo_materia`),
  ADD KEY `fk_asignacion_grado` (`codigo_grado`);

--
-- Indices de la tabla `tbl_asistencias`
--
ALTER TABLE `tbl_asistencias`
  ADD PRIMARY KEY (`codigo_asistencia`),
  ADD KEY `fk_alumno_asistencia` (`codigo_alumno`);

--
-- Indices de la tabla `tbl_audit`
--
ALTER TABLE `tbl_audit`
  ADD PRIMARY KEY (`id_audit`);

--
-- Indices de la tabla `tbl_ciclo`
--
ALTER TABLE `tbl_ciclo`
  ADD PRIMARY KEY (`codigo_ciclo`),
  ADD KEY `fk_asignacion_grado_alumno` (`codigo_grado`),
  ADD KEY `fk_asignacion_profesor` (`codigo_profesor`);

--
-- Indices de la tabla `tbl_departamentos`
--
ALTER TABLE `tbl_departamentos`
  ADD PRIMARY KEY (`codigo_departamento`);

--
-- Indices de la tabla `tbl_grados`
--
ALTER TABLE `tbl_grados`
  ADD PRIMARY KEY (`codigo_grado`);

--
-- Indices de la tabla `tbl_materias`
--
ALTER TABLE `tbl_materias`
  ADD PRIMARY KEY (`codigo_materia`);

--
-- Indices de la tabla `tbl_municipios`
--
ALTER TABLE `tbl_municipios`
  ADD PRIMARY KEY (`codigo_municipio`);

--
-- Indices de la tabla `tbl_nota_tarea`
--
ALTER TABLE `tbl_nota_tarea`
  ADD PRIMARY KEY (`id_nota_tarea`);

--
-- Indices de la tabla `tbl_nota_total`
--
ALTER TABLE `tbl_nota_total`
  ADD PRIMARY KEY (`codigo_nota_total`),
  ADD KEY `fk_nota_ciclo` (`codigo_ciclo`),
  ADD KEY `fk_nota_alumno` (`codigo_alumno`),
  ADD KEY `fk_nota_materia` (`codigo_materia`);

--
-- Indices de la tabla `tbl_parentezco`
--
ALTER TABLE `tbl_parentezco`
  ADD PRIMARY KEY (`codigo_parentezco`);

--
-- Indices de la tabla `tbl_profesores`
--
ALTER TABLE `tbl_profesores`
  ADD PRIMARY KEY (`codigo_profesor`),
  ADD KEY `fk_departamento_profesor` (`codigo_departamento`),
  ADD KEY `fk_municipio_profesor` (`codigo_municipio`);

--
-- Indices de la tabla `tbl_responsables`
--
ALTER TABLE `tbl_responsables`
  ADD PRIMARY KEY (`codigo_responsable`),
  ADD KEY `fk_parentezco_responsable` (`codigo_parentezco`);

--
-- Indices de la tabla `tbl_tareas`
--
ALTER TABLE `tbl_tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `fk_notas_matera` (`codigo_materia`),
  ADD KEY `fk_notas_grado` (`codigo_ciclo`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`codigo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_alumnos`
--
ALTER TABLE `tbl_alumnos`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tbl_asignacion_alumno`
--
ALTER TABLE `tbl_asignacion_alumno`
  MODIFY `codigo_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tbl_asignacion_materia`
--
ALTER TABLE `tbl_asignacion_materia`
  MODIFY `codigo_asignacion_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_asistencias`
--
ALTER TABLE `tbl_asistencias`
  MODIFY `codigo_asistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `tbl_audit`
--
ALTER TABLE `tbl_audit`
  MODIFY `id_audit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tbl_ciclo`
--
ALTER TABLE `tbl_ciclo`
  MODIFY `codigo_ciclo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tbl_departamentos`
--
ALTER TABLE `tbl_departamentos`
  MODIFY `codigo_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_grados`
--
ALTER TABLE `tbl_grados`
  MODIFY `codigo_grado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tbl_materias`
--
ALTER TABLE `tbl_materias`
  MODIFY `codigo_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_municipios`
--
ALTER TABLE `tbl_municipios`
  MODIFY `codigo_municipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_nota_tarea`
--
ALTER TABLE `tbl_nota_tarea`
  MODIFY `id_nota_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `tbl_nota_total`
--
ALTER TABLE `tbl_nota_total`
  MODIFY `codigo_nota_total` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tbl_parentezco`
--
ALTER TABLE `tbl_parentezco`
  MODIFY `codigo_parentezco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tbl_responsables`
--
ALTER TABLE `tbl_responsables`
  MODIFY `codigo_responsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `tbl_tareas`
--
ALTER TABLE `tbl_tareas`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `codigo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_alumnos`
--
ALTER TABLE `tbl_alumnos`
  ADD CONSTRAINT `fk_departamento_alumno` FOREIGN KEY (`codigo_departamento`) REFERENCES `tbl_departamentos` (`codigo_departamento`),
  ADD CONSTRAINT `fk_municipio_alumno` FOREIGN KEY (`codigo_municipio`) REFERENCES `tbl_municipios` (`codigo_municipio`),
  ADD CONSTRAINT `fk_responsable_alumno` FOREIGN KEY (`codigo_responsable`) REFERENCES `tbl_responsables` (`codigo_responsable`);

--
-- Filtros para la tabla `tbl_asignacion_alumno`
--
ALTER TABLE `tbl_asignacion_alumno`
  ADD CONSTRAINT `fk_asignacion_alumno` FOREIGN KEY (`codigo_alumno`) REFERENCES `tbl_alumnos` (`id_alumno`),
  ADD CONSTRAINT `fk_asignacion_ciclo` FOREIGN KEY (`codigo_ciclo`) REFERENCES `tbl_ciclo` (`codigo_ciclo`);

--
-- Filtros para la tabla `tbl_asignacion_materia`
--
ALTER TABLE `tbl_asignacion_materia`
  ADD CONSTRAINT `fk_asignacion_grado` FOREIGN KEY (`codigo_grado`) REFERENCES `tbl_grados` (`codigo_grado`),
  ADD CONSTRAINT `fk_asignacion_materia` FOREIGN KEY (`codigo_materia`) REFERENCES `tbl_materias` (`codigo_materia`);

--
-- Filtros para la tabla `tbl_asistencias`
--
ALTER TABLE `tbl_asistencias`
  ADD CONSTRAINT `fk_alumno_asistencia` FOREIGN KEY (`codigo_alumno`) REFERENCES `tbl_alumnos` (`id_alumno`);

--
-- Filtros para la tabla `tbl_ciclo`
--
ALTER TABLE `tbl_ciclo`
  ADD CONSTRAINT `fk_asignacion_grado_alumno` FOREIGN KEY (`codigo_grado`) REFERENCES `tbl_grados` (`codigo_grado`),
  ADD CONSTRAINT `fk_asignacion_profesor` FOREIGN KEY (`codigo_profesor`) REFERENCES `tbl_profesores` (`codigo_profesor`);

--
-- Filtros para la tabla `tbl_nota_total`
--
ALTER TABLE `tbl_nota_total`
  ADD CONSTRAINT `fk_nota_alumno` FOREIGN KEY (`codigo_alumno`) REFERENCES `tbl_alumnos` (`id_alumno`),
  ADD CONSTRAINT `fk_nota_ciclo` FOREIGN KEY (`codigo_ciclo`) REFERENCES `tbl_ciclo` (`codigo_ciclo`),
  ADD CONSTRAINT `fk_nota_materia` FOREIGN KEY (`codigo_materia`) REFERENCES `tbl_materias` (`codigo_materia`);

--
-- Filtros para la tabla `tbl_profesores`
--
ALTER TABLE `tbl_profesores`
  ADD CONSTRAINT `fk_departamento_profesor` FOREIGN KEY (`codigo_departamento`) REFERENCES `tbl_departamentos` (`codigo_departamento`),
  ADD CONSTRAINT `fk_municipio_profesor` FOREIGN KEY (`codigo_municipio`) REFERENCES `tbl_municipios` (`codigo_municipio`);

--
-- Filtros para la tabla `tbl_responsables`
--
ALTER TABLE `tbl_responsables`
  ADD CONSTRAINT `fk_parentezco_responsable` FOREIGN KEY (`codigo_parentezco`) REFERENCES `tbl_parentezco` (`codigo_parentezco`);

--
-- Filtros para la tabla `tbl_tareas`
--
ALTER TABLE `tbl_tareas`
  ADD CONSTRAINT `fk_notas_grado` FOREIGN KEY (`codigo_ciclo`) REFERENCES `tbl_ciclo` (`codigo_ciclo`),
  ADD CONSTRAINT `fk_notas_matera` FOREIGN KEY (`codigo_materia`) REFERENCES `tbl_materias` (`codigo_materia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
