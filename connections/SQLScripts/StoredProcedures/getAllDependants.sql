
DROP PROCEDURE IF EXISTS `getAllDependants`;

DELIMITER $$

CREATE PROCEDURE `getAllDependants`(IN user_Name varchar(25),IN visibility_ID INT, IN
messageId INT, IN recipientName varchar(25))

BEGIN
	DROP TEMPORARY TABLE IF EXISTS dependants;
    
	CREATE TEMPORARY TABLE dependants(userName varchar(25) NOT NULL);
    
	SELECT DISTINCT
		category
	INTO @category FROM
		messagevisibility
	WHERE
		visibilityId = visibility_ID;
        
	SELECT @category;
    
	CASE @category
		WHEN 'neighbors' THEN
			INSERT INTO dependants SELECT neighborUserName as userName FROM neighbor
			WHERE memberName = user_Name UNION SELECT user_Name;
		WHEN 'friends' THEN
			INSERT INTO dependants SELECT friendUserName as userName FROM friend
			WHERE memberName = user_Name UNION SELECT user_Name;
		WHEN 'hood' THEN
			INSERT INTO dependants SELECT userName FROM blockrequests natural join
			Connections.block
			WHERE hoodId =(SELECT hoodId FROM blockrequests natural join Connections.block
			WHERE userName = user_Name)
			AND currentStatus ='APPROVED' UNION SELECT user_Name;
		WHEN 'block' THEN
			INSERT INTO dependants SELECT userName FROM blockrequests
			WHERE blockId =(SELECT blockId FROM blockrequests WHERE userName =
			user_Name)
			AND currentStatus ='APPROVED' UNION SELECT user_Name;
		WHEN 'user' THEN
			INSERT INTO dependants SELECT recipientName as user_Name UNION SELECT user_Name;
		ELSE
		BEGIN
		END;
	END CASE;
END $$