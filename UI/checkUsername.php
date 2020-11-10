<?php
include_once '../Domain/Validation.php';
include_once '../Domain/Student.php';
include_once '../DataAccess/StudentDA.php';
session_start();
require '../UI/header.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Reset password</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />  

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  

    </head>
    <body>
        <div class="container card">
            <div class="card-body">
                <h1 h1 class="card-title">Reset Password</h1>
                <form action="../UI/checkUsername.php" method="post">
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <div class="form-group">
                        <label for="username" class="col-form-label">Enter your username: </label>
                        <input class="form-control" type="text" name="username" value="" size="20" /></p>
                    </div>
                    <div class="row justify-content-center">
                        <input class="submitBut btn btn-success" type="submit" value="Submit" name="submit" /> &nbsp;
                        <input class="resetBut btn btn-danger" type="reset" value="Cancel" name="reset"/>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <?php
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];

        if (empty($username)) {
            $_SESSION['error'] = "Username cannot be empty";
        } else {
            $std = new StudentDA();
            $test = $std->login($username);

            if ($test == null) {
                $_SESSION['error'] = "Username Not Found";
            } else {
                $_SESSION['reset'] = $test;
                echo '<script>location.href = "../UI/ResetPassword.php";</script>';
            }
        }
    }
    ?>
</html>
