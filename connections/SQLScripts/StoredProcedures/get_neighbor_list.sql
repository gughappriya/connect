DELIMITER $$
CREATE PROCEDURE `get_neighbor_list`(IN `userName` VARCHAR(25))
BEGIN
SELECT neighborUserName FROM Neighbor f
		 WHERE f.memberName = userName;

END