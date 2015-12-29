DELIMITER $$
CREATE PROCEDURE `change_block_request`(IN V_USERNAME VARCHAR(25), IN LATITUDE DECIMAL(18,10), IN LONGITUDE DECIMAL(18,10))
BEGIN
DECLARE found INT;
DECLARE block_id INT;
	SELECT blockId INTO block_id
    FROM block WHERE
		  LATITUDE >= southwestLat &&
          LATITUDE <= northeastLat &&
          LONGITUDE >= southwestLong &&
          LONGITUDE <= northeastLong
	LIMIT 1;
          
	SELECT COUNT(*) INTO found
	FROM `Connections`.`blockrequests` br
	WHERE br.userName = V_USERNAME AND br.blockid = block_id;
    SELECT found;
	IF found = 0 THEN
			UPDATE `Connections`.`blockrequests` SET `blockid`=block_id , `currentStatus`='Pending', approver1=NULL,approver2=NULL,approver3=NULL WHERE `userName` = V_USERNAME ;
				
			SELECT 'true';
	END IF;
END