
<?php include("include.php") ?>
<div class="row">
    <div class="panel-body">
        <div class="dataTable_wrapper">
            <h3> Welcome back to Connections, <?php echo $_SESSION['username']; ?>! </h3>
            <br>
            <?php
            //Create query
            $username = $_SESSION['username'];
            $check_block_query = "SELECT userName,currentStatus FROM blockrequests WHERE userName= ?";
            $uname = null;
            $currentStatus = null;
            if ($stmt = $mysqli->prepare($check_block_query)) {
                $stmt->bind_param("s", $username);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    $stmt->bind_result($uname, $currentStatus);
                    echo $uname;
                    echo $currentStatus;
                    if ($currentStatus == 'Pending') {
                        echo 'Your request to join a block is still pending with us.';
                    } else {
                        ?>
            <!--/.row --> 
                        <div class = "row">
                            <div class = "col-lg-3 col-md-6">
                                <div class = "panel panel-primary">
                                    <div class = "panel-heading">
                                        <div class = "row">
                                            <div class = "col-xs-3">
                                                <i class = "fa fa-comments fa-5x"></i>
                                            </div>
                                            <div class = "col-xs-9 text-right">
                                                <div>Neighbor Requests</div>
                                                <div class="huge" id='neighborRequestCount'></div>
                                            </div>
                                        </div>
                                    </div>
                                    <a id="blockRequests">
                                        <div class = "panel-footer">
                                            <span class = "pull-left">View Details</span>
                                            <span class = "pull-right"><i class = "fa fa-arrow-circle-right"></i></span>
                                            <div class = "clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class = "col-lg-3 col-md-6">
                                <div class = "panel panel-green">
                                    <div class = "panel-heading">
                                        <div class = "row">
                                            <div class = "col-xs-3">
                                                <i class = "fa fa-tasks fa-5x"></i>
                                            </div>
                                            <div class = "col-xs-9 text-right">
                                                <div class = "huge">12</div>
                                                <div>New Tasks!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href = "#">
                                        <div class = "panel-footer">
                                            <span class = "pull-left">View Details</span>
                                            <span class = "pull-right"><i class = "fa fa-arrow-circle-right"></i></span>
                                            <div class = "clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class = "col-lg-3 col-md-6">
                                <div class = "panel panel-yellow">
                                    <div class = "panel-heading">
                                        <div class = "row">
                                            <div class = "col-xs-3">
                                                <i class = "fa fa-shopping-cart fa-5x"></i>
                                            </div>
                                            <div class = "col-xs-9 text-right">
                                                <div class = "huge">124</div>
                                                <div>New Orders!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href = "#">
                                        <div class = "panel-footer">
                                            <span class = "pull-left">View Details</span>
                                            <span class = "pull-right"><i class = "fa fa-arrow-circle-right"></i></span>
                                            <div class = "clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class = "col-lg-3 col-md-6">
                                <div class = "panel panel-red">
                                    <div class = "panel-heading">
                                        <div class = "row">
                                            <div class = "col-xs-3">
                                                <i class = "fa fa-support fa-5x"></i>
                                            </div>
                                            <div class = "col-xs-9 text-right">
                                                <div class = "huge">13</div>
                                                <div>Support Tickets!</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href = "#">
                                        <div class = "panel-footer">
                                            <span class = "pull-left">View Details</span>
                                            <span class = "pull-right"><i class = "fa fa-arrow-circle-right"></i></span>
                                            <div class = "clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                       
                        <!--/.row -->
                          <?php
                    }
                }
            }
            $stmt->close();
            ?> 
        </div>
    </div>
</div>

