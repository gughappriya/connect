<?php include("include.php"); ?>
<form action = "home.php?page=blockRequests" method="POST">
    <!-- /.row -->
    <div class = "row">
        <div class = "col-lg-10">
            <?php
            try {
                $username = $_SESSION['username'];
                $block_query = "select b.blockId, b.hoodId from block b where b.blockId in (select blockId from blockrequests where userName= ?)";
                $stmt = $mysqli->prepare($block_query);
                $stmt->bind_param('s', $username);
                $stmt->execute();
                $stmt->bind_result($blockId, $hoodId);
                $rowcount = 0;
                while ($stmt->fetch()) {
                    $rowcount = $rowcount + 1;
                }
                $stmt->close();
                $get_user_query = "select userName from blockRequests br where br.blockId=? and currentStatus='Pending' 
                        and ((approver1 is null or approver1 != ?)
                        or ((approver2 is null or approver2 != ?) and approver1 != ?))and br.userName != ?";
                $select_stmt = $mysqli->prepare($get_user_query);
                $select_stmt->bind_param('dssss', $blockId, $username, $username,$username, $username);
                if ($select_stmt->execute()) {
                    $select_stmt->store_result();
                    $numrows = $select_stmt->num_rows;
                    $select_stmt->bind_result($uname);
                    if ($numrows == 0) {
                        ?> <h5> You have no pending requests </h5>
                        <div class = "list-group" id = "display" >
                            <?php
                        } else {
                            ?> <h5> You have following pending requests </h5>
                            <div class = "list-group" id = "display" >
                                <?php
                                /* fetch associative array */
                                while ($select_stmt->fetch()) {
                                    ?> <a class = "list-group-item" >
                                        <h4 class = "list-group-item-heading" > </h4>
                                        <p class = "list-group-item-text" ><?php echo $uname; ?> </p><br>
                                        <button type = "submit" name = "blockAccept" class = "btn btn-sm btn-primary" id = "blockAccept" value='<?php $uname ?>'> Accept</button>
                                    </a><?php
                                }
                                $select_stmt->close();
                                if (isset($_POST["blockAccept"])) {
                                    $_SESSION["pendingUser"] = $uname;
                                    if ($stmt = $mysqli->prepare("CALL blockrequest_approval(?,?)")) {
                                        $stmt->bind_param("ss", $username, $uname);
                                        if ($stmt->execute()) {
                                            mysqli_stmt_fetch($stmt);
                                        } else {
                                            echo $mysqli->error();
                                        }
                                    } else {
                                        echo $mysqli->error();
                                    }
                                   // header("refresh: 1; home.php?page=blockRequests");
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
