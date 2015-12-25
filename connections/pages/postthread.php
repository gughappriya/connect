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
            $lat = 40.58;
            $longi = -76.89;
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



