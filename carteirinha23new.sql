-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: carteirinha23
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.24.04.1

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
-- Table structure for table `cardapio`
--

DROP TABLE IF EXISTS `cardapio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cardapio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_refeicao` date NOT NULL,
  `dia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `principal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `acompanhamento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sobremesa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ind_excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cardapio`
--

LOCK TABLES `cardapio` WRITE;
/*!40000 ALTER TABLE `cardapio` DISABLE KEYS */;
INSERT INTO `cardapio` VALUES (47,'2024-10-21','segunda','miojo','Arroz e feijão','Maçã',0),(48,'2024-10-22','terca','miojo','Alface','Laranja',0),(49,'2024-10-23','quarta','miojo','Salada','Banana',0),(50,'2024-10-24','quinta','miojo','Farofa','a',0),(51,'2024-10-25','sexta','miojo','Batata palha','Abacaxi',0);
/*!40000 ALTER TABLE `cardapio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `nota` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario` (`id_usuario`),
  KEY `fk_nota` (`nota`),
  CONSTRAINT `fk_nota` FOREIGN KEY (`nota`) REFERENCES `status_feedback` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horario_padrao`
--

DROP TABLE IF EXISTS `horario_padrao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horario_padrao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inicio_vig` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fim_vig` timestamp NULL DEFAULT NULL,
  `horario` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario_padrao`
--

LOCK TABLES `horario_padrao` WRITE;
/*!40000 ALTER TABLE `horario_padrao` DISABLE KEYS */;
INSERT INTO `horario_padrao` VALUES (1,'2024-07-17 07:10:38','2024-07-18 07:11:14','16:10:00'),(2,'2024-07-18 07:11:14','2024-07-19 07:14:12','22:11:00'),(3,'2024-07-19 07:14:12','2024-07-19 07:14:33','04:14:00'),(4,'2024-07-19 07:14:33','2024-07-26 12:19:36','09:00:00'),(5,'2024-07-26 12:19:36','2024-09-16 19:26:52','10:19:00'),(6,'2025-04-15 01:12:06','2025-04-14 03:00:00','21:26:00'),(7,'2025-04-14 03:00:00',NULL,'23:59:00');
/*!40000 ALTER TABLE `horario_padrao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `justificativa`
--

DROP TABLE IF EXISTS `justificativa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `justificativa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `justificativa`
--

LOCK TABLES `justificativa` WRITE;
/*!40000 ALTER TABLE `justificativa` DISABLE KEYS */;
INSERT INTO `justificativa` VALUES (1,'Aula no contra turno'),(2,'Transporte'),(3,'Projeto/TCC/Estágio'),(4,'Outro'),(5,'Refeição recebida por transferência');
/*!40000 ALTER TABLE `justificativa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificacao`
--

DROP TABLE IF EXISTS `notificacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificacao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_remetente` int NOT NULL,
  `id_destinatario` int NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `assunto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensagem` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lida` tinyint(1) NOT NULL DEFAULT '0',
  `transferencia` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_remetente` (`id_remetente`),
  KEY `fk_destinatario` (`id_destinatario`),
  KEY `fk_transferencia_notification` (`transferencia`),
  CONSTRAINT `fk_destinatario` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_remetente` FOREIGN KEY (`id_remetente`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_transferencia_notification` FOREIGN KEY (`transferencia`) REFERENCES `status_notification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificacao`
--

LOCK TABLES `notificacao` WRITE;
/*!40000 ALTER TABLE `notificacao` DISABLE KEYS */;
INSERT INTO `notificacao` VALUES (8,3,2,'2025-02-04','16:09:28','Transferência de Almoço','Saudações Vitor, o estudante Botteste fez a você uma solicitação de transferência de almoço!\n\nMotivo: nao quero mais',1,2),(11,1,2,'2025-02-04','17:45:02','Testando notificação','Teste notificação',1,0),(15,2,3,'2025-02-04','20:22:21','Transferência de Almoço','Saudações Botteste, o estudante Vitor fez a você uma solicitação de transferência de almoço!\n\nMotivo: nao quero mais',1,2),(16,3,2,'2025-02-04','20:40:38','Transferência de Almoço','Saudações Vitor, o estudante Botteste fez a você uma solicitação de transferência de almoço!\n\nMotivo: Passei mal e tive que ir embora',1,2),(17,1,2,'2025-02-05','06:23:10','Testando novas notificações','lorem ipsum.',1,0),(18,6,4,'2025-04-09','22:03:16','testando','a mensagem chegou?',1,0),(19,4,6,'2025-04-11','23:28:14','Transferencia de almoço','Motivo da transferência: kkkkkkkkkkkkkkkk',1,0),(20,4,6,'2025-04-11','23:26:11','testeeee','oioioi',1,0),(21,4,6,'2025-04-11','23:31:21','Transferencia de almoço','Motivo da transferência: hghfbew',1,1),(22,4,6,'2025-04-11','23:31:22','Transferencia de almoço','Motivo da transferência: hghfbew',1,0),(23,4,6,'2025-04-12','15:23:16','Transferencia de almoço','Motivo da transferência: vvvvv',1,0),(24,4,6,'2025-04-12','15:34:38','Transferencia de almoço','Motivo da transferência: lllllll',1,0),(25,4,6,'2025-04-12','17:06:41','Transferencia de almoço','Motivo da transferência: njnjnjnjnjnjjjj',1,0),(27,4,6,'2025-04-12','17:12:56','Transferencia de almoço','Motivo da transferência: ttttttttttttttttttttttttttt',1,0),(31,4,6,'2025-04-12','17:30:35','Transferencia de almoço','Motivo da transferência: aaaaaaaaaa',1,0),(36,4,6,'2025-04-12','17:39:55','Transferencia de almoço','Motivo da transferência: hhhhhhhhhhh',1,0),(37,4,6,'2025-04-12','17:44:50','Transferencia de almoço','Motivo da transferência: ssssssssssss',1,0),(38,4,6,'2025-04-14','22:22:13','Transferencia de almoço','Motivo da transferência: não quero mais',1,1),(40,4,6,'2025-04-16','21:01:58','Transferencia de almoço','Motivo da transferência: é peixe, não gosto',1,0),(41,4,6,'2025-04-16','23:25:44','Transferencia de almoço','Motivo da transferência: hoje é domingoo',1,1),(42,6,4,'2025-04-17','13:08:58','Transferencia de almoço','Motivo da transferência: ppppp',1,0),(43,6,4,'2025-04-17','13:14:05','Transferencia de almoço','Motivo da transferência: fff',1,0),(44,6,4,'2025-04-17','13:18:13','Transferencia de almoço','Motivo da transferência: eee',1,0),(45,6,4,'2025-04-17','13:23:13','Transferencia de almoço','Motivo da transferência: sss',1,0),(46,6,4,'2025-04-17','13:27:13','Transferencia de almoço','Motivo da transferência: llll',1,0),(47,4,6,'2025-04-17','13:29:45','Transferencia de almoço','Motivo da transferência: testando transferencia',1,0),(48,6,4,'2025-04-17','13:32:37','Transferencia de almoço','Motivo da transferência: ww',1,0),(49,6,4,'2025-04-17','14:22:02','Transferencia de almoço','Motivo da transferência: qqqq',1,0),(50,6,4,'2025-04-17','14:25:22','Transferencia de almoço','Motivo da transferência: aaaa',1,0),(51,4,6,'2025-04-17','14:27:22','Transferencia de almoço','Motivo da transferência: rr',1,0),(52,6,4,'2025-04-17','17:50:01','Transferencia de almoço','Motivo da transferência: kljkl',1,0),(54,4,6,'2025-04-17','18:31:47','Transferencia de almoço','Motivo da transferência: iii',1,0),(55,4,6,'2025-04-17','22:59:50','Transferencia de almoço','Motivo da transferência: çppp',1,0),(56,4,6,'2025-04-17','23:01:30','Transferencia de almoço','Motivo da transferência: ccc',1,0),(58,4,6,'2025-04-17','23:03:16','Transferencia de almoço','Motivo da transferência: aaa',1,0);
/*!40000 ALTER TABLE `notificacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refeicao`
--

DROP TABLE IF EXISTS `refeicao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `refeicao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_cardapio` int NOT NULL,
  `id_status_ref` int NOT NULL,
  `id_justificativa` int DEFAULT NULL,
  `data_solicitacao` date NOT NULL,
  `hora_solicitacao` time NOT NULL,
  `outra_justificativa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motivo_cancelamento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_cardapio` (`id_cardapio`),
  KEY `id_status` (`id_status_ref`),
  KEY `id_justificativa` (`id_justificativa`),
  CONSTRAINT `refeicao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  CONSTRAINT `refeicao_ibfk_2` FOREIGN KEY (`id_cardapio`) REFERENCES `cardapio` (`id`),
  CONSTRAINT `refeicao_ibfk_3` FOREIGN KEY (`id_status_ref`) REFERENCES `status_ref` (`id`),
  CONSTRAINT `refeicao_ibfk_4` FOREIGN KEY (`id_justificativa`) REFERENCES `justificativa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refeicao`
--

LOCK TABLES `refeicao` WRITE;
/*!40000 ALTER TABLE `refeicao` DISABLE KEYS */;
INSERT INTO `refeicao` VALUES (18,2,47,1,3,'2025-02-03','16:40:39','projeto','nao quero mais'),(19,2,47,1,2,'2025-02-03','17:18:25','transporte',NULL),(20,2,48,1,1,'2025-02-04','15:45:15','contra-turno',NULL),(21,2,47,1,2,'2025-02-10','14:43:37','transporte','nao quero mais'),(22,2,47,1,2,'2025-02-10','15:14:33','transporte','nao quero mais'),(23,2,47,1,3,'2025-02-10','15:15:52','projeto',''),(24,2,47,1,1,'2025-02-10','15:16:38','contra-turno','nao quero mais'),(25,2,47,1,2,'2025-02-10','15:29:06','transporte','Passei mal e tive que ir embora'),(26,2,47,1,2,'2025-02-10','15:31:21','transporte','Passei mal e tive que ir embora'),(27,2,47,1,3,'2025-02-10','15:32:09','projeto',''),(28,2,47,1,2,'2025-02-10','16:32:57','transporte','Passei mal e tive que ir embora'),(29,2,49,1,1,'2025-02-12','19:16:48','contra-turno',NULL),(30,4,48,1,1,'2025-04-01','14:52:25','contra-turno','não quero mais'),(31,4,48,1,1,'2025-04-01','14:55:38','contra-turno','xxxx'),(32,5,48,1,1,'2025-04-01','15:02:20','contra-turno',NULL),(33,4,48,1,1,'2025-04-01','15:27:22','contra-turno','aaaa'),(34,4,48,1,1,'2025-04-01','15:33:38','contra-turno',NULL),(35,4,49,1,1,'2025-04-02','20:15:11','contra-turno',NULL),(36,4,50,1,2,'2025-04-03','16:09:32','transporte','não quero mais'),(37,4,50,1,1,'2025-04-03','18:29:41','contra-turno','nada dms'),(38,4,50,1,1,'2025-04-03','18:33:16','contra-turno','aa'),(39,4,50,1,2,'2025-04-03','18:37:43','transporte','aaaa'),(40,4,50,1,1,'2025-04-03','18:46:38','contra-turno','aaaaaaaaaaaaaa'),(41,4,50,1,2,'2025-04-03','20:11:07','transporte','mmm'),(42,4,50,1,1,'2025-04-03','20:42:54','contra-turno','qqq'),(43,6,50,1,1,'2025-04-03','20:50:10','contra-turno',NULL),(44,4,50,1,1,'2025-04-03','21:49:34','contra-turno',NULL),(45,4,47,1,1,'2025-04-05','19:09:58','contra-turno',NULL),(46,4,49,1,1,'2025-04-09','22:12:18','contra-turno',NULL),(47,4,51,1,1,'2025-04-11','22:18:24','contra-turno',NULL),(48,4,47,1,2,'2025-04-14','22:12:32','transporte','bb'),(49,4,47,1,3,'2025-04-14','22:13:29','projeto','vvvvvv'),(50,4,47,1,1,'2025-04-14','22:19:47','contra-turno',NULL),(51,4,49,5,1,'2025-04-16','20:59:12','contra-turno','aaaaaaaaaaaa'),(52,4,49,5,2,'2025-04-16','21:00:31','transporte',NULL),(53,6,49,1,5,'2025-04-16','23:03:01',NULL,'zzzzzzzzzz'),(54,4,49,2,1,'2025-04-16','23:05:29','contra-turno','ggggggg'),(55,4,49,1,3,'2025-04-16','23:25:23','projeto',NULL),(56,6,49,2,5,'2025-04-16','23:26:11',NULL,'qqqq'),(57,4,50,2,3,'2025-04-17','13:07:39','projeto','qqqqqqqqq'),(58,6,50,5,1,'2025-04-17','13:08:35','contra-turno',NULL),(59,4,50,2,5,'2025-04-17','13:09:50',NULL,'aa'),(60,4,50,2,5,'2025-04-17','13:15:40',NULL,'iii'),(61,4,50,2,5,'2025-04-17','13:19:47',NULL,'zz'),(62,4,50,2,5,'2025-04-17','13:23:36',NULL,'ddd'),(63,4,50,2,5,'2025-04-17','13:27:42',NULL,'aa'),(64,6,50,5,5,'2025-04-17','13:30:23',NULL,NULL),(65,4,50,2,5,'2025-04-17','13:33:04',NULL,'ee'),(66,6,50,5,1,'2025-04-17','14:21:47','contra-turno',NULL),(67,4,50,2,5,'2025-04-17','14:23:25',NULL,'aa'),(68,6,50,5,1,'2025-04-17','14:24:31','contra-turno',NULL),(69,4,50,5,5,'2025-04-17','14:26:14',NULL,NULL),(70,6,50,2,5,'2025-04-17','17:48:47',NULL,'qq'),(71,4,50,1,1,'2025-04-17','18:28:16','contra-turno',NULL);
/*!40000 ALTER TABLE `refeicao` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg01_refeicao` BEFORE INSERT ON `refeicao` FOR EACH ROW SET NEW.id_status_ref = 1 */;;
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
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg02_refeicao` BEFORE INSERT ON `refeicao` FOR EACH ROW SET NEW.data_solicitacao = CONVERT_TZ(NOW(),'+00:00', '+00:00') */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `status_feedback`
--

DROP TABLE IF EXISTS `status_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status_feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_feedback`
--

LOCK TABLES `status_feedback` WRITE;
/*!40000 ALTER TABLE `status_feedback` DISABLE KEYS */;
INSERT INTO `status_feedback` VALUES (1,'Muito Ruim'),(2,'Ruim'),(3,'Neutro'),(4,'Bom'),(5,'Muito bom');
/*!40000 ALTER TABLE `status_feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_msg`
--

DROP TABLE IF EXISTS `status_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status_msg` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_msg`
--

LOCK TABLES `status_msg` WRITE;
/*!40000 ALTER TABLE `status_msg` DISABLE KEYS */;
INSERT INTO `status_msg` VALUES (1,'Lida'),(2,'Não Lida');
/*!40000 ALTER TABLE `status_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_notification`
--

DROP TABLE IF EXISTS `status_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status_notification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_notification`
--

LOCK TABLES `status_notification` WRITE;
/*!40000 ALTER TABLE `status_notification` DISABLE KEYS */;
INSERT INTO `status_notification` VALUES (0,'Sem transferência'),(1,'Em processo\r\n'),(2,'Transferida'),(3,'Cancelada'),(5,'Cancelada por tempo');
/*!40000 ALTER TABLE `status_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_ref`
--

DROP TABLE IF EXISTS `status_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `status_ref` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_ref`
--

LOCK TABLES `status_ref` WRITE;
/*!40000 ALTER TABLE `status_ref` DISABLE KEYS */;
INSERT INTO `status_ref` VALUES (1,'Agendada'),(2,'Cancelada'),(3,'Confirmada'),(4,'Não compareceu'),(5,'transferida');
/*!40000 ALTER TABLE `status_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricula` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'root','root@gmail.com','20201180041','81dc9bdb52d04dc20036dbd8313ed055','adm','00'),(2,'vitor','vitor@gmail.com','20201180046','58573b6d50c9bb551471d1227925c0b6','estudante','00'),(3,'botteste','botteste@gmail.com','20201180011','202cb962ac59075b964b07152d234b70','estudante','75982777354'),(4,'Murilo Neves Matutino','mmatutino617@gmail.com','2000','aad59eab8682a0d4cddb5648a651e32f','estudante','71999343064'),(5,'João','joazinhodograu@gmail.com','2001','698dc19d489c4e4db73e28a713eab07b','estudante','00'),(6,'Cristiano Matutino','cris524matutino4@gmail.com','2002','698dc19d489c4e4db73e28a713eab07b','estudante','999999'),(7,'adm','adm@gmail.com','2003','698dc19d489c4e4db73e28a713eab07b','adm','55');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-21 20:39:43
