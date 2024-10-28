-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: fashion_mylishop
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.29-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'mylishop','8A86E1AAF7327885729E5B450841FEF6');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Thời Trang Nam'),(2,'Thời Trang Nữ'),(3,'Hàng Mới Về');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--
CREATE TABLE IF NOT EXISTS product_bill (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    date DATE NOT NULL
);

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `contents` text,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `contents` text,
  `created` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,'Tạ Đình Phong','tadinhphong000@gmail.com','Demo web','Test thôi nhá','2018-02-02 08:32:54',0);
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` float NOT NULL,
  `date_order` datetime NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,245000,'2018-01-25 18:30:30',0,12),(2,225000,'2018-01-25 19:42:03',0,13),(3,245000,'2018-01-25 19:45:13',0,14),(4,245000,'2018-02-02 08:27:05',0,15),(5,245000,'2018-02-02 08:29:12',0,15);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_order`
--

DROP TABLE IF EXISTS `product_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_order` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  KEY `product_id` (`product_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_order`
--

LOCK TABLES `product_order` WRITE;
/*!40000 ALTER TABLE `product_order` DISABLE KEYS */;
INSERT INTO `product_order` VALUES (12,1,1),(14,2,1),(17,3,1),(12,4,1),(17,5,1);
/*!40000 ALTER TABLE `product_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `saleprice` float NOT NULL,
  `created` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `keyword` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Áo Thun  Mát Mẻ',1,'images/fashion_boy/ao dep - xanh duong.jpg','',180000,0,'2017-12-18',5,'',0),(2,'Áo Khoác Vest',1,'images/fashion_boy/men-cloth.jpg','',290000,0,'2017-12-18',8,'',0),(3,'Quần Thời Thượng',1,'images/fashion_boy/men-wear.jpg','',210000,0,'2017-12-18',10,'',0),(4,'Vest Xám Kẻ Sọc',1,'images/fashion_boy/vest-xam-ke-soc-an-tuong.jpg','',180000,0,'2017-12-18',7,'',0),(5,'Áo Sơ Mi Nâu',1,'images/fashion_boy/ao so mi de nlon.jpg','',250000,0,'2017-12-18',12,'',0),(6,'Đầm viscose xanh',2,'images/fashion_girl/Green-Viscose-Dresses.jpg','',165000,0,'2017-12-18',15,'',0),(7,'Váy Màu Xanh',2,'images/fashion_girl/Set_ao_croptop_co_sen_chan_vay_mau_xanh.jpg','',155000,0,'2017-12-18',9,'',0),(8,'Váy Màu Hồng',2,'images/fashion_girl/Dress-Materials.jpg','',195000,0,'2017-12-18',19,'',0),(9,'Áo Khoác kaki',2,'images/fashion_girl/Ao_khoac_kaki_hai_lop_mau_ke.jpg','',265000,0,'2017-12-18',15,'',0),(10,'Đầm maxi hai dây',2,'images/fashion_girl/Dam_maxi_hai_day_kem_nit.jpg','',315000,0,'2017-12-18',10,'',0),(11,'Áo Sơ Mi Xanh',3,'images/hangmoive/ao so mi.jpg','',225000,0,'2017-12-18',10,'',0),(12,'Đầm Xòe Ren Màu Trắng',3,'images/hangmoive/Dam_xoe_phoi_ren_xinh_xan_mau_trang.jpg','',245000,0,'2017-12-18',20,'',0),(13,'Váy Đẹp Cho Phái Nữ',3,'images/hangmoive/womens-georgette.jpg','',275000,0,'2017-12-18',21,'',0),(14,'Vest Đen Chấm Nhỏ',3,'images/hangmoive/vest-den-cham-nho.jpg','',225000,0,'2017-12-18',17,'',0),(15,'Áo Sơ Mi Xanh Tím',3,'images/hangmoive/so-mi-xanh-tim-hoa-tiet-tron.jpg','',225000,0,'2017-12-18',6,'',0),(16,'Giày Nâu Xám Phái Nam',3,'images/hangmoive/Brown-Casual-Shoes.jpg','',235000,0,'2017-12-18',11,'',0),(17,'Giày Nâu Giản dị',3,'images/hangmoive/Roadster-Casual-Shoes.jpg','',245000,0,'2017-12-18',13,'',0),(18,'Giày adidas',1,'images/shoes/adidas-alphabounce-reflective-pack-2.jpg','',195000,0,'2017-12-18',15,'',0),(19,'Dép Su Quay Hậu',1,'images/shoes/dep quay hau.jpg','',115000,0,'2017-12-18',13,'',0),(20,'Giày Cao Gót Màu Nâu Bóng',2,'images/shoes/giay-cao-co-mau-nau-bong-tron.png','',199000,0,'2017-12-18',20,'',0),(21,'Dép Bạc Gót',2,'images/shoes/Silver-Heeled-Sandals.jpg','',299000,0,'2017-12-18',10,'',0),(22,'Giày Ống Cao',3,'images/hangmoive/Tan-Boots-425x498.jpg','',259000,0,'2017-12-18',10,'',0),(23,'Giày Thể Thao Năng Động',2,'images/shoes/Giay the thao nu xanh.jpg','',169000,0,'2017-12-18',25,'',0),(24,'Giày Cao Gót Su',2,'images/shoes/giay cao ong  lon.jpg','',269000,0,'2017-12-18',0,'',0),(25,'Giày Thể Thao Nike',1,'images/shoes/xanhduongfreetr5printtrainings-.jpg','',199000,0,'2017-12-18',13,'',0),(26,'Giày Thể Thao Xanh',1,'images/shoes/xanhairzoompegasus33runningsho.jpg','',189000,0,'2017-12-18',13,'',0),(27,'Đầm Dự Tiệc Màu Hồng Cam',2,'images/fashion_girl/Dam_du_tiec_dun_eo_ta_xeo_mau_hong_cam.jpg','',219000,0,'2017-12-18',20,'',0),(28,'Đầm Thai Sản Màu Xanh',2,'images/fashion_girl/Maternity-Store-300x351.jpg','',209000,0,'2017-12-18',30,'',0),(29,'Áo Thun Màu Trắng Hot',1,'images/fashion_boy/ao thun trang.jpg','',179000,0,'2017-12-18',16,'',0),(30,'Thắt Lưng Do Chạm Khắc',1,'images/fashion_boy/that-lung-da-khoa-tron-cham-khac-noi.png','',89000,0,'2017-12-18',15,'',0),(31,'Quần kaki Màu Nâu',1,'images/fashion_boy/quan-au-mau-bordeaux.jpg','',229000,0,'2017-12-18',15,'',0),(32,'Bộ Cotton Henley',1,'images/fashion_boy/Cotton-Henley-T-shirt.jpg','',299000,0,'2017-12-18',12,'',0),(33,'Váy Xám Đẹp',2,'images/fashion_girl/dress-f-blue.jpg','',239000,0,'2017-12-22',20,'',0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `contents` text,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotions`
--

LOCK TABLES `promotions` WRITE;
/*!40000 ALTER TABLE `promotions` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slides`
--

DROP TABLE IF EXISTS `slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slides`
--

LOCK TABLES `slides` WRITE;
/*!40000 ALTER TABLE `slides` DISABLE KEYS */;
INSERT INTO `slides` VALUES (1,'images/background.jpg',0),(2,'images/slide/slide-3.jpg',1),(3,'images/slide/slide-4.jpg',1),(4,'images/slide/slide-5.jpg',1),(5,'images/slide/slide-2.jpg',1),(6,'images/banner/2.jpg',2),(7,'images/banner/3.jpg',2),(8,'images/banner/banner.jpg',2),(9,'images/banner/khuyenmaithang12.png',2),(10,'images/partner/partner1.png',3),(11,'images/partner/partner2.png',3),(12,'images/partner/partner3.png',3),(13,'images/partner/partner4.png',3),(14,'images/partner/partner5.png',3),(15,'images/partner/partner6.jpg',3);
/*!40000 ALTER TABLE `slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,'Hoih My','my.hoih','49CDB4C2B576011E554669632DFBD7CC','my.hoih@student.passerellesnumeriques.org','Đà Nẵng','01697450200',NULL,1),(11,'y blir','blir.y','C00813256690A14079A569831F9BAAD6','blir.y@student.passerellesnumeriques.org','Đà Nẵng','0926055983',NULL,1),(12,'Ly Ca Tiếu','','','hoihmy2712@gmail.com','Đà Nẵng','01697450200',NULL,0),(13,'Ly Ca Tiếu','','','hoihmy2712@gmail.com','Đà Nẵng','01697450200',NULL,0),(14,'Ly Ca Tiếu','','','hoihmy2712@gmail.com','Đà Nẵng','01697450200',NULL,0),(15,'Hello','hello','5d41402abc4b2a76b9719d911017c592','hoihmy2712@gmail.com','Đà Nẵng','123456789',NULL,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_groupby_idorder`
--

DROP TABLE IF EXISTS `view_groupby_idorder`;
/*!50001 DROP VIEW IF EXISTS `view_groupby_idorder`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_groupby_idorder` AS SELECT 
 1 AS `idOrder`,
 1 AS `status`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_order_list`
--

DROP TABLE IF EXISTS `view_order_list`;
/*!50001 DROP VIEW IF EXISTS `view_order_list`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_order_list` AS SELECT 
 1 AS `idOrder`,
 1 AS `fullname`,
 1 AS `phone`,
 1 AS `email`,
 1 AS `idUser`,
 1 AS `address`,
 1 AS `idProduct`,
 1 AS `nameProduct`,
 1 AS `price`,
 1 AS `saleprice`,
 1 AS `quantity`,
 1 AS `status`,
 1 AS `dateOrder`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_groupby_idorder`
--

/*!50001 DROP VIEW IF EXISTS `view_groupby_idorder`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_groupby_idorder` AS select `orders`.`id` AS `idOrder`,`orders`.`status` AS `status` from (((`orders` join `users` on((`orders`.`user_id` = `users`.`id`))) join `product_order` on((`product_order`.`order_id` = `orders`.`id`))) join `products` on((`product_order`.`product_id` = `products`.`id`))) group by `orders`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_order_list`
--

/*!50001 DROP VIEW IF EXISTS `view_order_list`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_order_list` AS select `orders`.`id` AS `idOrder`,`users`.`fullname` AS `fullname`,`users`.`phone` AS `phone`,`users`.`email` AS `email`,`users`.`id` AS `idUser`,`users`.`address` AS `address`,`products`.`id` AS `idProduct`,`products`.`name` AS `nameProduct`,`products`.`price` AS `price`,`products`.`saleprice` AS `saleprice`,`product_order`.`quantity` AS `quantity`,`orders`.`status` AS `status`,`orders`.`date_order` AS `dateOrder` from (((`orders` join `users` on((`orders`.`user_id` = `users`.`id`))) join `product_order` on((`product_order`.`order_id` = `orders`.`id`))) join `products` on((`product_order`.`product_id` = `products`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-06 17:33:53
