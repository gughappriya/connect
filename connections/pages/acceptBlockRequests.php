<?php

include('include.php');
$pendinguser = $_SESSION['pendingUser'];
try {
    if ($stmt = $mysqli->prepare("CALL blockrequest_approval(?,?)")) {
        $stmt->bind_param("ss", $_SESSION['username'], $pendinguser);
        if ($stmt->execute()) {
            mysqli_stmt_fetch($stmt);
        } else {
            echo $mysqli->error();
        }
    } else {
        echo $mysqli->error();
    }
    mysqli_stmt_close($stmt);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
}
?>
