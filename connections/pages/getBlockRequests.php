<?php

include("include.php");
try {
    $stmt = $mysqli->prepare("select b.blockId, b.hoodId from block b where b.blockId in (select blockId from blockrequests where userName= ?);");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->bind_result($blockId, $hoodId);
    $stmt->close();
    $get_count_query = "select count(userName) from blockRequests br where br.blockId=? and currentStatus='Pending' 
                        and ((approver1 is null or approver1 != ?)
                        or (approver2 is null or approver2 != ?))";
    $select_stmt = $mysqli->prepare($get_count_query);
    $selectstmt->bind_param('dss', $blockId, $_SESSION['username'], $_SESSION['username']);
    if ($selectstmt->execute()) {
        $results = $selectstmt->fetchAll();
    }
    $newNeighbors = array();
    $counter = 0;
    foreach ($results as $rows) {
        $newNeighbors[$counter++] = $rows['userName'];
    }

    echo json_encode($newNeighbors);
    $select_stmt = null; // doing this is mandatory for connection to get closed
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
    $log->error("Error!: " . $e->getMessage() . "<br/>");
}
?>