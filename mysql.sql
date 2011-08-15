SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `sheet`;
CREATE TABLE `sheet` ( `sheetId` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'Sheet ID', `accessKey` VARCHAR(255) NOT NULL COMMENT 'Access key', `name` VARCHAR(255) NOT NULL COMMENT 'Sheet name', `currencyCode` VARCHAR(255) NOT NULL COMMENT 'Currency code (EUR, USD...)', `creatorEmail` VARCHAR(255) NOT NULL COMMENT 'Email of the creator of this sheet', `creationTS` DATETIME NOT NULL COMMENT 'Sheet creation date', `lastModificationTS` DATETIME NOT NULL COMMENT 'Last modification date (adding/updating/deleting person, operation or any object in the sheet)', PRIMARY KEY (`sheetId`) ) ENGINE=InnoDB COMMENT='List of sheets';
DROP TABLE IF EXISTS `person`;
CREATE TABLE `person` ( `personId` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'Person ID', `personName` VARCHAR(255) NOT NULL COMMENT 'Person name', `sheetIdFK` INTEGER NOT NULL COMMENT 'Sheet foreign key', PRIMARY KEY (`personId`), INDEX `person_FI_1` (`sheetIdFK`), CONSTRAINT `person_FK_1` FOREIGN KEY (`sheetIdFK`) REFERENCES `sheet` (`sheetId`) ON DELETE CASCADE ) ENGINE=InnoDB COMMENT='List of person in the community';
DROP TABLE IF EXISTS `outgoing`;
CREATE TABLE `outgoing` ( `outId` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'Outgoing ID', `outWeight` FLOAT COMMENT 'Weight applied to the person', `operationIdFK` INTEGER NOT NULL COMMENT 'Operation foreign key', `personIdFK` INTEGER NOT NULL COMMENT 'Person foreign key', PRIMARY KEY (`outId`), INDEX `outgoing_FI_1` (`operationIdFK`), CONSTRAINT `outgoing_FK_1` FOREIGN KEY (`operationIdFK`) REFERENCES `operation` (`operationId`) ON DELETE CASCADE, INDEX `outgoing_FI_2` (`personIdFK`), CONSTRAINT `outgoing_FK_2` FOREIGN KEY (`personIdFK`) REFERENCES `person` (`personId`) ON DELETE CASCADE ) ENGINE=InnoDB COMMENT='What is consumed by the community';
DROP TABLE IF EXISTS `incoming`;
CREATE TABLE `incoming` ( `inId` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'Incoming ID', `inAmount` FLOAT COMMENT 'Amount of the incoming', `operationIdFK` INTEGER NOT NULL COMMENT 'Operation foreign key', `personIdFK` INTEGER NOT NULL COMMENT 'Person foreign key', PRIMARY KEY (`inId`), INDEX `incoming_FI_1` (`operationIdFK`), CONSTRAINT `incoming_FK_1` FOREIGN KEY (`operationIdFK`) REFERENCES `operation` (`operationId`) ON DELETE CASCADE, INDEX `incoming_FI_2` (`personIdFK`), CONSTRAINT `incoming_FK_2` FOREIGN KEY (`personIdFK`) REFERENCES `person` (`personId`) ON DELETE CASCADE ) ENGINE=InnoDB COMMENT='What is shared by the community';
DROP TABLE IF EXISTS `operation`;
CREATE TABLE `operation` ( `operationId` INTEGER NOT NULL AUTO_INCREMENT COMMENT 'Operation ID', `operationTS` DATETIME NOT NULL COMMENT 'Operation date', `operationDescription` TEXT NOT NULL COMMENT 'Operation description', `sheetIdFK` INTEGER NOT NULL COMMENT 'Sheet foreign key', `totalInAmount` FLOAT NOT NULL COMMENT 'Total amount of all incomings for this operation', `totalOutWeight` FLOAT NOT NULL COMMENT 'Total weight of all outgoings for this operation', PRIMARY KEY (`operationId`), INDEX `operation_FI_1` (`sheetIdFK`), CONSTRAINT `operation_FK_1` FOREIGN KEY (`sheetIdFK`) REFERENCES `sheet` (`sheetId`) ON DELETE CASCADE ) ENGINE=InnoDB COMMENT='List of operations (made of incomings and outgoings)';
SET FOREIGN_KEY_CHECKS = 1;

delimiter |

DROP TRIGGER IF EXISTS `incomingInsert` |
CREATE TRIGGER `incomingInsert` AFTER INSERT ON `incoming` FOR EACH ROW BEGIN UPDATE operation SET totalInAmount = ( SELECT COALESCE ( SUM(inAmount), 0) FROM incoming WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK; END; |
DROP TRIGGER IF EXISTS `incomingUpdate` |
CREATE TRIGGER `incomingUpdate` AFTER UPDATE ON `incoming` FOR EACH ROW BEGIN UPDATE operation SET totalInAmount = ( SELECT COALESCE ( SUM(inAmount), 0) FROM incoming WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK; END; |
DROP TRIGGER IF EXISTS `incomingDelete` |
CREATE TRIGGER `incomingDelete` AFTER DELETE ON `incoming` FOR EACH ROW BEGIN UPDATE operation SET totalInAmount = ( SELECT COALESCE ( SUM(inAmount), 0) FROM incoming WHERE operationIdFK = OLD.operationIdFK) WHERE operationId = OLD.operationIdFK; END; |
DROP TRIGGER IF EXISTS `outgoingInsert` |
CREATE TRIGGER `outgoingInsert` AFTER INSERT ON `outgoing` FOR EACH ROW BEGIN UPDATE operation SET totalOutWeight = ( SELECT COALESCE ( SUM(outWeight), 0) FROM outgoing WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK ; END; |
DROP TRIGGER IF EXISTS `outgoingUpdate` |
CREATE TRIGGER `outgoingUpdate` AFTER UPDATE ON `outgoing` FOR EACH ROW BEGIN UPDATE operation SET totalOutWeight = ( SELECT COALESCE ( SUM(outWeight), 0) FROM outgoing WHERE operationIdFK = NEW.operationIdFK) WHERE operationId = NEW.operationIdFK; END; |
DROP TRIGGER IF EXISTS `outgoingDelete` |
CREATE TRIGGER `outgoingDelete` AFTER DELETE ON `outgoing` FOR EACH ROW BEGIN UPDATE operation SET totalOutWeight = ( SELECT COALESCE ( SUM(outWeight), 0) FROM outgoing WHERE operationIdFK = OLD.operationIdFK) WHERE operationId = OLD.operationIdFK; END; |

delimiter ;
