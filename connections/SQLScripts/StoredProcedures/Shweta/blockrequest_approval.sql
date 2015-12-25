DELIMITER $$
CREATE PROCEDURE blockrequest_approval(IN approverName VARCHAR(25), IN toApproveName VARCHAR(25))
BEGIN
  SELECT `blockid` INTO @block_id 
  FROM blockrequests 
  WHERE userName = approverName;
  
  SELECT COUNT(*) INTO @count
  FROM blockrequests 
  WHERE currentStatus = 'Approved' AND blockid = @block_id
  GROUP BY blockid;
  
  IF @count = 1 THEN
      UPDATE blockrequests 
      SET approver1 = approverName, currentStatus = 'Approved', memberSince = now()
      WHERE userName = toApproveName;
      
	UPDATE user SET blockId = @block_id WHERE userName = toApproveName;
  ELSE IF @count = 2 THEN
	  SELECT approver1 INTO @approv1 
      FROM blockrequests WHERE userName = toApproveName;
      IF @approv1 IS NULL THEN
		UPDATE blockrequests
		SET approver1 = approverName 
        WHERE userName = toApproveName; 
	  ELSE
		UPDATE blockrequests
		SET approver2 = approverName, currentStatus = 'Approved', memberSince = now()
        WHERE userName = toApproveName;
		UPDATE user SET blockId = @block_id WHERE userName = toApproveName;
	  END IF;
  ELSE 
	  SELECT approver1, approver2 INTO @approv1, @approv2
	  FROM blockrequests WHERE userName = toApproveName;
	  IF @approv1 IS NULL THEN
		UPDATE blockrequests
		SET approver1 = approverName 
        WHERE userName = toApproveName; 
	  ELSEIF @approv2 IS NULL THEN
		UPDATE blockrequests
		SET approver2 = approverName 
        WHERE userName = toApproveName; 
	  ELSE
        UPDATE blockrequests
		SET approver3 = approverName, currentStatus = 'Approved', memberSince = now()
        WHERE userName = toApproveName; 
        
        UPDATE user SET blockId = @block_id WHERE userName = toApproveName;
	  END IF;
      END IF;
  END IF;
  
  
END