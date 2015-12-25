



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

                        $select_query = "SELECT DISTINCT B.messageId,B.topic,B.messageAuthor,B.creationDate as threadCreationDate
                                         FROM
((SELECT DISTINCT m.messageId,m.topic,m.messageAuthor,m.creationDate as sortDate,m.creationDate,null as replyId,null as
                                        replyMessage,CONCAT('Your neighbor ',N.neighborUserName,' has posted a thread') as Note
                                        FROM message m
                                        inner join messagerecipient mr on m.messageId = mr.messageId AND mr.recepientUserName = ? AND m.blockid =(SELECT blockId
	from blockrequests WHERE userName =?)
                                        INNER JOIN neighbor N On N.memberName =  ? AND N.neighborUserName = m.messageAuthor)
                               UNION     (SELECT DISTINCT m.messageId,m.topic,m.messageAuthor,r.creationDate as sortDate,m.creationDate,r.replyId,r.reply as
                                        replyMessage,CONCAT('Your neighbor ',N.neighborUserName,' has replied for this thread') as Note
                                        FROM message m 
                                        inner join messagerecipient mr on m.messageId = mr.messageId AND mr.recepientUserName = ?  AND m.blockid =(SELECT blockId
	from blockrequests WHERE userName =?)                                      
                                        inner join reply r on r.messageId = m.messageId 
                                        INNER JOIN neighbor N On N.memberName =  ? AND N.neighborUserName = r.replyByUser)   
                                        order by sortDate desc) B
                                        ";
//echo $username,$password,$fname,$lname,$gender,$dob,$addss,$city,$state,$profilepic,$profiledesc;
//move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_path);
//echo $insert_query;
                        if ($select_stmt = $mysqli->prepare($select_query)) {
                            $select_stmt->bind_param('ssssss', $username, $username, $username, $username,$username,$username);
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








