CREATE DATABASE  IF NOT EXISTS `pczauth` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `pczauth`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: pczauth
-- ------------------------------------------------------
-- Server version	5.7.14

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
-- Table structure for table `forumoptions`
--

DROP TABLE IF EXISTS `forumoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forumoptions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forumoptions`
--

LOCK TABLES `forumoptions` WRITE;
/*!40000 ALTER TABLE `forumoptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `forumoptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forumposts`
--

DROP TABLE IF EXISTS `forumposts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forumposts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forumposts`
--

LOCK TABLES `forumposts` WRITE;
/*!40000 ALTER TABLE `forumposts` DISABLE KEYS */;
/*!40000 ALTER TABLE `forumposts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forums`
--

DROP TABLE IF EXISTS `forums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forums` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forums`
--

LOCK TABLES `forums` WRITE;
/*!40000 ALTER TABLE `forums` DISABLE KEYS */;
/*!40000 ALTER TABLE `forums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forumtopics`
--

DROP TABLE IF EXISTS `forumtopics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forumtopics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `forum_id` int(11) unsigned NOT NULL,
  `is_sticky` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forumtopics`
--

LOCK TABLES `forumtopics` WRITE;
/*!40000 ALTER TABLE `forumtopics` DISABLE KEYS */;
/*!40000 ALTER TABLE `forumtopics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'admin','Administrator'),(2,'members','General User');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) unsigned NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_moderator` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_confirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'127.0.0.1','administrator','$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36','','admin@admin.com','',NULL,NULL,'kvnPTi6VZo/.jCTtHn6yw.',1268889823,1507489646,1,'Admin','istrator','ADMIN','0','default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(2,'127.0.0.1','diolz90@yahoo.com','$2y$08$1DLLwI/TO1iJ5lE6inA95OE5VuE5wW5xLIqO/Q5dDvPb4BhLtVkwC',NULL,'diolz90@yahoo.com',NULL,NULL,NULL,NULL,1494733522,1494733615,1,'levi','levi','levi','2222','default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(3,'127.0.0.1','diolz901@yahoo.com','$2y$08$ku/b8M8WpEQNU2FiJV1JpeBFvAITWlPxYcpZG8mNpEg6.19prYXwW',NULL,'diolz901@yahoo.com',NULL,NULL,NULL,NULL,1494734174,1494736022,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(4,'127.0.0.1','diolz902@yahoo.com','$2y$08$nW790kSxit4Z.9v7WnoLiOzVRV6xsUs/f8./E5yTWNINwfTLJTMyW',NULL,'diolz902@yahoo.com',NULL,NULL,NULL,NULL,1494736428,1494736428,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(5,'127.0.0.1','diolz903@yahoo.com','$2y$08$hU3kQ6a8jXId/K.uPVI3EeTzbAUxFV1Cd3wUtHMnazgWusl9ZAUIK',NULL,'diolz903@yahoo.com',NULL,NULL,NULL,NULL,1494736556,1494736678,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(6,'127.0.0.1','diolz904@yahoo.com','$2y$08$p0Fgw6dJZW/kPcBJb/Cc9ePvroLuA8rc1h09icLLizeQCHcAifkGu',NULL,'diolz904@yahoo.com',NULL,NULL,NULL,NULL,1494737668,1494737668,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(7,'127.0.0.1','diolz905@yahoo.com','$2y$08$sCXprv36o.fN98M5HMbw/.T5XFqIRzP02qgiTpr/0dWuWsi.VAveC',NULL,'diolz905@yahoo.com',NULL,NULL,NULL,NULL,1494737953,1494737953,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(8,'127.0.0.1','diolz906@yahoo.com','$2y$08$S0p670edu4mUNFj467GmH.H.Le7.Pzsk3PKQdu3xBJp766/1of3Me',NULL,'diolz906@yahoo.com',NULL,NULL,NULL,NULL,1494738156,1494738156,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(9,'127.0.0.1','diolz906@yahoo.com1','$2y$08$SUL6C1um7JJj/lF8EmGKq.e2iy14ECtbnXgEOsUGAVgcXY9fmt49.',NULL,'diolz906@yahoo.com1',NULL,NULL,NULL,'AgNWuanadoNwPpzxpTn65u',1494738220,1494793680,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(10,'127.0.0.1','diolz906@yahoo.com12','$2y$08$d1rxIFYAkza3IPAIzPS8AO8YAHC5MyWDHElRxjFgQjGg2xP3NjS.O',NULL,'diolz906@yahoo.com12',NULL,NULL,NULL,NULL,1494738290,1494738290,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(11,'127.0.0.1','diolz906@yahoo.com13','$2y$08$S.tcbI9uon1wgIXR/W8LO.arZQ84WBqY7asBC8JNUMiN1COZ/50wC',NULL,'diolz906@yahoo.com13',NULL,NULL,NULL,NULL,1494738312,1494738312,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(12,'127.0.0.1','thebest','$2y$08$YvQWnafUP2zmkjK5qRSa4OC9WOXG8AWIchM.96SQnvtf5CJS0gEum',NULL,'thebest@yahoo.com',NULL,NULL,NULL,NULL,1496478905,1496478940,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(13,'127.0.0.1','thesecond','$2y$08$ohOiiyHQEVsKIc9kgk22s.iiv8P5luS0VvCdScd9EDRNzPLPDey4O',NULL,'thesecond@yahoo.com',NULL,NULL,NULL,NULL,1496480090,1496480090,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(14,'127.0.0.1','test','$2y$08$GvRQwYsK0AwRA9a9C7XJhOOx7Ftrhpfe4dIjOV7vTnVaE3ygc1bNm',NULL,'test@yahoo.com',NULL,NULL,NULL,NULL,1496495651,1496495651,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(15,'127.0.0.1','mysample','$2y$08$UGHH4/kIyOolNss5s9UJzefLWplxgFh6iojv5uDlOqkTTrguJD5c2',NULL,'mysample@yahoo.com',NULL,NULL,NULL,NULL,1496495873,1496495874,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(16,'127.0.0.1','xxx','$2y$08$3mtUPktR6S3cHkriYFx5q.boVdG/h5B8qYRNDs6oThwa4OdtKsRVC',NULL,'xxx@yahoo.com',NULL,NULL,NULL,NULL,1496495914,1496579255,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(17,'127.0.0.1','the best 11','$2y$08$ev.SD7vmTbM0bfkRYFk08.01cWdxsVtL9E1eIuxjeJXh5F84FmPg6',NULL,'diola90s@gmail.com',NULL,NULL,NULL,NULL,1501952814,1502005510,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0),(18,'127.0.0.1','levi','$2y$08$xC5tge.ycOICQWbr24GbLeEqQ/Ele0hH15vKUKa76YH8IU0cAuVpO',NULL,'diolz95@yahoo.com',NULL,NULL,NULL,NULL,1502006144,1502006682,1,NULL,NULL,NULL,NULL,'default.jpg','0000-00-00 00:00:00',NULL,0,0,0,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (1,1,1),(2,1,2),(3,2,2),(4,3,2),(5,4,2),(6,5,2),(7,6,2),(8,7,2),(9,8,2),(10,9,2),(11,10,2),(12,11,2),(13,12,2),(14,13,2),(15,14,2),(16,15,2),(17,16,2),(18,17,2),(19,18,2);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'pczauth'
--

--
-- Dumping routines for database 'pczauth'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-12 18:37:30
