<!DOCTYPE html>
<?php
if (session_id() == '') {
    session_start();
}
if ($_SESSION['username'] != '') {
    header("refresh: home.php");
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Signup</title>
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
                width: 350px;
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
                    zoom: 10
                });
                var infoWindowFeed = new google.maps.InfoWindow({map: mapFeed});

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        infoWindowFeed.setPosition(pos);
                        infoWindowFeed.setContent('You are here: '+ pos.lat+','+ pos.lng);
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
        <style>
 #photoDiv div {
  display: inline;

  width: 30%;
}
</style>
    </head>
    <body>

        <div class="container">
            <!--<div id="page-wrapper">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User Registration</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Please enter details
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form method="POST" name="regForm" id="regForm" action="postregister.php" enctype='multipart/form-data' class="form-vertical"> 
                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="fname">First Name</label>
                                            <input type="text" class="form-control" name="fname" id="fn" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="ln">Last Name</label>
                                            <input type="text" class="form-control" name="lname" id="ln" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" name="username" id="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender</label>                         
                                            <input type="radio"  name="sex"  value="male" checked>Male                       
                                            <input type="radio" name="sex" value="female">Female
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="pic">Profile Picture</label>
                                        
                                        <div  class="col-md-9" id="photoDiv" >
							<div class="col-md-9" align="left">
                                                            <input type="file" class="filestyle" data-input="false" name="fileImage" id="image_upload" required="">
<!-- 								<input name="userfile" type="file" id="userfile"> " -->
							</div>
							</div>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea name="address" class="form-control" id="addr" required></textarea>

                                    </div>
                                    <div class="form-group">
                                        <label for="about">Tell us something about yourself</label>
                                        <textarea class="form-control" name="profiledesc" id="about"></textarea>
                                    </div>
<!--                                    <div class="col-md-9">-->
                                        <div class="form-group">
                                               <label for="about">Your location</label>
                                                <input type='hidden' class="form-control" name="feedLocation"
                                                       placeholder="Enter location">
<!--                                            </div>-->
                                        </div>
                                        <div class="maps" id="mapFeed"></div>
<!--                                    </div>-->
                                    <input type="submit" value="Register" class="btn btn-primary pull-right" />
                                    </div>
                                </form>

                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!--        </div>-->
            <!-- /#page-wrapper -->

        </div>
    </body>
</html>