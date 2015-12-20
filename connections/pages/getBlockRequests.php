<?php
	include('include.php');
	try {
		$stmt= $mysqli->prepare('select u.blockId,hoodId from user u join block where u.userName= ?;');
                $stmt->bind_param("s", $_SESSION['username']);
                $stmt->bind_result($blockId, $hoodId);
		$stmt= $mysqli->prepare('select userName from blockRequests br join block b where br.blockId=? and b.hoodId=? and currentStatus="Pending" '
                        . 'and approver1 != ? or approver2 != ?;');
		$results = $stmt->fetchAll();

		$newNeighbors = array();
		$counter=0;
		foreach ($results as $rows){
			$newNeighbors[$counter++] = $rows['userName'];
		}

		echo json_encode($newNeighbors);
		$stmt = null; // doing this is mandatory for connection to get closed
		
	} catch (PDOException $e) {
		echo "Error!: " . $e->getMessage() . "<br/>";
		$log->error("Error!: " . $e->getMessage() . "<br/>");
	}
?>