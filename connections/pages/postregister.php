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
//$password = cleanText($_POST['password']);
$password = md5($_POST['password']);
$confPassword = md5($_POST['confPassword']);
$fname = cleanText($_POST['fname']);
$lname = cleanText($_POST['lname']);
$gender = cleanText($_POST['sex']);
$dob = cleanText($_POST['dob']);
$address = cleanText($_POST['address']);
$city = cleanText($_POST['city']);
$state = cleanText($_POST['state']);
$profilepic = $_POST['username'];
$profiledesc = cleanText($_POST['profiledesc']);
//$notificationtype = cleanText($_POST['notificationType']);
//$notificationvalue = cleanText($_POST['notificationvalue']);
//set the upload path for the image file
$target_path = $_SERVER['DOCUMENT_ROOT'] . "../images/user_images/" . basename($_POST["username"]) . ".jpg";

if (strcmp($password, $confPassword) != 0) {
    $errmsg_arr[] = 'Passwords do not match';
    $errflag = true;
}

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
$dob = strtotime($dob);
$insert_query = "INSERT INTO " .
        "user (username," .
        "password," .
        "firstName," .
        "lastName," .
        "gender," .
        "birthdate," .
        "address," .
        "city," .
        "stateId," .
        "profilePic," .
        "profileDescription," .
        "recentvisitedTime) " .
        "VALUES" .
        "(?,?,?,?,?,FROM_UNIXTIME(?),?,?,?,?,?,now())";
//echo $username,$password,$fname,$lname,$gender,$dob,$address,$city,$state,$profilepic,$profiledesc;
//move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_path);
//echo $insert_query;
if ($insert_stmt = $mysqli->prepare($insert_query)) {
    $insert_stmt->bind_param('sssssississ', $username, $password, $fname, $lname, $gender, $dob, $address, $city, $state, $profilepic, $profiledesc);
    if ($insert_stmt->execute()) {
        echo "<div class='isa_info'>Successfully registered! </div>";
        header("location: home.php?page=dashboard");
    }
    else {
        echo "Query failed";
    }
    $insert_stmt->close();
}
?>