<head>
    <style>
        #circle
        {
            border-radius:50% 50% 50% 50%;  
            width:80px;
            height:80px;
        }
    </style>
    <?php
    include ("include.php");
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connections</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>

<?php include("include.php"); ?>
              
<form  method="POST">
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
                $select_stmt->bind_param('dssss', $blockId, $username, $username, $username, $username);
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
                                    ?> <div class = "row">
                                        <?php $current = $uname; ?>
                                        <a class = "list-group-item" >
                                        <h4 class = "list-group-item-heading" > </h4>
                                        <p class = "list-group-item-text" ><?php echo $current; ?> </p><br>
                                         <div> <?php echo "<img src=../images/user_images/" . $current . ".jpg id='circle' height='30' width='30'>" ?> <br>  </div> <br><br>                  
                                        <button type = "submit" name = "blockAccept" class = "btn btn-sm btn-primary" id = "blockAccept" value='<?php $uname ?>'> Accept</button>
                                        </a></div><?php
                    }
                    $select_stmt->close();
                       if (isset($_POST["blockAccept"])) {
                        //$_SESSION["pendingUser"] = $uname;
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
