-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.27-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.2.0.6576
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para tec2u
CREATE DATABASE IF NOT EXISTS `tec2u` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `tec2u`;

-- Copiando estrutura para tabela tec2u.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `numero` varchar(8) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(60) NOT NULL,
  `cidade` varchar(60) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela tec2u.clientes: ~3 rows (aproximadamente)
DELETE FROM `clientes`;
INSERT INTO `clientes` (`id`, `nome`, `cep`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`) VALUES
	(1, 'Tanjirou Kamado', '01139-001', 'Avenida Marquês de São Vicente', '666', '', 'Várzea da Barra Funda', 'São Paulo', 'SP'),
	(2, 'Takeshi Hongou', '13145-740', 'Rua Aldo Manoel de Souza', '6', '', 'João Aranha', 'Paulínia', 'SP'),
	(8, 'Koutarou Minami', '02320-000', 'Rua Adolfo Del Vecchio', '343', '', 'Parque Casa de Pedra', 'São Paulo', 'SP'),
	(9, 'Hiroshi Tsukuba', '13145-700', 'Avenida Duque de Caxias', '8678', 'Casa 1', 'João Aranha', 'Paulínia', 'SP'),
	(10, 'Shiro Kazami', '13141-000', 'Rodovia Professor Zeferino Vaz', '655', '', 'Parque Brasil 500', 'Paulínia', 'SP'),
	(11, 'Keisuke Jin', '13142-000', 'Avenida Prefeito José Lozano Araújo', '53433', '', 'Parque Bom Retiro', 'Paulínia', 'SP'),
	(12, 'Jon Shigeru', '13142-200', 'Rua Maria Adelaide Alves Caetano Bardou', '50', '', 'Parque Bom Retiro', 'Paulínia', 'SP'),
	(13, 'Kazuya Oki', '13141-100', 'Rua 3', '3', '', 'Parque Brasil 500', 'Paulínia', 'SP'),
	(14, 'Hironobu Kageyama', '01138-000', 'Rua James Holland', '343', '', 'Barra Funda', 'São Paulo', 'SP'),
	(15, 'Ichirou Mizuki', '01137-000', 'Rua Cruzeiro', '70', '', 'Barra Funda', 'São Paulo', 'SP'),
	(17, 'Takashi Shishido', '01234-000', 'Avenida Pacaembu', '564', '', 'Pacaembu', 'São Paulo', 'SP');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
