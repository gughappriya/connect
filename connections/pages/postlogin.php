<?php include("include.php") ?>
<?php

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    $str = @trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return $str;
}

if (isset($_POST['username']) && isset($_POST['password'])) {

    //Sanitize the POST values
    $username = clean($_POST["username"]);
    $password = (md5($_POST["password"]));
}

//Create query
$check_user_query = "SELECT firstname,lastname,recentvisitedTime FROM user WHERE UserName=? AND Password=?";
$numrows = 0;
if ($stmt = $mysqli->prepare($check_user_query)) {
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();
    $numrows = $stmt->num_rows;
    if ($numrows == 1) {
        $stmt->bind_result($fname, $lname, $recentVisitedTime);
        $_SESSION['username'] = $username;
        $_SESSION['firstname'] = $fname;
        $_SESSION['recentVisitedTime']=$recentVisitedTime;
        header("location: home.php?page=dashboard");
        //TODO: Update user's recent visited time to current date time
        mysqli_stmt_close($stmt);
        exit();
    } else {
        //Login failed
        //header("location: errorlogin.php");
        //TODO: Should be replaced with error page 
        echo $mysqli->error();
        echo 'Error';
    }
    mysqli_stmt_close($stmt);
    exit();
}
?>
