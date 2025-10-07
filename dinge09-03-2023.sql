-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: dinge
-- ------------------------------------------------------
-- Server version	10.6.12-MariaDB-0ubuntu0.22.04.1

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
-- Table structure for table `tab_besitzer`
--

DROP TABLE IF EXISTS `tab_besitzer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_besitzer` (
  `id_besitzer` int(11) NOT NULL AUTO_INCREMENT,
  `name_besitzer` varchar(50) NOT NULL,
  PRIMARY KEY (`id_besitzer`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_besitzer`
--

LOCK TABLES `tab_besitzer` WRITE;
/*!40000 ALTER TABLE `tab_besitzer` DISABLE KEYS */;
INSERT INTO `tab_besitzer` VALUES (2,'Matthias'),(3,'Claudia');
/*!40000 ALTER TABLE `tab_besitzer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_dinge`
--

DROP TABLE IF EXISTS `tab_dinge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_dinge` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name_dinge` varchar(50) NOT NULL,
  `beschreibung_dinge` text NOT NULL,
  `typ` varchar(20) NOT NULL,
  `datum` datetime NOT NULL DEFAULT current_timestamp(),
  `besitzer` varchar(20) NOT NULL,
  `fs_ort` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fs_kiste` (`fs_ort`) USING BTREE,
  CONSTRAINT `tab_dinge_ibfk_1` FOREIGN KEY (`fs_ort`) REFERENCES `tab_ort` (`id_ort`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_dinge`
--

LOCK TABLES `tab_dinge` WRITE;
/*!40000 ALTER TABLE `tab_dinge` DISABLE KEYS */;
INSERT INTO `tab_dinge` VALUES (1,'Akku Ladegerät',' zum Laden der Akkus','Werkzeug','2020-03-10 12:50:40','Matthias',1),(2,'teil1',' zum testen','Sonstiges','2020-03-11 07:21:17','Claudia',4),(3,'Netzwerkkabel',' ','Computer','2020-09-01 09:01:16','Matthias',4),(4,'Antennenkabel',' altes Koax Antennenkabel','Fernsehen','2020-09-01 09:02:51','Matthias',4),(5,'Monitorkabel',' Kabel mit Sub D Stecker für Anschluss an VGA','Computer','2020-09-01 09:04:00','Matthias',4),(6,'Motorsäge Akku',' die kleine Motorsäge mit Akku','Werkzeug','2020-09-01 09:45:56','Matthias',5),(7,'Abisolierzange',' ','Werkzeug','2020-09-12 03:44:27','Matthias',6),(8,'Crimpzange u. Hülsen',' ','Werkzeug','2020-09-12 07:02:28','Matthias',6),(9,'Test',' nur so ..','Sonstiges','2020-12-02 04:12:59','Matthias',2),(10,'Kopfhörer In-Ear Soundcore',' Bluetooth drahtlos','Audio','2020-12-08 10:25:01','Matthias',7),(11,'Kopfhörer geschlossen Hama',' Bluetooth und 3,5\" Klinke','Audio','2020-12-08 10:26:14','Matthias',7),(12,'Aufsätze Kopfhörer',' verschieden grosse Aufsätze für In-Ear Kopfhörer','Audio','2020-12-08 10:27:30','Matthias',7),(13,'Kopfhörer In-Ear Samsung',' 3 Stück weiss\r\n1 Stück schwarz','Audio','2020-12-27 06:57:15','Matthias',7),(14,'Arduino Uno R3 Elegoo',' ','Elektronik','2021-01-01 10:48:28','Matthias',9),(15,'Sonoff S20 WiFi',' schaltbare Steckdose\r\n2 * S20\r\n1 * Basic','Elektronik','2021-01-01 10:49:49','Matthias',9),(16,'FT232 Adapter',' USB to serial z.B. für ESP','Elektronik','2021-01-01 10:52:17','Matthias',9),(17,'Steckbrücken',' verschiedene','Elektronik','2021-01-01 11:13:55','Matthias',10),(18,'div. Kabel',' ','Elektronik','2021-01-01 11:14:14','Matthias',10),(19,'Lochplatinen',' verschiedene Größen','Elektronik','2021-01-01 11:14:42','Matthias',10),(20,'Kabel Krokodilklemmen',' verschiedene Farben','Elektronik','2021-01-01 11:15:37','Matthias',10),(21,' NodeMCU ESP8266',' 3 Boards mit USB und WiFi','Elektronik','2021-01-01 11:23:23','Matthias',11),(22,'FT232 Adapter YP 05','China Variante FTDI USB to serial z.B. für ESP','Elektronik','2021-01-01 11:26:27','Matthias',11),(23,'Nova PM Sensor SDS011',' aus meinem Feinstaubsensor Projekt\r\nwahrscheinlich defekt','Elektronik','2021-01-02 04:00:54','Matthias',11),(24,'Lichtsensor',' mit High- / Low-Ausgang, LM393','Elektronik','2021-01-02 04:06:04','Matthias',11),(25,'Relaisboard 4 Kanal',' 4 Stück','Elektronik','2021-01-02 04:08:30','Matthias',11),(26,'LED Box',' verschiedene Farben in Box','Elektronik','2021-01-02 04:09:31','Matthias',11),(27,'Raspberry PI 4',' Model B 2 GB RAM','Elektronik','2021-01-02 04:10:56','Matthias',11),(28,'3,5 Kabel Klinke auf Klinke',' 2 Kabel','Audio','2021-01-02 10:01:31','Matthias',7),(29,'Kopfhörer In-Ear Bluedio',' Bluetooth drahtlos','Audio','2021-01-02 10:51:10','Matthias',7),(30,'Kopfhörer In-Ear NoName',' Bluetooth drahtlos','Audio','2021-01-02 10:53:02','Matthias',7),(31,'Trotec BN30',' Steckdosen-Thermostat','Sonstiges','2021-01-02 11:07:37','Matthias',12),(32,'Pebble',' Smart Watch','Sonstiges','2021-01-02 11:08:23','Matthias',12),(33,'Devolo dLan',' 500','Sonstiges','2021-01-02 11:09:05','Matthias',12),(34,'Energy Meter',' zur Verbrauchsmessung','Sonstiges','2021-01-02 11:09:44','Matthias',12),(35,'Tablet Samsung',' ','Sonstiges','2021-01-02 11:10:18','Matthias',12),(36,'Kindle',' 3 Stück E-Book Reader','Sonstiges','2021-01-02 11:10:36','Matthias',12),(37,'SD Karten',' 2 Stück','Elektronik','2021-01-07 11:22:14','Matthias',11),(38,'NodeMCU ESP32',' 2 Boards mit USB und WiFi und Bluetooth','Elektronik','2021-01-30 10:22:56','Matthias',11),(39,'Metall Plätchen','für Handy Halterung selbstklebend','Sonstiges','2021-02-02 06:56:25','Matthias',13),(40,'Kunststoff Projekt Box',' Wasserdicht Schwarz DIY Gehäuse für z.B. nodemcu','Elektronik','2021-02-02 11:09:57','Matthias',11),(41,'DHT11 Sensor',' 2 Stück DHT11 Digitale Temperatur und Feuchtigkeit Sensor','Elektronik','2021-02-02 11:13:07','Matthias',11),(42,'D1 Mini ESP8266 NodeMCU',' D1 Mini ESP8266 ESP-12 ESP-12F CH340G CH340 V2 USB WeMos WIFI Entwicklung Bord D1 Mini NodeMCU Lua IOT Bord 3,3 V Mit Pins','Elektronik','2021-02-02 11:14:03','Matthias',11),(43,'D1 Mini ESP8266 ESP-12E',' D1 Mini ESP8266 ESP-12 ESP-12F CH340G CH340 V2 USB WeMos WIFI Entwicklung Bord D1 Mini NodeMCU Lua IOT Bord 3,3 V Mit Pins\r\n\r\nhttp://stefanfrings.de/esp8266/','Elektronik','2021-02-02 11:16:56','Matthias',11),(44,'test',' ','Werkzeug','2021-02-11 05:32:53','Matthias',1),(45,'IP Cam',' mit Netzteil','Computer','2021-02-14 07:36:42','Matthias',12),(46,'ESP32-CAM','3 Stück','Elektronik','2021-03-18 07:45:25','Matthias',11),(47,'Adapter 3,5 Klinke auf Chinch','vom Hisense TV Fernseher Schlafzimmer','Audio','2021-03-23 05:42:52','Matthias',7),(48,'Wechselschalter','Feuchtraum IP44 Aufputz\r\n3 Stück\r\n1 verwendet zum Umschalten Worx oberer/unterer Garten','Sonstiges','2021-04-08 03:07:16','Matthias',14),(49,'Test Gerät','','Sonstiges','2022-04-09 09:36:46','Matthias',15),(50,'ACC akut','','Sonstiges','2022-04-09 09:40:00','Matthias',16),(51,'Adapter 3,5\" auf USB C','3 Stück\r\nfür Kopfhörer an Handy/Tablet ohne 3,5\" Buchse\r\npasst nicht für Samsung\r\nvon TU','Werkzeug','2022-04-19 05:20:00','Matthias',7),(52,'3d Brille','2 Stück','Sonstiges','2023-01-15 07:08:53','Matthias',15),(53,'Linsen für Fernrohr','','Sonstiges','2023-01-15 07:12:52','Matthias',15);
/*!40000 ALTER TABLE `tab_dinge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_ort`
--

DROP TABLE IF EXISTS `tab_ort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_ort` (
  `id_ort` int(11) NOT NULL AUTO_INCREMENT,
  `name_ort` varchar(30) NOT NULL,
  `beschreibung_ort` text NOT NULL,
  `fs_regal` int(11) NOT NULL,
  PRIMARY KEY (`id_ort`),
  KEY `fs_regal` (`fs_regal`),
  CONSTRAINT `tab_ort_ibfk_1` FOREIGN KEY (`fs_regal`) REFERENCES `tab_regal` (`id_regal`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_ort`
--

LOCK TABLES `tab_ort` WRITE;
/*!40000 ALTER TABLE `tab_ort` DISABLE KEYS */;
INSERT INTO `tab_ort` VALUES (1,'Kiste Akku','Kiste mit Ladegerät und div. Akkus',2),(2,'Test Kiste','das ist eine Kiste zum testen',1),(4,'Kiste Kabel','mit Netzwerk-, Monitor- und Antennenkabel',3),(5,'oben rechts','',4),(6,'Opas Kiste','Werkzeugkiste von Claudis Opa',4),(7,'Kiste Audio','Kopfhörer etc',7),(8,'Kiste Test','leer',2),(9,'Kiste Arduino','allgemeines Zubehör für Arduin',7),(10,'Kiste Elekronik Kabel','',7),(11,'Kiste Elekronik Zubehör','',7),(12,'Kiste Kleingeräte','',7),(13,'Kiste Handy','',7),(14,'Kiste Elektro Zubehör','',7),(15,'Kiste Sonstiges','noch nicht erstellt',7),(16,'Kiste Medizin Erkältung','',8);
/*!40000 ALTER TABLE `tab_ort` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_regal`
--

DROP TABLE IF EXISTS `tab_regal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_regal` (
  `id_regal` int(11) NOT NULL AUTO_INCREMENT,
  `name_regal` varchar(25) NOT NULL,
  `beschreibung_regal` text NOT NULL,
  `fs_zimmer` int(11) NOT NULL,
  PRIMARY KEY (`id_regal`),
  KEY `fs_zimmer` (`fs_zimmer`),
  CONSTRAINT `tab_regal_ibfk_1` FOREIGN KEY (`fs_zimmer`) REFERENCES `tab_zimmer` (`id_zimmer`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_regal`
--

LOCK TABLES `tab_regal` WRITE;
/*!40000 ALTER TABLE `tab_regal` DISABLE KEYS */;
INSERT INTO `tab_regal` VALUES (1,'Ikea Regal Server','mit schwarzen Kisten und dem Server ...',1),(2,'Ikea Regal Tür','rechts neben der Eingangstür',1),(3,'Stapelboxen Tür','Ikea Boxen durchsichtig',1),(4,'Metallregal Rückfront','',10),(5,'bewegliches Regal','',11),(7,'Ikea Regal Elektronik','hinter meinem Schreibtisch neben dem Bastel-Tisch',1),(8,'Regal rechts','Metallregal auf der rechten Se',4);
/*!40000 ALTER TABLE `tab_regal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_stockwerk`
--

DROP TABLE IF EXISTS `tab_stockwerk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_stockwerk` (
  `id_stockwerk` int(11) NOT NULL AUTO_INCREMENT,
  `name_stockwerk` varchar(25) NOT NULL,
  `beschreibung_stockwerk` text NOT NULL,
  PRIMARY KEY (`id_stockwerk`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_stockwerk`
--

LOCK TABLES `tab_stockwerk` WRITE;
/*!40000 ALTER TABLE `tab_stockwerk` DISABLE KEYS */;
INSERT INTO `tab_stockwerk` VALUES (1,'Dachgeschoss','unterm Dach im Haus'),(3,'1.Stock','im Haus'),(4,'Erdgeschoss','im Haus'),(5,'Keller','im Haus'),(6,'Draussen','alle Orte außerhalb des Hauses');
/*!40000 ALTER TABLE `tab_stockwerk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_typ`
--

DROP TABLE IF EXISTS `tab_typ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_typ` (
  `id_typ` int(11) NOT NULL AUTO_INCREMENT,
  `name_typ` varchar(11) NOT NULL,
  PRIMARY KEY (`id_typ`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_typ`
--

LOCK TABLES `tab_typ` WRITE;
/*!40000 ALTER TABLE `tab_typ` DISABLE KEYS */;
INSERT INTO `tab_typ` VALUES (1,'Werkzeug'),(2,'Computer'),(3,'Audio'),(4,'Sonstiges'),(5,'Fernseher'),(6,'Elektronik');
/*!40000 ALTER TABLE `tab_typ` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_zimmer`
--

DROP TABLE IF EXISTS `tab_zimmer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_zimmer` (
  `id_zimmer` int(11) NOT NULL AUTO_INCREMENT,
  `name_zimmer` varchar(25) NOT NULL,
  `beschreibung_zimmer` text NOT NULL,
  `fs_stockwerk` int(11) NOT NULL,
  PRIMARY KEY (`id_zimmer`),
  KEY `fs_stockwerk` (`fs_stockwerk`),
  CONSTRAINT `tab_zimmer_ibfk_1` FOREIGN KEY (`fs_stockwerk`) REFERENCES `tab_stockwerk` (`id_stockwerk`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_zimmer`
--

LOCK TABLES `tab_zimmer` WRITE;
/*!40000 ALTER TABLE `tab_zimmer` DISABLE KEYS */;
INSERT INTO `tab_zimmer` VALUES (1,'Arbeitszimmer','von Matthias',1),(2,'Hauptraum','der Dachboden',1),(3,'unterm Giebel','über die Leiter erreichbar',1),(4,'Abstellraum 1. Stock','der hintere Raum',3),(5,'Partyraum','Zimmer zur Terrasse',6),(6,'Garage','unsere Doppelgarage',6),(10,'Werkstatt','',5),(11,'Technikraum','',5),(12,'Küche 1.Stock','Küche im ersten Stock',3);
/*!40000 ALTER TABLE `tab_zimmer` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-09  3:00:01
