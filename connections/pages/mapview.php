<div id="map" style="width:500px;height:380px;"></div>
<?php

//Function to sanitize values received from the form. Prevents SQL injection
function cleanText($str) {
    $str = @trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return $str;
}

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $recentLoginTime = $_SESSION["recentVisitedTime"];
//Create INSERT query

    $select_query = "SELECT northeastLat, northEastLong,southwestLat,southwestLong from block where blockId =(SELECT blockId from blockRequests where username =? )
                                        ";
//echo $username,$password,$fname,$lname,$gender,$dob,$addss,$city,$state,$profilepic,$profiledesc;
//move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_path);
//echo $insert_query;
    if ($select_stmt = $mysqli->prepare($select_query)) {
        $select_stmt->bind_param('s', $username);
        $select_stmt->execute();
        $select_stmt->store_result();
        $select_stmt->bind_result($nelat, $nelongi, $swlat, $swlongi);
        while ($select_stmt->fetch()) {
           
        }
    }


    $select_stmt->close();

    $select1_query = "SELECT user.username,latitude, longitude from user natural join blockrequests where blockId =(SELECT blockId from blockRequests where username =? )
                                        ";
//echo $username,$password,$fname,$lname,$gender,$dob,$addss,$city,$state,$profilepic,$profiledesc;
//move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_path);
//echo $insert_query;
    if ($select1_stmt = $mysqli->prepare($select1_query)) {
        $select1_stmt->bind_param('s', $username);
        $select1_stmt->execute();
        $select1_stmt->store_result();
        $select1_stmt->bind_result($blockUserName,$lat, $long);
        $userPositions = array();
        $rowCount = 0;
        while ($select1_stmt->fetch()) {
            
     
            $userPositions[$rowCount] = array();
           
                //$userPositions[$rowCount][$col] = array();
                array_push($userPositions[$rowCount], $blockUserName);
                array_push($userPositions[$rowCount], $lat);
                array_push($userPositions[$rowCount], $long);
                array_push($userPositions, $userPositions[$rowCount])  ;
           
        $rowcount=$rowCount+1;
            //array_push($userPositions, $lat, $long);
        }
    }


    $select1_stmt->close();
}
?>
<script>



    var myLatLng = {lat: 40.691056, lng: -73.989178};
    function initMap() {
        // var myLatLng = {lat: -25.363, lng: 131.044};

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: myLatLng
        });
        
        <?php echo "var markers=[];";
         for ($row=0;$row<sizeof($userPositions);$row++) {           
            
                echo "markers.push(['".$userPositions[$row][0]."',".$userPositions[$row][1].",".$userPositions[$row][2]."]);";
                
                
            
        }
        
        echo " // Display multiple markers on a map
        var infoWindow = new google.maps.InfoWindow(), marker, i;

        // Loop through our array of markers & place each one on the map
        {
            for (i = 0; i < markers.length; i++) {           
            
                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                // bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: markers[i][0]
                });

            }
            // METROTECH HOOD FIT BOUNDS FOR HOOD BOUNDARY
            var southWest = new google.maps.LatLng(".$swlat.",".$swlongi.");
            var northEast = new google.maps.LatLng(".$nelat.",".$nelongi.");
            var bounds = new google.maps.LatLngBounds(southWest, northEast);
            map.fitBounds(bounds);

           // flightPath.setMap(map);

        }
"
        ?>



//        var markers = [
//            ['pat', 40.6940596, -73.9865231],
//            ['priya', 40.69458330745518, -73.98688336852501],
//            ['shweta1', 40.694578, -73.986578], ['donald', 40.694381129427335, -73.98683350536885],
//            ['gugha', 40.69464956969747, -73.98681204802415],
//            ['kay', 40.694413667759704, -73.9863721657457]
//
//
//        ];

       




    }

    //will load map upon page downloading
    function loadScript() {
        var script = document.createElement("script");
        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyAvGdG32LF6a8sIQl3tvYl95r8fEOiL4R4&callback=initMap";
        document.body.appendChild(script);
    }

    window.onload = loadScript;

    //        GOOGLE MAP API KEY sAIzaSyAvGdG32LF6a8sIQl3tvYl95r8fEOiL4R4
</script>
<!--<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvGdG32LF6a8sIQl3tvYl95r8fEOiL4R4&callback=initMap">
</script>-->