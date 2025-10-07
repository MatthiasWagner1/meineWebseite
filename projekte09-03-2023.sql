-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: projekte
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
-- Table structure for table `projekte`
--

DROP TABLE IF EXISTS `projekte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projekte` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name_projekte` varchar(50) NOT NULL,
  `datum` varchar(10) NOT NULL,
  `prio` varchar(2) NOT NULL,
  `beschreibung_projekte` text NOT NULL,
  `erledigt` varchar(1) NOT NULL,
  `typ` varchar(20) NOT NULL,
  `wiedervorlage` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projekte`
--

LOCK TABLES `projekte` WRITE;
/*!40000 ALTER TABLE `projekte` DISABLE KEYS */;
INSERT INTO `projekte` VALUES (1,'Akkusauger','10.02.2021','1','Dreame V9 oder Jimmy JV85 zwischen 100 und 150\r\n\r\n14.02.2021 Gerät ist geliefert, leider defekt an der Halterung, Reklamation beim Lieferanten - sie bieten 5 Euro\r\n\r\n15.02.2021 E-Mail: Angebot abgelehnt, ich möchte eine neue Halterung\r\n\r\n\r\n24.02.2021 ich bekomme 20 Euro wegen der kaputten Halterung - das ist in Ordnung\r\nZahlung abwarten dann erledigt\r\n\r\n\r\n25.02.2021 20,- Euro zurückerstattet, alles OK\r\n','1','Haus',''),(2,'Rente - Termin zur Beratung','11.02.2021','1','das macht Hr. Seubert, Mitarbeiter der Gemeinde, Tel. 09155/78-37\r\nMail am 10.2. am seubert@simmelsdorf.de\r\nSehr geehrter Herr Seubert,\r\nich bin im Jahr 1959 geboren und würde gerne Ihre Rentenberatung in Anspruch nehmen.\r\n\r\nWie können wir am besten einen Termin vereinbaren?\r\n\r\n15.02.2021 \r\nTelefonat mit Herrn Seubert, er veranlasst die Zusendung neuester Renteninformationen. Die scanne ich und schicke sie per E-Mail an seubert@simmelsdorf.de. den Antrag selber verschickt man 3 Monate vor Rentenbeginn.\r\n\r\n18.02.2021 Renteninfo angekommt, gescannt und per Mail an Hr. Seubert\r\n\r\n19.2.2021 die Kurzfassung ist da, die ausführliche wurde durch Hr. Seubert angefordert\r\n\r\n24.02.2021 Rentenauskunft angekommen, 2 Lücken kann ich prüfen, wahrscheinlich kommt nichts dabei raus, habe ich\r\nmit Harry Teschner schon gemacht.\r\nFazit: Enddatum ist der 1.9.2025, erster möglicher Termin isr der 1.7.2022 mit 11,4% Abschlag\r\ndas werden dann ca. 1300,-\r\n\r\nIch melde mich Anfang 2022 bei Herrn Seubert und wir stellen den Rentenantrag\r\n\r\n\r\n06.02.2022 Mail an:\r\nGuten Morgen Herr Seubert,\r\n\r\nwir hatten vor einem Jahr Kontakt bezüglicher einer Rentenberatung. Wir sind verblieben, dass ich mich Anfang 2022 bei Ihnen wegen eines Termins melde. Wann ist bei Ihnen ein Termin möglich?\r\n\r\nMfG\r\n\r\nMatthias Wagner\r\n\r\n\r\n16.02.2022 \r\nheute den Antrag bei der Gemeinde in den Briefkasten geworfen, Ich habe die Krankenkasse nachgetragen und die Daten der letztem Arbeitslosigkeit\r\n\r\n\r\n04.03.2022 Antrag bei Herrn Seubert angekommen, alles OK, er schickt alles weiter, Info bis Ende Mai 2022\r\n\r\n\r\n\r\n25.05.2022\r\nAnruf Hr. Seubert: noch kein Rentenbescheid da, er kümmert sich, ruft bei der Rentenstelle an und gibt mir Bescheid\r\n\r\n','1','Sonstiges','20.05.2022'),(3,'Allianz Versicherung','12.02.2021','1','Auto ummelden, neue Versicherung\r\n11.2.2021 Auto umgemeldet, neue Versicherung von Thomas, alte Versicherung wird vom Landratsamt informiert und beendet\r\n\r\n15.02.2021 heute email an info@allianz.de, claudi und ich ins cc. wie soll mit welcher versicherung verfahren werden\r\n\r\n\r\n23.02.2021 Telefoniert mit Frau Grundmann, sie benötigt eine Sterbeurkunde, heute per Mail verschickt, sie lümmert sich\r\n\r\n\r\n04.03.2021 bis heute nichts passiert. Telefoniert mit Frau Pohle, sehr nett, sie macht alles so wie die Mail vom 15.2. Private Haftpflicht bekommt Leni einen Single Tarif, zusammenlegen mit unserem Vertrag geht nicht da Partnervertrag, Aufhebung von Rechtsschutz und Glasversicherung möglich.\r\n','1','Sonstiges',''),(4,'Infobildschirm - Kindle oder Monitor ','12.02.2021','2','oder kleines OLED Display','','Computer',''),(5,'Anwesenheit','12.02.2021','3','','','Computer',''),(6,'Münzen erfassen','11.02.2021','3','','','Haus',''),(7,'Krankenkasse - Wechsel zur Barmer über Claudia','12.02.2021','1','01.02.2021 Telefonat mit Barmer - sie schicken ein Formular\r\n\r\n16.02.2021 Telefonat: am 4.2. wurde das Formular verschickt - sie schickt nochmal eines\r\n\r\n\r\n01.03.2021 Nach telefonischer Rücksprache das Formular Familienversicherung ausgefüllt und per E-Mail an service@barmer.de verschickt.\r\n','1','Sonstiges',''),(15,'Hänger ummelden','16.02.2021','1','16.02.2021 Wunsch: umschreiben auf mich - alles andere bleibt - klappt das mit der steuer? zulassung fragen\r\n\r\n\r\n18.02.2021 \r\nHänger umgemeldet auf mich','1','Haus',''),(16,'metadata.opf Info über E-Books','18.02.2021','1','ist das ein zentraler Server?\r\n\r\n25.05.2021 \r\nnein kein zentraler Server!\r\ncontent.opf ist ein Teil des Archives aus dem epub Dateien bestehen.\r\nInhalts dieses xml Doumentes ist unter anderem: Titel, Autor, ISBN, Kategorie?? ....\r\nideal um z.B. den Dateinamen anzupassen oder nach doppelten Dateien zu suchen ....\r\n\r\nwie könnte man vorgehen:\r\n\r\n1. welche meiner ebooks habe ich als epub datei - wahrscheinlich fast alle?\r\n2. kann ich \r\n- das Archiv entpacken \r\n- content.opf auslesen \r\n- umbenennen, \r\n- in db schreiben, \r\n- Umkopieren ....??? \r\n- archiv löschen\r\n- .....\r\n\r\nhier habe ich probeweise entpackt:\r\n/mnt/pve/daten/Buecher/ebooks/Das Joshua-Profil/t/Das Joshua-Profil - Sebastian Fitzek/OEBPS/\r\n\r\nhttps://de.wikipedia.org/wiki/EPUB#Stammdatei_inhalt.opf_(Version_2)\r\nhttps://www.dpc-consulting.org/epub-praxis-die-epub-metadaten/#\r\nhttps://www.delphipraxis.net/178941-anzeigen-eines-ebooks-im-epub-format.html\r\n\r\nhttps://living-sun.com/php/665787-extract-only-text-from-epub-php-html-zip-epub.html\r\n\r\n\r\n','','Computer',''),(17,'Bank abschleifen und streichen','28.02.2021','1','\r\n03.04.2021 Gestern fertiggestellt\r\nBretter aus Douglasie mit Leinöl eingelassen,\r\nMetallgestell neu lackiert\r\n\r\n','1','Garten',''),(18,'Treppe Terrasse entmoosen','28.02.2021','1','','1','Garten',''),(19,'sudo chmod 777 -R /media/filme/','05.03.2021','2','alle Verzeichnisse sind für alle verfügbar, dadurch ist zu erkennen:\r\n- welche Filme wurden schon angesehen\r\n- wo wurde ein Film beendet\r\n\r\n\r\n06.06.2021 \r\ntäglich per cron als root vom pve\r\n0 7 * * * chmod 777 -R /media/filme/\r\n\r\nfunktioniert das?\r\n\r\n\r\n','1','Computer',''),(20,'ESP32 CAM mit 18650 für Rasenroboter','18.03.2021','2','Installieren, 3 Stück in Elektronik Zubehör\r\n\r\nESP32-Cam - Webserver einrichten, EdisTechlab\r\n\r\n','','Elektronik',''),(21,'LED und Solar reparieren','20.03.2021','3','https://www.youtube.com/watch?v=aE_RKU3tMc0&t=159s','','Elektronik',''),(22,'Sammelthread NodeMCU','20.03.2021','3','Datenbereitstellung über MQTT mit NodeMCU ESP8266 \r\nhttps://youtu.be/7kK4aSKq8PE \r\n\r\nWhat is the Ideal Battery Technology to Power 3.3V Devices like the ESP8266?\r\nhttps://youtu.be/heD1zw3bMhw \r\n\r\nBest power saving mode - Much Deeper Deep Sleep ESP8266\r\nhttps://youtu.be/n_A_8Y4xNx8 \r\n\r\nPower Saving with ESP8266 (Sleep Mode) Tutorial with some Tricks\r\nhttps://youtu.be/6SdyImetbp8 \r\n\r\nESP8266 12 / 7 - How to solder breakout board and flash with Arduino IDE\r\nhttps://youtu.be/O2SSyfP6OM0 \r\n\r\noutdoor Temperaturen logging with ESP8266 12f\r\n\r\n\r\n\r\n','','Elektronik',''),(23,'Fasseinlauf Haus, Wasser geht verloren ','05.04.2021','1','Vielleicht den Einlauf aus dem Marderhaus verwenden','1','Haus',''),(24,'Z-Wave iobroker neu installieren','05.04.2021','1','\r\n07.04.2021 in ioBroker: neuen Adapter installiert: Z-Wave 2\r\n\r\n','1','Computer',''),(25,'neues Wlan für IOT - getrennt vom Hauptnetz','07.04.2021','2','vnet - evtl. mit managed switch? oder kann das der unifi access point? oder als Gast netz ???\r\nwas ist mit meinen cams - lassen sich die ips ändern??\r\n\r\n','','Computer',''),(26,'Steuer 2021','08.04.2021','1','wo sammeln wir die Belege das Jahr über?\r\n\r\n17.05.2021 \r\nerledigt - 4400,- sollen wir zurück bekommen.\r\nBelege in Schubfach Steuer','1','Sonstiges',''),(27,'neues Tablet','08.04.2021','1','WhatsApp\r\nOsmAnd\r\n','1','Computer',''),(28,'NAS Backup Daten und Proxmox','10.04.2021','1','','','Computer',''),(29,'Wallbox cfos ins Wlan','17.04.2021','1','','1','Computer',''),(30,'Reifenwechsel Fabia','21.04.2021','1','Rostfleck bearbeiten und Lackstift mitnehmen\r\n\r\n23.04.2021 Termin heute bei Ayranci in Hüttenbach. 15,-\r\n','1','Sonstiges',''),(31,'18650er Akku Pack','22.04.2021','2','Laden der Akkus mit 4,2 Volt\r\n\r\nDie Kapazität der verwendeten Akkus sollten annähernd gleich sein.\r\nWie misst man die Kapazität?\r\nAbgabestrom: 2 - 30 A\r\n\r\n\r\n1 Akku ca. 3,6 Volt und 3000 mAh (kleine 2.200 - 2.500 sind No-Name)\r\n\r\n4S 2P bedeutet 4 Akkus in Serie, 2 parallel entspricht ca. 16 Volt\r\n\r\n4s entspricht 3,6 Volt mal 4 = 14,4 Volt\r\n2p entspricht 3000 mAh mal 2 = 6000 mAh\r\n\r\nFür meinen Trolley brauche ich 24V 10Ah\r\n\r\n7S: 7 * 3,6 V = 25,2V\r\n\r\n3p: 3 * 3.000 mAh = 9.000 mAh\r\ndas sind 21 Stück 18650er\r\n\r\n4p: 4 * 3.000 mAh = 12.000 mAh\r\ndas sind 28 Stück 18650er\r\n\r\nWie stark sollen die vernickelten Bänder sein? 0,1 -0,2 mm?\r\n0,15 mm ist Standard\r\n\r\n','','Elektronik',''),(32,'ESP Klingel ins Wlan','23.04.2021','3','mit ESP \r\nwenn es klingelt: Nachricht Telegram mit Bild\r\n\r\n','','Computer',''),(33,'Elektrocaddy','17.05.2021','1','bei meinem Caddy Akku durch 18650er nachbauen - geht das?\r\n\r\noder Georg fragen und den Emotion ausprobieren?\r\n\r\noder wieder tragen?\r\n\r\n\r\n19.05.2021 \r\ntragen - eher nicht\r\nmein Edelstahltrolley ist schwer und unhandlich??\r\nIst der Akku defekt? Netzteil liefert keinen Strom, Netzteil bestellt Amazon 20,-\r\nder Emotion von Georg ist klein und handlich - hat aber beim 1. Versuch nicht funktioniert\r\n\r\n28.05.2021 \r\nGeorgs Emotion hat beim 2. Mal auch nicht funktioniert, habe morgen Christas Emotion dabei zum Tests\r\n\r\n01.06.2021 \r\nHabe Christas Emotion ausprobiert - der gefällt mir nicht - Emotion ist raus.\r\nBei meinem Eco Trolley ist weder Batterie noch Akku defekt - vielleicht Elektronik. Dann baue ich vielleicht einen Ein/Aus Schalter rein - 10, 20 - 30 Meter etc. brauche ich nicht\r\n\r\n\r\n08.06.2021 \r\nAkku ist wohl doch kaputt - ich hab falsch gemessen :-(\r\nich teste jetzt den Trolley mit meinem Netzteil und wenn der geht bau ich einen Akku aus 18650er nach\r\n\r\nTrolley geht - mit meinem Netzteil - Lampe geht an - Motor läuft - in verschiedenen Geschwindigkeiten\r\n\r\n\r\n11.06.2021 \r\nGestern eine Batterie bestellt - soll in 10 Tagen da sein\r\n\r\n14.08.2021 \r\nBatterie kam nie an, hab mir einen JuCad gekauft von Günter für 900,- inkl. Bag\r\n','1','Sonstiges',''),(34,'Füllstandsmesser für Heizöltank​','04.06.2021','2','OilFox - Der intelligente Füllstandsmesser für Ihren Heizöltank​','','Haus',''),(35,'Nextcloud','08.06.2021','3','Nextcloud auf einem Proxmox Server installieren:\r\nhttps://www.youtube.com/watch?v=ULrP2VztfOg','','Computer',''),(36,'WLED-Leuchte','20.06.2021','3','WLED-Leuchte - App und ioBroker-Integration | haus-automatisierung:\r\nhttps://www.youtube.com/watch?v=fOdkO0ywErI\r\n','','Elektronik',''),(37,'VSCode und PlatformIO statt Arduino IDE','22.08.2021','1','https://www.youtube.com/watch?v=Yb-HOBynJdc&t=756s\r\n\r\n27.03.2022 \r\nmit Micro Python','1','Computer',''),(38,'Regenfässer verbinden','03.09.2021','1','vom blauen Fass am Haus zu den grünen Fässern\r\nKaltwasserleitung oder Schlauch?\r\nBefestigen mit Anschraubmuffe?\r\nWie dick? 1-2 Zoll?\r\n\r\nhttps://www.sanitaer-produkte.de/product_info.php?info=p102_regentonnen-verbinder---40.html\r\nhttps://www.talu.de/regentonnen-verbinden/#materialien_und_werkzeuge\r\n\r\n','1','Haus',''),(39,'ESP-01S','06.09.2021','1','https://wolles-elektronikkiste.de/esp8266-esp-01-modul','','Elektronik','');
/*!40000 ALTER TABLE `projekte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tab_typ`
--

DROP TABLE IF EXISTS `tab_typ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tab_typ` (
  `id_typ` int(11) NOT NULL AUTO_INCREMENT,
  `name_typ` varchar(20) NOT NULL,
  PRIMARY KEY (`id_typ`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tab_typ`
--

LOCK TABLES `tab_typ` WRITE;
/*!40000 ALTER TABLE `tab_typ` DISABLE KEYS */;
INSERT INTO `tab_typ` VALUES (1,'Haus'),(2,'Garten'),(3,'Computer'),(4,'Sonstiges'),(5,'Elektronik');
/*!40000 ALTER TABLE `tab_typ` ENABLE KEYS */;
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
