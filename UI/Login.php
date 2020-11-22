<?php
session_start();
require 'header.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Page</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    </head>
    <style>
        .center{
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .box{
            width:400;
        }
        .container{
            margin-top:3%;
        }
        .submitBut, .resetBut{
            width:30%;
        }
        .submitBut{
            margin-right: 1%;
        }
        .resetBut{
            margin-left: 1%;
        }
        h1{
            text-align: center;
        }
    </style>
    <body>
        <?php
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == 'staff') {
                ?>
                <div class="container box">
                    <div class="container card">
                        <div class="card-body">
                            <img src='../image/tarcBeyondEducation.png' width="243" height="127" class="center"><br>
                            <h1 class="card-title"><b>Staff Login</b></h1>
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                                unset($_SESSION['error']);
                            }
                            ?>
                            <form method="post" action="../Domain/validateLogin.php">
                                <div class="form-group">
                                    <label for="adminid" class="col-form-label">Admin ID:</label>
                                    <input class="form-control" type="text" placeholder="Enter admin id" name="adminid" autofocus=""/>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-form-label">Password:</label>
                                    <input class="form-control" type="password" placeholder="Enter your password" name ="adminpass"/>
                                </div>
                                <div class="row justify-content-center">
                                    <input class="submitBut btn btn-success" type="submit" name="staffSubmit" value="Login"/>
                                    <input class="resetBut btn btn-danger" type="reset" name="reset" value="Cancel"/>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <?php
            } else if ($_SESSION['role'] == 'society') {
                ?>
                <div class="container box">
                    <div class="container card">
                        <div class="card-body">
                            <img src='../image/tarcBeyondEducation.png' width="243" height="127" class="center"><br>
                            <h1 class="card-title"><b>Society Login</b></h1>
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                                unset($_SESSION['error']);
                            }
                            ?>
                            <form method="post" action="../Domain/validateLogin.php">
                                <div class="form-group">
                                    <label for="societyid" class="col-form-label">Society ID: </label>
                                    <input class="form-control" type="text" placeholder="Enter society id (number only)" name="societyid" autofocus="" />
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-form-label">Password: </label>
                                    <input class="form-control" type="password" placeholder="Enter your password" name ="societypass"/>
                                </div>
                                <div class="row justify-content-center">
                                    <input type="submit" name="societySubmit" value="Login" class="submitBut btn btn-success"/> 
                                    <input type="reset" name="reset" value="Cancel" class="resetBut btn btn-danger"/>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <?php
            } else if ($_SESSION['role'] == 'student') {
                ?>
                <div class="container box">
                    <div class="container card">
                        <div class="card-body">
                            <img src='../image/tarcBeyondEducation.png' width="243" height="127" class="center"><br>
                            <h1 class="card-title"><b>Student Login</b></h1>
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                                unset($_SESSION['error']);
                            }
                            ?>
                            <form method="post" action="../Domain/validateLogin.php">
                                <div class="form-group">
                                    <label for="username" class="col-form-label">Username:</label> 
                                    <input class="form-control" type="text" placeholder="Enter username" name="userid" autofocus=""/>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-form-label">Password:</label> 
                                    <input class="form-control" type="password" placeholder="Enter your password" name ="studentpass"/>
                                </div>
                                <div class="row justify-content-center">
                                    <input class="submitBut btn btn-success" type="submit" name="studentSubmit" value="Login"/> 
                                    <input class="resetBut btn btn-danger" type="reset" name="reset" value="Cancel"/>
                                </div>
                                <h5 class="card-subtitle mt-3 text-muted"><label>Forgot Password? <a href="../UI/ForgotPassword.php">Click Here</a></label></h5>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                header("Location:../UI/HomePage.php");
            }
        } else {
            header("Location:../UI/HomePage.php");
        }
        ?> 
    </body>
</html>
