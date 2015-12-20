  <script language="javascript" type="text/javascript">
    	function getNewNeighbourCount(){
    		var xhttp = new XMLHttpRequest();
    		  xhttp.onreadystatechange = function() {
    		    if (xhttp.readyState == 4 && xhttp.status == 200) {
    		     document.getElementById("neighborRequestCount").innerHTML = xhttp.responseText;
    		    }
    		  };
    		  xhttp.open("GET", "countBlockRequests.php", true);
    		  xhttp.send();

    		  getFriendRequestCount();
    	}
      function ajaxCallBlockRequests() {
        $.ajax({
              url: "getBlockRequests.php",
              cache: false,
              type: "GET",
              crossDomain: true,
              success: function(data) {
                    alert(JSON.parse(data));
                    response = JSON.parse(data);
                    var arrayLength = response.length;
                    for (var i = 0; i < arrayLength; i++) {
                        alert(response[i]);
                        //Do something
                        $('#modalBlockRequests .modal-body #displayBlockRequests tbody').append('<tr id="user'+(i)+'"></tr>');
                        //div = '<div class="form-group"><div class="col-md-9"><label for="userName" class="col-md-3 control-label">UserName</label></div></div><button type="button" class="btn btn-warning"  id="cancel">Cancel</button><button type="button" class="btn btn-primary" id="accept">Accept</button>'
                        $('#user'+i).append('<td><div class="form-group"><div class="col-md-9"><label for="userName" class="col-md-3 control-label">'+response[i]+'</label></div></div></td>');
                        $('#user'+i).append('</td><button data-user="'+response[i]+'" type="button" class="btn btn-primary" id="blockAccept">Accept</button>');

                        $('#user'+i).append('<td><button data-user="'+response[i]+'" type="button" class="btn btn-warning"  id="blockDecline">Cancel</button></td>');
                    }
                    //$("#modalBlockRequests .modal-body #table").val( feedId );

                    $('#modalBlockRequests').modal('show');


                },
                error: function(xhr) {
                    alert(JSON.stringify(xhr));
                }
          });
        }
        function ajaxCallAcceptBlockRequests(user) {
          $.ajax({
                url: "acceptBlockRequest.php",
                cache: false,
                type: "POST",
                crossDomain: true,
                data: {
                  "requestingUserName": encodeURIComponent(user),
                },
                success: function(data) {
                      alert(JSON.parse(data));
                  },
                  error: function(xhr) {
                      alert(JSON.stringify(xhr));
                  }
            });
          }
          	function getNewNeighbourCount(){
    		var xhttp = new XMLHttpRequest();
    		  xhttp.onreadystatechange = function() {
    		    if (xhttp.readyState == 4 && xhttp.status == 200) {
    		     document.getElementById("neighborRequestCount").innerHTML = xhttp.responseText;
    		    }
    		  };
    		  xhttp.open("GET", "countNewNeighbourRequest.php", true);
    		  xhttp.send();

    		  //getFriendRequestCount();
    	}
      $(document).ready(function() {
        $("a#blockRequests").click(function(event){
          alert('Neighbor requests');
          ajaxCallBlockRequests();
        });
        $('body').on('click','#blockAccept', function(event){
          alert('Block accept clicked'+$(this).data("user"));
          ajaxCallAcceptBlockRequests($(this).data("user"));
        });
 
      });

    </script> 
<div class="row">
    <div class="panel-body">
        <div class="dataTable_wrapper">
            <h3> Welcome back to Connections, <?php echo $_SESSION['username']; ?>! </h3>
            <br>
            <?php
            //Create query
           include ("include.php");
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
                        ?><!--/.row --> 
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
                                    <a href = "#">
                                        <div class = "panel-footer">
                                            <span class = "pull-left">View Details</span>
                                            <span class = "pull-right"><i class = "fa fa-arrow-circle-right"></i></span>
                                            <div class = "clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
<!--                            <div class = "col-lg-3 col-md-6">
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
                            </div>-->
                       
                        <!--/.row --><?php
                    }
                }
            }
            $stmt->close();
            ?>
        </div>
    </div>
</div>
