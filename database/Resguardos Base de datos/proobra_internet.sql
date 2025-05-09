-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.4.3 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para proobra_intranet
CREATE DATABASE IF NOT EXISTS `proobra_intranet` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `proobra_intranet`;

-- Volcando estructura para tabla proobra_intranet.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.mano_de_obra
CREATE TABLE IF NOT EXISTS `mano_de_obra` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `replanteo_id` bigint unsigned NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dias` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mano_de_obra_replanteo_id_foreign` (`replanteo_id`),
  CONSTRAINT `mano_de_obra_replanteo_id_foreign` FOREIGN KEY (`replanteo_id`) REFERENCES `replanteos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.materiales
CREATE TABLE IF NOT EXISTS `materiales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `replanteo_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `materiales_replanteo_id_foreign` (`replanteo_id`),
  CONSTRAINT `materiales_replanteo_id_foreign` FOREIGN KEY (`replanteo_id`) REFERENCES `replanteos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.obras
CREATE TABLE IF NOT EXISTS `obras` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` bigint unsigned NOT NULL,
  `fecha_aceptacion` date DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `duracion_dias` int NOT NULL,
  `estado` enum('aceptada','en_ejecucion','finalizada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aceptada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.presupuestos
CREATE TABLE IF NOT EXISTS `presupuestos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cliente_nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `duracion_dias` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cliente` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `superficie` decimal(8,2) DEFAULT NULL,
  `bps_mano_obra` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.presupuesto_costos
CREATE TABLE IF NOT EXISTS `presupuesto_costos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `presupuesto_id` bigint unsigned NOT NULL,
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `concepto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `presupuesto_costos_presupuesto_id_foreign` (`presupuesto_id`),
  CONSTRAINT `presupuesto_costos_presupuesto_id_foreign` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.replanteos
CREATE TABLE IF NOT EXISTS `replanteos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `presupuesto_id` bigint unsigned NOT NULL,
  `descripcion_tarea` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` int NOT NULL DEFAULT '0',
  `dias` int DEFAULT NULL,
  `metros2` decimal(8,2) DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `replanteos_presupuesto_id_foreign` (`presupuesto_id`),
  CONSTRAINT `replanteos_presupuesto_id_foreign` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
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

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla proobra_intranet.users
CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
