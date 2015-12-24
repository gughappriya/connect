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
echo $password;
$fname = cleanText($_POST['fname']);
$lname = cleanText($_POST['lname']);
$gender = cleanText($_POST['sex']);
$address = cleanText($_POST['address']);


$profilepic = addslashes($_FILES['fileImage']['tmp_name']);
$profilepic = file_get_contents($profilepic);
$profilepic = base64_encode($profilepic);


//$profilepic = $_POST['username'];
$profiledesc = cleanText($_POST['profiledesc']);
//$notificationtype = cleanText($_POST['notificationType']);
//$notificationvalue = cleanText($_POST['notificationvalue']);
//set the upload path for the image file
//$target_path = $_SERVER['DOCUMENT_ROOT'] . "Connect/connections/images/user_images/" . basename($_FILES['file']['name']);
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
//echo $username,$password,$fname,$lname,$gender,$dob,$address,$city,$state,$profilepic,$profiledesc;
//echo $target_path;
//if (move_uploaded_file($_FILES['userfile']['tmp_name'], $target_path)) {
//    echo "File is valid, and was successfully uploaded.\n";
//} else {
//    echo "Possible file upload attack!\n";
//}
//
//echo 'Here is some more debugging info:';
//print_r($_FILES);

echo $profilepic;
if ($insert_stmt = $mysqli->prepare($insert_query)) {
    $insert_stmt->bind_param('ssssssss', $username, $password, $fname, $lname, $gender, $address, $profilepic, $profiledesc);
    if ($insert_stmt->execute()) {
        echo "<div class='isa_info'>Successfully registered! </div>";
        $_SESSION['username'] = $username;
        $_SESSION['firstname'] = $fname;
        header("location: home.php?page=dashboard");
    } else {
        echo "Query failed";
    }
    $insert_stmt->close();
} else {
    echo 'Please check your input again';
}
?>