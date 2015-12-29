DROP PROCEDURE IF EXISTS `insertNewThread`;
DELIMITER $$
CREATE PROCEDURE `insertNewThread`(IN author varchar(25),IN topic TEXT, IN visibilityID INT,IN body LONGTEXT,IN lat DECIMAL(20,15) , IN longi DECIMAL(20,15),OUT threadId INT,IN recipientName varchar(25))
BEGIN
	INSERT INTO message(topic,visibilityId,messageAuthor,textBody,threadLat,threadLong,creationDate,blockId)
	VALUES(topic,visibilityID,author,body,lat,longi,now(),(SELECT blockId FROM blockrequests WHERE userName =
			author));
    
	SELECT LAST_INSERT_ID() INTO threadId;
    
	CALL `Connections`.`getAllDependants`(author,visibilityID, threadId,recipientName) ;
    
	INSERT INTO messagerecipient(SELECT threadId as messageId,userName as
	recipientUserName,now() as lastSeen FROM dependants) ;
    
	DROP TEMPORARY TABLE IF EXISTS dependants;
END
END $$
