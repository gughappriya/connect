DROP PROCEDURE IF EXISTS `getBlockFeeds`;
DELIMITER $$
CREATE PROCEDURE `getBlockFeeds`(IN user_name varchar(25))
BEGIN
	SELECT recentvisitedTime INTO @lastLoginTime FROM User WHERE userName=user_name;
	SELECT DISTINCT m.messageId,m.topic,m.messageAuthor,br.blockId,visibilityId,m.creationDate as
	threadCreatedTime,r.creationDate as MessageCreationTime,@lastLoginTime as
	LastLoginTimeOfCurrentUser
	FROM message m
	inner join blockrequests br ON br.userName = m.messageAuthor AND br.blockid = (SELECT blockId
	from blockrequests WHERE userName =user_name) AND br.currentStatus='Approved'
	inner JOIN messagerecipient mr ON mr.messageId = m.messageId AND mr.recepientUserName =	user_name
	LEFT join reply r on m.messageId = r.messageId
	AND TIMESTAMPDIFF(SECOND, m.creationDate, @lastLoginTime) <=0
	OR TIMESTAMPDIFF(SECOND, r.creationDate, @lastLoginTime) <=0 ;
END