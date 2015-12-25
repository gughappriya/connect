CREATE DEFINER=`root`@`localhost` PROCEDURE `get_friend_list`(IN `userName` VARCHAR(25))
BEGIN
SELECT friendUserName FROM Friend f
		 WHERE f.memberName = userName
UNION ALL
SELECT memberName FROM Friend f
		 WHERE f.friendUserName = userName;
END