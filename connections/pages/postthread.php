
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Bootstrap Core CSS -->
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <script src="../External/jquery-1.11.3.min.js"></script>
        <script src="../External/jquery-1.11.3.js"></script>
        <script src="../External/bootstrap-table.min.js"></script>
        <script src="../External/bootstrap-table.js"></script>
        <script type="text/javascript" src="../External/bootstrap-filestyle.min.js"></script>
        <link rel="stylesheet" href="../External/bootstrap-table.css">
        <link rel="stylesheet" href="../External/bootstrap-table.min.css">
        <link href="../dist/js/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
        <script src="../dist/js/facebox.js" type="text/javascript"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9M0xgelZJZNa7gNDEDCKTjZe1mRvb7Zo&callback=initMap"
        async defer></script>
        <style type="text/css">
            .maps {
                height: 200px;
                width: 400px;
                margin:1%;
                background-color: #CCC;
            }
        </style>
        <script language="javascript" type="text/javascript">
            var markers = [];
            var marker;
            var pos;
            function initMap() {
                var mapFeed = new google.maps.Map(document.getElementById('mapFeed'), {
                    center: {lat: -34.397, lng: 150.644},
                    zoom: 17
                });
                var infoWindowFeed = new google.maps.InfoWindow({map: mapFeed});

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        infoWindowFeed.setPosition(pos);
                        //infoWindowFeed.setContent('You are here: ' + pos.lat + ',' + pos.lng);
                        infoWindowFeed.setContent('You are here!');
                        updateMarkerPosition(pos, 'input[name=feedLocation]');
                        mapFeed.setCenter(pos);
                    }, function () {
                        handleLocationError(true, infoWindowFeed, mapFeed.getCenter());
                    });
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindowFeed, mapFeed.getCenter());
                }
                mapFeed.addListener('click', function (e) {
                    deleteMarkers();
                    placeMarkerAndPanTo(e.latLng, mapFeed);
                    updateMarkerPosition(marker.getPosition(), 'input[name=feedLocation]');
                });

            }

            function updateMarkerPosition(latLng, element) {
                $(element).val(latLng.lat().toString() + ',' + latLng.lng().toString());
            }
            function setMapOnAll(map) {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap(map);
                }
            }
            function clearMarkers() {
                setMapOnAll(null);
            }
            function deleteMarkers() {
                clearMarkers();
                markers = [];
            }

            function placeMarkerAndPanTo(latLng, map) {
                marker = new google.maps.Marker({
                    position: latLng,
                    map: map
                });
                map.panTo(latLng);
                markers.push(marker);
            }

            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
            }


            function getXMLHTTP() { //fuction to return the xml http object
                var xmlhttp = false;
                try {
                    xmlhttp = new XMLHttpRequest();
                }
                catch (e) {
                    try {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    catch (e) {
                        try {
                            xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                        }
                        catch (e1) {
                            xmlhttp = false;
                        }
                    }
                }

                return xmlhttp;
            }
        </script>

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

//Array to store validation errors
        $errmsg_arr = array();

//Validation error flag
        $errflag = false;

//Function to sanitize values received from the form. Prevents SQL injection
        function cleanText($str) {
            $str = @trim($str);
            if (get_magic_quotes_gpc()) {
                $str = stripslashes($str);
            }
            return $str;
        }

//Sanitize the POST values
        $topic = cleanText(isset($_POST['topic']) ? $_POST['topic'] : null);
        $textBody = cleanText(isset($_POST['textBody']) ? $_POST['textBody'] : null);
        $visibility = cleanText(isset($_POST['visibility']) ? $_POST['visibility'] : null);


        if ($topic != '') {
            $stmt = $mysqli->prepare('SET @threadId := ?');
            $stmt->bind_param('i', $threadId);
            $stmt->execute();
            if ($stmt = $mysqli->prepare("CALL insertNewThread(?,?,?,?,?,?,@threadId,?)")) {

                if (empty($_POST['feedLocation'])) {
                    $lat = 40.69347581139949;
                    $longi = -73.98621305823326;
                } else {
                    $location = $_POST['feedLocation'];
                    $myArray = explode(',', $location);
                    $lat = $myArray[0];
                    $longi = $myArray[1];
                }
                // $lat = 40.58;
                //  $longi = -76.89;
                $recepientName = '';


                $stmt->bind_param("ssisdds", $_SESSION['username'], $topic, $visibility, $textBody, $lat, $longi, $recepientName);
                // mysqli_stmt_bind_result($stmt, $threadId);
                if ($stmt->execute()) {
                    mysqli_stmt_fetch($stmt);
                    
                } else {
                    echo $mysqli->error();
                    mysqli_stmt_close($stmt);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo $mysqli->error();
                mysqli_stmt_close($stmt);
            }
            // mysqli_stmt_close($stmt);
        }
        ?>


        <div class="row">

            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">

                        <form method="POST" name="messageForm" id="messageForm"  class="form-vertical">                   
                            <div class="form-group">
                                <label for="txtTopic">Topic: </label>
                                <input type="text" class="form-control" name="topic" id="txtTopic" required>
                            </div>
                            <div class="form-group">
                                <label for="txtBody">Type your post here: </label>
                                <textarea class="form-control" name="textBody" id="txtBody" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="visibility">Visible To:</label>
                                <select name="visibility" required>
                                    <option value="">Select...</option>
                                    <option value="600">Neighbors</option>
                                    <option value="601">Friends</option>
                                    <option value="602">User</option>
                                    <option value="603">Hood</option>
                                    <option value="604">Block</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="about">Choose your location</label>
                                <input class="form-control" data-input="false" name="feedLocation"
                                       placeholder="Enter location" >
                                <!--                                            </div>-->
                            </div>
                            <div class="maps" id="mapFeed"></div>
                            <!--                                    </div>-->

                            <input type="submit" value="Post Thread" class="btn btn-primary pull-right" />
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.row (nested) -->
        </div>
        <!-- /.panel-body -->
        <!-- Button trigger modal -->



    <?php } ?> 
</html>



