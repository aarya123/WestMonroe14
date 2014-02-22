SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `WMP14` DEFAULT CHARACTER SET latin1 ;
USE `WMP14` ;

-- -----------------------------------------------------
-- Table `WMP14`.`Candidate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMP14`.`Candidate` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `school` VARCHAR(45) NOT NULL,
  `major` VARCHAR(45) NOT NULL,
  `gpa` DECIMAL(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id` (`id` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `WMP14`.`Event`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMP14`.`Event` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `location` VARCHAR(45) NOT NULL,
  `time` DATETIME NOT NULL,
  `description` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `WMP14`.`Event_has_Candidate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `WMP14`.`Event_has_Candidate` (
  `Event_id` INT NOT NULL,
  `Candidate_id` INT(11) NOT NULL,
  PRIMARY KEY (`Event_id`, `Candidate_id`),
  INDEX `fk_Event_has_Candidate_Candidate1_idx` (`Candidate_id` ASC),
  INDEX `fk_Event_has_Candidate_Event_idx` (`Event_id` ASC),
  CONSTRAINT `fk_Event_has_Candidate_Event`
    FOREIGN KEY (`Event_id`)
    REFERENCES `WMP14`.`Event` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Event_has_Candidate_Candidate1`
    FOREIGN KEY (`Candidate_id`)
    REFERENCES `WMP14`.`Candidate` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;