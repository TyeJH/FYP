<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Student.php';
session_start();
require 'header.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Register Account</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    </head>
    <style>
        .container{
            text-align:center;
        }
    </style>
    <body>
        <div class='container'>
            <br>
            <!--           1215 × 636-->
            <img src='../image/tarcBeyondEducation.png' width="243" height="127">
            <?php
            if (isset($_SESSION['status'])) {
                if ($_SESSION['status'] == 'staff') {
                    ?>
                    <h1>Staff Account Register</h1>
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <form action="../Domain/ValidateRegsiter.php" method="post">
                        <label>Admin ID:</label>
                        <select name="adminid">
                            <option selected disabled hidden>Select an Option</option>
                            <option value="DSA">Department of Student Affairs (DSA)</option>
                            <option value="BUR">Bursary (BUR)</option>
                            <option value="CCM">Department of Corporate Communication And Marketing (CCM)</option>
                            <option value="DEM">Department of Estates And Maintenance (DEM)</option>
                            <option value="DOS">Department of Security (DOS)</option>
                        </select><br>
                        <label>Password: </label>&nbsp;<input type="password" name="pass" placeholder="Enter your password"/><br>
                        <label>Confirm Password:</label>&nbsp;<input type="password" name="cpass" placeholder="Re-Type your password"/><br>
                        <input type="submit" name="staffSubmit" value="Register"/> <input type="reset" name="reset" value="Cancel"/>
                    </form>
                    <?php
                } else if ($_SESSION['status'] == 'student') {
                    $stu = new Student();
                    $uid = $stu->generateRandomId();
                    ?>
                    <h1>Student Account Register</h1>
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <form method="post" action="../Domain/ValidateRegsiter.php">
                        <input type="hidden" name="id" value="<?= $uid ?>"/>
                        <label>Username: </label> <input type="text" name="name" placeholder="Enter your username"/><br>
                        <label>Email: </label><input type="email" name="email" placeholder="example@domain.com"/><br>
                        <label>Password: </label> <input type="password" name="pass" placeholder="Enter your password"/><br>
                        <label>Confirm Password: </label><input type="password" name="cpass" placeholder="Re-Type your password"/><br>
                        <label>Student ID: </label> <input type="text" name="studid" placeholder="Enter your student id"/><br>
                        <input type="submit" name="studentSubmit" value="Register"/> <input type="reset" name="reset" value="Cancel"/>
                    </form>
                    <?php
                }
            } else {
                header("Location:../UI/HomePage.php");
            }
            ?>
        </div>

    </body>
</html>
