DELIMITER $$
CREATE PROCEDURE `get_friend_search`(IN `userName` VARCHAR(25))
BEGIN
SELECT u.userName FROM user u
WHERE  u.userName != userName AND
u.userName NOT IN (
SELECT friendUserName FROM Friend f
		 WHERE f.memberName = userName
UNION ALL
SELECT memberName FROM Friend f
		 WHERE f.friendUserName = userName)
AND blockId is not null;
END