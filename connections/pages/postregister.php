<?php include('include.php') ?>
<?php

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
$username = cleanText($_POST['username']);
$password = md5($_POST['password']);
$fname = cleanText($_POST['fname']);
$lname = cleanText($_POST['lname']);
$gender = cleanText($_POST['sex']);
$address = cleanText($_POST['address']);


//$profilepic = addslashes($_FILES['fileImage']['tmp_name']);
//$profilepic = file_get_contents($profilepic);
//$profilepic = base64_encode($profilepic);


$profilepic = $_POST['username'];
$profiledesc = cleanText($_POST['profiledesc']);
$location = $_POST['feedLocation'];
$myArray = explode(',', $location);
$latitude = $myArray[0];
$longitude = $myArray[1];

//$notificationtype = cleanText($_POST['notificationType']);
//$notificationvalue = cleanText($_POST['notificationvalue']);
//set the upload path for the image file
$target_path = $_SERVER['DOCUMENT_ROOT'] . "../images/user_images/" . basename($_POST["username"]) . ".jpg";
//echo $target_path;
//Check for duplicate login ID
if ($username != '') {
    $qry = "SELECT * FROM user WHERE UserName= ?";
    $stmt = $mysqli->prepare($qry);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $num_rows = 0;
    while ($stmt->fetch()) {
        $num_rows = $num_rows + 1;
    }
    if ($num_rows > 0) {
        $errmsg_arr[] = 'UserName already in use';
        $errflag = true;
    }
}
//If there are input validations, redirect back to the registration form
echo $errflag;
if ($errflag) {
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
    session_write_close();
    header("location: register.php");
    exit();
}
//Create INSERT query
$insert_query = "INSERT INTO " .
        "user (username," .
        "password," .
        "firstName," .
        "lastName," .
        "gender," .
        "address," .
        "profilePic," .
        "profileDescription," .
        "recentvisitedTime) " .
        "VALUES" .
        "(?,?,?,?,?,?,?,?,now())";

move_uploaded_file($_FILES['fileImage']['tmp_name'], $target_path);
if ($insert_stmt = $mysqli->prepare($insert_query)) {
    $insert_stmt->bind_param('ssssssss', $username, $password, $fname, $lname, $gender, $address, $profilepic, $profiledesc);
    if ($insert_stmt->execute()) {
        echo "<div class='isa_info'>Successfully registered! </div>";
        $_SESSION['username'] = $username;
        $_SESSION['firstname'] = $fname;
        if ($insert_blockrequest = $mysqli->prepare("CALL insert_block_request(?,?,?)")) {
            $insert_blockrequest->bind_param("sdd", $_SESSION['username'], $latitude,$longitude);
            if ($insert_blockrequest->execute()) {
                mysqli_stmt_fetch($insert_blockrequest);
            } else {
                echo $mysqli->error();
            }
            $insert_blockrequest ->close();
        } else {
            echo $mysqli->error();
        }
        // 40.72956780913899,-74.05866622924805;
        header("location: home.php?page=dashboard");
    } else {
        echo "Query failed";
    }
    $insert_stmt->close();
} else {
    echo 'Please check your input again';
}
?>