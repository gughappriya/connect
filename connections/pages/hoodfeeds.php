



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

                        $select_query = "SELECT DISTINCT B.messageId,B.topic,B.messageAuthor,B.threadCreatedTime as
	threadCreatedTime FROM
((SELECT 
	DISTINCT m.messageId,m.topic,m.messageAuthor,br.blockId,m.creationDate as
	threadCreatedTime ,m.creationDate as sortDate ,CONCAT('Your block member ',br.userName,' has posted a thread') as Note
	FROM message m
	inner join blockrequests br ON br.userName = m.messageAuthor AND br.userName<>? AND br.currentStatus='Approved' AND m.blockid =(SELECT blockId
	from blockrequests WHERE userName =?)
    inner join block bl ON bl.blockId = br.blockId AND  bl.hoodId = (SELECT hoodId
	from blockrequests inner join block ON block.blockId=blockrequests.blockId WHERE userName =?) 
	inner JOIN messagerecipient mr ON mr.messageId = m.messageId AND mr.recepientUserName =	?)
    UNION(SELECT 
	DISTINCT m.messageId,m.topic,m.messageAuthor,br.blockId,m.creationDate as
	threadCreatedTime,r.creationDate as sortDate  ,CONCAT('Your block member ',br.userName,' has replied for this thread') as Note
	FROM message m inner join reply r on m.messageId = r.messageId AND m.blockid =(SELECT blockId
	from blockrequests WHERE userName =?)
	inner join blockrequests br ON br.userName = m.messageAuthor AND br.currentStatus='Approved'
    inner join block bl ON bl.blockId = br.blockId AND  bl.hoodId = (SELECT hoodId
	from blockrequests inner join block ON block.blockId=blockrequests.blockId WHERE userName =?) 
	inner JOIN messagerecipient mr ON mr.messageId = m.messageId AND mr.recepientUserName =	?)
    ORDER BY sortDate DESC)B  ;";
//echo $username,$password,$fname,$lname,$gender,$dob,$addss,$city,$state,$profilepic,$profiledesc;
//move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_path);
//echo $insert_query;
                        if ($select_stmt = $mysqli->prepare($select_query)) {
                            $select_stmt->bind_param('sssssss', $username, $username,$username, $username,$username, $username,$username);
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








