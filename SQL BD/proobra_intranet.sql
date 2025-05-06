-- Adminer 4.8.4 MySQL 8.4.3 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `proobra_intranet` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `proobra_intranet`;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `categorias_operarios`;
CREATE TABLE `categorias_operarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `configuraciones`;
CREATE TABLE `configuraciones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `clave` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `configuraciones_clave_unique` (`clave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `gastos_fijos_configurables`;
CREATE TABLE `gastos_fijos_configurables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('porcentaje','monto') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monto',
  `valor` decimal(10,2) NOT NULL DEFAULT '0.00',
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gastos_fijos_configurables` (`id`, `nombre`, `tipo`, `valor`, `editable`, `created_at`, `updated_at`) VALUES
(1,	'IVA',	'porcentaje',	22.00,	0,	'2025-04-17 15:50:52',	'2025-04-17 15:50:52'),
(2,	'Inscripción de obra',	'monto',	8000.00,	1,	'2025-04-17 15:50:52',	'2025-04-17 19:47:01'),
(3,	'IMM',	'monto',	1300.00,	1,	'2025-04-17 15:50:52',	'2025-04-17 19:47:12'),
(4,	'Responsabilidad civil',	'monto',	6500.00,	1,	'2025-04-17 15:50:52',	'2025-04-17 15:50:52'),
(5,	'SYSO',	'monto',	15000.00,	1,	'2025-04-17 15:50:52',	'2025-04-17 19:47:23');

DROP TABLE IF EXISTS `gastos_fijos_presupuesto`;
CREATE TABLE `gastos_fijos_presupuesto` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cantidad_ml` decimal(10,0) DEFAULT NULL,
  `presupuesto_id` bigint unsigned NOT NULL,
  `gasto_fijo_id` bigint unsigned NOT NULL,
  `valor_aplicado` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gastos_fijos_presupuesto_presupuesto_id_foreign` (`presupuesto_id`),
  KEY `gastos_fijos_presupuesto_gasto_fijo_id_foreign` (`gasto_fijo_id`),
  CONSTRAINT `gastos_fijos_presupuesto_gasto_fijo_id_foreign` FOREIGN KEY (`gasto_fijo_id`) REFERENCES `gastos_fijos_configurables` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gastos_fijos_presupuesto_presupuesto_id_foreign` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gastos_fijos_presupuesto` (`id`, `cantidad_ml`, `presupuesto_id`, `gasto_fijo_id`, `valor_aplicado`, `created_at`, `updated_at`) VALUES
(1,	NULL,	2,	1,	22.00,	'2025-04-17 19:43:33',	'2025-04-17 19:43:33'),
(2,	2,	2,	3,	190.00,	'2025-04-17 19:43:33',	'2025-04-17 19:44:30'),
(3,	NULL,	2,	4,	6500.00,	'2025-04-17 19:44:42',	'2025-04-17 19:44:42'),
(4,	NULL,	2,	2,	3500.00,	'2025-04-17 19:46:41',	'2025-04-17 19:46:41'),
(5,	NULL,	2,	5,	3500.00,	'2025-04-17 19:46:41',	'2025-04-17 19:46:41'),
(8,	7,	3,	3,	1300.00,	'2025-04-17 19:49:35',	'2025-04-17 20:35:37'),
(9,	NULL,	3,	4,	6500.00,	'2025-04-17 19:49:35',	'2025-04-17 19:49:35'),
(11,	NULL,	5,	1,	22.00,	'2025-04-17 22:50:59',	'2025-04-17 22:50:59'),
(12,	2,	5,	3,	1300.00,	'2025-04-17 22:50:59',	'2025-04-17 22:50:59'),
(13,	NULL,	5,	5,	15000.00,	'2025-04-17 22:50:59',	'2025-04-17 22:50:59'),
(14,	NULL,	3,	1,	22.00,	'2025-04-17 23:15:43',	'2025-04-17 23:15:43'),
(15,	NULL,	7,	1,	22.00,	'2025-04-17 23:18:29',	'2025-04-17 23:18:29'),
(16,	NULL,	9,	1,	22.00,	'2025-04-17 23:29:08',	'2025-04-17 23:29:08'),
(17,	NULL,	9,	4,	6500.00,	'2025-04-17 23:29:08',	'2025-04-17 23:29:08'),
(18,	NULL,	9,	5,	15000.00,	'2025-04-17 23:29:08',	'2025-04-17 23:29:08'),
(19,	NULL,	8,	1,	22.00,	'2025-04-18 01:26:34',	'2025-04-18 01:26:34'),
(20,	NULL,	8,	2,	8000.00,	'2025-04-18 01:26:34',	'2025-04-18 01:26:34'),
(22,	NULL,	7,	2,	8000.00,	'2025-04-18 03:20:04',	'2025-04-18 03:20:04'),
(23,	7,	7,	3,	1300.00,	'2025-04-18 03:20:04',	'2025-04-18 03:20:04'),
(24,	NULL,	7,	4,	6500.00,	'2025-04-18 03:20:04',	'2025-04-18 03:20:04'),
(25,	NULL,	7,	5,	15000.00,	'2025-04-18 03:20:04',	'2025-04-18 03:20:04'),
(26,	NULL,	17,	1,	22.00,	'2025-04-18 11:38:26',	'2025-04-18 11:38:26'),
(27,	0,	17,	3,	1300.00,	'2025-04-18 11:38:26',	'2025-04-18 11:38:26'),
(28,	NULL,	17,	5,	15000.00,	'2025-04-18 11:38:26',	'2025-04-18 11:38:26'),
(29,	NULL,	17,	2,	8000.00,	'2025-04-18 11:39:04',	'2025-04-18 11:39:04'),
(30,	NULL,	16,	1,	22.00,	'2025-04-18 11:40:31',	'2025-04-18 11:40:31'),
(31,	NULL,	16,	2,	8000.00,	'2025-04-18 11:40:31',	'2025-04-18 11:40:31'),
(32,	5,	16,	3,	1300.00,	'2025-04-18 11:40:31',	'2025-04-18 11:40:31'),
(33,	NULL,	16,	4,	6500.00,	'2025-04-18 11:40:31',	'2025-04-18 11:40:31'),
(34,	NULL,	16,	5,	15000.00,	'2025-04-18 11:40:31',	'2025-04-18 11:40:31'),
(35,	NULL,	18,	1,	22.00,	'2025-04-18 11:44:46',	'2025-04-18 11:44:46'),
(36,	NULL,	18,	2,	8000.00,	'2025-04-18 11:44:46',	'2025-04-18 11:44:46'),
(37,	2,	18,	3,	1300.00,	'2025-04-18 11:44:46',	'2025-04-18 11:44:46'),
(38,	NULL,	18,	4,	6500.00,	'2025-04-18 11:44:46',	'2025-04-18 11:44:46'),
(39,	NULL,	18,	5,	15000.00,	'2025-04-18 11:44:46',	'2025-04-18 11:44:46'),
(40,	NULL,	20,	1,	22.00,	'2025-04-18 12:45:20',	'2025-04-18 12:45:20'),
(41,	NULL,	20,	2,	8000.00,	'2025-04-18 12:57:18',	'2025-04-18 12:57:18'),
(42,	NULL,	21,	1,	22.00,	'2025-04-18 13:32:13',	'2025-04-18 13:32:13'),
(43,	NULL,	22,	1,	22.00,	'2025-04-18 13:47:15',	'2025-04-18 13:47:15'),
(44,	NULL,	23,	1,	22.00,	'2025-04-18 13:55:18',	'2025-04-18 13:55:18'),
(45,	0,	23,	3,	1300.00,	'2025-04-18 13:57:23',	'2025-04-18 13:57:23'),
(46,	NULL,	23,	4,	6500.00,	'2025-04-18 13:57:23',	'2025-04-18 13:57:23'),
(47,	NULL,	24,	1,	22.00,	'2025-04-18 13:58:46',	'2025-04-18 13:58:46'),
(48,	NULL,	25,	1,	22.00,	'2025-04-18 14:01:09',	'2025-04-18 14:01:09'),
(49,	NULL,	26,	1,	22.00,	'2025-04-18 14:03:58',	'2025-04-18 14:03:58'),
(50,	NULL,	27,	1,	22.00,	'2025-04-18 14:17:33',	'2025-04-18 14:17:33'),
(51,	NULL,	27,	2,	8000.00,	'2025-04-18 14:17:44',	'2025-04-18 14:17:44'),
(52,	NULL,	8,	4,	6500.00,	'2025-04-18 15:01:24',	'2025-04-18 15:01:24'),
(53,	NULL,	8,	5,	15000.00,	'2025-04-18 15:01:24',	'2025-04-18 15:01:24');

DROP TABLE IF EXISTS `laudos_operarios`;
CREATE TABLE `laudos_operarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `orden` int DEFAULT NULL,
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sector` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Construcción',
  `laudo_base` decimal(10,2) NOT NULL DEFAULT '0.00',
  `desgaste_ropa` decimal(10,2) NOT NULL DEFAULT '0.00',
  `transporte` decimal(10,2) NOT NULL DEFAULT '0.00',
  `s_balancin` decimal(10,2) NOT NULL DEFAULT '0.00',
  `herramientas` decimal(10,2) NOT NULL DEFAULT '0.00',
  `alimentos` decimal(10,2) NOT NULL DEFAULT '0.00',
  `presentismo_semanal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `presentismo_mensual` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_jornal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `laudos_operarios` (`id`, `orden`, `categoria`, `sector`, `laudo_base`, `desgaste_ropa`, `transporte`, `s_balancin`, `herramientas`, `alimentos`, `presentismo_semanal`, `presentismo_mensual`, `total_jornal`, `created_at`, `updated_at`) VALUES
(1,	NULL,	'Peón común cat III',	'Construcción',	1656.22,	97.63,	85.42,	58.59,	0.00,	173.82,	142.57,	68.41,	2282.66,	NULL,	NULL),
(2,	NULL,	'Peón práctico cat IV',	'Construcción',	1804.44,	97.63,	85.42,	58.59,	0.00,	173.82,	142.57,	68.41,	2430.88,	NULL,	NULL),
(3,	NULL,	'½ Oficial cat V',	'Construcción',	1953.01,	97.63,	85.42,	195.30,	39.04,	195.30,	154.31,	74.04,	2794.05,	NULL,	NULL),
(4,	1,	'Oficial VIII',	'Construcción',	2612.37,	97.63,	85.42,	195.30,	39.04,	195.30,	206.41,	99.04,	3530.51,	NULL,	'2025-04-17 15:58:06'),
(5,	NULL,	'Peón común IyC',	'Industria y Comercio',	2018.38,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	2018.38,	NULL,	NULL),
(6,	NULL,	'Peón IyC',	'Industria y Comercio',	2197.70,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	2197.70,	NULL,	NULL),
(7,	NULL,	'Medio Oficial IyC',	'Industria y Comercio',	2378.83,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	2378.83,	NULL,	NULL),
(8,	NULL,	'Oficial IyC',	'Industria y Comercio',	3181.82,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	3181.82,	NULL,	NULL),
(9,	NULL,	'Peón común cat III',	'Construcción',	1656.22,	97.63,	85.42,	58.59,	0.00,	173.82,	142.57,	68.41,	2282.66,	NULL,	NULL),
(10,	NULL,	'Peón práctico cat IV',	'Construcción',	1804.44,	97.63,	85.42,	58.59,	0.00,	173.82,	142.57,	68.41,	2430.88,	NULL,	NULL),
(11,	NULL,	'½ Oficial cat V',	'Construcción',	1953.01,	97.63,	85.42,	195.30,	39.04,	195.30,	154.31,	74.04,	2794.05,	NULL,	NULL),
(12,	NULL,	'Oficial cat VIII',	'Construcción',	2612.37,	97.63,	85.42,	195.30,	39.04,	195.30,	206.41,	99.04,	3530.51,	NULL,	NULL),
(13,	NULL,	'Peón común IyC',	'Industria y Comercio',	2018.38,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	2018.38,	NULL,	NULL),
(14,	NULL,	'Peón IyC',	'Industria y Comercio',	2197.70,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	2197.70,	NULL,	NULL),
(15,	NULL,	'Medio Oficial IyC',	'Industria y Comercio',	2378.83,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	2378.83,	NULL,	NULL),
(16,	NULL,	'Oficial IyC',	'Industria y Comercio',	3181.82,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	3181.82,	NULL,	NULL);

DROP TABLE IF EXISTS `mano_de_obra`;
CREATE TABLE `mano_de_obra` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `presupuesto_id` bigint unsigned NOT NULL,
  `replanteo_id` bigint unsigned DEFAULT NULL,
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `dias` int DEFAULT NULL,
  `comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mano_de_obra_presupuesto_id_foreign` (`presupuesto_id`),
  KEY `mano_de_obra_replanteo_id_foreign` (`replanteo_id`),
  CONSTRAINT `mano_de_obra_presupuesto_id_foreign` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mano_de_obra_replanteo_id_foreign` FOREIGN KEY (`replanteo_id`) REFERENCES `replanteos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mano_de_obra` (`id`, `presupuesto_id`, `replanteo_id`, `categoria`, `cantidad`, `dias`, `comentario`, `created_at`, `updated_at`) VALUES
(1,	2,	1,	'Peón común cat III',	2.20,	4,	'',	'2025-04-17 17:58:21',	'2025-04-17 19:46:41'),
(2,	2,	1,	'Peón común cat III',	2.00,	0,	'',	'2025-04-17 18:01:26',	'2025-04-17 19:45:55'),
(3,	2,	1,	'Medio Oficial IyC',	1.00,	0,	'',	'2025-04-17 18:02:38',	'2025-04-17 19:45:55'),
(4,	3,	2,	'Peón común cat III',	1.00,	10,	'',	'2025-04-17 19:49:35',	'2025-04-17 19:49:35'),
(5,	3,	2,	'½ Oficial cat V',	1.00,	1,	'',	'2025-04-17 19:49:35',	'2025-04-17 19:49:35'),
(6,	9,	3,	'Peón común cat III',	1.00,	1,	'ñpç´+',	'2025-04-17 23:29:53',	'2025-04-18 00:34:24'),
(7,	9,	3,	'Peón común cat III',	1.00,	10,	'',	'2025-04-18 00:33:26',	'2025-04-18 00:33:44'),
(8,	9,	3,	'Peón común cat III',	1.00,	1,	'',	'2025-04-18 00:34:24',	'2025-04-18 00:34:24'),
(9,	7,	4,	'Peón común cat III',	25.00,	45,	'',	'2025-04-18 11:15:44',	'2025-04-18 11:15:44'),
(10,	7,	5,	'Peón común cat III',	5.00,	5,	'',	'2025-04-18 11:19:10',	'2025-04-18 11:19:10'),
(11,	7,	4,	'Medio Oficial IyC',	1.00,	1,	'',	'2025-04-18 11:19:40',	'2025-04-18 11:19:40'),
(12,	17,	6,	'Peón común cat III',	1.00,	12,	'',	'2025-04-18 11:38:26',	'2025-04-18 11:38:26'),
(13,	16,	7,	'Peón común cat III',	1.00,	45,	'',	'2025-04-18 11:40:31',	'2025-04-18 11:40:31'),
(14,	18,	9,	'Peón IyC',	2.54,	2,	'',	'2025-04-18 11:44:46',	'2025-04-18 11:44:46'),
(15,	18,	8,	'Oficial cat VIII',	14.50,	4,	'',	'2025-04-18 11:44:46',	'2025-04-18 11:44:46'),
(16,	19,	11,	'Peón común cat III',	3.00,	4,	'',	'2025-04-18 12:30:52',	'2025-04-18 12:42:21'),
(17,	19,	10,	'Peón común cat III',	4.00,	45,	'',	'2025-04-18 12:30:52',	'2025-04-18 12:30:52'),
(18,	20,	12,	'Peón común cat III',	45.00,	8878787,	'',	'2025-04-18 13:20:07',	'2025-04-18 13:26:51'),
(19,	21,	14,	'Peón común cat III',	12.00,	1,	'',	'2025-04-18 13:32:13',	'2025-04-18 13:32:13'),
(20,	21,	13,	'½ Oficial cat V',	1.00,	22,	'',	'2025-04-18 13:32:13',	'2025-04-18 13:32:13'),
(21,	22,	15,	'Peón práctico cat IV',	12.00,	12,	'',	'2025-04-18 13:47:33',	'2025-04-18 13:47:33'),
(22,	23,	16,	'Peón práctico cat IV',	45.00,	5,	'',	'2025-04-18 13:58:00',	'2025-04-18 13:58:00'),
(23,	8,	17,	'Peón práctico cat IV',	1.00,	1,	'',	'2025-04-18 15:01:24',	'2025-04-18 15:01:24');

DROP TABLE IF EXISTS `materiales`;
CREATE TABLE `materiales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `orden` int DEFAULT NULL,
  `presupuesto_id` bigint unsigned NOT NULL,
  `replanteo_id` bigint unsigned DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad_unidades` decimal(10,2) DEFAULT NULL,
  `costo_unitario` decimal(10,2) DEFAULT NULL,
  `manos` decimal(10,2) DEFAULT NULL,
  `rendimiento` decimal(10,2) DEFAULT NULL,
  `litros_por_lata` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materiales_presupuesto_id_foreign` (`presupuesto_id`),
  KEY `materiales_replanteo_id_foreign` (`replanteo_id`),
  CONSTRAINT `materiales_presupuesto_id_foreign` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `materiales_replanteo_id_foreign` FOREIGN KEY (`replanteo_id`) REFERENCES `replanteos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `materiales` (`id`, `orden`, `presupuesto_id`, `replanteo_id`, `descripcion`, `cantidad_unidades`, `costo_unitario`, `manos`, `rendimiento`, `litros_por_lata`, `created_at`, `updated_at`) VALUES
(1,	1,	2,	1,	'hjl',	1.00,	1453.00,	0.00,	1.00,	1.00,	'2025-04-17 18:01:26',	'2025-04-17 18:01:26'),
(2,	1,	2,	1,	'gh',	4.00,	454.00,	0.00,	1.00,	1.00,	'2025-04-17 18:02:38',	'2025-04-17 19:43:33'),
(3,	1,	2,	1,	'uiy',	200.00,	8000.00,	2.00,	8.00,	18.00,	'2025-04-17 19:44:09',	'2025-04-17 19:44:09'),
(4,	1,	3,	2,	'bn',	14.00,	458.00,	0.00,	1.00,	1.00,	'2025-04-17 19:49:35',	'2025-04-17 19:49:35'),
(5,	1,	3,	2,	'jkl',	55.00,	554.00,	0.00,	1.00,	1.00,	'2025-04-17 19:49:35',	'2025-04-17 19:49:35'),
(6,	1,	9,	3,	'jhkil',	52.00,	52.00,	0.00,	1.00,	1.00,	'2025-04-17 23:29:54',	'2025-04-17 23:29:54'),
(7,	2,	7,	5,	'klñ',	45.00,	545.00,	0.00,	1.00,	1.00,	'2025-04-18 11:15:44',	'2025-04-18 11:19:10'),
(8,	2,	7,	5,	'lkñ',	908.00,	98.00,	0.00,	1.00,	1.00,	'2025-04-18 11:19:10',	'2025-04-18 11:19:10'),
(9,	1,	17,	6,	'hjk',	4.00,	4554.00,	0.00,	1.00,	1.00,	'2025-04-18 11:38:26',	'2025-04-18 11:38:26'),
(10,	1,	16,	7,	'lñ',	41.00,	145.00,	0.00,	1.00,	1.00,	'2025-04-18 11:40:31',	'2025-04-18 11:40:31'),
(11,	1,	18,	8,	'fghj',	5.00,	45.00,	0.00,	1.00,	1.00,	'2025-04-18 11:44:46',	'2025-04-18 11:44:46'),
(12,	2,	18,	9,	'fgh',	200.00,	7000.00,	3.00,	18.00,	18.00,	'2025-04-18 11:44:46',	'2025-04-18 11:44:46'),
(13,	1,	19,	10,	'jhk',	45.00,	45.00,	0.00,	1.00,	1.00,	'2025-04-18 12:42:21',	'2025-04-18 12:42:21'),
(14,	1,	20,	12,	'lñ',	4.00,	444.00,	0.00,	1.00,	1.00,	'2025-04-18 13:13:35',	'2025-04-18 13:13:35'),
(15,	1,	21,	13,	'1',	657.00,	765.00,	0.00,	1.00,	1.00,	'2025-04-18 13:32:13',	'2025-04-18 13:32:13'),
(16,	1,	22,	15,	'ñç´´',	45.00,	45.00,	0.00,	1.00,	1.00,	'2025-04-18 13:47:15',	'2025-04-18 13:47:15'),
(17,	1,	23,	16,	'khlj',	453.00,	543.00,	0.00,	1.00,	1.00,	'2025-04-18 13:58:00',	'2025-04-18 13:58:00'),
(18,	1,	8,	17,	'lñ',	41.00,	14.00,	0.00,	1.00,	1.00,	'2025-04-18 15:01:24',	'2025-04-18 15:01:24');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2025_04_17_000001_create_presupuestos_table',	1),
(2,	'2025_04_17_000002_create_replanteos_table',	1),
(3,	'2025_04_17_000003_create_materiales_table',	1),
(4,	'2025_04_17_000004_create_mano_de_obra_table',	1),
(5,	'2025_04_17_000005_create_laudos_operarios_table',	1),
(6,	'2025_04_17_000006_create_gastos_fijos_configurables_table',	1),
(7,	'2025_04_17_000007_create_gastos_fijos_presupuesto_table',	1),
(8,	'2025_04_17_000008_create_configuraciones_table',	1),
(9,	'2025_04_17_092613_create_sessions_table',	1),
(10,	'2025_04_17_092815_create_cache_table',	1),
(11,	'2025_04_17_093409_create_users_table',	1),
(12,	'2025_04_17_000009_create_obras_table',	2),
(13,	'2025_04_17_000010_create_categorias_operarios_table',	3),
(14,	'2025_04_17_112658_add_fecha_to_presupuestos_table',	4),
(15,	'2025_04_17_113038_add_fechas_to_presupuestos_table',	5),
(16,	'2025_04_17_113430_add_titulo_caratula_to_presupuestos_table',	6),
(17,	'2025_04_17_113612_add_descripcion_to_presupuestos_table',	7),
(18,	'2025_04_17_113936_add_bps_mano_obra_to_presupuestos_table',	8),
(19,	'2025_04_17_114129_add_missing_columns_to_presupuestos_and_laudos_operarios',	9),
(20,	'2025_04_17_135054_add_comentarios_to_presupuestos_table',	10),
(21,	'2025_04_17_144503_add_descripcion_tarea_to_replanteos_table',	11);

DROP TABLE IF EXISTS `obras`;
CREATE TABLE `obras` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `duracion_dias` int DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `obras` (`id`, `nombre`, `fecha_inicio`, `duracion_dias`, `estado`, `created_at`, `updated_at`) VALUES
(1,	'Impermeabilización de terraza 50m²',	'2025-04-07',	20,	'en_ejecucion',	'2025-04-17 13:41:14',	'2025-04-17 13:41:14');

DROP TABLE IF EXISTS `presupuestos`;
CREATE TABLE `presupuestos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo_caratula` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `bps_mano_obra` decimal(5,2) NOT NULL DEFAULT '0.00',
  `caratula` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `duracion_dias` int NOT NULL DEFAULT '0',
  `superficie` decimal(10,2) DEFAULT NULL,
  `utilidad` decimal(5,2) NOT NULL DEFAULT '0.00',
  `bps_porcentaje` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comentarios` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `presupuestos` (`id`, `titulo`, `titulo_caratula`, `descripcion`, `bps_mano_obra`, `caratula`, `empresa`, `cliente`, `telefono`, `direccion`, `email`, `fecha`, `fecha_inicio`, `duracion_dias`, `superficie`, `utilidad`, `bps_porcentaje`, `created_at`, `updated_at`, `comentarios`) VALUES
(1,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'',	'',	'',	'',	'',	'2025-04-17 11:40:12',	'2025-04-17 11:40:12',	0,	0.00,	0.00,	0.00,	'2025-04-17 14:40:12',	'2025-04-17 14:40:12',	NULL),
(2,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-04-17 12:08:31',	0,	100.00,	65.00,	0.00,	'2025-04-17 15:08:31',	'2025-04-17 17:43:12',	NULL),
(3,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	'ff',	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-17 16:47:48',	0,	100.00,	65.00,	0.00,	'2025-04-17 19:47:48',	'2025-04-17 19:49:35',	NULL),
(4,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-04-17 17:47:33',	0,	0.00,	0.00,	0.00,	'2025-04-17 20:47:33',	'2025-04-18 14:34:02',	NULL),
(5,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-04-17 19:04:19',	0,	100.00,	65.00,	0.00,	'2025-04-17 22:04:19',	'2025-04-17 22:50:59',	NULL),
(6,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'',	'',	'',	'',	'',	'2025-04-17 19:42:40',	'2025-04-17 19:42:40',	0,	0.00,	0.00,	0.00,	'2025-04-17 22:42:40',	'2025-04-17 22:42:40',	NULL),
(7,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	'xcgvd',	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-17 20:17:08',	0,	1000.00,	83.00,	0.00,	'2025-04-17 23:17:08',	'2025-04-18 03:20:04',	NULL),
(8,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	NULL,	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-17 20:27:53',	0,	100.00,	65.00,	0.00,	'2025-04-17 23:27:53',	'2025-04-18 15:01:24',	NULL),
(9,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	NULL,	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-17 20:27:57',	0,	100.00,	12.00,	0.00,	'2025-04-17 23:27:57',	'2025-04-17 23:29:08',	NULL),
(10,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'',	'',	'',	'',	'',	'2025-04-17 21:42:58',	'2025-04-17 21:42:58',	0,	0.00,	0.00,	0.00,	'2025-04-18 00:42:58',	'2025-04-18 00:42:58',	NULL),
(11,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-04-17 21:45:28',	0,	0.00,	0.00,	0.00,	'2025-04-18 00:45:28',	'2025-04-18 00:50:12',	NULL),
(12,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'',	'',	'',	'',	'',	'2025-04-17 21:51:06',	'2025-04-17 21:51:06',	0,	0.00,	0.00,	0.00,	'2025-04-18 00:51:06',	'2025-04-18 00:51:06',	NULL),
(13,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'',	'',	'',	'',	'',	'2025-04-17 23:02:02',	'2025-04-17 23:02:02',	0,	0.00,	0.00,	0.00,	'2025-04-18 02:02:02',	'2025-04-18 02:02:02',	NULL),
(14,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'',	'',	'',	'',	'',	'2025-04-17 23:03:13',	'2025-04-17 23:03:13',	0,	0.00,	0.00,	0.00,	'2025-04-18 02:03:13',	'2025-04-18 02:03:13',	NULL),
(15,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'',	'',	'',	'',	'',	'2025-04-17 23:03:16',	'2025-04-17 23:03:16',	0,	0.00,	0.00,	0.00,	'2025-04-18 02:03:16',	'2025-04-18 02:03:16',	NULL),
(16,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-04-17 23:03:17',	0,	56.00,	65.00,	0.00,	'2025-04-18 02:03:17',	'2025-04-18 11:41:09',	NULL),
(17,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-04-17 23:03:18',	0,	100.00,	65.00,	0.00,	'2025-04-18 02:03:18',	'2025-04-18 11:39:04',	NULL),
(18,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	'dsfr',	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-18 08:41:37',	0,	425.00,	70.00,	0.00,	'2025-04-18 11:41:37',	'2025-04-18 11:46:34',	NULL),
(19,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	'dfg',	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-18 09:16:43',	0,	443.00,	45.00,	0.00,	'2025-04-18 12:16:43',	'2025-04-18 12:42:21',	NULL),
(20,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	'sd',	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-18 09:42:32',	0,	100.00,	45.00,	0.00,	'2025-04-18 12:42:32',	'2025-04-18 12:57:18',	NULL),
(21,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	'y8p',	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-18 10:30:27',	0,	100.00,	45.00,	0.00,	'2025-04-18 13:30:27',	'2025-04-18 13:32:13',	NULL),
(22,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	NULL,	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-18 10:46:31',	0,	100.00,	65.00,	0.00,	'2025-04-18 13:46:31',	'2025-04-18 13:47:15',	NULL),
(23,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	NULL,	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-18 10:49:50',	0,	50.00,	50.00,	0.00,	'2025-04-18 13:49:50',	'2025-04-18 13:58:00',	NULL),
(24,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-04-18 10:58:15',	0,	114.00,	77.00,	0.00,	'2025-04-18 13:58:15',	'2025-04-18 13:58:46',	NULL),
(25,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-04-18 11:00:40',	0,	100.00,	41.00,	0.00,	'2025-04-18 14:00:40',	'2025-04-18 14:01:09',	NULL),
(26,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-04-18 11:03:37',	0,	414.00,	41.00,	0.00,	'2025-04-18 14:03:37',	'2025-04-18 14:03:58',	NULL),
(27,	'Nuevo presupuesto2d',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	'toto',	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-18 11:14:53',	0,	400.00,	44.00,	0.00,	'2025-04-18 14:14:53',	'2025-04-18 14:17:33',	NULL),
(28,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2025-04-18 11:34:46',	0,	4444.00,	44.00,	0.00,	'2025-04-18 14:34:46',	'2025-04-18 14:39:37',	NULL);

DROP TABLE IF EXISTS `replanteos`;
CREATE TABLE `replanteos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `presupuesto_id` bigint unsigned NOT NULL,
  `dias` int DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` int DEFAULT NULL,
  `m2` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `descripcion_tarea` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `replanteos_presupuesto_id_foreign` (`presupuesto_id`),
  CONSTRAINT `replanteos_presupuesto_id_foreign` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `replanteos` (`id`, `observaciones`, `presupuesto_id`, `dias`, `descripcion`, `orden`, `m2`, `created_at`, `updated_at`, `descripcion_tarea`) VALUES
(1,	'1',	2,	0,	NULL,	1,	0.00,	'2025-04-17 17:58:21',	'2025-04-17 18:01:26',	'dsf'),
(2,	'',	3,	0,	NULL,	1,	0.00,	'2025-04-17 19:49:35',	'2025-04-17 19:49:35',	'xcv'),
(3,	'',	9,	0,	NULL,	1,	0.00,	'2025-04-17 23:29:53',	'2025-04-17 23:29:53',	'vb'),
(4,	'',	7,	0,	NULL,	1,	4.00,	'2025-04-18 11:15:44',	'2025-04-18 11:19:10',	'gf'),
(5,	'',	7,	0,	NULL,	2,	4.00,	'2025-04-18 11:19:10',	'2025-04-18 11:19:10',	'cgxf'),
(6,	'',	17,	0,	NULL,	1,	0.00,	'2025-04-18 11:38:26',	'2025-04-18 11:38:26',	'fg'),
(7,	'',	16,	0,	NULL,	1,	0.00,	'2025-04-18 11:40:31',	'2025-04-18 11:40:31',	'klñ'),
(8,	'',	18,	5,	NULL,	1,	41.00,	'2025-04-18 11:44:46',	'2025-04-18 11:44:46',	'lñ'),
(9,	'',	18,	2,	NULL,	2,	5.00,	'2025-04-18 11:44:46',	'2025-04-18 11:44:46',	'fdgh'),
(10,	'',	19,	0,	NULL,	1,	0.00,	'2025-04-18 12:30:52',	'2025-04-18 12:30:52',	'asfg'),
(11,	'',	19,	0,	NULL,	2,	0.00,	'2025-04-18 12:30:52',	'2025-04-18 12:30:52',	'sdf'),
(12,	'',	20,	0,	NULL,	1,	0.00,	'2025-04-18 13:02:54',	'2025-04-18 13:02:54',	'1'),
(13,	'',	21,	0,	NULL,	1,	0.00,	'2025-04-18 13:32:13',	'2025-04-18 13:32:13',	'hj'),
(14,	'',	21,	0,	NULL,	2,	0.00,	'2025-04-18 13:32:13',	'2025-04-18 13:32:13',	'hj'),
(15,	'',	22,	0,	NULL,	1,	0.00,	'2025-04-18 13:47:15',	'2025-04-18 13:47:15',	'jh'),
(16,	'',	23,	0,	NULL,	1,	0.00,	'2025-04-18 13:58:00',	'2025-04-18 13:58:00',	'd'),
(17,	'',	8,	0,	NULL,	1,	0.00,	'2025-04-18 15:01:24',	'2025-04-18 15:01:24',	'sdfg');

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ktxPLskWzyZdSudyP3meu8pyjLrtpl3xzfhpDgBJ',	1,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Avast/133.0.0.0',	'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUkpTaUc2UG9PNDVUTHI5T2RJMDZKbDhJWjlpSVBEM3Q3M2JDVGxzcyI7czozOiJ1cmwiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ5OiJodHRwOi8vcHJvb2JyYWMuaW50cmFuZXQudGVzdC9wcmVzdXB1ZXN0b3MvOC9lZGl0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',	1744977693);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'Administrador',	'admin@proobra.com',	NULL,	'$2y$12$DudqMAPw2tYlpLJeq3uiVOR/RvWIsZ2EMVyOqASeQpyU7iNUsfAJq',	NULL,	'2025-04-17 13:05:48',	'2025-04-17 13:16:10');

-- 2025-04-18 12:21:03
