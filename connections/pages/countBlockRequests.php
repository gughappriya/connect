<?php
	include('include.php');
	try {
		$stmt= $mysqli->prepare('select u.blockId,hoodId from user u join block where u.userName= ?;');
                 $stmt->bind_param("s", $_SESSION['username']);
//		$stmt->execute(array($userName));
//		$results = $stmt->fetchAll();
//
//		foreach($results as $row){
//			$block=$row['block'];
//			$hood=$row['hood'];
//		}
                $stmt->bind_result($blockId, $hoodId);
		$stmt= $mysqli->prepare('select count(userName) from blockRequests br join block b where br.blockId=? and b.hoodId=? and currentStatus="Pending" '
                        . 'and approver1 != ? or approver2 != ?;');
		$stmt = null; // doing this is mandatory for connection to get closed
	} catch (PDOException $e) {
		echo "Error!: " . $e->getMessage() . "<br/>";
	}

?>
