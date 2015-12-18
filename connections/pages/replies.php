

<?php $mId = isset($_GET['mId']) ? $_GET['mId'] : 0; ?>
<?php 
if (!empty($_POST['btnReplyPost'])) {


if( isset($_POST["replyMessage"])){
    $replyMessage = cleanText($_POST['replyMessage']);
    $stmt = $mysqli->prepare('SET @newReplyId := ?');
    $stmt->bind_param('i', $newReplyId);
    $stmt->execute();
    if ($stmt = $mysqli->prepare("CALL insertReply(?,?,?,?,@newReplyId)")) {     
        $replyForReplyId = null;

        $stmt->bind_param("ssii", $_SESSION['username'], $replyMessage, $mId, $replyForReplyId);
        // mysqli_stmt_bind_result($stmt, $threadId);
        if ($stmt->execute()) {
            mysqli_stmt_fetch($stmt);
          
        } else {
            echo $mysqli->error();
        }
        
    } else {
        echo $mysqli->error();
    }
    mysqli_stmt_close($stmt);
}else{
    echo 'Its empty';
}
}
?>

<div class="row">

    <div class="panel-body">
          <form method="POST" name="replyForm" id="replyForm" class="form-vertical"> 
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Type your reply here
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="reply">Your Reply</label>
                            <textarea name="replyMessage" class="form-control" id="replyMessage" required>
                            </textarea>
                        </div>
                         <input type="submit" value="Post" name="btnReplyPost" class="btn btn-primary pull-right" />
                    </div>                     
  
                </div></div></div>
          </form>

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
                                 WHERE messageId = ? ORDER BY CreationDate DESC;";
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
                    
                </div></div></div>";
                }
            }


            $select_stmt->close();
        }
        ?>

    </div>



</div>









