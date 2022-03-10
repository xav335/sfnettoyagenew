-- MySQL dump 10.19  Distrib 10.3.31-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: sfnettoyage
-- ------------------------------------------------------
-- Server version	10.3.31-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(30) NOT NULL,
  `mdp` varchar(30) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'stephane','stephane33335','administrateur'),(2,'admin','admin33335','ico');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catproduct`
--

DROP TABLE IF EXISTS `catproduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catproduct` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `ordre_affichage` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catproduct`
--

LOCK TABLES `catproduct` WRITE;
/*!40000 ALTER TABLE `catproduct` DISABLE KEYS */;
INSERT INTO `catproduct` VALUES (41,41,'Protection bois  ','/_MG_5081-41.jpg',1),(43,43,' ','/_MG_5255-43.jpg',2),(54,0,'Nettoyage vitrines','',2),(57,56,'amenagements','',1),(60,60,'Protection bois  ','',1),(65,65,'Protection bois  ','',1),(66,66,'Protection aluminium  ','',2),(68,81,'Balisage ','',2),(69,65,'Protection bois ','',1),(73,71,'Protection en Contre Plaqué   ','',1),(75,75,'Protection aluminium  ','',6),(77,75,'Habillage bois  ','',1),(79,79,'Protection bois ','',5),(81,81,'Gyrophare et rampe  ','',5),(82,82,'Marchepied ','',4),(83,83,'Plastification et résine étanche ','',5),(84,84,'Transformation VP/VU','',8),(85,0,'Entretien de locaux','',4),(87,0,'Remise en état','',1),(94,94,'Produits','',13),(96,80,'Habillage et protection','',1),(97,97,'Balisage ','',3),(100,0,'Nettoyage à l\'eau pure','',3);
/*!40000 ALTER TABLE `catproduct` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `adresse` varchar(250) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `newsletter` tinyint(4) NOT NULL DEFAULT 0,
  `fromgoldbook` tinyint(4) NOT NULL DEFAULT 0,
  `fromcontact` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (11,'Javier','GONZALEZ','20 avenue de la foret','33700','Merignac','fjavi.gonzalez@gmail.com','+33681731870','bonjour',0,1,1),(12,'Jean-Luc','MIARD','297 chemin de Mauran','33360','QUINSAC','jeanluc.miard@orange.fr','0684329513','Bonjour, nous sommes à la recherche d\'un prestataire afin de nettoyer une pergola bio-climatique adossée en alu peint (blanc) de 15 m² environ, parties intérieures et extérieures.\r\nMerci de me contacter au numéro de mobile ci-dessus.\r\nCordialement',0,0,1),(13,'-','-','-','-','-','rachel@digitworldweb.com','4055550117','Hi,\r\n\r\n \r\n\r\nI am Rachel Stinson from Progos Tech established since 2010. We are passionate about ecommerce web development. We have certified Wordpress/PrestaShop module developers with 5+ years of experience available for long term and short term engagements. \r\n\r\n\r\n\r\nLet me know if you have any task that we can help you with. \r\n\r\n\r\n\r\nRegards,\r\n\r\n \r\nRachel Stinson, \r\n\r\nhttps://progostech.com',0,0,1),(14,'','','','','','dweingart@zoominternet.net','','',1,0,0),(15,'','','','','','admauger@gmail.com','','',1,0,0),(16,'','','','','','ma.luca10@hotmail.com','','',1,0,0),(17,'','','','','','wvsupercooper@outlook.com','','',1,0,0),(18,'','','','','','toddj@almsgivingelectric.com','','',1,0,0),(19,'','','','','','david_boone@me.com','','',1,0,0),(20,'','','','','','monika.milotta@t-online.de','','',1,0,0),(21,'','','','','','pradyumna.gurusamy@gmail.com','','',1,0,0),(22,'','','','','','mshay327@gmail.com','','',1,0,0),(23,'','','','','','mdegraft@verizon.net','','',1,0,0),(24,'','','','','','blakarion@icloud.com','','',1,0,0),(25,'','','','','','scarlsen27@gmail.com','','',1,0,0),(26,'','','','','','richens@comcast.net','','',1,0,0),(27,'','','','','','trent@nelsonsbbq.com','','',1,0,0),(28,'','','','','','alicia_clucas@yahoo.co.uk','','',1,0,0),(29,'','','','','','okamikeyfan@sbcglobal.net','','',1,0,0),(30,'','','','','','lfassauer@gmail.com','','',1,0,0),(31,'','','','','','woody83801@gmail.com','','',1,0,0),(32,'','','','','','kennelson@printpro-inc.com','','',1,0,0),(33,'','','','','','sales@tontitownwinery.com','','',1,0,0),(34,'','','','','','sakins@equipmentinc.com','','',1,0,0),(35,'','','','','','louise.shafi@ntlworld.com','','',1,0,0),(36,'','','','','','hurdscott@comcast.net','','',1,0,0),(37,'','','','','','cynthia-grant@comcast.net','','',1,0,0),(38,'','','','','','josh@lowcountryaudiosc.com','','',1,0,0),(39,'','','','','','thanley@gmail.com','','',1,0,0),(40,'','','','','','bdbdbdbhf@yahoo.com','','',1,0,0),(41,'','','','','','rita452@cox.net','','',1,0,0),(42,'','','','','','liufred@gmail.com','','',1,0,0),(43,'Yasmina','Benaddi','30 rue Augustinot à Latresne','33360','Latresne','yasmina.benaddi@gmail.com','+33663672587','Bonjour \r\n\r\nPourriez-vous m\'envoyer un devis pour le lavage de baies vitrées. Nouvelle construction sur Carignan de Bordeaux. Vitres avec traces de pluie et poussière maissans plâtre. Menuiseries propres.\r\nRDC : 4 baies vitrées de 2m40 sur 2m40\r\nR+1 : 4 baies vitrées de 2m40 sur 2m15 et une 5e en double hauteur donc nécessité dun échafaudage.\r\nCordialement\r\n Yasmina Benaddi  ',0,0,1),(44,'','','','','','info@hiltonmgmt.com','','',1,0,0),(45,'','','','','','5129656291@vtext.com','','',1,0,0),(46,'','','','','','phparilla@cox.net','','',1,0,0),(47,'','','','','','nwrjoo@gmail.com','','',1,0,0),(48,'','','','','','mt3813@aol.com','','',1,0,0),(49,'','','','','','cherylbolduc1@yahoo.com','','',1,0,0),(50,'','','','','','swraith@cogeco.ca','','',1,0,0),(51,'','','','','','c.aranjo@globalstep.com','','',1,0,0),(52,'','','','','','simon_madden@hotmail.com','','',1,0,0),(53,'Den','ATTENTION','ATTENTION','ATTENTION','ATTENTION','info@hostdomains.com','+12548593423','TERMINATION OF DOMAIN sfnettoyage.com\r\nInvoice#: 481353\r\nDate: 2021-04-12\r\n\r\nIMMEDIATE ATTENTION REGARDING YOUR DOMAIN sfnettoyage.com IS ABSOLUTLY NECESSARY\r\n\r\nTERMINATION OF YOUR DOMAIN sfnettoyage.com WILL BE COMPLETED WITHIN 24 HOURS\r\n\r\nYour payment for the renewal of your domain sfnettoyage.com has not received yet\r\n\r\nWe have tried to reach you by phone several times, to inform you regarding the TERMINATION of your domain sfnettoyage.com\r\n\r\nCLICK HERE FOR SECURE ONLINE PAYMENT: https://domainorder.ga/?n=sfnettoyage.com&r=a&t=1618185815&p=v13\r\n\r\nIF WE DO NOT RECEIVE YOUR PAYMENT WITHIN 24 HOURS, YOUR DOMAIN sfnettoyage.com WILL BE TERMINATED!\r\n\r\nCLICK HERE FOR SECURE ONLINE PAYMENT: https://domainorder.ga/?n=sfnettoyage.com&r=a&t=1618185815&p=v13\r\n\r\nYOUR IMMEDIATE ATTENTION IS ABSOLUTELY NECESSARY IN ORDER TO KEEP YOUR DOMAIN sfnettoyage.com\r\n\r\nThe submission notification sfnettoyage.com will EXPIRE WITHIN 24 HOURS after reception of this email',0,0,1),(54,'brice','lamarque','13 chemin de salvy ','33360','latresne ','lamarque.brice@gmail.com','0783277034','bonjour,\r\n\r\nprise d rdv pour lavage vitre extérieur svp ',0,0,1),(55,'','','','','','Connor.Little@hotmail.com','','',1,0,0),(56,'','','','','','jessicaviba08@gmail.com','','',1,0,0),(57,'','','','','','killroy7440@yahoo.com','','',1,0,0),(58,'','','','','','bettyrichardsonohio@gmail.com','','',1,0,0),(59,'','','','','','emilyklysen1@yahoo.com','','',1,0,0),(60,'','','','','','michellebligh@yahoo.com','','',1,0,0),(61,'','','','','','kturvey208@gmail.com','','',1,0,0),(62,'','','','','','jgholson22@yahoo.com','','',1,0,0),(63,'','','','','','go@showhis.email','','',1,0,0),(64,'','','','','','Brenden_Weissnat16@yahoo.com','','',1,0,0),(65,'fabiene','dumont','20 bis chemin du port de l hemme ','33360','latresne','tabanac54@orange.fr','0632978731','Bonjour \r\nje vais emménager dans un appartement neuf qui vient de m\'être livré.\r\nJe souhaite un dépoussiérage complet et nettoyage avant d\'emménager. \r\nIl s\'agit d\'un appartement de type T3 avec de grandes baies vitrées ainsi qu\'une terrasse  = + 50 m² \r\nmerci de prendre contact avec moi pour établir un devis concernant ce nettoyage et un abonnement de lavage des baies régulier \r\nje vous en remercie d\'avance\r\nFabienne Dumont ',0,0,1);
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_categorie`
--

DROP TABLE IF EXISTS `contact_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_categorie` (
  `id_contact` int(11) unsigned NOT NULL,
  `id_categorie` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_categorie`
--

LOCK TABLES `contact_categorie` WRITE;
/*!40000 ALTER TABLE `contact_categorie` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goldbook`
--

DROP TABLE IF EXISTS `goldbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goldbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `nom` varchar(250) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `online` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goldbook`
--

LOCK TABLES `goldbook` WRITE;
/*!40000 ALTER TABLE `goldbook` DISABLE KEYS */;
INSERT INTO `goldbook` VALUES (1,'2015-09-06 00:00:00','Emmanuelle','Emmanuelle.braillard@gmail.com','Très professionnel ! je recommande!!',1),(2,'2015-09-07 00:00:00','Xavier','xavier@gonzalez.pm','Prestation nickel, très pro, très satisfait',1);
/*!40000 ALTER TABLE `goldbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_news`
--

DROP TABLE IF EXISTS `media_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_news` int(11) NOT NULL,
  `url_media` varchar(250) NOT NULL,
  `url_apercu` varchar(250) NOT NULL,
  `type_media` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`,`id_news`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_news`
--

LOCK TABLES `media_news` WRITE;
/*!40000 ALTER TABLE `media_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id_news` int(11) NOT NULL AUTO_INCREMENT,
  `date_news` datetime NOT NULL,
  `titre` varchar(250) NOT NULL,
  `contenu` text DEFAULT NULL,
  `image1` varchar(250) DEFAULT NULL,
  `online` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_news`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'2019-01-02 00:00:00','Nouveau site internet ','Voici mon nouveau site internet n\'hésitez pas à me laisser un petit message sur mon livre d\'or.','/internet-1.png',1);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `titre` varchar(250) DEFAULT NULL,
  `bas_page` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter`
--

LOCK TABLES `newsletter` WRITE;
/*!40000 ALTER TABLE `newsletter` DISABLE KEYS */;
INSERT INTO `newsletter` VALUES (12,'2015-01-01 00:00:00','Ceci est la toute nouvelle actu',' ');
/*!40000 ALTER TABLE `newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_detail`
--

DROP TABLE IF EXISTS `newsletter_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_newsletter` int(10) unsigned NOT NULL,
  `titre` varchar(250) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `link` varchar(250) DEFAULT NULL,
  `texte` text DEFAULT NULL,
  PRIMARY KEY (`id`,`id_newsletter`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_detail`
--

LOCK TABLES `newsletter_detail` WRITE;
/*!40000 ALTER TABLE `newsletter_detail` DISABLE KEYS */;
INSERT INTO `newsletter_detail` VALUES (1,12,'Nouveau site internet','/internet-12.png','http://www.sfnettoyage.com/','');
/*!40000 ALTER TABLE `newsletter_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_categorie` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `fichier_pdf` varchar(100) NOT NULL,
  `accueil` enum('0','1') NOT NULL DEFAULT '0',
  `online` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (13,87,'Rénovation carrelage ','Exemple de rénovation de carrelage avant et après','','1','1'),(14,54,'Nettoyage veranda','Nettoyage veranda','','1','1'),(15,100,'nettoyage à l\'eau pure','Nettoyage à l\'eau pure','','1','1'),(16,85,'Décapage carrelage','<iframe src=\"https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fsfnettoyage%2Fvideos%2F455137988013951%2F&show_text=0&width=560\" width=\"560\" height=\"322\" style=\"border:none;overflow:hidden\" scrolling=\"no\" frameborder=\"0\" allowTransparency=\"true\" allowFullScreen=\"true\"></iframe>','','1','1'),(17,85,'Nettoyage de terrase','<iframe src=\"https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fsfnettoyage%2Fvideos%2F468985029962580%2F&show_text=0&width=267\" width=\"267\" height=\"476\" style=\"border:none;overflow:hidden\" scrolling=\"no\" frameborder=\"0\" allowTransparency=\"true\" allowFullScreen=\"true\"></iframe>','','1','1'),(18,87,'Rénovation d\'un muret','Rénovation d\'un muret','','0','1');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_image`
--

DROP TABLE IF EXISTS `product_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_image` (
  `num_image` int(11) NOT NULL AUTO_INCREMENT,
  `num_produit` int(11) NOT NULL,
  `fichier` varchar(100) NOT NULL,
  `defaut` enum('oui','non') NOT NULL DEFAULT 'non',
  PRIMARY KEY (`num_image`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_image`
--

LOCK TABLES `product_image` WRITE;
/*!40000 ALTER TABLE `product_image` DISABLE KEYS */;
INSERT INTO `product_image` VALUES (20,4,'/IMG_6130-4.jpg','non'),(25,4,'/IMG_6686-4.jpg','oui'),(30,9,'/Fevrier_14_001-9.jpg','oui'),(31,9,'/Fevrier_14_004-9.jpg','non'),(32,9,'/Samsung_1115_004-9.jpg','non'),(34,11,'/0115_003-11.jpg','oui'),(36,3,'/Oct_15_042-3.jpg','oui'),(38,1,'/0115_002-1.jpg','non'),(40,1,'/Trafic_MTS_014-1.jpg','oui'),(44,10,'/AVAD_006-10.jpg','non'),(45,11,'/0115_003-11.jpg','non'),(47,3,'/AVAD_001-3.jpg','non'),(48,3,'/003-3.jpg','non'),(49,9,'/20140214_083539-9.jpg','non'),(50,9,'/Master-9.jpg','non'),(51,9,'/mb_sprinter_3665_05-9.jpg','non'),(52,3,'/Oct_15_Tel_026-3.jpg','non'),(53,3,'/AVAD_006-3.jpg','non'),(54,7,'/Oct_15_034-7.jpg','non'),(55,7,'/Novembre_12_004-7.jpg','non'),(56,7,'/Decembre_12_010-7.jpg','non'),(57,7,'/Avril_13_034-7.jpg','non'),(59,6,'/DSCF2356-6.jpg','non'),(60,6,'/DSCF1159-6.jpg','non'),(61,6,'/200-6.jpg','non'),(62,10,'/003-10.jpg','oui'),(63,12,'/Trafic_MTS_014-12.jpg','non'),(64,12,'/Mai_15_007-12.jpg','oui'),(65,12,'/DSCF2379-12.jpg','non'),(66,12,'/BB_0115_007-12.jpg','non'),(67,12,'/BB_0115_005-12.jpg','non'),(68,12,'/225-12.jpg','non'),(69,12,'/0115_002-12.jpg','non'),(70,6,'/Juillet_11_024-6.jpg','non'),(71,7,'/Avril_13_034-7.jpg','oui'),(72,6,'/023-6.jpg','oui'),(73,13,'/avant-13.jpg','non'),(74,13,'/apres-13.jpg','oui'),(75,14,'/pp-14.jpg','oui'),(76,15,'/photo_3_-15.jpg','oui'),(77,15,'/photo_4_-15.jpg','non'),(80,17,'/Screenshot_2019_01_01_22.26.21-17.png','oui'),(82,18,'/muret2-18.jpg','oui'),(85,18,'/muret1-18.jpg','non');
/*!40000 ALTER TABLE `product_image` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-10  8:57:42
