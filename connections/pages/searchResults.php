



<?php $searchText = isset($_GET['searchVal']) ? '%'.$_GET['searchVal'].'%' : ''; ?>

<div class="row">

    <div class="panel-body">
        <div class="dataTable_wrapper">
          

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

                        $select_query = "
                        (SELECT DISTINCT m.messageId,m.topic,m.textBody,m.messageAuthor,m.creationDate as
                        threadCreatedTime
                        FROM message m
                        inner join messagerecipient mr on m.messageId = mr.messageId AND mr.recepientUserName =? AND m.blockid =(SELECT blockId
	from blockrequests WHERE userName =?)
                        WHERE m.topic like ?
                        OR m.textBody like ?
                         )
                        UNION
                         (SELECT DISTINCT m.messageId,m.topic,m.textBody,m.messageAuthor,m.creationDate as threadCreatedTime
                        FROM message m
                        inner join messagerecipient mr on m.messageId = mr.messageId AND mr.recepientUserName =? AND m.blockid =(SELECT blockId
	from blockrequests WHERE userName =?)
                        inner join reply r on m.messageId = r.messageId
                        WHERE r.reply like ?)ORDER BY threadCreatedTime DESC ";
//echo $username,$password,$fname,$lname,$gender,$dob,$addss,$city,$state,$profilepic,$profiledesc;
//move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_path);
//echo $insert_query;
                        if ($select_stmt = $mysqli->prepare($select_query)) {
                            $select_stmt->bind_param('sssssss', $username,$username,$searchText,$searchText,$username,$username,$searchText);
                            $select_stmt->execute();
                            $select_stmt->store_result();
                            $select_stmt->bind_result($mId, $topic,$body, $author, $threadCreatedDate);
                            while ($select_stmt->fetch()) {
                                
                                  echo "  <div class=\"row\">
                    <div class=\"col-lg-12\">
                    <div class=\"panel panel-default\">
                        <div class=\"panel-heading\">
                           Posted By $author on $threadCreatedDate
                        </div>
                        <div class=\"panel-body\">
                            <p><a href=\"home.php?page=replies&mId=$mId\" >$topic</a></p>
                                <p>$body</p>
                        </div>                     
                    
                </div></div></div>";
                                
                            }
                        }


                        $select_stmt->close();
                    }
                    ?>
                
        </div>



    </div>
</div>
 <script>
    var btn = document.getElementById('textSearch');
    
   document.getElementById('txtSearch').value = "<?php echo(htmlentities($_GET['searchVal'])); ?>";
       
   
  </script>








