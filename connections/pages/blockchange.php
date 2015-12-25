 <?php
 function cleanText($str) {
    $str = @trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return $str;
}
 $locFromMap = cleanText(isset($_POST['feedLocation']) ? $_POST['feedLocation'] : null);
 if($locFromMap != ''){
    $location = $_POST['feedLocation'];
    $myArray = explode(',', $location);
    $latitude = $myArray[0];
    $longitude = $myArray[1];
    //$_SESSION['username'] = $username;
    
    if ($change_blockrequest = $mysqli->prepare("CALL change_block_request(?,?,?)")) {
        $change_blockrequest->bind_param("sdd", $_SESSION['username'], $latitude,$longitude);
        if ($change_blockrequest->execute()) {
            mysqli_stmt_fetch($change_blockrequest);
        } else {
            echo $mysqli->error();
        }
        $change_blockrequest ->close();
    } else {
        echo $mysqli->error();
    }

 }
 ?>
 <form method="POST" name="blockChangeForm" id="blockChangeForm"  class="form-vertical"> 
     <style type="text/css">
            .maps {
                height: 200px;
                width: 400px;
                margin:1%;
                background-color: #CCC;
            }
        </style>
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9M0xgelZJZNa7gNDEDCKTjZe1mRvb7Zo&callback=initMap"
        async defer></script>
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
    <div class="form-group">
        <label for="about">Choose your location</label>
        <input class="form-control" data-input="false" name="feedLocation"
               placeholder="Enter location" required>
        <!--                                            </div>-->
    </div>
    <div class="maps" id="mapFeed"></div>
    <!--                                    </div>-->
   <input type="submit" value="Save" class="btn btn-primary pull-right" />
</form>

