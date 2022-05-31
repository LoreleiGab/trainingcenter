-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema sportsdb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sportsdb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sportsdb` DEFAULT CHARACTER SET utf8 ;
USE `sportsdb` ;

-- -----------------------------------------------------
-- Table `sportsdb`.`modalities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`modalities` (
  `id` SMALLINT(2) NOT NULL AUTO_INCREMENT,
  `modalidade` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `modalidade_UNIQUE` (`modalidade` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`positions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`positions` (
  `id` SMALLINT(2) NOT NULL,
  `modality_id` SMALLINT(2) NOT NULL,
  `posição` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_positions_modalities1_idx` (`modality_id` ASC),
  CONSTRAINT `fk_positions_modalities1`
    FOREIGN KEY (`modality_id`)
    REFERENCES `sportsdb`.`modalities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`members`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`members` (
  `id` SMALLINT(2) NOT NULL,
  `membro_dominante` VARCHAR(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `membro_dominante_UNIQUE` (`membro_dominante` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`teams`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`teams` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `equipe` VARCHAR(20) NOT NULL,
  `modality_id` SMALLINT(2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_teams_modalities1_idx` (`modality_id` ASC),
  CONSTRAINT `fk_teams_modalities1`
    FOREIGN KEY (`modality_id`)
    REFERENCES `sportsdb`.`modalities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`proflles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`proflles` (
  `id` SMALLINT(1) NOT NULL AUTO_INCREMENT,
  `perfil` VARCHAR(18) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `perfil_UNIQUE` (`perfil` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `apelido` VARCHAR(20) NOT NULL,
  `email` VARCHAR(70) NOT NULL,
  `telefone` VARCHAR(15) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `profile_id` SMALLINT(1) NOT NULL,
  `photo` MEDIUMTEXT NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_users_proflles1_idx` (`profile_id` ASC),
  CONSTRAINT `fk_users_proflles1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `sportsdb`.`proflles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`athletes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`athletes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome_completo` VARCHAR(120) NOT NULL,
  `apelido` VARCHAR(20) NULL,
  `data_nascimento` DATE NOT NULL,
  `altura` DECIMAL(3,2) NOT NULL,
  `peso` DECIMAL(5,2) NOT NULL,
  `percentual_gordura` SMALLINT(2) NOT NULL,
  `team_id` INT NOT NULL,
  `modality_id` SMALLINT(2) NOT NULL,
  `position_id` SMALLINT(2) NOT NULL,
  `member_id` SMALLINT(2) NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_athletes_positions1_idx` (`position_id` ASC),
  INDEX `fk_athletes_members1_idx` (`member_id` ASC),
  INDEX `fk_athletes_teams1_idx` (`team_id` ASC),
  INDEX `fk_athletes_modalities1_idx` (`modality_id` ASC),
  INDEX `fk_athletes_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_athletes_positions1`
    FOREIGN KEY (`position_id`)
    REFERENCES `sportsdb`.`positions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_members1`
    FOREIGN KEY (`member_id`)
    REFERENCES `sportsdb`.`members` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_teams1`
    FOREIGN KEY (`team_id`)
    REFERENCES `sportsdb`.`teams` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_modalities1`
    FOREIGN KEY (`modality_id`)
    REFERENCES `sportsdb`.`modalities` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `sportsdb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`group_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`group_types` (
  `id` SMALLINT(2) NOT NULL AUTO_INCREMENT,
  `tipo_grupo` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `tipo_grupo_UNIQUE` (`tipo_grupo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`groups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`groups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `team_id` INT NOT NULL,
  `group_type_id` SMALLINT(2) NOT NULL,
  `data` DATE NOT NULL,
  `minutagem` SMALLINT(3) NOT NULL,
  `percepcao_planejada` SMALLINT(2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_groups_group_types1_idx` (`group_type_id` ASC),
  INDEX `fk_groups_teams1_idx` (`team_id` ASC),
  CONSTRAINT `fk_groups_group_types1`
    FOREIGN KEY (`group_type_id`)
    REFERENCES `sportsdb`.`group_types` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_groups_teams1`
    FOREIGN KEY (`team_id`)
    REFERENCES `sportsdb`.`teams` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`sleeping_hours`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`sleeping_hours` (
  `id` SMALLINT(2) NOT NULL,
  `horas_dormidas` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `horas_dormidas_UNIQUE` (`horas_dormidas` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`efforts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`efforts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `athete_id` INT NOT NULL,
  `data` DATE NOT NULL,
  `psr` SMALLINT(2) NOT NULL,
  `pse` SMALLINT(2) NOT NULL,
  `sleeping_hour_id` SMALLINT(2) NOT NULL,
  `degree_pain` SMALLINT(2) NOT NULL,
  `stress` SMALLINT(2) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_efforts_sleeping_hours1_idx` (`sleeping_hour_id` ASC),
  INDEX `fk_efforts_athletes1_idx` (`athete_id` ASC),
  CONSTRAINT `fk_efforts_sleeping_hours1`
    FOREIGN KEY (`sleeping_hour_id`)
    REFERENCES `sportsdb`.`sleeping_hours` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_efforts_athletes1`
    FOREIGN KEY (`athete_id`)
    REFERENCES `sportsdb`.`athletes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`sitepains`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`sitepains` (
  `id` SMALLINT(2) NOT NULL,
  `local da dor` CHAR(1) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`efforts_sitepains`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`efforts_sitepains` (
  `effort_id` INT NOT NULL,
  `sitepain_id` SMALLINT(2) NOT NULL,
  PRIMARY KEY (`effort_id`, `sitepain_id`),
  INDEX `fk_efforts_pains_pains1_idx` (`sitepain_id` ASC),
  CONSTRAINT `fk_efforts_pains_efforts1`
    FOREIGN KEY (`effort_id`)
    REFERENCES `sportsdb`.`efforts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_efforts_pains_pains1`
    FOREIGN KEY (`sitepain_id`)
    REFERENCES `sportsdb`.`sitepains` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`jumps`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`jumps` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `athlete_id` INT NOT NULL,
  `salto` SMALLINT(3) NOT NULL,
  `data` DATE NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_jumps_athletes1`
    FOREIGN KEY (`athlete_id`)
    REFERENCES `sportsdb`.`athletes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`assimetrys`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`assimetrys` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `athlete_id` INT NOT NULL,
  `flex_joelho_direito` DECIMAL(3,1) NOT NULL,
  `flex_joelho_esquerdo` DECIMAL(3,1) NOT NULL,
  `exten_joelho_direito` DECIMAL(3,1) NOT NULL,
  `exten_joelho_esquerdo` DECIMAL(3,1) NOT NULL,
  `relacao_joelho_direito` DECIMAL(3,1) NOT NULL,
  `relacaoiq_joelho_esquerdo` DECIMAL(3,1) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Assimetry_athletes1_idx` (`athlete_id` ASC),
  CONSTRAINT `fk_Assimetry_athletes1`
    FOREIGN KEY (`athlete_id`)
    REFERENCES `sportsdb`.`athletes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sportsdb`.`athletes_has_Assimetry`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sportsdb`.`athletes_has_Assimetry` (
  `athletes_id` INT NOT NULL,
  `Assimetry_idAssimetry` INT NOT NULL,
  PRIMARY KEY (`athletes_id`, `Assimetry_idAssimetry`),
  INDEX `fk_athletes_has_Assimetry_Assimetry1_idx` (`Assimetry_idAssimetry` ASC),
  INDEX `fk_athletes_has_Assimetry_athletes1_idx` (`athletes_id` ASC),
  CONSTRAINT `fk_athletes_has_Assimetry_athletes1`
    FOREIGN KEY (`athletes_id`)
    REFERENCES `sportsdb`.`athletes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_athletes_has_Assimetry_Assimetry1`
    FOREIGN KEY (`Assimetry_idAssimetry`)
    REFERENCES `sportsdb`.`assimetrys` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `sportsdb`.`proflles`
-- -----------------------------------------------------
START TRANSACTION;
USE `sportsdb`;
INSERT INTO `sportsdb`.`proflles` (`id`, `perfil`) VALUES (DEFAULT, 'Fisiologista');
INSERT INTO `sportsdb`.`proflles` (`id`, `perfil`) VALUES (DEFAULT, 'Treinador');
INSERT INTO `sportsdb`.`proflles` (`id`, `perfil`) VALUES (DEFAULT, 'Preparador Físico');
INSERT INTO `sportsdb`.`proflles` (`id`, `perfil`) VALUES (DEFAULT, 'Atleta');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sportsdb`.`group_types`
-- -----------------------------------------------------
START TRANSACTION;
USE `sportsdb`;
INSERT INTO `sportsdb`.`group_types` (`id`, `tipo_grupo`) VALUES (DEFAULT, 'G1');
INSERT INTO `sportsdb`.`group_types` (`id`, `tipo_grupo`) VALUES (DEFAULT, 'G2');
INSERT INTO `sportsdb`.`group_types` (`id`, `tipo_grupo`) VALUES (DEFAULT, 'G3');
INSERT INTO `sportsdb`.`group_types` (`id`, `tipo_grupo`) VALUES (DEFAULT, 'G4');

COMMIT;

