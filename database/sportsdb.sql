-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.24-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para sportsdb
CREATE DATABASE IF NOT EXISTS `sportsdb` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sportsdb`;

-- Copiando estrutura para tabela sportsdb.assimetrys
CREATE TABLE IF NOT EXISTS `assimetrys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `athlete_id` int(11) NOT NULL,
  `flex_joelho_direito` decimal(3,1) NOT NULL,
  `flex_joelho_esquerdo` decimal(3,1) NOT NULL,
  `exten_joelho_direito` decimal(3,1) NOT NULL,
  `exten_joelho_esquerdo` decimal(3,1) NOT NULL,
  `relacao_joelho_direito` decimal(3,1) NOT NULL,
  `relacaoiq_joelho_esquerdo` decimal(3,1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Assimetry_athletes1_idx` (`athlete_id`),
  CONSTRAINT `fk_Assimetry_athletes1` FOREIGN KEY (`athlete_id`) REFERENCES `athletes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.assimetrys: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.athletes
CREATE TABLE IF NOT EXISTS `athletes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(120) NOT NULL,
  `apelido` varchar(20) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `altura` decimal(3,2) NOT NULL,
  `peso` decimal(5,2) NOT NULL,
  `percentual_gordura` smallint(2) NOT NULL,
  `team_id` int(11) NOT NULL,
  `modality_id` smallint(2) NOT NULL,
  `position_id` smallint(2) NOT NULL,
  `member_id` smallint(2) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_athletes_positions1_idx` (`position_id`),
  KEY `fk_athletes_members1_idx` (`member_id`),
  KEY `fk_athletes_teams1_idx` (`team_id`),
  KEY `fk_athletes_modalities1_idx` (`modality_id`),
  KEY `fk_athletes_users1_idx` (`user_id`),
  CONSTRAINT `fk_athletes_members1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_modalities1` FOREIGN KEY (`modality_id`) REFERENCES `modalities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_positions1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_teams1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.athletes: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.athletes_has_assimetry
CREATE TABLE IF NOT EXISTS `athletes_has_assimetry` (
  `athletes_id` int(11) NOT NULL,
  `Assimetry_idAssimetry` int(11) NOT NULL,
  PRIMARY KEY (`athletes_id`,`Assimetry_idAssimetry`),
  KEY `fk_athletes_has_Assimetry_Assimetry1_idx` (`Assimetry_idAssimetry`),
  KEY `fk_athletes_has_Assimetry_athletes1_idx` (`athletes_id`),
  CONSTRAINT `fk_athletes_has_Assimetry_Assimetry1` FOREIGN KEY (`Assimetry_idAssimetry`) REFERENCES `assimetrys` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_has_Assimetry_athletes1` FOREIGN KEY (`athletes_id`) REFERENCES `athletes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.athletes_has_assimetry: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.efforts
CREATE TABLE IF NOT EXISTS `efforts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `athete_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `psr` smallint(2) NOT NULL,
  `pse` smallint(2) NOT NULL,
  `sleeping_hour_id` smallint(2) NOT NULL,
  `degree_pain` smallint(2) NOT NULL,
  `stress` smallint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_efforts_sleeping_hours1_idx` (`sleeping_hour_id`),
  KEY `fk_efforts_athletes1_idx` (`athete_id`),
  CONSTRAINT `fk_efforts_athletes1` FOREIGN KEY (`athete_id`) REFERENCES `athletes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_efforts_sleeping_hours1` FOREIGN KEY (`sleeping_hour_id`) REFERENCES `sleeping_hours` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.efforts: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.efforts_sitepains
CREATE TABLE IF NOT EXISTS `efforts_sitepains` (
  `effort_id` int(11) NOT NULL,
  `sitepain_id` smallint(2) NOT NULL,
  PRIMARY KEY (`effort_id`,`sitepain_id`),
  KEY `fk_efforts_pains_pains1_idx` (`sitepain_id`),
  CONSTRAINT `fk_efforts_pains_efforts1` FOREIGN KEY (`effort_id`) REFERENCES `efforts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_efforts_pains_pains1` FOREIGN KEY (`sitepain_id`) REFERENCES `sitepains` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.efforts_sitepains: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `group_type_id` smallint(2) NOT NULL,
  `data` date NOT NULL,
  `minutagem` smallint(3) NOT NULL,
  `percepcao_planejada` smallint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_groups_group_types1_idx` (`group_type_id`),
  KEY `fk_groups_teams1_idx` (`team_id`),
  CONSTRAINT `fk_groups_group_types1` FOREIGN KEY (`group_type_id`) REFERENCES `group_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_groups_teams1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.groups: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.group_types
CREATE TABLE IF NOT EXISTS `group_types` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `tipo_grupo` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipo_grupo_UNIQUE` (`tipo_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.group_types: ~4 rows (aproximadamente)
INSERT IGNORE INTO `group_types` (`id`, `tipo_grupo`) VALUES
	(1, 'G1'),
	(2, 'G2'),
	(3, 'G3'),
	(4, 'G4');

-- Copiando estrutura para tabela sportsdb.jumps
CREATE TABLE IF NOT EXISTS `jumps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `athlete_id` int(11) NOT NULL,
  `salto` smallint(3) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jumps_athletes1` (`athlete_id`),
  CONSTRAINT `fk_jumps_athletes1` FOREIGN KEY (`athlete_id`) REFERENCES `athletes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.jumps: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.members
CREATE TABLE IF NOT EXISTS `members` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `membro_dominante` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `membro_dominante_UNIQUE` (`membro_dominante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.members: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.modalities
CREATE TABLE IF NOT EXISTS `modalities` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `modalidade` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `modalidade_UNIQUE` (`modalidade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.modalities: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.positions
CREATE TABLE IF NOT EXISTS `positions` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `modality_id` smallint(2) NOT NULL,
  `posição` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_positions_modalities1_idx` (`modality_id`),
  CONSTRAINT `fk_positions_modalities1` FOREIGN KEY (`modality_id`) REFERENCES `modalities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.positions: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.proflles
CREATE TABLE IF NOT EXISTS `proflles` (
  `id` smallint(1) NOT NULL AUTO_INCREMENT,
  `perfil` varchar(18) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `perfil_UNIQUE` (`perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.proflles: ~4 rows (aproximadamente)
INSERT IGNORE INTO `proflles` (`id`, `perfil`) VALUES
	(4, 'Atleta'),
	(1, 'Fisiologista'),
	(3, 'Preparador Físico'),
	(2, 'Treinador');

-- Copiando estrutura para tabela sportsdb.sitepains
CREATE TABLE IF NOT EXISTS `sitepains` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `local da dor` char(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.sitepains: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.sleeping_hours
CREATE TABLE IF NOT EXISTS `sleeping_hours` (
  `id` smallint(2) NOT NULL AUTO_INCREMENT,
  `horas_dormidas` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `horas_dormidas_UNIQUE` (`horas_dormidas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.sleeping_hours: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.teams
CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `equipe` varchar(20) NOT NULL,
  `modality_id` smallint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_teams_modalities1_idx` (`modality_id`),
  CONSTRAINT `fk_teams_modalities1` FOREIGN KEY (`modality_id`) REFERENCES `modalities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.teams: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sportsdb.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apelido` varchar(20) NOT NULL,
  `email` varchar(70) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_id` smallint(1) NOT NULL,
  `photo` mediumtext DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_users_proflles1_idx` (`profile_id`),
  CONSTRAINT `fk_users_proflles1` FOREIGN KEY (`profile_id`) REFERENCES `proflles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sportsdb.users: ~1 rows (aproximadamente)
INSERT IGNORE INTO `users` (`id`, `apelido`, `email`, `telefone`, `password`, `profile_id`, `photo`, `created`, `modified`) VALUES
	(1, 'teste', 'teste@teste.com', '(11) 98765-4321', 'U3FJOUQ1dzQ3dUJHTW9wUVF2a0s0QT09', 1, NULL, '2022-06-01 19:31:46', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
