CREATE DEFINER=`root`@`localhost` PROCEDURE `send_friend_request`(IN `inviter` VARCHAR(25), IN `invitee`  VARCHAR(25))
BEGIN
   INSERT INTO Friend (memberName,friendUserName,currentStatus) 
   VALUES (inviter,invitee,'Pending');
END