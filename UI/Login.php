<?php
session_start();
require 'header.php';
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login Page</title>
    </head>
    <style>
        .container{
            text-align:center;
        }
        table{
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <body>
        <div class='container'>
            <!--           1215 × 636-->
            <img src='../image/tarcBeyondEducation.png' width="243" height="127"><br>
            <?php
            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] == 'staff') {
                    ?>
                    <h1>Staff Account Login</h1>
                    <form method="post" action="../Domain/validateLogin.php">
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                            unset($_SESSION['error']);
                        }
                        ?>
                        <table>
                            <tr>
                                <th>Admin ID:</th>
                                <td><input type="text" placeholder="Enter admin id" name="adminid" autofocus=""/></td>
                            </tr>
                            <tr>
                                <th>Password:</th>
                                <td><input type="password" placeholder="Enter your password" name ="adminpass"/></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" name="staffSubmit" value="Login"/>
                                    <input type="reset" name="reset" value="Cancel"/></td>
                            </tr>
                        </table>
                    </form>
                    <?php
                } else if ($_SESSION['role'] == 'society') {
                    ?>
                    <h1>Society Account Login</h1>
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <form method="post" action="../Domain/validateLogin.php">
                        <label>Society ID: </label> <input type="text" placeholder="Enter society id (number only)" name="societyid" autofocus=""/><br>
                        <label>Password: </label> <input type="password" placeholder="Enter your password" name ="societypass"/><br>
                        <input type="submit" name="societySubmit" value="Login"/> <input type="reset" name="reset" value="Cancel"/><br>
                    </form>

                    <?php
                } else if ($_SESSION['role'] == 'student') {
                    ?>
                    <h1>Student Account Login</h1>
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <form method="post" action="../Domain/validateLogin.php">
                        <label>User ID: </label> <input type="text" placeholder="Enter user id (number only)" name="userid" autofocus=""/><br>
                        <label>Password: </label> <input type="password" placeholder="Enter your password" name ="studentpass"/><br>
                        <input type="submit" name="studentSubmit" value="Login"/> <input type="reset" name="reset" value="Cancel"/><br>
                    </form>
                    <?php
                } else {
                    header("Location:../UI/HomePage.php");
                }
            } else {
                header("Location:../UI/HomePage.php");
            }
            ?>     
        </div>
    </body>
</html>
