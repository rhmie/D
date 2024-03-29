-- MySQL dump 10.13  Distrib 5.6.51, for Linux (x86_64)
--
-- Host: localhost    Database: chuanshin_db
-- ------------------------------------------------------
-- Server version	5.6.51-cll-lve

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
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mname` varchar(24) NOT NULL COMMENT '姓名',
  `password` varchar(64) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT '密碼',
  `zip` varchar(3) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT '郵遞區號',
  `county` varchar(3) CHARACTER SET utf8 DEFAULT NULL COMMENT '縣市',
  `district` varchar(4) CHARACTER SET utf8 DEFAULT NULL COMMENT '區域',
  `addr` varchar(128) CHARACTER SET utf8 DEFAULT NULL COMMENT '地址',
  `phone` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT '電話',
  `fb_id` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'facebook',
  `line_id` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL COMMENT 'line id',
  `cdate` datetime NOT NULL COMMENT '註冊日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (8,'bobo','f379eaf3c831b04de153469d1bec345e','114','台北市','內湖區','康樂街186巷27號4樓','0975892729',NULL,NULL,'2021-04-26 06:35:47'),(21,'Allen Chang',NULL,NULL,NULL,NULL,NULL,'0928956494','4820198454673159',NULL,'2021-07-16 23:19:49'),(23,'韓月希',NULL,NULL,NULL,NULL,NULL,'0970334380',NULL,'U68bd46df40b2645d62cd4c1dbd80dedb','2021-09-05 13:09:00'),(24,'Egg','4297f44b13955235245b2497399d7a93','300','新竹市','北區','五福路55號7樓之1','0986808557',NULL,NULL,'2021-09-06 19:56:00'),(25,'艾莉絲',NULL,NULL,NULL,NULL,NULL,'0905798319','592529458404520',NULL,'2021-09-07 08:59:00'),(27,'黃健能','5c11926e5415fd8dfbeab07935bed227',NULL,NULL,NULL,NULL,'0909507015',NULL,NULL,'2021-09-19 08:49:00'),(28,'蔡測試','e10adc3949ba59abbe56e057f20f883e',NULL,NULL,NULL,NULL,'0973600186',NULL,NULL,'2021-09-26 00:22:00'),(29,'Yixin Coon',NULL,NULL,NULL,NULL,NULL,'0980999553','1233180957200142',NULL,'2021-09-26 05:58:00'),(30,'mark','0b4e7a0e5fe84ad35fb5f95b9ceeac79',NULL,NULL,NULL,NULL,'0955883581',NULL,NULL,'2021-09-27 23:49:00'),(31,'手動','0fc555d13f3a5d1b692641f9733b5844',NULL,NULL,NULL,NULL,'1234567',NULL,NULL,'0000-00-00 00:00:00'),(33,'sc','0b4e7a0e5fe84ad35fb5f95b9ceeac79',NULL,NULL,NULL,NULL,'09',NULL,NULL,'2021-10-08 14:59:00'),(34,'pppp','f7baef4a00d253885351e8c44710d2d8',NULL,NULL,NULL,NULL,'0916465148',NULL,NULL,'2021-11-03 15:02:00');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-13  0:00:01
