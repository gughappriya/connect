<?php include("include.php"); ?>
<head>
<!--      Bootstrap Core CSS 
    <link href="css/bootstrap.min.css" rel="stylesheet">

     Custom CSS 
    <link href="css/sb-admin.css" rel="stylesheet">

     Custom Fonts 
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="External/jquery-1.11.3.min.js"></script>
    <script src="External/jquery-1.11.3.js"></script>
    <script src="External/bootstrap-table.min.js">< /script
                < script src = "External/bootstrap-table.js" ></script>
    <link rel="stylesheet" href="External/bootstrap-table.css">
    <link rel="stylesheet" href="External/bootstrap-table.min.css">

    <script src="External/bootstrap.min.js"></script>
    <script src="External/bootstrap.js"></script>
    <script language="javascript" type="text/javascript">
        function ajaxCallAcceptBlockRequests(user) {
            $.ajax({
                url: "acceptBlockRequest.php",
                cache: false,
                type: "POST",
                crossDomain: true,
                data: {
                    "requestingUserName": encodeURIComponent(user),
                },
                success: function (data) {
                    alert(JSON.parse(data));
                },
                error: function (xhr) {
                    alert(JSON.stringify(xhr));
                }
            });
        }
//        $(document).ready(function () {
//        $('body').on('click', '#blockAccept', function (event) {
//        alert('Block accept clicked' + $(this).data("user"));
//                ajaxCallAcceptBlockRequests($(this).data("user"));
//        });
//        }

        $(document).ready(function () {
        $("#blockAccept").click(function(){
        alert('Block accept clicked' + $(this).data("user"));
                ajaxCallAcceptBlockRequests($(this).data("user"));
        });
        }
        
    </script>-->
</head>

<form action = "blockRequests.php" method="POST">
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
                        or (approver2 is null or approver2 != ?))and br.userName != ?";

                $select_stmt = $mysqli->prepare($get_user_query);
                $select_stmt->bind_param('dsss', $blockId, $username, $username, $username);
                if ($select_stmt->execute()) {
                    $select_stmt->store_result();
                    $numrows = $select_stmt->num_rows;
                    $select_stmt->bind_result($uname);
                    if ($numrows == 0) {
                        ?> <h3> You have no pending requests </h3>
                        <div class = "list-group" id = "display" >
                            <?php
                        } else {
                            ?> <h3> You have following pending requests </h3>
                            <div class = "list-group" id = "display" >
                                <?php
                                // $result = mysqli_stmt_get_result($select_stmt);
                                /* fetch associative array */
                                while ($select_stmt->fetch()) {
                                    ?> <a class = "list-group-item" >
                                        <h4 class = "list-group-item-heading" > </h4>
                                        <p class = "list-group-item-text" ><?php echo $uname; ?> </p><br>
                                        <button type = "button" class = "btn btn-sm btn-primary" id = "blockAccept"> Accept</button>
                                    </a><?php
                                }
                                $select_stmt->close();
                                if (isset($_POST["blockAccept"])) {                                  
                                    $_SESSION["pendingUser"] = $uname;
                                     header("refresh: 1; acceptBlockRequests.php");
                                }
                            }
                        }
                        //echo json_encode($newNeighbors);
                        // doing this is mandatory for connection to get closed
                    } catch (PDOException $e) {
                        echo "Error!: " . $e->getMessage() . "<br/>";
                        $log->error("Error!: " . $e->getMessage() . "<br/>");
                    }
                    ?>
                </div>
            </div>
        </div>
</form>

