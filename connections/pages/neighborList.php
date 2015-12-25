<head>
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

<!-- /.row -->
<div class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a id="friends">My Neighbors</a>
                </li>
                <li><a style="padding-top: 4px;padding-bottom: 4px;margin-top: 10px;" data-toggle="modal" data-placement="right" title="Follow a neighbor" class="btn btn-default" id="addFriend" data-target ="#modalAddFriend"><span class="glyphicon glyphicon-plus" ></span></a>
                </li>
            </ul>

        </div>
        <!--/.nav-collapse -->
    </div>
</div>
<div class = "list-group" id = "display" >
    <?php
    try {
        $username = $_SESSION['username'];
        $stmt = $mysqli->prepare("CALL get_neighbor_list(?)");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($neighbor);

        while ($stmt->fetch()) {
            ?>
            <a class = "list-group-item" >
                <h4 class = "list-group-item-heading" > </h4>
                <p class = "list-group-item-text" ><?php echo $neighbor; ?> </p><br>
            </a><?php
        }
        $stmt->close();
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>";
    }
    ?>  
</div>
<div id="display">
    <table id="displayTable"  class="col-md-2"></table>
</div>

<div class="modal fade" id="modalAddFriend" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <b>Add friend</b>
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form class="form-horizontal" action = "home.php?page=neighborList" method="POST" role="form">

                    <div class="form-group">
                        <div class="col-md-9">
                            <?php
                            try {
                                $stmt = $mysqli->prepare("CALL get_neighbor_search(?)");
                                $stmt->bind_param('s', $username);
                                $stmt->execute();
                                $stmt->bind_result($newneighbor);
                                while ($stmt->fetch()) {
                                    ?>
                                    <a class = "list-group-item" >
                                        <h4 class = "list-group-item-heading" > </h4>
                                        <p class = "list-group-item-text" ><?php echo $newneighbor; ?> </p><br>
                                        <button type = "submit" name = "addfriend" class = "btn btn-sm btn-primary" id = "addfriend" value='<?php $newneighbor ?>'> Follow</button>
                                    </a><?php
                                }
                                $stmt->close();
                                 if (isset($_POST["addfriend"])) {
                                    //$_SESSION["pendingUser"] = $uname;
                                    if ($requeststmt = $mysqli->prepare("CALL follow_neighbor(?,?)")) {
                                        $requeststmt->bind_param("ss", $username, $newneighbor);
                                        if ($requeststmt->execute()) {
                                            mysqli_stmt_fetch($requeststmt);
                                        } else {
                                            echo $mysqli->error();
                                        }
                                    } else {
                                        echo $mysqli->error();
                                    }
                                    $requeststmt->close();
                                   // header("refresh: 1; home.php?page=blockRequests");
                                }
                                
                                
                            } catch (PDOException $e) {
                                echo "Error!: " . $e->getMessage() . "<br/>";
                            }
                            ?>  
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



