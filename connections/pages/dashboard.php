

<head>
    <style>
        #circle
        {
            border-radius:50% 50% 50% 50%;  
            width:100px;
            height:100px;
        }
    </style>
</head>
<?php
include("include.php");
$username = $_SESSION['username'];
$check_pending_user = "select count(*) from blockrequests br where br.userName= ? and currentStatus = 'Pending'";
$stmt = $mysqli->prepare($check_pending_user);
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();
$numrows = $stmt->num_rows;
$stmt->bind_result($count);
while ($stmt->fetch()) {
    $numrows = $numrows + 1;
}
if ($count == 1) {
    ?><h4> Welcome to Connections, <?php echo $_SESSION['username']; ?>! </h4>
    <br>
    <h5> Your block request is still pending! </h5>      <?php
} else {
    ?>

    <div class="row">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <h4> Welcome to Connections, <?php echo $_SESSION['username']; ?>! </h4>
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
                            <!--      <div class="row">-->

                            <!--    </div>-->

                            <div class = "row">

                                <div class = "col-lg-3 col-md-6">
                                    <div >
                                        <?php echo "<img src=../images/user_images/" . $username . ".jpg id='circle'  height='40' width='40'>" ?></div>
                                    </div>
                                    <!--                        <div class = "panel panel-primary">
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
                                                               </div>-->
                                    <!--                           </div>
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
                                                              </div>-->
                                    <!--                            <div class = "col-lg-3 col-md-6">
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
                                                                </div>-->
                                    <!--                            <div class = "col-lg-3 col-md-6">
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
                                                                </div>-->

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
        </div>
    <?php } ?>

