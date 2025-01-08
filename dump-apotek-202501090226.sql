-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: apotek
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `medicines`
--

DROP TABLE IF EXISTS `medicines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medicines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `deleted` char(5) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicines`
--

LOCK TABLES `medicines` WRITE;
/*!40000 ALTER TABLE `medicines` DISABLE KEYS */;
INSERT INTO `medicines` VALUES (1,'Paracetamol','Pain Reliever',50,1000.00,''),(2,'Ibuprofen','Pain Reliever',30,2000.00,''),(3,'Amoxicillin','Antibiotic',70,5000.00,''),(4,'Cetirizine','Antihistamine',100,1500.00,''),(5,'Loperamide','Antidiarrheal',20,2500.00,''),(6,'Omeprazole','Antacid',40,3000.00,''),(7,'Salbutamol','Bronchodilator',25,3500.00,''),(8,'Metformin','Diabetes',60,4000.00,''),(9,'Amlodipine','Hypertension',45,4500.00,''),(10,'Vitamin C','Supplement',150,1000.00,''),(11,'Diclofenac','Pain Reliever',80,1200.00,''),(12,'Ranitidine','Antacid',35,2800.00,''),(13,'Ciprofloxacin','Antibiotic',90,4800.00,''),(14,'Clarithromycin','Antibiotic',55,5100.00,''),(15,'Azithromycin','Antibiotic',85,6000.00,''),(16,'Tetracycline','Antibiotic',40,5800.00,''),(17,'Doxycycline','Antibiotic',95,5700.00,''),(18,'Hydrochlorothiazide','Diuretic',25,3000.00,''),(19,'Losartan','Hypertension',65,3500.00,''),(20,'Simvastatin','Cholesterol',50,3400.00,''),(21,'Prednisolone','Steroid',100,1500.00,''),(22,'Aspirin','Pain Reliever',120,900.00,''),(23,'Atorvastatin','Cholesterol',30,4400.00,''),(24,'Candesartan','Hypertension',45,4700.00,''),(25,'Gabapentin','Neuropathy',20,3200.00,''),(26,'Morphine','Pain Reliever',15,7500.00,''),(27,'Furosemide','Diuretic',80,2000.00,''),(28,'Clopidogrel','Antiplatelet',25,2300.00,''),(29,'Spironolactone','Diuretic',50,2800.00,''),(30,'Carbamazepine','Epilepsy',60,2600.00,''),(31,'Valproate','Epilepsy',55,2500.00,''),(32,'Loratadine','Antihistamine',70,1800.00,''),(33,'Albuterol','Bronchodilator',40,3100.00,''),(34,'Esomeprazole','Antacid',90,2900.00,''),(35,'Warfarin','Anticoagulant',35,2200.00,''),(36,'Rivaroxaban','Anticoagulant',25,5100.00,''),(37,'Apixaban','Anticoagulant',45,5200.00,''),(38,'Dabigatran','Anticoagulant',30,5300.00,''),(39,'Enoxaparin','Anticoagulant',20,7500.00,''),(40,'Metoprolol','Hypertension',50,4400.00,''),(41,'Bisoprolol','Hypertension',60,4200.00,''),(42,'Propranolol','Hypertension',40,4100.00,''),(43,'Carvedilol','Hypertension',35,4300.00,''),(44,'Lisinopril','Hypertension',90,4600.00,''),(45,'Ramipril','Hypertension',55,4500.00,''),(46,'Perindopril','Hypertension',70,4700.00,''),(47,'Captopril','Hypertension',80,4400.00,''),(48,'Enalapril','Hypertension',75,4300.00,''),(49,'Nifedipine','Hypertension',65,4200.00,''),(50,'Verapamil','Hypertension',50,4100.00,''),(51,'Diltiazem','Hypertension',55,4300.00,''),(52,'Methotrexate','Rheumatoid Arthritis',20,9500.00,''),(53,'Sulfasalazine','Rheumatoid Arthritis',25,8500.00,''),(54,'Hydroxychloroquine','Rheumatoid Arthritis',30,8000.00,''),(55,'Chloroquine','Antimalarial',40,7500.00,''),(56,'Artemether','Antimalarial',35,7200.00,''),(57,'Lumefantrine','Antimalarial',25,7000.00,''),(58,'Quinine','Antimalarial',20,6900.00,''),(59,'Ivermectin','Antiparasitic',45,6800.00,''),(60,'Albendazole','Antiparasitic',60,6700.00,''),(61,'Mebendazole','Antiparasitic',70,6600.00,''),(62,'Praziquantel','Antiparasitic',55,6500.00,''),(63,'Clomiphene','Fertility',50,6400.00,''),(64,'Letrozole','Fertility',45,6300.00,''),(65,'Tamoxifen','Cancer',25,6200.00,''),(66,'Anastrozole','Cancer',20,6100.00,''),(67,'Exemestane','Cancer',15,6000.00,''),(68,'Paclitaxel','Cancer',10,5900.00,''),(69,'Docetaxel','Cancer',8,5800.00,''),(70,'Doxorubicin','Cancer',5,5700.00,''),(71,'Cisplatin','Cancer',4,5600.00,''),(72,'Carboplatin','Cancer',6,5500.00,''),(73,'Etoposide','Cancer',7,5400.00,''),(74,'Imatinib','Cancer',3,5300.00,''),(75,'Dasatinib','Cancer',2,5200.00,''),(76,'Nilotinib','Cancer',1,5100.00,''),(77,'Sorafenib','Cancer',9,5000.00,''),(78,'Sunitinib','Cancer',11,4900.00,''),(79,'Bevacizumab','Cancer',12,4800.00,''),(80,'Trastuzumab','Cancer',13,4700.00,''),(81,'Rituximab','Cancer',14,4600.00,''),(82,'Cetuximab','Cancer',16,4500.00,''),(83,'Panitumumab','Cancer',18,4400.00,''),(84,'Fluorouracil','Cancer',19,4300.00,''),(85,'Capecitabine','Cancer',17,4200.00,''),(86,'Gemcitabine','Cancer',22,4100.00,''),(87,'Vincristine','Cancer',21,4000.00,''),(88,'Vinblastine','Cancer',23,3900.00,''),(89,'Erlotinib','Cancer',24,3800.00,''),(90,'Gefitinib','Cancer',26,3700.00,''),(91,'Crizotinib','Cancer',27,3600.00,''),(92,'Ceritinib','Cancer',28,3500.00,''),(93,'Alectinib','Cancer',29,3400.00,''),(94,'Lorlatinib','Cancer',29,3300.00,''),(95,'paracetamol','pereda rasa sakit',11,10000.00,'*'),(96,'a','a',1,1.00,'*');
/*!40000 ALTER TABLE `medicines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `medicine_id` int NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `sold_by` varchar(255) NOT NULL,
  `sale_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted` char(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `medicine_id` (`medicine_id`),
  CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,1,5,5000.00,'Admin','2025-01-01 09:30:00',''),(2,2,2,4000.00,'Admin','2025-01-01 10:00:00',''),(3,3,3,15000.00,'Manager','2025-01-02 11:15:00',''),(4,4,1,1500.00,'Admin','2025-01-02 14:20:00',''),(5,5,6,15000.00,'User','2025-01-03 08:45:00',''),(6,6,4,12000.00,'Manager','2025-01-03 12:10:00',''),(7,7,10,35000.00,'Admin','2025-01-03 15:30:00',''),(8,8,3,12000.00,'User','2025-01-04 09:50:00',''),(9,9,7,28000.00,'Admin','2025-01-04 11:00:00',''),(10,10,1,4500.00,'Manager','2025-01-04 13:45:00',''),(11,11,8,7200.00,'Admin','2025-01-05 08:20:00',''),(12,12,5,25000.00,'Manager','2025-01-05 09:30:00',''),(13,13,6,15000.00,'User','2025-01-05 10:45:00',''),(14,14,2,9000.00,'Admin','2025-01-05 12:10:00',''),(15,15,1,1000.00,'User','2025-01-05 13:25:00',''),(16,16,7,24500.00,'Manager','2025-01-05 14:50:00',''),(17,17,4,6000.00,'Admin','2025-01-05 16:00:00',''),(18,18,3,13500.00,'Admin','2025-01-06 09:30:00',''),(19,19,9,31500.00,'Manager','2025-01-06 10:45:00',''),(20,20,2,8000.00,'User','2025-01-06 12:00:00',''),(21,93,10,34000.00,'komeng','2025-01-07 01:07:54',''),(22,1,10,10000.00,'komeng','2025-01-07 01:12:16',''),(23,39,3,22500.00,'komeng','2025-01-07 23:36:45',''),(24,21,4,6000.00,'komeng','2025-01-08 00:40:38',''),(25,32,6,10800.00,'komeng','2025-01-08 00:47:50',''),(26,14,9,45900.00,'komeng','2025-01-08 00:58:56',''),(27,54,2,16000.00,'komeng','2025-01-08 01:28:52','*'),(28,32,1,1800.00,'komeng','2025-01-08 02:07:50','*'),(29,32,18,32400.00,'komeng','2025-01-08 21:01:30','');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','manager','user') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `deleted` char(5) COLLATE utf8mb4_general_ci NOT NULL,
  `fullName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$lRITzzQ0w/yj8KoXhmRxAu45fN6SHd4YZOnS.zlUNJ8RhZscAV21a','admin',1,'2025-01-08 22:52:14','','super admin'),(2,'user','$2y$10$4xxhffhnLBk5GDU.umqPD.IJ0RqqL3Kq6KAO1UypQICQeijZ/unS2','user',0,'2025-01-08 22:52:22','','user 2'),(3,'user2','$2y$10$bEX4RTqv7tMwSJU/2s2vhu5x.cw14/7T87FdHGkM2Z7lXgi07KE9u','user',0,'2025-01-08 22:52:41','*',''),(4,'john','$2y$10$y1chY8mVKxQjRsUwHDxtAOIzPTAu5MBvVk0kb..jOIlITqPtGRjye','user',1,'2025-01-09 00:35:33','','John Smith'),(5,'jane','$2y$10$t6vp9iAJXVkKcMtmQYG.rO462YZSLrbVeTmYR5s/XWnvTEoThsQL2','admin',1,'2025-01-09 00:59:47','','Jane Smith');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'apotek'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-09  2:26:58
