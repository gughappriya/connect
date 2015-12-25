DELIMITER $$
CREATE PROCEDURE `friend_request_approval`(IN `approverName` VARCHAR(25), IN `toApproveName` VARCHAR(25))
BEGIN
	Update friend set currentStatus = 'Approved' where memberName = toApproveName and friendUserName = approverName;
END