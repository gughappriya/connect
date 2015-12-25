CREATE DEFINER=`root`@`localhost` PROCEDURE `follow_neighbor`(IN `follower` VARCHAR(25), IN `followee`  VARCHAR(25))
BEGIN
	INSERT INTO Neighbor (memberName,neighborUserName,neighborSince,isActive) 
   VALUES (follower,followee,now(),'true');
END