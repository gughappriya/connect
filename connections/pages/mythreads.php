<?php
include("include.php");
$username = $_SESSION['username'];
$check_pending_user = "select count(*) from blockrequests br where br.userName= ?";
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
                <table class="table table-striped table-bordered table-hover" id="threadsTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Topic</th>
                            <th>Created Date</th>
                            <th>Author Name</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>

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

                            $select_query = "SELECT DISTINCT m.messageId,m.topic,m.messageAuthor,m.creationDate
                                        FROM message m WHERE m.messageAuthor = ?
                                        ORDER BY creationdate DESC
                                        ";
//echo $username,$password,$fname,$lname,$gender,$dob,$addss,$city,$state,$profilepic,$profiledesc;
//move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_path);
//echo $insert_query;
                            if ($select_stmt = $mysqli->prepare($select_query)) {
                                $select_stmt->bind_param('s', $username);
                                $select_stmt->execute();
                                $select_stmt->store_result();
                                $select_stmt->bind_result($mId, $topic, $author, $threadCreatedDate);
                                while ($select_stmt->fetch()) {
                                    echo "<tr class=\"odd gradeX\">
                                           <td>$mId<td><a href=\"home.php?page=replies&mId=$mId\" >$topic</a></td>
                                            <td>$threadCreatedDate</td><td>$author</td><td></td></tr>";
                                }
                            }


                            $select_stmt->close();
                        }
                        ?>
                    </tbody>
                </table>
            </div>



        </div>
    </div>

<?php } ?>






