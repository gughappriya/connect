CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_block_request`(IN USERNAME VARCHAR(25), IN LATITUDE DECIMAL(18,10), IN LONGITUDE DECIMAL(18,10))
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
	WHERE br.userName = USERNAME AND br.blockid = block_id;
    SELECT found;
	IF found = 0 THEN
			INSERT INTO `Connections`.`blockrequests` (`userName`, `blockid`, `currentStatus`)
				VALUES (USERNAME, block_id, 'Pending');
			SELECT 'true';
	END IF;
END