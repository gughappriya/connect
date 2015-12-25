<?php include("include.php"); ?>
<form action = "home.php?page=friendRequests" method="POST">
    <!-- /.row -->
    <div class = "row">
        <div class = "col-lg-10">
            <?php
            try {
                $username = $_SESSION['username'];
                $get_pending_request = "Select memberName from friend where friendUserName = ? and currentStatus ='Pending'";

                $select_stmt = $mysqli->prepare($get_pending_request);
                $select_stmt->bind_param('s',$username);
                if ($select_stmt->execute()) {
                    $select_stmt->store_result();
                    $numrows = $select_stmt->num_rows;
                    $select_stmt->bind_result($friendname);
                    if ($numrows == 0) {
                        ?> <label for="about">You have no pending friend requests</label>
                        <div class = "list-group" id = "display" >
                            <?php
                        } else {
                            ?> <h5> You have following pending friend requests </h5>
                            <div class = "list-group" id = "display" >
                                <?php
                                /* fetch associative array */
                                while ($select_stmt->fetch()) {
                                    ?> <a class = "list-group-item" >
                                        <h4 class = "list-group-item-heading" > </h4>
                                        <p class = "list-group-item-text" ><?php echo $friendname; ?> </p><br>
                                        <button type = "submit" name = "blockAccept" class = "btn btn-sm btn-primary" id = "blockAccept" value='<?php $friendname ?>'> Accept</button>
                                    </a><?php
                                }
                                $select_stmt->close();

                                if (isset($_POST["blockAccept"])) {
                                    if ($stmt = $mysqli->prepare("CALL friend_request_approval(?,?)")) {
                                        $stmt->bind_param("ss", $username, $friendname);
                                        if ($stmt->execute()) {
                                            mysqli_stmt_fetch($stmt);
                                        } else {
                                            echo $mysqli->error();
                                        }
                                    } else {
                                        echo $mysqli->error();
                                    }
                                }
                            }
                        }
                    } catch (PDOException $e) {
                        echo "Error!: " . $e->getMessage() . "<br/>";
                        $log->error("Error!: " . $e->getMessage() . "<br/>");
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</form>

