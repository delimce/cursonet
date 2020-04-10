/*
 Navicat Premium Data Transfer

 Source Server         : LOCAL
 Source Server Type    : MySQL
 Source Server Version : 50729
 Source Host           : localhost:3306
 Source Schema         : cursonet_db

 Target Server Type    : MySQL
 Target Server Version : 50729
 File Encoding         : 65001

 Date: 10/04/2020 00:24:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_admin
-- ----------------------------
DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE `tbl_admin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ' ',
  `apellido` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ' ',
  `foto` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'foto del profesor/administrador',
  `user` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `pass` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `es_admin` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `email` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ' ',
  `telefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `fax` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fecha` datetime(0) NOT NULL,
  `sintesis` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'sistesis o CV',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user`(`user`) USING BTREE,
  INDEX `admin`(`es_admin`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de administradores y profesores\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_admin_curso
-- ----------------------------
DROP TABLE IF EXISTS `tbl_admin_curso`;
CREATE TABLE `tbl_admin_curso`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `curso_id` int(11) UNSIGNED NOT NULL,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_id`(`admin_id`) USING BTREE,
  INDEX `curso_id`(`curso_id`) USING BTREE,
  CONSTRAINT `tbl_admin_curso_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `tbl_admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_admin_curso_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `tbl_curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_cartelera
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cartelera`;
CREATE TABLE `tbl_cartelera`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curso_id` int(10) UNSIGNED NOT NULL,
  `grupo_id` smallint(6) UNSIGNED NOT NULL DEFAULT 0,
  `mensaje` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `fecha_c` datetime(0) NOT NULL COMMENT 'fecha de creado el mensaje',
  `destaca` tinyint(1) NULL DEFAULT 0 COMMENT 'si el mensaje destaca',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `curso_id`(`curso_id`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  CONSTRAINT `cartelera_fk` FOREIGN KEY (`curso_id`) REFERENCES `tbl_curso` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'mensajes en la cartelera para las secciones' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_contenido
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contenido`;
CREATE TABLE `tbl_contenido`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `curso_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `autor` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'id del autor del tema',
  `titulo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `contenido` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `borrador` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'si es un borrador  o no',
  `fecha` datetime(0) NOT NULL,
  `leido` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'cantidad de veces leido',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  INDEX `fecha`(`fecha`) USING BTREE,
  INDEX `curso_id`(`curso_id`) USING BTREE,
  CONSTRAINT `contenido_fk` FOREIGN KEY (`curso_id`) REFERENCES `tbl_curso` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 76 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de contenidos x curso\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_contenido_grupo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contenido_grupo`;
CREATE TABLE `tbl_contenido_grupo`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `contenido_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `grupo_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `content`(`contenido_id`) USING BTREE,
  INDEX `grupo`(`grupo_id`) USING BTREE,
  CONSTRAINT `FK_contenido_grupo_1` FOREIGN KEY (`contenido_id`) REFERENCES `tbl_contenido` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_contenido_grupo_fk` FOREIGN KEY (`grupo_id`) REFERENCES `tbl_grupo` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'relacion contenidos por grupo' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_contenido_recurso
-- ----------------------------
DROP TABLE IF EXISTS `tbl_contenido_recurso`;
CREATE TABLE `tbl_contenido_recurso`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `contenido_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'id del registro del contenido',
  `recurso_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'id del registro del archivo',
  `tipo` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contenido_id`(`contenido_id`) USING BTREE,
  INDEX `recurso_id`(`recurso_id`) USING BTREE,
  CONSTRAINT `tbl_contenido_recurso_fk` FOREIGN KEY (`contenido_id`) REFERENCES `tbl_contenido` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `tbl_contenido_recurso_fk1` FOREIGN KEY (`recurso_id`) REFERENCES `tbl_recurso` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 823 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de recursos x contenidos\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_curso
-- ----------------------------
DROP TABLE IF EXISTS `tbl_curso`;
CREATE TABLE `tbl_curso`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `alias` varchar(22) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'nombre corto del curso',
  `fecha_creado` datetime(0) NOT NULL,
  `duracion` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'tiempo q dura',
  `descripcion` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `resp` int(10) UNSIGNED NULL DEFAULT NULL,
  `notas` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `alias`(`alias`) USING BTREE,
  INDEX `tbl_curso_resp_foreign`(`resp`) USING BTREE,
  CONSTRAINT `tbl_curso_resp_foreign` FOREIGN KEY (`resp`) REFERENCES `tbl_admin` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla con la informacion de los cursos (materias a dictar)\r\n' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_equipo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_equipo`;
CREATE TABLE `tbl_equipo`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `grupo_id` int(10) UNSIGNED NOT NULL COMMENT 'id del grupo',
  `nombre` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'nombre del equipo',
  `descripcion` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  CONSTRAINT `tbl_equipo_fk` FOREIGN KEY (`grupo_id`) REFERENCES `tbl_grupo` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de equipos de secciones para proy y foros' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_equipo_estudiante
-- ----------------------------
DROP TABLE IF EXISTS `tbl_equipo_estudiante`;
CREATE TABLE `tbl_equipo_estudiante`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipo_id` int(10) UNSIGNED NOT NULL,
  `est_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `equipo_id`, `est_id`) USING BTREE,
  INDEX `equipo_id`(`equipo_id`) USING BTREE,
  INDEX `est_id`(`est_id`) USING BTREE,
  CONSTRAINT `tbl_equipo_estudiante_fk` FOREIGN KEY (`equipo_id`) REFERENCES `tbl_equipo` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `tbl_equipo_estudiante_fk1` FOREIGN KEY (`est_id`) REFERENCES `tbl_estudiante` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla que asocia un estudiante a un equipo' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_estudiante
-- ----------------------------
DROP TABLE IF EXISTS `tbl_estudiante`;
CREATE TABLE `tbl_estudiante`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_number` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `apellido` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `foto` longblob NULL COMMENT 'foto del estudiante',
  `sexo` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `fecha_nac` date NULL DEFAULT NULL,
  `telefono_p` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `telefono_c` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `email` varchar(55) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `msn` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `twitter` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `carrera` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `nivel` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `universidad` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `internet_acc` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NO',
  `internet_zona` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'NINGUNA',
  `user` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `pass` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `fecha_creado` datetime(0) NOT NULL,
  `activo` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `clave_preg` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ' ' COMMENT 'pregunta para recordar clave de alumno',
  `clave_resp` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ' ' COMMENT 'respuesta para recordar clave de alumno',
  `share_info` tinyint(1) NOT NULL DEFAULT 1,
  `notify_msg` tinyint(1) NOT NULL DEFAULT 0,
  `notify_forum` tinyint(1) NOT NULL DEFAULT 0,
  `notify_exam` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'token para micro servicios',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id_number`(`id_number`) USING BTREE,
  INDEX `activo`(`activo`) USING BTREE,
  INDEX `user`(`user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 487 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de estudiantes de los cursos' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_evaluacion
-- ----------------------------
DROP TABLE IF EXISTS `tbl_evaluacion`;
CREATE TABLE `tbl_evaluacion`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `autor` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nombre` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `curso_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `contenido_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `grupo_id` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `fecha` datetime(0) NOT NULL,
  `fecha_fin` datetime(0) NOT NULL,
  `npreg` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'nro de preguntas',
  `tipo` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 seleccion, 2 desarrollo',
  `nivel` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 whatever, 1 easy, 2 normal, 3 hard',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `contenido`(`contenido_id`) USING BTREE,
  INDEX `curso_grupo`(`curso_id`, `grupo_id`) USING BTREE,
  CONSTRAINT `evaluacion_fk` FOREIGN KEY (`contenido_id`) REFERENCES `tbl_contenido` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'tabla de evaluaciones' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_evaluacion_estudiante
-- ----------------------------
DROP TABLE IF EXISTS `tbl_evaluacion_estudiante`;
CREATE TABLE `tbl_evaluacion_estudiante`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `est_id` int(10) UNSIGNED NOT NULL,
  `eval_id` int(10) UNSIGNED NOT NULL,
  `nota` float(5, 2) NOT NULL DEFAULT -1.00,
  `correccion` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'comentario del profesor',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `est_id`(`est_id`) USING BTREE,
  INDEX `eval_id`(`eval_id`) USING BTREE,
  CONSTRAINT `evaluacion_estudiante_fk` FOREIGN KEY (`est_id`) REFERENCES `tbl_estudiante` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `evaluacion_estudiante_fk1` FOREIGN KEY (`eval_id`) REFERENCES `tbl_evaluacion` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de notas de los estudiantes x evaluacion\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_evaluacion_pregunta
-- ----------------------------
DROP TABLE IF EXISTS `tbl_evaluacion_pregunta`;
CREATE TABLE `tbl_evaluacion_pregunta`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `curso_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `eval_id` int(10) UNSIGNED NULL DEFAULT 0,
  `tipo` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 des, 1 seleccion',
  `pregunta` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nivel` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'nivel de complejidad, para el caso de las preguntas tipo seleccion',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `evaluacion`(`eval_id`) USING BTREE,
  INDEX `tipo`(`tipo`, `nivel`) USING BTREE,
  CONSTRAINT `FK_evaluacion_preguntas_1` FOREIGN KEY (`eval_id`) REFERENCES `tbl_evaluacion` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'InnoDB free: 10240 kB; (`eval_id`) REFER `cursonet/evaluacio' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_evaluacion_respuesta
-- ----------------------------
DROP TABLE IF EXISTS `tbl_evaluacion_respuesta`;
CREATE TABLE `tbl_evaluacion_respuesta`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `est_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `preg_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `respuesta` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pregunta`(`est_id`) USING BTREE,
  INDEX `estudiante`(`preg_id`) USING BTREE,
  CONSTRAINT `evaluacion_respuesta_fk` FOREIGN KEY (`est_id`) REFERENCES `tbl_estudiante` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `evaluacion_respuesta_fk1` FOREIGN KEY (`preg_id`) REFERENCES `tbl_evaluacion_pregunta` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'tabla de respuestas de los estudiantes por evaluacion\r\nrevis' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_evaluacion_respuesta_s
-- ----------------------------
DROP TABLE IF EXISTS `tbl_evaluacion_respuesta_s`;
CREATE TABLE `tbl_evaluacion_respuesta_s`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `est_id` int(10) UNSIGNED NOT NULL,
  `preg_id` int(10) UNSIGNED NOT NULL,
  `resp_opc` int(11) NOT NULL COMMENT 'opcion de la respuesta que contesto el estudiante',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `est_id`(`est_id`) USING BTREE,
  INDEX `preg_id`(`preg_id`) USING BTREE,
  CONSTRAINT `evaluacion_respuesta_s_fk` FOREIGN KEY (`est_id`) REFERENCES `tbl_estudiante` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `evaluacion_respuesta_s_fk1` FOREIGN KEY (`preg_id`) REFERENCES `tbl_evaluacion_pregunta` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_feedback
-- ----------------------------
DROP TABLE IF EXISTS `tbl_feedback`;
CREATE TABLE `tbl_feedback`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(125) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'nombre completo',
  `perfil` enum('est','admin') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'est' COMMENT 'est o admin',
  `email` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `tipo_com` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 general, 2 sugerencia, 3 bug',
  `comentario` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'el comentario',
  `pro` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'pros de la herramienta',
  `contra` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'contras de la herramienta',
  `suject_extra_info` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'informacion extra del sujeto',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  INDEX `perfil`(`perfil`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de comentarios,mejoras, sugerencias o felicitaciones d' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_foro
-- ----------------------------
DROP TABLE IF EXISTS `tbl_foro`;
CREATE TABLE `tbl_foro`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `autor` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `curso_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `contenido_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `grupo_id` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `equipo_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `titulo` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `resumen` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL COMMENT 'breve resumen si se desea',
  `content` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `fecha_post` datetime(0) NOT NULL,
  `fecha_fin` datetime(0) NOT NULL COMMENT 'fecha en que termina el tiempo para hacer post',
  `leido` smallint(6) NOT NULL DEFAULT 0 COMMENT 'campo para determinar los comentarios nuevos, por defecto el numero total de comentarios cuando se abre el foro',
  `nota` smallint(6) NOT NULL DEFAULT 0 COMMENT 'porcentaje si es 0 no es evaluado',
  `corregido` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 falta por evaluar, 1 evaluado',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  INDEX `contenido_id`(`contenido_id`) USING BTREE,
  INDEX `curso_id`(`curso_id`) USING BTREE,
  CONSTRAINT `tbl_foro_ibfk_1` FOREIGN KEY (`contenido_id`) REFERENCES `tbl_contenido` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'tabla de foros\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_foro_comentario
-- ----------------------------
DROP TABLE IF EXISTS `tbl_foro_comentario`;
CREATE TABLE `tbl_foro_comentario`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foro_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `tipo_sujeto` enum('admin','est') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'est' COMMENT 'si responde un estudiante o un admin',
  `sujeto_id` int(10) UNSIGNED NOT NULL,
  `content` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `fecha_post` datetime(0) NOT NULL,
  `valido` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'si es 0 no ha sido evaluado, 1 fue aceptado',
  `response` int(11) NOT NULL DEFAULT 0 COMMENT 'para saber si el coment es resp de otro post',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sujeto`(`tipo_sujeto`, `sujeto_id`) USING BTREE,
  INDEX `foro_id`(`foro_id`) USING BTREE,
  CONSTRAINT `foro_comentario_fk` FOREIGN KEY (`foro_id`) REFERENCES `tbl_foro` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1267 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'tabla de comentarios x foro' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_foro_comentario_like
-- ----------------------------
DROP TABLE IF EXISTS `tbl_foro_comentario_like`;
CREATE TABLE `tbl_foro_comentario_like`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario_id` int(11) NOT NULL,
  `tipo_sujeto` enum('admin','est') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'est' COMMENT 'si responde un estudiante o un admin',
  `sujeto_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `comentario_id`(`comentario_id`) USING BTREE,
  INDEX `tipo_sujeto`(`tipo_sujeto`, `sujeto_id`) USING BTREE,
  CONSTRAINT `tbl_foro_comentario_like_ibfk_1` FOREIGN KEY (`comentario_id`) REFERENCES `tbl_foro_comentario` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 176 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_foro_estudiante
-- ----------------------------
DROP TABLE IF EXISTS `tbl_foro_estudiante`;
CREATE TABLE `tbl_foro_estudiante`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'tabla que guarda la nota del estudiante en el foro',
  `est_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `foro_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `nota` float(6, 3) NOT NULL DEFAULT -1.000,
  `correccion` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL COMMENT 'descripcion de la correccion',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `est_id`(`est_id`) USING BTREE,
  INDEX `foro_id`(`foro_id`) USING BTREE,
  CONSTRAINT `foro_estudiante_fk` FOREIGN KEY (`est_id`) REFERENCES `tbl_estudiante` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `foro_estudiante_fk1` FOREIGN KEY (`foro_id`) REFERENCES `tbl_foro` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 69 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_foro_respuesta
-- ----------------------------
DROP TABLE IF EXISTS `tbl_foro_respuesta`;
CREATE TABLE `tbl_foro_respuesta`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `comentario_id` int(11) NOT NULL DEFAULT 0,
  `tipo_sujeto` enum('admin','est') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'est' COMMENT 'si responde un estudiante o un admin',
  `sujeto_id` int(10) NOT NULL COMMENT 'id del profesor que responde',
  `content` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `com_id`(`comentario_id`) USING BTREE,
  INDEX `tipo_sujeto`(`tipo_sujeto`, `sujeto_id`) USING BTREE,
  CONSTRAINT `tbl_foro_respuesta_ibfk_1` FOREIGN KEY (`comentario_id`) REFERENCES `tbl_foro_comentario` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 613 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'las respuesta que hace el profesor a los comentarios en el f' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_grupo
-- ----------------------------
DROP TABLE IF EXISTS `tbl_grupo`;
CREATE TABLE `tbl_grupo`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `curso_id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT ' ',
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `prof_id` int(11) UNSIGNED NULL DEFAULT NULL COMMENT 'profesor responsable',
  `turno` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 presencial, 1 semi p, 2 a distancia',
  `fecha_creado` datetime(0) NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fecha`(`fecha_creado`) USING BTREE,
  INDEX `curso_id`(`curso_id`) USING BTREE,
  INDEX `prof_id`(`prof_id`) USING BTREE,
  CONSTRAINT `tbl_grupo_fk` FOREIGN KEY (`curso_id`) REFERENCES `tbl_curso` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `tbl_grupo_ibfk_1` FOREIGN KEY (`prof_id`) REFERENCES `tbl_admin` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de grupos o secciones\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_grupo_estudiante
-- ----------------------------
DROP TABLE IF EXISTS `tbl_grupo_estudiante`;
CREATE TABLE `tbl_grupo_estudiante`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `curso_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `est_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `grupo_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `curso_id`(`curso_id`) USING BTREE,
  INDEX `est_id`(`est_id`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  CONSTRAINT `grupo_estudiante_fk` FOREIGN KEY (`curso_id`) REFERENCES `tbl_curso` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `grupo_estudiante_fk1` FOREIGN KEY (`est_id`) REFERENCES `tbl_estudiante` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `tbl_grupo_estudiante_fk` FOREIGN KEY (`grupo_id`) REFERENCES `tbl_grupo` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 218 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_log_admin
-- ----------------------------
DROP TABLE IF EXISTS `tbl_log_admin`;
CREATE TABLE `tbl_log_admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `fecha_in` datetime(0) NOT NULL COMMENT 'fecha en que accede',
  `ip_acc` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ip de donde accede',
  `info_cliente` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'informacion sobre el so y el browser del cliente',
  `curso_id` int(10) NULL DEFAULT 0 COMMENT 'curso con el que ingreso por defecto',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_log_id`(`admin_id`) USING BTREE,
  CONSTRAINT `admin_log_id` FOREIGN KEY (`admin_id`) REFERENCES `tbl_admin` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 540 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_log_est
-- ----------------------------
DROP TABLE IF EXISTS `tbl_log_est`;
CREATE TABLE `tbl_log_est`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `est_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `fecha_in` datetime(0) NULL DEFAULT NULL COMMENT 'fecha en que accede',
  `ip_acc` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'ip de donde accede',
  `info_cliente` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'informacion sobre el so y el browser del cliente',
  `contenidos` varchar(220) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'ids, de los contenidos revisados (separados por coma)',
  `descargas` varchar(220) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'ids de las descargas realizadas (separadas por coma)',
  `links` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'ids de los links visitados',
  `soporte_a` smallint(6) NOT NULL DEFAULT 0 COMMENT 'veces que a hecho consultas por tema',
  `soporte_t` smallint(6) NOT NULL DEFAULT 0 COMMENT 'veces que ha pedido ayuda a soporte tecnico',
  `ncontenidos` smallint(6) NOT NULL DEFAULT 0 COMMENT 'numero de contenidos descargados',
  `ndescargas` smallint(6) NOT NULL DEFAULT 0 COMMENT 'numero de descargas hechas',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `estudiante_id`(`est_id`) USING BTREE,
  INDEX `fecha`(`fecha_in`) USING BTREE,
  CONSTRAINT `log_est_fk` FOREIGN KEY (`est_id`) REFERENCES `tbl_estudiante` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 156 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de log de ingreso al sistema x estudiante\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_mensaje_admin
-- ----------------------------
DROP TABLE IF EXISTS `tbl_mensaje_admin`;
CREATE TABLE `tbl_mensaje_admin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 admin to admin, 1 student to admin',
  `urgencia` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `de` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'remite',
  `para` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'admin_id',
  `subject` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fecha` datetime(0) NOT NULL COMMENT 'fecha de la ultima modificacion',
  `leido` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT 'si esta leido o no',
  `destinatario` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'campo que indica el destinatario del mensaje enviado, en caso de que sea individual o grupo',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tipo`(`tipo`) USING BTREE,
  INDEX `para`(`para`) USING BTREE,
  INDEX `de`(`de`) USING BTREE,
  CONSTRAINT `FK_mensaje_admin_1` FOREIGN KEY (`para`) REFERENCES `tbl_admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 98 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'InnoDB free: 7168 kB; (`to`) REFER `edunet2/admin`(`id`) ON ' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_mensaje_est
-- ----------------------------
DROP TABLE IF EXISTS `tbl_mensaje_est`;
CREATE TABLE `tbl_mensaje_est`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 student to student, 1 profe to student',
  `urgencia` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `de` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'remite',
  `para` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'estudiante_id',
  `subject` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `fecha` datetime(0) NOT NULL COMMENT 'fecha de la ultima modificacion',
  `leido` tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT 'si esta leido o no',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tipo`(`tipo`) USING BTREE,
  INDEX `para`(`para`) USING BTREE,
  CONSTRAINT `FK_mensaje_est_1` FOREIGN KEY (`para`) REFERENCES `tbl_estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 193 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'InnoDB free: 7168 kB; (`to`) REFER `edunet2/estudiante`(`id`' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_mensaje_est_enviado
-- ----------------------------
DROP TABLE IF EXISTS `tbl_mensaje_est_enviado`;
CREATE TABLE `tbl_mensaje_est_enviado`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `est_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'remite',
  `tipo` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 student to student, 1 profe to student',
  `urgencia` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `para` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'estudiante_id',
  `subject` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tipo`(`tipo`) USING BTREE,
  INDEX `para`(`para`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'InnoDB free: 7168 kB; (`to`) REFER `edunet2/estudiante`(`id`' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tbl_plan_estudiante
-- ----------------------------
DROP TABLE IF EXISTS `tbl_plan_estudiante`;
CREATE TABLE `tbl_plan_estudiante`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'item del plan evaluador que corresponde',
  `est_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'id del estudiante que tiene la nota',
  `nota` float(9, 4) NULL DEFAULT 0.0000 COMMENT 'nota real obtenida por el estudiante',
  `correccion` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'justificacion de la nota colocada',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  INDEX `item_id`(`item_id`) USING BTREE,
  INDEX `est_id`(`est_id`) USING BTREE,
  CONSTRAINT `plan_estudiante_fk` FOREIGN KEY (`item_id`) REFERENCES `tbl_plan_item` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `plan_estudiante_fk1` FOREIGN KEY (`est_id`) REFERENCES `tbl_estudiante` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla que almacena la nota del estudiante en cada item segun' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_plan_evaluador
-- ----------------------------
DROP TABLE IF EXISTS `tbl_plan_evaluador`;
CREATE TABLE `tbl_plan_evaluador`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `grupo_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `titulo` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ' ',
  `en_base` tinyint(3) NOT NULL DEFAULT 0 COMMENT 'campo que explica en base a que porcentaje se evalua, la nota final',
  `redondeo` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'redondeo de notas al final',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `grupo_id`(`grupo_id`) USING BTREE,
  CONSTRAINT `tbl_plan_evaluador_fk` FOREIGN KEY (`grupo_id`) REFERENCES `tbl_grupo` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'tabla de planes\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_plan_item
-- ----------------------------
DROP TABLE IF EXISTS `tbl_plan_item`;
CREATE TABLE `tbl_plan_item`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `titulo` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipo` enum('foro','eval','proy','otro') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'foro' COMMENT 'el tipo de la actividad',
  `id_act` int(11) NOT NULL DEFAULT 0 COMMENT 'el id de la actividad en el caso de que sea foro,eval,proy sino es 0',
  `porcentaje` float(9, 4) NOT NULL DEFAULT 0.0000 COMMENT 'expresado en % sobre la nota final',
  `en_base` float(9, 4) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `plan_id`(`plan_id`) USING BTREE,
  INDEX `tipo_act`(`tipo`, `id_act`) USING BTREE,
  CONSTRAINT `plan_item_fk` FOREIGN KEY (`plan_id`) REFERENCES `tbl_plan_evaluador` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 119 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de item a evaluar en el plan\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_pregunta_opcion
-- ----------------------------
DROP TABLE IF EXISTS `tbl_pregunta_opcion`;
CREATE TABLE `tbl_pregunta_opcion`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `preg_id` int(10) UNSIGNED NOT NULL,
  `opcion` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `correcta` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `preg_id`(`preg_id`) USING BTREE,
  CONSTRAINT `pregunta_opcion_fk` FOREIGN KEY (`preg_id`) REFERENCES `tbl_evaluacion_pregunta` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 82 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'opciones para las preguntas de opcion multiple\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_proyecto
-- ----------------------------
DROP TABLE IF EXISTS `tbl_proyecto`;
CREATE TABLE `tbl_proyecto`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(125) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `autor` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `curso_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `contenido_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `grupo` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `enunciado` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'enunciado del proyecto',
  `fecha_entrega` datetime(0) NOT NULL,
  `fecha_edit` datetime(0) NULL DEFAULT NULL,
  `nota` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fecha_entrega`(`fecha_entrega`) USING BTREE,
  INDEX `contenido_id`(`contenido_id`) USING BTREE,
  CONSTRAINT `proyecto_fk` FOREIGN KEY (`contenido_id`) REFERENCES `tbl_contenido` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'tabla de proyectos\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_proyecto_estudiante
-- ----------------------------
DROP TABLE IF EXISTS `tbl_proyecto_estudiante`;
CREATE TABLE `tbl_proyecto_estudiante`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proy_id` int(11) NOT NULL DEFAULT 0,
  `est_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `rec_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'id del recurso q fue subido por el estudiante',
  `correccion` mediumtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'justificacion de la nota colocada',
  `nota` float(5, 2) NOT NULL DEFAULT -1.00,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `proy_id`(`proy_id`) USING BTREE,
  INDEX `est_id`(`est_id`) USING BTREE,
  CONSTRAINT `proyecto_estudiante_fk` FOREIGN KEY (`proy_id`) REFERENCES `tbl_proyecto` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `proyecto_estudiante_fk1` FOREIGN KEY (`est_id`) REFERENCES `tbl_estudiante` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'tabla de notas de estudiantes en proyectos\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_proyecto_recurso
-- ----------------------------
DROP TABLE IF EXISTS `tbl_proyecto_recurso`;
CREATE TABLE `tbl_proyecto_recurso`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proy_id` int(11) NOT NULL DEFAULT 0,
  `rec_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `tipo` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 archivo, 1 enlace, 2 video',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `proy_id`(`proy_id`) USING BTREE,
  INDEX `rec_id`(`rec_id`) USING BTREE,
  CONSTRAINT `tbl_proyecto_recurso_fk` FOREIGN KEY (`proy_id`) REFERENCES `tbl_proyecto` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `tbl_proyecto_recurso_fk1` FOREIGN KEY (`rec_id`) REFERENCES `tbl_recurso` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'tabla relacion que recursos tiene cada proyecto\r\nrevision VE' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_recurso
-- ----------------------------
DROP TABLE IF EXISTS `tbl_recurso`;
CREATE TABLE `tbl_recurso`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 descargable, 1 link, 2, video, 3 leible',
  `fecha` datetime(0) NULL DEFAULT NULL,
  `dir` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'path o url',
  `add_by` enum('admin','est') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'admin',
  `persona` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'id de la persona quien lo agrego',
  `descripcion` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `downloads` smallint(6) NOT NULL DEFAULT 0 COMMENT 'numero de veces descargado',
  `fuente` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'fuente del archivo ejemplo youtube',
  `size` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ' ' COMMENT 'cuanto pesa',
  `mime` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `extension` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `filepath` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  INDEX `tipo`(`tipo`) USING BTREE,
  INDEX `add_by_persona`(`add_by`, `persona`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 522 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'tabla de recursos subidos por el admin o estudiantes\r\nrevisi' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for tbl_setup
-- ----------------------------
DROP TABLE IF EXISTS `tbl_setup`;
CREATE TABLE `tbl_setup`  (
  `id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `titulo` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `titulo_admin` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `modo` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `lenguaje` varchar(55) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `log` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `uni_nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `uni_dir` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `uni_telefono` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ' ',
  `uni_fax` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `uni_website` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `uni_logo` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `signature` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `bienvenido_est` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'texto de bienvenida est',
  `fin_inscripcion` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'texto saliente al completar la insc',
  `formato_fecha` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'd/m/Y',
  `formato_fecha_db` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '%d/%m/%Y',
  `envio_email` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '0 no envia email 1, envia email',
  `admin_email` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `titulo_ins` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `timezone` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'America/caracas' COMMENT 'zona horaria',
  `version` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'la version actual de cursonet',
  `dif_hora` smallint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'revision VE' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
