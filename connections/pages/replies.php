

<?php $mId = isset($_GET['mId']) ? $_GET['mId'] : 0; ?>

<div class="row">

    <div class="panel-body">


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

                $select_query = "SELECT DISTINCT replyId,reply,replyByUser,CreationDate
                                 FROM reply
                                 WHERE messageId = ?;";
//echo $username,$password,$fname,$lname,$gender,$dob,$addss,$city,$state,$profilepic,$profiledesc;
//move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_path);
//echo $insert_query;
            if ($select_stmt = $mysqli->prepare($select_query)) {
                $select_stmt->bind_param('i', $mId);
                $select_stmt->execute();
                $select_stmt->store_result();
                $select_stmt->bind_result($replyId, $reply, $replyBy, $creationDate);
                while ($select_stmt->fetch()) {
                    echo "  <div class=\"row\">
                    <div class=\"col-lg-12\">
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                           Posted By $replyBy on $creationDate
                        </div>
                        <div class=\"panel-body\">
                            <p>$reply</p>
                        </div>
                        <div class=\"panel-footer\">
                            
                        </div>
                    
                </div></div></div>";
                }
            }


            $select_stmt->close();
        }
        ?>

    </div>



</div>









