-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: utilitybilling
-- ------------------------------------------------------
-- Server version	8.0.37

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
-- Table structure for table `paymentlines`
--

DROP TABLE IF EXISTS `paymentlines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paymentlines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `paymentheader_id` int DEFAULT NULL,
  `opening_water_readings` int DEFAULT NULL,
  `closing_water_readings` int DEFAULT NULL,
  `settled` tinyint(1) DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `update_at` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `deleted_at` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `tenant_id` int DEFAULT NULL,
  `tenant_name` varchar(150) DEFAULT NULL,
  `agreed_rent_payable` double DEFAULT NULL,
  `agreed_water_rate` double DEFAULT NULL,
  `water_bill` double DEFAULT NULL,
  `units_used` int DEFAULT NULL,
  `service_charge` int DEFAULT NULL,
  `invoiced` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-paymentlines-paymentheader_id` (`paymentheader_id`),
  KEY `idx_water_readings` (`opening_water_readings`,`closing_water_readings`,`water_bill`),
  KEY `idx_water_rate` (`agreed_water_rate`),
  CONSTRAINT `fk-paymentlines-paymentheader_id` FOREIGN KEY (`paymentheader_id`) REFERENCES `paymentheader` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1532 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `paymentlines_BEFORE_UPDATE` BEFORE UPDATE ON `paymentlines` FOR EACH ROW BEGIN
	IF NEW.opening_water_readings IS NOT NULL 
       AND (NEW.closing_water_readings - NEW.opening_water_readings) > 0 THEN
       SET NEW.units_used = NEW.closing_water_readings - NEW.opening_water_readings;
       SET NEW.water_bill = NEW.agreed_water_rate * NEW.units_used;
    ELSE
        SET NEW.water_bill = 0;
    END IF;
END */;;
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

-- Dump completed on 2024-11-18 20:57:07
