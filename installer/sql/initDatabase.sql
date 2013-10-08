-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.51-community


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema nearteam_poc
--

CREATE DATABASE IF NOT EXISTS nearteam_poc;
USE nearteam_poc;

--
-- Definition of table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `id_country` int(10) unsigned NOT NULL,
  `iso` varchar(2) DEFAULT NULL,
  `iso3` varchar(3) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `postal_code_regexp` varchar(255) DEFAULT NULL,
  `phone_prefix` int(11) DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  `phone_regexp` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_country`),
  KEY `country_visibility_idx` (`visibility`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` (`id_country`,`iso`,`iso3`,`name`,`postal_code_regexp`,`phone_prefix`,`visibility`,`phone_regexp`) VALUES 
 (1,'','','France','^(d{5})$',33,0,''),
 (2,'','','Espagne','^(d{4})$',27,0,''),
 (3,'','','Suisse','',355,0,''),
 (4,'','','Afrique du Sud','^(d{5})$',213,0,''),
 (5,'','','Albanie','^(d{5})$',49,0,''),
 (6,'','','Algérie','^(?:AD)*(d{3})$',376,0,''),
 (7,'','','Allmagne','',244,0,''),
 (8,'','','Andorre','',0,0,''),
 (9,'','','Angola','',672,0,''),
 (10,'','','Anguila','',0,0,'');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;


--
-- Definition of table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id_user` int(10) unsigned NOT NULL,
  `id_Log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `create_dt` timestamp NULL DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `target` longtext,
  `target_type` varchar(255) DEFAULT NULL,
  `target_id` int(10) unsigned DEFAULT NULL,
  `action_object` longtext,
  `action_object_type` varchar(255) DEFAULT NULL,
  `action_object_id` int(10) unsigned DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_Log`),
  KEY `IDX_8F3F68C56B3CA4B` (`id_user`),
  CONSTRAINT `FK_8F3F68C56B3CA4B` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` (`id_user`,`id_Log`,`create_dt`,`action`,`target`,`target_type`,`target_id`,`action_object`,`action_object_type`,`action_object_id`,`message`) VALUES 
 (2,11,NULL,'deleteUser','{\"idUser\":\"2\",\"createDt\":{\"date\":\"2012-07-19 05:00:00\",\"timezone_type\":3,\"timezone\":\"Europe\\/Berlin\"},\"firstName\":\"Habiba\",\"lastName\":\"Abdellatif\",\"updateDt\":{\"date\":\"2012-07-20 05:00:00\",\"timezone_type\":3,\"timezone\":\"Europe\\/Berlin\"},\"isDeleted\":false,\"birthDate\":\"1986-05-17\",\"gender\":\"F\",\"email\":\"Habiba@Nearteam.fr\",\"isVIP\":true,\"phone\":\"32564888\",\"deleteDt\":{\"date\":\"2012-07-17 05:00:00\",\"timezone_type\":3,\"timezone\":\"Europe\\/Berlin\"},\"mobilePhone\":\"32564888\",\"address\":\"20 rue du Sentier\",\"country\":\"Espagne\"}','Nearteam\\UserBundle\\Entity\\User',2,NULL,NULL,NULL,'2013-10-09,16:10,Delete user,2');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;


--
-- Definition of table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(10) unsigned NOT NULL,
  `id_country` int(10) unsigned NOT NULL,
  `create_dt` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `update_dt` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_vip` tinyint(1) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `cp` varchar(255) DEFAULT NULL,
  `mobile_phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` enum('M','F') DEFAULT NULL,
  `delete_dt` timestamp NULL DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `IDX_8D93D6498DEE6016` (`id_country`),
  CONSTRAINT `FK_8D93D6498DEE6016` FOREIGN KEY (`id_country`) REFERENCES `country` (`id_country`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id_user`,`id_country`,`create_dt`,`first_name`,`last_name`,`update_dt`,`is_deleted`,`birth_date`,`email`,`is_vip`,`phone`,`cp`,`mobile_phone`,`address`,`gender`,`delete_dt`,`account_type`) VALUES 
 (1,1,'2012-07-19 05:00:00','Amir','Sghair','2012-07-20 05:00:00',0,'1986-05-17','admin@admin.com',1,'36598745',NULL,'36598745','20 rue du Sentier','M','2012-07-17 05:00:00',NULL),
 (2,2,'2012-07-19 05:00:00','Habiba','Abdellatif','2012-07-20 05:00:00',0,'1986-05-17','Habiba@Nearteam.fr',1,'32564888',NULL,'32564888','20 rue du Sentier','F','2012-07-17 05:00:00',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
