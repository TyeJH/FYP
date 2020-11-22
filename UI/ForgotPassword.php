<?php
require 'C:\xampp\composer\vendor\autoload.php';
include_once '../Domain/Validation.php';
include_once '../Domain/Email.php';
include_once '../Domain/Student.php';
include_once '../DataAccess/StudentDA.php';
session_start();
require 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Forgot Password</title>
        <style>
            .container{
                margin-top: 7%;
                text-align:center;
            }
            table{
                margin-left: auto;
                margin-right: auto;
            }
            h6{
                text-align:left;
            }
        </style>
    </head>
    <body>
        <div class="container card">
            <div class="card-body">
                <h1 h1 class="card-title">Forgot Your Password</h1>
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<h6 style=color:red>' . $_SESSION['error'] . '</h6>';
                    unset($_SESSION['error']);
                }
                ?>
                <form action="ForgotPassword.php" method="post">
                    <div class="form-group">
                        <label for="username" class="col-form-label">Enter your email address: </label>
                        <input class="form-control" type="email" name="email" value=""/></p>
                    </div>
                    <div class="row justify-content-center">
                        <input class="submitBut btn btn-success" type="submit" value="Submit" name="submit" /> &nbsp;
                        <input class="resetBut btn btn-danger" type="button" value="Cancel" name="cancel" onclick="JavaScript:window.location = '../UI/Login.php'"/>
                    </div>
                </form>
            </div>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];

            if (empty($email)) {
                $_SESSION['error'] = "Email cannot be empty";
                echo '<script>location.href = "../UI/ForgotPassword.php";</script>';
            } else {
                $std = new StudentDA();
                $test = $std->recover($email);

                if ($test == null) {
                    $_SESSION['error'] = "Email Not Found";
                    echo '<script>location.href = "../UI/ForgotPassword.php";</script>';
                } else {
                    echo "Email found<br>";

                    $to = $test->studEmail;
                    $toName = $test->username;
                    $subject = 'Recover Your Password';
                    $message = '<a href=http://localhost/FYP/UI/checkUsername.php>Reset Password</a>';
                    $from = "admin@system.com";
                    $sender = "Admin";
                    $mail = new Email($to, $toName, $subject, $message, $from, $sender);
                    if ($mail->setting()) {
                        $_SESSION['role'] = 'student';
                        echo '<script>alert("An email had been sent to your account.");location.href = "../UI/Login.php";</script>';
                    } else {
                        echo $mail->errorMessage();
                    }
                }
            }
        }
        ?>
    </body>
</html>
