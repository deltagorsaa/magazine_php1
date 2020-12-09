-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fashion_db
-- ------------------------------------------------------
-- Server version	8.0.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cities` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `country_id` smallint NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_country_fk_idx` (`country_id`),
  CONSTRAINT `cities_country_fk` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (2,1,'Москва'),(3,1,'Владивосток');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Россия');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencies` (
  `code` smallint NOT NULL,
  `short_name` varchar(3) NOT NULL,
  `full_name` varchar(45) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'RUB','Российский рубль');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_office_payment_type`
--

DROP TABLE IF EXISTS `delivery_office_payment_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivery_office_payment_type` (
  `office_id` int NOT NULL,
  `payment_type_id` tinyint NOT NULL,
  UNIQUE KEY `delivery_office_payment_type_idx` (`office_id`,`payment_type_id`),
  KEY `delivery_office_payment_type_payment_fk_idx` (`payment_type_id`),
  CONSTRAINT `delivery_office_payment_type_office_fk` FOREIGN KEY (`office_id`) REFERENCES `delivery_offices` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `delivery_office_payment_type_payment_fk` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_types` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_office_payment_type`
--

LOCK TABLES `delivery_office_payment_type` WRITE;
/*!40000 ALTER TABLE `delivery_office_payment_type` DISABLE KEYS */;
INSERT INTO `delivery_office_payment_type` VALUES (1,1),(1,2),(2,2);
/*!40000 ALTER TABLE `delivery_office_payment_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_office_worktime`
--

DROP TABLE IF EXISTS `delivery_office_worktime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivery_office_worktime` (
  `office_id` int NOT NULL,
  `day_number` tinyint NOT NULL,
  `worktime_from` varchar(5) NOT NULL,
  `worktime_to` varchar(5) NOT NULL,
  UNIQUE KEY `delivery_office_worktime_idx` (`office_id`,`day_number`),
  KEY `delivery_office_worktime_office_fk_idx` (`office_id`) /*!80000 INVISIBLE */,
  CONSTRAINT `delivery_office_worktime_office_fk` FOREIGN KEY (`office_id`) REFERENCES `delivery_offices` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_office_worktime`
--

LOCK TABLES `delivery_office_worktime` WRITE;
/*!40000 ALTER TABLE `delivery_office_worktime` DISABLE KEYS */;
INSERT INTO `delivery_office_worktime` VALUES (1,1,'9:00','22:00'),(1,2,'9:00','22:00'),(1,3,'9:00','22:00'),(1,4,'9:00','22:00'),(1,5,'9:00','22:00'),(1,6,'9:00','22:00'),(1,7,'9:00','22:00'),(2,4,'10:00','12:00');
/*!40000 ALTER TABLE `delivery_office_worktime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_offices`
--

DROP TABLE IF EXISTS `delivery_offices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivery_offices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `street_id` smallint NOT NULL,
  `room` varchar(20) DEFAULT NULL,
  `min_delivery_day` smallint NOT NULL,
  `max_delivery_day` smallint NOT NULL,
  `street_number` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_offices`
--

LOCK TABLES `delivery_offices` WRITE;
/*!40000 ALTER TABLE `delivery_offices` DISABLE KEYS */;
INSERT INTO `delivery_offices` VALUES (1,2,NULL,5,7,'4'),(2,2,'4',2,3,'22');
/*!40000 ALTER TABLE `delivery_offices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_types`
--

DROP TABLE IF EXISTS `delivery_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `delivery_types` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `add_price` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_types`
--

LOCK TABLES `delivery_types` WRITE;
/*!40000 ALTER TABLE `delivery_types` DISABLE KEYS */;
INSERT INTO `delivery_types` VALUES (1,'Самовывоз',0),(2,'Курьерская доставка',280);
/*!40000 ALTER TABLE `delivery_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `good_group`
--

DROP TABLE IF EXISTS `good_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `good_group` (
  `good_id` int NOT NULL,
  `group_id` int DEFAULT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `good_group_idx` (`good_id`,`group_id`),
  KEY `good_group_group_fk_idx` (`group_id`),
  CONSTRAINT `good_group_good_fk` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `good_group_group_fk` FOREIGN KEY (`group_id`) REFERENCES `good_groups` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `good_group`
--

LOCK TABLES `good_group` WRITE;
/*!40000 ALTER TABLE `good_group` DISABLE KEYS */;
INSERT INTO `good_group` VALUES (21,3,1),(21,6,0),(21,1,0),(23,2,1),(23,6,0),(23,7,0),(23,1,0),(24,3,1),(24,6,0),(24,1,0),(25,2,1),(25,1,0),(27,2,1),(27,6,0),(27,1,0),(28,2,1),(28,6,0),(28,7,0),(28,1,0),(29,2,1),(29,1,0),(30,2,1),(30,7,0),(30,1,0),(31,8,1),(31,6,0),(31,7,0),(31,1,0),(32,5,1),(32,6,0),(32,1,0),(33,5,1),(33,6,0),(33,1,0),(26,5,1),(26,1,0),(34,3,1),(34,6,0),(34,1,0),(35,5,1),(35,6,0),(35,7,0),(35,1,0),(22,2,1),(22,6,0),(22,7,0),(22,1,0);
/*!40000 ALTER TABLE `good_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `good_groups`
--

DROP TABLE IF EXISTS `good_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `good_groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `short_name` varchar(45) NOT NULL,
  `is_gui_visible` tinyint(1) NOT NULL DEFAULT '0',
  `gui_filter_type` varchar(10) DEFAULT 'category',
  `code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `good_groups`
--

LOCK TABLES `good_groups` WRITE;
/*!40000 ALTER TABLE `good_groups` DISABLE KEYS */;
INSERT INTO `good_groups` VALUES (1,'Все',1,'category','all'),(2,'Женщины',1,'category','women'),(3,'Мужчины',1,'category','men'),(4,'Дети',1,'category','children'),(5,'Аксессуары',1,'category','acces'),(6,'Новинки',1,'checked','new'),(7,'Распродажа',1,'checked','sale'),(8,'Часы',0,'category','watch'),(9,'Платья',0,'category','dress'),(10,'Сумки',0,'category','bags');
/*!40000 ALTER TABLE `good_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goods` (
  `id` int NOT NULL AUTO_INCREMENT,
  `short_name` varchar(45) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `currency_code` smallint NOT NULL DEFAULT '1',
  `image_path` varchar(255) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `goods_currency_fk_idx` (`currency_code`),
  CONSTRAINT `goods_currency_fk` FOREIGN KEY (`currency_code`) REFERENCES `currencies` (`code`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (21,'qwerty',123,1,'/img/products/408D551F-1897-459A-B139-5562691EA9E6_1598588829808_default.jpg','2020-10-13 12:44:47',0),(22,'Платье',888,1,'/img/products/0E367FF2-A9AC-4BB0-A657-33F03A50219C_1598588829808_default.jpeg','2020-10-27 16:35:05',1),(23,'Рубашка',500,1,'/img/products/FD3B7F95-B4B6-4EAA-ADDB-DDD38B110E71_product-2.jpg','2020-10-27 16:35:33',1),(24,'Часы',1000,1,'/img/products/040FDD8D-863C-49E8-8F23-6A0AEBAD288C_product-3.jpg','2020-10-27 16:35:50',1),(25,'Брюки',1500,1,'/img/products/650503BB-ABC4-4169-AEDF-D86C81D0F94F_product-4.jpg','2020-10-27 16:36:16',1),(26,'Сумка',900,1,'/img/products/46D66692-5375-4D68-A26D-F34131039C94_1598588829808_default.jpeg','2020-10-27 16:36:31',1),(27,'Платье',200,1,'/img/products/DDF85E68-C277-4980-B7E4-12B4B1D0E3F7_product-6.jpg','2020-10-27 16:36:51',1),(28,'Пальто с коротким рукавом',1100,1,'/img/products/065B4B29-DBF4-474C-8DF7-C47204354668_product-7.jpg','2020-10-27 16:37:19',1),(29,'Джинсы',300,1,'/img/products/E2291510-75F2-444C-898A-A660C944DA82_product-8.jpg','2020-10-27 16:37:36',1),(30,'Обувь',1400,1,'/img/products/60731156-4E6C-4F0A-B4BA-3FB3F7DB64BB_product-9.jpg','2020-10-27 16:37:51',1),(31,'Часы копия',12,1,'/img/products/4750B89B-C292-4944-A713-9BEB3B8E24D7_product-3.jpg','2020-10-27 16:38:37',1),(32,'Обувь копия',234,1,'','2020-10-27 16:55:50',0),(33,'Обувь копия',238,1,'/img/products/04764FD7-0F05-45C3-9F65-1B28276F6168_1598588829808_default.jpeg','2020-10-27 16:57:38',1),(34,'12',123,1,'/img/products/07583B00-93DA-4E54-A039-89639F04FCDA_1.jpg','2020-11-22 21:24:11',1),(35,'qwerty123',0,1,'/img/products/1A9DAA3E-B28D-4A34-994C-806C4E9AFD8C_1.jpg','2020-11-22 21:24:58',1);
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_history`
--

DROP TABLE IF EXISTS `goods_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goods_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `good_id` int NOT NULL,
  `short_name` varchar(45) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `currency_code` smallint NOT NULL DEFAULT '1',
  `image_path` varchar(255) NOT NULL,
  `change_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `goods_history_currency_fk_idx` (`currency_code`),
  KEY `goods_history_good_fk_idx` (`good_id`),
  CONSTRAINT `goods_history_currency_fk` FOREIGN KEY (`currency_code`) REFERENCES `currencies` (`code`) ON UPDATE CASCADE,
  CONSTRAINT `goods_history_good_fk` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_history`
--

LOCK TABLES `goods_history` WRITE;
/*!40000 ALTER TABLE `goods_history` DISABLE KEYS */;
INSERT INTO `goods_history` VALUES (28,21,'qwerty',123,1,'/img/products/408D551F-1897-459A-B139-5562691EA9E6_1598588829808_default.jpg','2020-10-13 12:44:47',1),(29,21,'qwerty',123,1,'/img/products/408D551F-1897-459A-B139-5562691EA9E6_1598588829808_default.jpg','2020-10-27 16:32:49',0),(30,22,'Платье',800,1,'/img/products/E3E91EFF-E0C2-4EC0-8622-9363DD369EB1_product-1.jpg','2020-10-27 16:35:05',1),(31,23,'Рубашка',500,1,'/img/products/FD3B7F95-B4B6-4EAA-ADDB-DDD38B110E71_product-2.jpg','2020-10-27 16:35:33',1),(32,24,'Часы',1000,1,'/img/products/040FDD8D-863C-49E8-8F23-6A0AEBAD288C_product-3.jpg','2020-10-27 16:35:50',1),(33,25,'Брюки',1500,1,'/img/products/650503BB-ABC4-4169-AEDF-D86C81D0F94F_product-4.jpg','2020-10-27 16:36:16',1),(34,26,'Сумка',900,1,'/img/products/8770854B-3D56-4169-A14F-F13B51EB2592_product-5.jpg','2020-10-27 16:36:31',1),(35,27,'Платье',200,1,'/img/products/DDF85E68-C277-4980-B7E4-12B4B1D0E3F7_product-6.jpg','2020-10-27 16:36:51',1),(36,28,'Пальто с коротким рукавом',1100,1,'/img/products/065B4B29-DBF4-474C-8DF7-C47204354668_product-7.jpg','2020-10-27 16:37:19',1),(37,29,'Джинсы',300,1,'/img/products/E2291510-75F2-444C-898A-A660C944DA82_product-8.jpg','2020-10-27 16:37:36',1),(38,30,'Обувь',1400,1,'/img/products/60731156-4E6C-4F0A-B4BA-3FB3F7DB64BB_product-9.jpg','2020-10-27 16:37:51',1),(39,31,'Часы копия',12,1,'/img/products/4750B89B-C292-4944-A713-9BEB3B8E24D7_product-3.jpg','2020-10-27 16:38:37',1),(42,33,'Обувь копия',234,1,'/img/products/6DB8EF1C-1AA8-47A6-B72C-5FE51D693EA9_product-9.jpg','2020-10-27 16:57:38',1),(43,22,'Платье',800,1,'/img/products/E3E91EFF-E0C2-4EC0-8622-9363DD369EB1_product-1.jpg','2020-10-29 16:38:33',1),(44,22,'Платье',808,1,'/img/products/467ED634-1ECD-4DBA-A263-470969D3E467_диплом.jpg','2020-10-29 16:39:01',1),(45,22,'Платье',810,1,'/img/products/467ED634-1ECD-4DBA-A263-470969D3E467_диплом.jpg','2020-10-29 16:39:34',1),(46,22,'Платье',810,1,'/img/products/2E98FDD9-AC01-41F0-9938-2280FA6C83E2_product-1.jpg','2020-10-29 16:40:00',1),(47,22,'Платье',810,1,'/img/products/2A4897E3-9631-4697-9AF0-BE3B37E2226E_1.jpg','2020-11-11 12:53:03',1),(48,22,'Платье',810,1,'/img/products/226FB4A2-2EA2-4433-9373-EAAFD7910331_1.jpg','2020-11-11 12:53:33',1),(49,31,'Часы копия',12,1,'/img/products/4750B89B-C292-4944-A713-9BEB3B8E24D7_product-3.jpg','2020-11-11 12:54:04',0),(50,33,'Обувь копия',238,1,'/img/products/6DB8EF1C-1AA8-47A6-B72C-5FE51D693EA9_product-9.jpg','2020-11-11 13:00:34',1),(51,31,'Часы копия',12,1,'/img/products/4750B89B-C292-4944-A713-9BEB3B8E24D7_product-3.jpg','2020-11-11 13:02:26',1),(52,33,'Обувь копия',238,1,'/img/products/04764FD7-0F05-45C3-9F65-1B28276F6168_1598588829808_default.jpeg','2020-11-18 15:10:03',1),(53,26,'Сумка',900,1,'/img/products/46D66692-5375-4D68-A26D-F34131039C94_1598588829808_default.jpeg','2020-11-18 15:17:12',1),(54,22,'Платье',810,1,'/img/products/A6B67082-BEAC-4854-9BF7-E615FD302ACA_диплом.jpg','2020-11-18 15:17:58',1),(55,22,'Платье',810,1,'/img/products/0E367FF2-A9AC-4BB0-A657-33F03A50219C_1598588829808_default.jpeg','2020-11-18 15:18:24',1),(56,34,'12',123,1,'/img/products/07583B00-93DA-4E54-A039-89639F04FCDA_1.jpg','2020-11-22 21:24:11',1),(57,35,'qwerty123',0,1,'/img/products/1A9DAA3E-B28D-4A34-994C-806C4E9AFD8C_1.jpg','2020-11-22 21:24:58',1),(62,22,'Платье',888,1,'/img/products/0E367FF2-A9AC-4BB0-A657-33F03A50219C_1598588829808_default.jpeg','2020-11-25 14:12:36',1);
/*!40000 ALTER TABLE `goods_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_good`
--

DROP TABLE IF EXISTS `order_good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_good` (
  `order_id` int NOT NULL,
  `good_id` int NOT NULL,
  `count` float NOT NULL,
  UNIQUE KEY `order_good_idx` (`order_id`,`good_id`),
  KEY `order_good_order_idx` (`order_id`),
  KEY `order_good_good_fk_idx` (`good_id`),
  CONSTRAINT `order_good_good_fk` FOREIGN KEY (`good_id`) REFERENCES `goods_history` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `order_good_order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_good`
--

LOCK TABLES `order_good` WRITE;
/*!40000 ALTER TABLE `order_good` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_good` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `payment_type_id` tinyint NOT NULL,
  `delivery_type_id` tinyint NOT NULL,
  `delivery_office_id` int DEFAULT NULL,
  `street_id` int DEFAULT NULL,
  `street_number` varchar(10) DEFAULT NULL,
  `room` varchar(10) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `create_by` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_payment_type_fk_idx` (`payment_type_id`) /*!80000 INVISIBLE */,
  KEY `order_street_fk_idx` (`street_id`),
  KEY `order_delivery_type_fk_idx` (`delivery_type_id`),
  KEY `order_delivery_office_fk_idx` (`delivery_office_id`),
  KEY `order_user_fk_idx` (`create_by`),
  CONSTRAINT `order_delivery_office_fk` FOREIGN KEY (`delivery_office_id`) REFERENCES `delivery_offices` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `order_delivery_type_fk` FOREIGN KEY (`delivery_type_id`) REFERENCES `delivery_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `order_payment_type_fk` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `order_street_fk` FOREIGN KEY (`street_id`) REFERENCES `streets` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `order_user_fk` FOREIGN KEY (`create_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_types`
--

DROP TABLE IF EXISTS `payment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_types` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_types`
--

LOCK TABLES `payment_types` WRITE;
/*!40000 ALTER TABLE `payment_types` DISABLE KEYS */;
INSERT INTO `payment_types` VALUES (1,'Наличные'),(2,'Банковской картой');
/*!40000 ALTER TABLE `payment_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `streets`
--

DROP TABLE IF EXISTS `streets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `streets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `city_id` smallint NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `street_city_fk_idx` (`city_id`),
  CONSTRAINT `street_city_fk` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `streets`
--

LOCK TABLES `streets` WRITE;
/*!40000 ALTER TABLE `streets` DISABLE KEYS */;
INSERT INTO `streets` VALUES (2,2,'Тверская'),(3,3,'Гамарника');
/*!40000 ALTER TABLE `streets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_group` (
  `user_id` int NOT NULL,
  `group_id` smallint NOT NULL,
  UNIQUE KEY `user_group_idx` (`user_id`,`group_id`),
  KEY `user_group-group_fk_idx` (`group_id`),
  CONSTRAINT `user_group-group_fk` FOREIGN KEY (`group_id`) REFERENCES `user_groups` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `user_group-user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (1,1),(2,1),(1,2);
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_groups` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'Оператор','Может заходить в административный интерфейс и видеть список заказов'),(2,'Администратор','может заходить в административный интерфейс, видеть список заказов и управлять товарами');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` bigint NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_client` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Тестовый Тест Тестович1','test@test.com','65e84be33532fb784c48129675f9eff3a682b27168c0ea744b2cf58ee02337c5',70000000000,'2020-09-24 00:00:00',1,0),(2,'Тестовый Тест Тестович2','test2@test2.com','65e84be33532fb784c48129675f9eff3a682b27168c0ea744b2cf58ee02337c5',70000000001,'2020-09-25 00:00:00',1,0),(25,'Клиентский Клиент Клиентович','client@client2.com','8510e6683d7b9083bad10a1738199ae0ab90410fd8979f9379b6fb01c171870d',70000000002,'2020-10-01 19:41:02',1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-25 15:54:36
