



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
                        <th>Count</th>
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

                        $select_query = "SELECT DISTINCT m.messageId,m.topic,m.messageAuthor,br.blockId,visibilityId,m.creationDate as
	threadCreatedTime,r.creationDate as MessageCreationTime,@lastLoginTime as
	LastLoginTimeOfCurrentUser
	FROM message m
	inner join blockrequests br ON br.userName = m.messageAuthor AND br.blockid = (SELECT blockId
	from blockrequests WHERE userName =?) AND br.currentStatus='APPROVED'
	inner JOIN messagerecipient mr ON mr.messageId = m.messageId AND mr.recepientUserName =	?
	LEFT join reply r on m.messageId = r.messageId
	AND TIMESTAMPDIFF(SECOND, m.creationDate, ?) <=0
	OR TIMESTAMPDIFF(SECOND, r.creationDate, ?) <=0 ;";
//echo $username,$password,$fname,$lname,$gender,$dob,$addss,$city,$state,$profilepic,$profiledesc;
//move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_path);
//echo $insert_query;
                        if ($select_stmt = $mysqli->prepare($select_query)) {
                            $select_stmt->bind_param('ssss', $username, $username, $recentLoginTime, $recentLoginTime);
                            $select_stmt->execute();
                            $select_stmt->store_result();
                            $select_stmt->bind_result($mId, $topic, $author, $blockId, $visibilityId, $threadCreatedDate, $replyCreatedDate, $lastLoginTimeOfUser);
                            while ($select_stmt->fetch()) {
                                echo "<tr class=\"odd gradeX\">
                                           <td>$mId<td><a href=\"home.php?page=replies&mId=$mId\" >$topic</a></td>
                                            <td>$threadCreatedDate</td><td>$author</td><td>1</td></tr>";
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








