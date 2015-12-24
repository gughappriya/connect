
CREATE SCHEMA IF NOT EXISTS `Connections` ;
USE `Connections` ;


DROP TABLE IF EXISTS Family;
DROP TABLE IF EXISTS Friend;
DROP TABLE IF EXISTS Neighbor;
DROP TABLE IF EXISTS BlockRequests;
DROP TABLE IF EXISTS Reply;
DROP TABLE IF EXISTS MessageRecipient;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS MessageVisibility;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Block;
DROP TABLE IF EXISTS Hood;
DROP TABLE IF EXISTS NotificationType;
DROP TABLE IF EXISTS State;
DROP TABLE IF EXISTS Country;


-- -----------------------------------------------------
-- Utility Tables
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `Connections`.`Country`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`Country` (
  `countryId` INT NOT NULL AUTO_INCREMENT,
  `countryName` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`countryId`))
ENGINE = InnoDB;

ALTER TABLE `Connections`.`Country` AUTO_INCREMENT=100;
-- -----------------------------------------------------
-- Table `Connections`.`State`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`State` (
  `stateId` INT NOT NULL  AUTO_INCREMENT,
  `stateName` VARCHAR(20) NOT NULL,
  `countryId` INT  NOT NULL,
  PRIMARY KEY (`stateId`),
  CONSTRAINT `countryId`
    FOREIGN KEY (`countryId`)
    REFERENCES `Connections`.`Country` (`countryId`)
    ON DELETE NO ACTION)
ENGINE = InnoDB;

ALTER TABLE `Connections`.`State` AUTO_INCREMENT=200;
-- -----------------------------------------------------
-- Table `Connections`.`NotificationType`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`NotificationType` (
  `notificationType` VARCHAR(25) NOT NULL,  
  PRIMARY KEY (`notificationType`)
  )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Connections`.`Hood`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`Hood` (
  `hoodId` INT NOT NULL AUTO_INCREMENT,
  `hoodName` VARCHAR(20) NOT NULL,
  `northeastLat` DECIMAL(20,15) NOT NULL,
  `northeastLong` DECIMAL(20,15) NOT NULL,
  `southwestLat` DECIMAL(20,15) NOT NULL,
  `southwestLong` DECIMAL(20,15) NOT NULL,
  PRIMARY KEY (`hoodId`))
ENGINE = InnoDB;

ALTER TABLE `Connections`.`Hood` AUTO_INCREMENT=300;
-- -----------------------------------------------------
-- Table `Connections`.`Block`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`Block` (
  `blockId` INT NOT NULL AUTO_INCREMENT,
  `hoodId` INT NOT NULL,
  `blockName` VARCHAR(20) NOT NULL,
  `northeastLat` DECIMAL(20,15) NOT NULL,
  `northeastLong` DECIMAL(20,15) NOT NULL,
  `southwestLat` DECIMAL(20,15) NOT NULL,
  `southwestLong` DECIMAL(20,15) NOT NULL,
  PRIMARY KEY (`blockId`),
  CONSTRAINT `hoodId`
    FOREIGN KEY (`hoodId`)
    REFERENCES `Connections`.`Hood` (`hoodId`)
    ON DELETE NO ACTION)
ENGINE = InnoDB;

ALTER TABLE `Connections`.`Block` AUTO_INCREMENT=400;
-- -----------------------------------------------------
-- Table `Connections`.`Relation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`Relation` (
  `relationId` INT NOT NULL AUTO_INCREMENT,
  `relationName` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`relationId`))
ENGINE = InnoDB;

ALTER TABLE `Connections`.`Relation` AUTO_INCREMENT=500;
-- -----------------------------------------------------
-- Table `Connections`.`MessageVisibility`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`MessageVisibility` (
  `visibilityId` INT NOT NULL AUTO_INCREMENT,
  `category` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`visibilityId`))
ENGINE = InnoDB;

ALTER TABLE `Connections`.`MessageVisibility` AUTO_INCREMENT=600;
-- -----------------------------------------------------
-- Schema Tables
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `Connections`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`User` (
  `userName` VARCHAR(25) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `firstName` VARCHAR(45) NOT NULL,
  `lastName` VARCHAR(45) NOT NULL,
  `gender` VARCHAR(10) NOT NULL,
  `address` TEXT NULL,
  `profilePic` VARCHAR(25)  NULL,
  `profileDescription` TEXT NULL,
  `recentvisitedTime` DATETIME NOT NULL,
  `notificationType` VARCHAR(15) NULL,
  `notificationValue` VARCHAR(15) NULL,
  `blockId` INT NULL,
  PRIMARY KEY (`userName`),
   CONSTRAINT `notificationtype`
    FOREIGN KEY (`notificationType`)
    REFERENCES `Connections`.`notificationType` (`notificationType`)
    ON DELETE NO ACTION,
   CONSTRAINT `userblockId`
    FOREIGN KEY (`blockId`)
    REFERENCES `Connections`.`Block` (`blockId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Connections`.`BlockRequests`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`BlockRequests` (
  `userName` VARCHAR(25) NOT NULL,
  `blockId` INT NOT NULL,
  `approver1` VARCHAR(25)  NULL,
  `approver2` VARCHAR(25)  NULL,
  `approver3` VARCHAR(25)  NULL,
  `currentStatus` VARCHAR(10) NOT NULL,
  `memberSince` DATETIME NULL,
  PRIMARY KEY (`userName`),
  CONSTRAINT `userName`
    FOREIGN KEY (`userName`)
    REFERENCES `Connections`.`User` (`userName`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `blockId`
    FOREIGN KEY (`blockId`)
    REFERENCES `Connections`.`Block` (`blockId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `approver1`
    FOREIGN KEY (`approver1`)
    REFERENCES `Connections`.`User` (`userName`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `approver2`
    FOREIGN KEY (`approver2`)
    REFERENCES `Connections`.`User` (`userName`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `approver3`
    FOREIGN KEY (`approver3`)
    REFERENCES `Connections`.`User` (`userName`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Connections`.`Neighbor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`Neighbor` (
  `memberName` VARCHAR(25) NOT NULL,
  `neighborUserName` VARCHAR(25) NOT NULL,
  `neighborSince` DATETIME DEFAULT NULL,
  `isActive` VARCHAR(15) NULL,
  PRIMARY KEY (`memberName`, `neighborUserName`),
  CONSTRAINT `Neigbor`
    FOREIGN KEY (`memberName`)
    REFERENCES `Connections`.`User` (`userName`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `neighborUserName`
    FOREIGN KEY (`neighborUserName`)
    REFERENCES `Connections`.`User` (`userName`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Connections`.`Friend`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`Friend` (
  `memberName` VARCHAR(25) NOT NULL,
  `friendUserName` VARCHAR(25) NOT NULL,
  `currentStatus` VARCHAR(15) NOT NULL,
  `approvedTime` DATETIME DEFAULT NULL,
  `isActive` VARCHAR(15) NULL,
  PRIMARY KEY (`memberName`, `friendUserName`),
  CONSTRAINT `initiatorUserName`
    FOREIGN KEY (`memberName`)
    REFERENCES `Connections`.`User` (`userName`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `friendUserName`
    FOREIGN KEY (`friendUserName`)
    REFERENCES `Connections`.`User` (`userName`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Connections`.`Family`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Connections`.`Family` (
  `userName` VARCHAR(25) NOT NULL,
  `fuserName` VARCHAR(25) NOT NULL,
  `relationId` INT NOT NULL,
  PRIMARY KEY (`userName`, `fuserName`),
  CONSTRAINT `familyName`
    FOREIGN KEY (`userName`)
    REFERENCES `Connections`.`User` (`userName`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fuserName`
    FOREIGN KEY (`fuserName`)
    REFERENCES `Connections`.`User` (`userName`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `relationId`
    FOREIGN KEY (`relationId`)
    REFERENCES `Connections`.`Relation` (`relationId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `Connections`.`Message`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `Connections`.`Message` (
  `messageId` INT NOT NULL AUTO_INCREMENT,
  `topic` TEXT NOT NULL,
  `visibilityId` INT NOT NULL,
  `messageAuthor` VARCHAR(45) NOT NULL,
  `textBody` LONGTEXT NULL,
  `threadLat` DECIMAL(20,15) NULL,
  `threadLong` DECIMAL(20,15) NULL,
  `creationDate` DATETIME NOT NULL, 
  `blockId` INT NOT NULL,
  PRIMARY KEY (`messageId`),
  CONSTRAINT `visibilityId`
    FOREIGN KEY (`visibilityId`)
    REFERENCES `Connections`.`MessageVisibility` (`visibilityId`),  
  CONSTRAINT `creator`
    FOREIGN KEY (`messageAuthor`)
    REFERENCES `Connections`.`User` (`userName`),
CONSTRAINT `block`
    FOREIGN KEY (`blockId`)
    REFERENCES `Connections`.`block` (`blockId`))
ENGINE = InnoDB;

ALTER TABLE `Connections`.`Message` AUTO_INCREMENT=1000;


-- -----------------------------------------------------
-- Table `Connections`.`Reply`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `Connections`.`Reply` (
  `replyId` INT NOT NULL AUTO_INCREMENT,
  `messageId` INT NOT NULL ,
  `reply` TEXT NOT NULL,  
  `replyByUser` VARCHAR(45) NOT NULL,
  `creationDate` DATETIME NOT NULL,
  `replyToReplyId` INT NULL,
  PRIMARY KEY (`replyId`),
  CONSTRAINT `replyTomessageId`
    FOREIGN KEY (`messageId`)
    REFERENCES `Connections`.`Message` (`messageId`),
  CONSTRAINT `replyToReplyId`
    FOREIGN KEY (`replyToReplyId`)
    REFERENCES `Connections`.`Reply` (`replyId`)
     ON DELETE CASCADE
     ON UPDATE CASCADE,
  CONSTRAINT `replycreator`
    FOREIGN KEY (`replyByUser`)
    REFERENCES `Connections`.`User` (`userName`))
ENGINE = InnoDB;

ALTER TABLE `Connections`.`Reply` AUTO_INCREMENT=2000;

-- -----------------------------------------------------
-- Table `Connections`.`MessageRecipient`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `Connections`.`MessageRecipient` (
  `messageId` INT NOT NULL,
  `recepientUserName` VARCHAR(25) NOT NULL,
  `lastSeen` DATETIME NOT NULL,
  PRIMARY KEY (`messageId`,`recepientUserName`),
  CONSTRAINT `messageId`
    FOREIGN KEY (`messageId`)
    REFERENCES `Connections`.`Message` (`messageId`)
     ON DELETE CASCADE
     ON UPDATE CASCADE,
  CONSTRAINT `messageRecipient`
    FOREIGN KEY (`recepientUserName`)
    REFERENCES `Connections`.`User` (`userName`)
     ON DELETE CASCADE
     ON UPDATE CASCADE)
ENGINE = InnoDB;

