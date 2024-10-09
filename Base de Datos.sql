-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para prueba
CREATE DATABASE IF NOT EXISTS `prueba` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `prueba`;

-- Volcando estructura para tabla prueba.doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Volcando datos para la tabla prueba.doctrine_migration_versions: ~0 rows (aproximadamente)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20241007050421', '2024-10-07 05:05:12', 61);

-- Volcando estructura para tabla prueba.messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla prueba.messenger_messages: ~0 rows (aproximadamente)

-- Volcando estructura para tabla prueba.producto
CREATE TABLE IF NOT EXISTS `producto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `clave_producto` int NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A7BB0615489290A8` (`clave_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla prueba.producto: ~1 rows (aproximadamente)
INSERT INTO `producto` (`id`, `clave_producto`, `nombre`, `precio`) VALUES
	(19, 2, 'Nuevo Nombre', 50),
	(27, 3, 'Paracetamol', 15),
	(28, 4, 'Paracetamol 350mg', 123),
	(30, 1, 'Naproxeno 123 mg', 50);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
