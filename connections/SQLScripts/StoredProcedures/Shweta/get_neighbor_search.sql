
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_neighbor_search`(IN `userName` VARCHAR(25))
BEGIN
    
SELECT u.userName FROM user u
WHERE (u.blockId is not null AND blockId = (SELECT b.blockId 
    FROM block b WHERE
    b.userName = userName))
AND u.userName != userName 
AND u.userName NOT IN
	(SELECT n.neighborUserName FROM Neighbor n
    WHERE n.memberName = userName);
END