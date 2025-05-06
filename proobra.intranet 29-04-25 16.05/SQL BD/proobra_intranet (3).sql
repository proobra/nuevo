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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gastos_fijos_presupuesto` (`id`, `cantidad_ml`, `presupuesto_id`, `gasto_fijo_id`, `valor_aplicado`, `created_at`, `updated_at`) VALUES
(55,	NULL,	34,	1,	22.00,	'2025-04-18 20:48:05',	'2025-04-18 20:48:05');

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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `laudos_operarios` (`id`, `orden`, `categoria`, `sector`, `laudo_base`, `desgaste_ropa`, `transporte`, `s_balancin`, `herramientas`, `alimentos`, `presentismo_semanal`, `presentismo_mensual`, `total_jornal`, `created_at`, `updated_at`) VALUES
(1,	1,	'Oficial VIII',	'Construcción',	2612.37,	97.63,	85.42,	195.30,	39.04,	195.30,	206.41,	99.04,	3530.51,	NULL,	'2025-04-17 15:58:06'),
(2,	2,	'½ Oficial V',	'Construcción',	1953.01,	97.63,	85.42,	195.30,	39.04,	195.30,	154.31,	74.04,	2794.05,	NULL,	NULL),
(3,	3,	'Peón práctico cat IV',	'Construcción',	1804.44,	97.63,	85.42,	58.59,	0.00,	173.82,	142.57,	68.41,	2430.88,	NULL,	NULL),
(4,	4,	'Peón común cat III',	'Construcción',	1656.22,	97.63,	85.42,	58.59,	0.00,	173.82,	142.57,	68.41,	2282.66,	NULL,	NULL),
(5,	5,	'Oficial IyC',	'Industria y Comercio',	3181.82,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	3181.82,	NULL,	NULL),
(6,	6,	'Medio Oficial IyC',	'Industria y Comercio',	2378.83,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	2378.83,	NULL,	NULL),
(7,	7,	'Peón IyC',	'Industria y Comercio',	2197.70,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	2197.70,	NULL,	NULL),
(8,	8,	'Peón común IyC',	'Industria y Comercio',	2018.38,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	0.00,	2018.38,	NULL,	NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mano_de_obra` (`id`, `presupuesto_id`, `replanteo_id`, `categoria`, `cantidad`, `dias`, `comentario`, `created_at`, `updated_at`) VALUES
(40,	34,	23,	'Oficial VIII',	2.00,	2,	'',	'2025-04-18 20:48:05',	'2025-04-18 20:48:05'),
(41,	34,	23,	'Medio Oficial IyC',	2.00,	2,	'',	'2025-04-18 20:48:05',	'2025-04-18 20:48:05');

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `materiales` (`id`, `orden`, `presupuesto_id`, `replanteo_id`, `descripcion`, `cantidad_unidades`, `costo_unitario`, `manos`, `rendimiento`, `litros_por_lata`, `created_at`, `updated_at`) VALUES
(23,	1,	34,	23,	NULL,	14.00,	14144.00,	0.00,	1.00,	1.00,	'2025-04-18 20:48:05',	'2025-04-18 20:48:05'),
(24,	1,	34,	23,	NULL,	4.00,	855.00,	0.00,	1.00,	1.00,	'2025-04-18 20:48:05',	'2025-04-18 20:48:05');

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `presupuestos` (`id`, `titulo`, `titulo_caratula`, `descripcion`, `bps_mano_obra`, `caratula`, `empresa`, `cliente`, `telefono`, `direccion`, `email`, `fecha`, `fecha_inicio`, `duracion_dias`, `superficie`, `utilidad`, `bps_porcentaje`, `created_at`, `updated_at`, `comentarios`) VALUES
(34,	'Nuevo presupuesto',	'',	'Presupuesto generado automáticamente',	0.00,	NULL,	'proobra',	'prueba',	'099363251',	'Sajama 137',	'martinporcires@gmail.com',	NULL,	'2025-04-18 17:45:01',	0,	100.00,	65.00,	0.00,	'2025-04-18 20:45:01',	'2025-04-18 20:48:15',	NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `replanteos` (`id`, `observaciones`, `presupuesto_id`, `dias`, `descripcion`, `orden`, `m2`, `created_at`, `updated_at`, `descripcion_tarea`) VALUES
(23,	'',	34,	0,	NULL,	1,	0.00,	'2025-04-18 20:48:05',	'2025-04-18 20:48:05',	'Prueba'),
(24,	'',	34,	0,	NULL,	2,	0.00,	'2025-04-18 20:48:05',	'2025-04-18 20:48:05',	'Prueba 2');

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
('6TJCjVgleRyjBzQ6ywkFr9TZNq9wYcJWeVDbNJ2y',	NULL,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.19.0 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36',	'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2s2akhnRlJabEZkOHpsMWdKNWxFVjlkUGFYRnY2aVJVcWNLNXVJZyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cDovL3Byb29icmFjLmludHJhbmV0LnRlc3QvP2hlcmQ9cHJldmlldyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwOi8vcHJvb2JyYWMuaW50cmFuZXQudGVzdC8/aGVyZD1wcmV2aWV3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',	1744995487),
('ktxPLskWzyZdSudyP3meu8pyjLrtpl3xzfhpDgBJ',	1,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Avast/133.0.0.0',	'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUkpTaUc2UG9PNDVUTHI5T2RJMDZKbDhJWjlpSVBEM3Q3M2JDVGxzcyI7czozOiJ1cmwiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUwOiJodHRwOi8vcHJvb2JyYWMuaW50cmFuZXQudGVzdC9wcmVzdXB1ZXN0b3MvMzEvZWRpdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',	1744984772),
('n1pnSG8sBxmAIlWpSXmnjYzJtplvlve3YhaoXFHr',	1,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Avast/133.0.0.0',	'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieVN6YW5lajFQSEI5azdpQ0x3VXJSd1VlaWZnNE9TR2R4SVVwN3o2RyI7czozOiJ1cmwiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUwOiJodHRwOi8vcHJvb2JyYWMuaW50cmFuZXQudGVzdC9wcmVzdXB1ZXN0b3MvMzQvZWRpdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',	1744998495),
('xssDrhbYjAeyIfkrAajk8zD60ktYfWSXKH4G3PwM',	NULL,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Herd/1.19.0 Chrome/120.0.6099.291 Electron/28.2.5 Safari/537.36',	'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSEliSzdJeklDQ3RLc29rbHhQUkgyMktYeGhZSlBnTmlRUUwybzJTRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9wcm9vYnJhYy5pbnRyYW5ldC50ZXN0L2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',	1744995489);

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

-- 2025-04-18 17:51:29
