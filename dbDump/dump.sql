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
-- Table structure for table `deliveries_from`
--

DROP TABLE IF EXISTS `deliveries_from`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deliveries_from` (
  `order_id` int NOT NULL,
  `delivery_type_id` tinyint NOT NULL,
  `delivery_office_id` int NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `delivery_from_type_fk_idx` (`delivery_type_id`),
  CONSTRAINT `delivery_from_order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `delivery_from_type_fk` FOREIGN KEY (`delivery_type_id`) REFERENCES `delivery_types` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliveries_from`
--

LOCK TABLES `deliveries_from` WRITE;
/*!40000 ALTER TABLE `deliveries_from` DISABLE KEYS */;
/*!40000 ALTER TABLE `deliveries_from` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deliveries_to`
--

DROP TABLE IF EXISTS `deliveries_to`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deliveries_to` (
  `order_id` int NOT NULL,
  `street_id` int NOT NULL,
  `room` varchar(10) NOT NULL,
  `delivery_type_id` tinyint NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `deliveries_delivery_type_fk_idx` (`delivery_type_id`),
  KEY `deliveries_to_street_id_idx` (`street_id`),
  CONSTRAINT `deliveries_to_delivery_type_fk` FOREIGN KEY (`delivery_type_id`) REFERENCES `delivery_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `deliveries_to_order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `deliveries_to_street_fk` FOREIGN KEY (`street_id`) REFERENCES `streets` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliveries_to`
--

LOCK TABLES `deliveries_to` WRITE;
/*!40000 ALTER TABLE `deliveries_to` DISABLE KEYS */;
/*!40000 ALTER TABLE `deliveries_to` ENABLE KEYS */;
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
INSERT INTO `good_group` VALUES (16,2,1),(16,6,0),(19,2,1),(19,6,0),(19,7,0),(19,1,0);
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
  `price` double NOT NULL,
  `currency_code` smallint NOT NULL DEFAULT '1',
  `image_path` varchar(255) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `goods_currency_fk_idx` (`currency_code`),
  CONSTRAINT `goods_currency_fk` FOREIGN KEY (`currency_code`) REFERENCES `currencies` (`code`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (16,'qwerty',8005,1,'/img/products/CC7D17C4-1EE8-4113-A732-EB2BCD9399CB_1598588829808_default.jpg','2020-09-29 13:02:42',1),(17,'qwerty',8005,1,'/img/products/D69FC0C9-7124-474E-93EE-9A333C02C461_1598588829808_default.jpg','2020-09-29 13:05:28',0),(19,'Привет1',800,1,'/img/products/D91E2BCA-229D-46C2-8FBC-3E160F2CD668_product-1.jpg','2020-09-29 14:41:37',1);
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`127.0.0.1`*/ /*!50003 TRIGGER `goods_AFTER_INSERT` AFTER INSERT ON `goods` FOR EACH ROW BEGIN
Insert INTO goods_history (good_id, short_name, price, currency_code, image_path,  change_at, is_active) values (
	new.id,
    new.short_name,
    new.price,
    new.currency_code,
    new.image_path
	,CURRENT_TIMESTAMP,
    new.is_active
);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`127.0.0.1`*/ /*!50003 TRIGGER `goods_AFTER_UPDATE` AFTER UPDATE ON `goods` FOR EACH ROW BEGIN
Insert INTO goods_history (good_id, short_name, price, currency_code, image_path, change_at, is_active) values (
	old.id,
    old.short_name,
    old.price,
    old.currency_code,
    old.image_path
	,CURRENT_TIMESTAMP
    ,old.is_active
);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
  `price` double NOT NULL,
  `currency_code` smallint NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `change_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `goods_history_currency_fk_idx` (`currency_code`),
  KEY `goods_history_good_fk_idx` (`good_id`),
  CONSTRAINT `goods_history_currency_fk` FOREIGN KEY (`currency_code`) REFERENCES `currencies` (`code`) ON UPDATE CASCADE,
  CONSTRAINT `goods_history_good_fk` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_history`
--

LOCK TABLES `goods_history` WRITE;
/*!40000 ALTER TABLE `goods_history` DISABLE KEYS */;
INSERT INTO `goods_history` VALUES (3,16,'qwerty',8005,1,'/img/products/D69FC0C9-7124-474E-93EE-9A333C02C461_1598588829808_default.jpg','2020-09-29 13:02:42',1),(4,17,'qwerty',8005,1,'/img/products/D69FC0C9-7124-474E-93EE-9A333C02C461_1598588829808_default.jpg','2020-09-29 13:05:28',1),(6,16,'qwerty',8005,1,'/img/products/D69FC0C9-7124-474E-93EE-9A333C02C461_1598588829808_default.jpg','2020-09-29 14:01:41',1),(19,16,'qwerty',8005,1,'/img/products/096C9CD5-DFC7-4B94-9F1F-4C969835104F_1598588829808_default.jpg','2020-09-29 14:39:15',1),(20,19,'Привет1',800,1,'/img/products/B6584A5C-16BB-4072-9A22-A80C37489070_product-1.jpg','2020-09-29 14:41:37',1),(21,19,'Привет1',800,1,'/img/products/B6584A5C-16BB-4072-9A22-A80C37489070_product-1.jpg','2020-09-29 14:45:29',1),(22,17,'qwerty',8005,1,'/img/products/D69FC0C9-7124-474E-93EE-9A333C02C461_1598588829808_default.jpg','2020-09-29 14:49:25',1);
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
  CONSTRAINT `order_good_good_fk` FOREIGN KEY (`good_id`) REFERENCES `goods_history` (`good_id`) ON UPDATE CASCADE,
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
  `comment` varchar(255) DEFAULT NULL,
  `created_by` int NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_payment_type_fk_idx` (`payment_type_id`),
  KEY `order_user_fk_idx` (`created_by`),
  CONSTRAINT `order_payment_type_fk` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_types` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `order_user_fk` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
-- Table structure for table `user_chart`
--

DROP TABLE IF EXISTS `user_chart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_chart` (
  `user_id` int NOT NULL,
  `good_id` int NOT NULL,
  `good_count` float NOT NULL,
  UNIQUE KEY `user_chart_idx` (`user_id`,`good_id`),
  KEY `user_chart_good_fk_idx` (`good_id`),
  CONSTRAINT `user_chart_good_fk` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `user_chart_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_chart`
--

LOCK TABLES `user_chart` WRITE;
/*!40000 ALTER TABLE `user_chart` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_chart` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
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
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Александр','delta@gorshkov-aleksandr.ru','790feaddf3848cb0d054c203e6895ae97352928bf4427c8da47d582796401dae',70000000000,'2020-09-24 00:00:00',1),(2,'Александр 1','a@a.com','790feaddf3848cb0d054c203e6895ae97352928bf4427c8da47d582796401dae',70000000001,'2020-09-25 00:00:00',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'fashion_db'
--
/*!50003 DROP PROCEDURE IF EXISTS `get_price_filter_by_category` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_price_filter_by_category`(catcode varchar(50))
BEGIN
	Select 
		'Цена' as name,
        'руб' as dimension,
        'min-price' as min_id,
        'max-price' as max_id,
		MIN(goods.price) as min_value ,
        MAX(goods.price) as max_value
    From good_groups ggs
    join good_group gg ON ggs.id = gg.group_id
    join goods ON goods.id = gg.good_id 
    Where ggs.code = catcode;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-30 10:20:40
