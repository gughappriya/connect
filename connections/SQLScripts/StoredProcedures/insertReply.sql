
DELIMITER $$
CREATE PROCEDURE `insertReply`(IN creator varchar(25),IN replyText TEXT, IN replyFor_MsgId INT,IN replyFor_ReplyId INT,OUT newReplyId INT)
BEGIN
    INSERT INTO reply(messageId,reply,replyByUser,creationDate,replyToReplyId)
    VALUES(replyFor_MsgId,replyText,creator,now(),replyFor_ReplyId);
    SELECT LAST_INSERT_ID() INTO newReplyId;
END
END $$