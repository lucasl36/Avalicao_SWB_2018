-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.38-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para aval_swb
CREATE DATABASE IF NOT EXISTS `aval_swb` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `aval_swb`;

-- Copiando estrutura para tabela aval_swb.tb_address
CREATE TABLE IF NOT EXISTS `tb_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(125) NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  `street_name` varchar(200) NOT NULL,
  `number` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `complement` varchar(50) DEFAULT NULL,
  `id_type_address` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tb_address_tb_type_address` (`id_type_address`),
  CONSTRAINT `FK_tb_address_tb_type_address` FOREIGN KEY (`id_type_address`) REFERENCES `tb_type_address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela aval_swb.tb_people
CREATE TABLE IF NOT EXISTS `tb_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(125) NOT NULL,
  `cpfcnpj` varchar(15) NOT NULL,
  `rgie` varchar(50) NOT NULL,
  `people_type` varchar(1) NOT NULL,
  `mail_address` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `cell_phone` varchar(20) NOT NULL,
  `birth` datetime DEFAULT NULL,
  `employess_amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela aval_swb.tb_people_address
CREATE TABLE IF NOT EXISTS `tb_people_address` (
  `people_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`people_id`,`address_id`),
  KEY `FK_tb_people_address_tb_address` (`address_id`),
  CONSTRAINT `FK_tb_people_address_tb_address` FOREIGN KEY (`address_id`) REFERENCES `tb_address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_tb_people_address_tb_people` FOREIGN KEY (`people_id`) REFERENCES `tb_people` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela aval_swb.tb_type_address
CREATE TABLE IF NOT EXISTS `tb_type_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(125) NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela aval_swb.tb_user
CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(125) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
