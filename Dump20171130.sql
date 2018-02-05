-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sdi
-- ------------------------------------------------------
-- Server version	5.7.18-log

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
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `inactivo` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,'MP','Mesa de Partes','1'),(2,'DG01','Dirección General','1'),(3,'UA02','Unidad Académica','1');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargos`
--

DROP TABLE IF EXISTS `cargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cargos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `inactivo` varchar(1) DEFAULT NULL,
  `areas_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cargos_areas_idx` (`areas_id`),
  CONSTRAINT `fk_cargos_areas` FOREIGN KEY (`areas_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargos`
--

LOCK TABLES `cargos` WRITE;
/*!40000 ALTER TABLE `cargos` DISABLE KEYS */;
INSERT INTO `cargos` VALUES (1,'Secretaria','1',1),(2,'Director General','1',2),(3,'Jefe de Unidad Academica','1',3);
/*!40000 ALTER TABLE `cargos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expedientes`
--

DROP TABLE IF EXISTS `expedientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expedientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) NOT NULL,
  `fecha_registro` date NOT NULL,
  `fecha_atendido` date DEFAULT NULL,
  `estado` varchar(1) NOT NULL,
  `tramites_id` int(11) NOT NULL,
  `areas_id` int(11) NOT NULL,
  `solicitantes_id` int(11) NOT NULL,
  `cargos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`cargos_id`),
  KEY `fk_expedientes_tramites1_idx` (`tramites_id`),
  KEY `fk_expedientes_areas1_idx` (`areas_id`),
  KEY `fk_expedientes_solicitantes1_idx` (`solicitantes_id`),
  KEY `fk_expedientes_cargos1_idx` (`cargos_id`),
  CONSTRAINT `fk_expedientes_areas1` FOREIGN KEY (`areas_id`) REFERENCES `areas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedientes_cargos1` FOREIGN KEY (`cargos_id`) REFERENCES `cargos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedientes_solicitantes1` FOREIGN KEY (`solicitantes_id`) REFERENCES `solicitantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedientes_tramites1` FOREIGN KEY (`tramites_id`) REFERENCES `tramites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedientes`
--

LOCK TABLES `expedientes` WRITE;
/*!40000 ALTER TABLE `expedientes` DISABLE KEYS */;
INSERT INTO `expedientes` VALUES (1,'0001','2017-11-26','2017-11-26','A',1,1,1,1);
/*!40000 ALTER TABLE `expedientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requisitos`
--

DROP TABLE IF EXISTS `requisitos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requisitos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `tramites_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_requisitos_tramites1_idx` (`tramites_id`),
  CONSTRAINT `fk_requisitos_tramites1` FOREIGN KEY (`tramites_id`) REFERENCES `tramites` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requisitos`
--

LOCK TABLES `requisitos` WRITE;
/*!40000 ALTER TABLE `requisitos` DISABLE KEYS */;
INSERT INTO `requisitos` VALUES (1,'Solicitud',1);
/*!40000 ALTER TABLE `requisitos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguimientos`
--

DROP TABLE IF EXISTS `seguimientos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seguimientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_remite_id` int(11) NOT NULL,
  `area_recibe_id` int(11) DEFAULT NULL,
  `fecha_envio` date NOT NULL,
  `accion` varchar(1) NOT NULL,
  `estado` int(11) NOT NULL,
  `expedientes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_seguimientos_expedientes1_idx` (`expedientes_id`),
  CONSTRAINT `fk_seguimientos_expedientes1` FOREIGN KEY (`expedientes_id`) REFERENCES `expedientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguimientos`
--

LOCK TABLES `seguimientos` WRITE;
/*!40000 ALTER TABLE `seguimientos` DISABLE KEYS */;
INSERT INTO `seguimientos` VALUES (1,1,2,'2017-11-26','E',1,1),(2,2,3,'2017-11-26','D',1,1),(3,3,3,'2017-11-26','A',1,1);
/*!40000 ALTER TABLE `seguimientos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitantes`
--

DROP TABLE IF EXISTS `solicitantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(45) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `inactivo` varchar(1) DEFAULT NULL,
  `curso` varchar(45) DEFAULT NULL,
  `programa` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `carrera` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitantes`
--

LOCK TABLES `solicitantes` WRITE;
/*!40000 ALTER TABLE `solicitantes` DISABLE KEYS */;
INSERT INTO `solicitantes` VALUES (1,'76235868','LEYLA ROSA','ACUÑA LATORRE','l@gmail.com','1','2','REGULAR','qwqwqwqwqwq','4646565','EDUCACIÓN INICIAL');
/*!40000 ALTER TABLE `solicitantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tramites`
--

DROP TABLE IF EXISTS `tramites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tramites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(6,3) NOT NULL,
  `inactivo` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tramites`
--

LOCK TABLES `tramites` WRITE;
/*!40000 ALTER TABLE `tramites` DISABLE KEYS */;
INSERT INTO `tramites` VALUES (1,'Carnet de biblioteca',3.000,'1');
/*!40000 ALTER TABLE `tramites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(45) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `tipo` varchar(1) DEFAULT NULL,
  `inactivo` varchar(1) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `cargos_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'8945','elargo','Elivar','Largo','elargor@gmail.com','$2y$10$RvMdO3tC2yccmO3NN6218.UlFLZKkNg85viSv7gxatebYQ4XcwWQ6','A','1',NULL,0),(2,'8956','mperez','Marco','Perez','m@gmail.com','$2y$10$8VeKXgbnIunkbYTHZyBA2eMu7dNddXykxrCijDZzlVd0RO/lQ7BY.','U','1','upload/perfil3.jpg',1),(3,'789','jvargas','Juan','Vargas','j@vargas','$2y$10$A/WTnRahy7fOup0jG.FnNeIUqdVToChVln9NcFu8C7Xl6KUinCUF6','U','1',NULL,2),(4,'895','scarrion','Stalin','Carrion','s@gmail.con','$2y$10$SoV9wmvSd9cvBb6x5pPKhOnYwZctYPkqBvoU/rNGt/mS6G/D5VWi6','U','1',NULL,3);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-30 22:57:26
