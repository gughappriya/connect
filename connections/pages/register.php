<!DOCTYPE html>
<?php
if (session_id() == '') {
    session_start();
}
if ($_SESSION['username'] != '') {
    header("refresh: home.php");
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Signup</title>
        <!-- Bootstrap Core CSS -->
        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    </head>
    <body>

        <div class="container">
            <!--<div id="page-wrapper">-->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User Registration</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Please enter details
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form method="POST" name="regForm" id="regForm" action="postregister.php" class="form-vertical"> 
                                    <div class="col-lg-6">

                                        <div class="form-group">
                                            <label for="fname">First Name</label>
                                            <input type="text" class="form-control" name="fname" id="fn" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="ln">Last Name</label>
                                            <input type="text" class="form-control" name="lname" id="ln" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" name="username" id="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="confPassword">Confirm Password</label>
                                            <input type="password" class="form-control" name="confPassword" id="confPassword" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender</label>                         
                                            <input type="radio"  name="sex"  value="male" checked>Male                       
                                            <input type="radio" name="sex" value="female">Female
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="dob">Date of birth</label>
                                            <input type="text" name="dob" class="form-control" id="dob" placeholder="MM/DD/YYYY" required>

                                        </div>
                                        <div class="form-group">
                                            <label for="pic">Profile Picture</label>
                                            <input type="file" class="form-control" name="profilepic" id="file">
                                        </div>

                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea name="address" class="form-control" id="addr" required></textarea>
                                           
                                        </div>
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" name="city" class="form-control" id="city">
                                        </div>
                                        <div class="form-group">
                                            <label for="mob">State</label>                                                        
                                            <select name="state" class="form-control"  id="mob" required>
                                                <option value="">Select...</option>
                                                <option value="200">New Jersey</option>
                                                <option value="201">New York</option>                                             

                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="about">Tell us something about yourself</label>
                                            <textarea class="form-control" name="profiledesc" id="about"></textarea>
                                        </div>
                                        <input type="submit" value="Register" class="btn btn-primary pull-right" />
                                    </div>
                                </form>

                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!--        </div>-->
            <!-- /#page-wrapper -->

        </div>





    </body>
</html>