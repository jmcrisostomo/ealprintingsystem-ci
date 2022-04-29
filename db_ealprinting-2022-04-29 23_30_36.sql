-- --------------------------------------------------------
-- Host:                         ngsi-db-server-1.ckihoohm6pyv.ap-southeast-1.rds.amazonaws.com
-- Server version:               8.0.23 - Source distribution
-- Server OS:                    Linux
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for db_ealprinting
CREATE DATABASE IF NOT EXISTS `db_ealprinting` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_ealprinting`;

-- Dumping structure for table db_ealprinting.tbl_attribute
CREATE TABLE IF NOT EXISTS `tbl_attribute` (
  `attribute_id` int NOT NULL AUTO_INCREMENT,
  `attribute_name` int NOT NULL DEFAULT '0',
  `state` varchar(50) NOT NULL DEFAULT '0',
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_by` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_ealprinting.tbl_attribute: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_attribute` ENABLE KEYS */;

-- Dumping structure for table db_ealprinting.tbl_audit_trail
CREATE TABLE IF NOT EXISTS `tbl_audit_trail` (
  `audit_trail_id` int NOT NULL AUTO_INCREMENT,
  `description` mediumtext,
  `date_modifed` datetime DEFAULT CURRENT_TIMESTAMP,
  `modify_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`audit_trail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table db_ealprinting.tbl_audit_trail: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_audit_trail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_audit_trail` ENABLE KEYS */;

-- Dumping structure for table db_ealprinting.tbl_cart
CREATE TABLE IF NOT EXISTS `tbl_cart` (
  `card_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(20,6) DEFAULT NULL,
  `date_modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `modify_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table db_ealprinting.tbl_cart: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_cart` ENABLE KEYS */;

-- Dumping structure for table db_ealprinting.tbl_category
CREATE TABLE IF NOT EXISTS `tbl_category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `state` varchar(255) DEFAULT 'ACTIVE',
  `category_name` varchar(255) DEFAULT NULL,
  `date_modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `modify_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table db_ealprinting.tbl_category: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_category` DISABLE KEYS */;
INSERT INTO `tbl_category` (`category_id`, `state`, `category_name`, `date_modified`, `modify_by`) VALUES
	(1, 'ACTIVE', 'Apparel', '2022-04-16 08:56:24', 'GENESIS_RECORD');
/*!40000 ALTER TABLE `tbl_category` ENABLE KEYS */;

-- Dumping structure for table db_ealprinting.tbl_product
CREATE TABLE IF NOT EXISTS `tbl_product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT 'ACTIVE',
  `description` text NOT NULL,
  `category_id` int DEFAULT NULL,
  `price` double(12,4) DEFAULT '0.0000',
  `current_stock` int DEFAULT NULL,
  `ceiling_stock` int DEFAULT NULL,
  `flooring_stock` int DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '[product_image].[file_extension]',
  `product_image_ext` varchar(50) DEFAULT NULL,
  `date_modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `modify_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table db_ealprinting.tbl_product: ~1 rows (approximately)
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
INSERT INTO `tbl_product` (`product_id`, `product_name`, `state`, `description`, `category_id`, `price`, `current_stock`, `ceiling_stock`, `flooring_stock`, `sku`, `product_image`, `product_image_ext`, `date_modified`, `modify_by`) VALUES
	(1, 'Unisex T-Shirt', 'ACTIVE', 'Lorem Ipsum', 1, 100.0000, 10, 10, 5, 'UNISHRT0001', 'istockphoto-1003948670-612x612', 'jpg', '2022-04-16 08:56:10', 'GENESIS_RECORD');
/*!40000 ALTER TABLE `tbl_product` ENABLE KEYS */;

-- Dumping structure for table db_ealprinting.tbl_product_variation
CREATE TABLE IF NOT EXISTS `tbl_product_variation` (
  `product_variation_id` int NOT NULL AUTO_INCREMENT,
  `attribute_id` int NOT NULL DEFAULT '0',
  `product_id` int NOT NULL DEFAULT '0',
  `price` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `state` varchar(255) DEFAULT NULL,
  `product_url` varchar(255) DEFAULT NULL,
  `date_modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `modify_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`product_variation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_ealprinting.tbl_product_variation: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_product_variation` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_product_variation` ENABLE KEYS */;

-- Dumping structure for table db_ealprinting.tbl_transaction
CREATE TABLE IF NOT EXISTS `tbl_transaction` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `state` varchar(255) DEFAULT 'ACTIVE',
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `transaction_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `remark` text,
  `modify_by` varchar(255) DEFAULT NULL,
  `date_modified` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table db_ealprinting.tbl_transaction: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_transaction` ENABLE KEYS */;

-- Dumping structure for table db_ealprinting.tbl_user
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `state` varchar(255) DEFAULT 'ACTIVE' COMMENT 'ACTIVE/INACTIVE',
  `user_type_id` int DEFAULT '0',
  `user_status` varchar(255) DEFAULT 'VERIFIED' COMMENT 'VERIFIED/UNVERIFIED',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table db_ealprinting.tbl_user: ~1 rows (approximately)
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` (`user_id`, `state`, `user_type_id`, `user_status`, `first_name`, `last_name`, `username`, `password`, `date_modified`, `modify_by`) VALUES
	(1, 'ACTIVE', 1, 'VERIFIED', 'Admin', '', 'admin', 'password!123', '2022-04-08 15:40:40', 'GENESIS_RECORD'),
	(2, 'ACTIVE', 2, 'VERIFIED', 'John', 'Doe', 'john.doe', '123456', '2022-04-21 06:07:00', 'GENESIS_RECORD');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;

-- Dumping structure for table db_ealprinting.tbl_user_type
CREATE TABLE IF NOT EXISTS `tbl_user_type` (
  `user_type_id` int NOT NULL AUTO_INCREMENT,
  `state` varchar(255) DEFAULT 'ACTIVE',
  `user_type` varchar(255) DEFAULT NULL,
  `date_modified` datetime DEFAULT CURRENT_TIMESTAMP,
  `modify_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table db_ealprinting.tbl_user_type: ~2 rows (approximately)
/*!40000 ALTER TABLE `tbl_user_type` DISABLE KEYS */;
INSERT INTO `tbl_user_type` (`user_type_id`, `state`, `user_type`, `date_modified`, `modify_by`) VALUES
	(1, 'ACTIVE', 'ADMIN', '2022-04-04 16:37:59', 'GENESIS_RECORD'),
	(2, 'ACTIVE', 'CUSTOMER', '2022-04-04 16:38:35', 'GENESIS_RECORD');
/*!40000 ALTER TABLE `tbl_user_type` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
