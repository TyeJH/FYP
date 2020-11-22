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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

        <style>
            .center{
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            .container{
                margin-top:2%;
            }
            .box{
                width:600;
            }
            .regBtn{
                width:40%;
            }
            p{
                padding:none;
                font-size:13px;
            }
            h1{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php
        if (isset($_SESSION['status'])) {
            if ($_SESSION['status'] == 'staff') {
                ?> 
                <div class="container box">
                    <div class="container card">
                        <div class="card-body">
                            <img src='../image/tarcBeyondEducation.png' width="243" height="127"  class="center"><br>
                            <h1 class="card-title"><b>Staff Register</b></h1>
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                                unset($_SESSION['error']);
                            }
                            ?>
                            <form action="../Domain/ValidateRegsiter.php" method="post">
                                <div class="form-group">
                                    <label for="id" class="col-form-label">Admin ID:</label>
                                    <select class="form-control" name="adminid">
                                        <option selected disabled hidden>Select an Option</option>
                                        <option value="DSA">Department of Student Affairs (DSA)</option>
                                        <option value="BUR">Bursary (BUR)</option>
                                        <option value="CCM">Department of Corporate Communication And Marketing (CCM)</option>
                                        <option value="DEM">Department of Estates And Maintenance (DEM)</option>
                                        <option value="DOS">Department of Security (DOS)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="pass" class="col-form-label">Password: </label>
                                    <input class="form-control" type="password" name="pass" placeholder="Enter your password"/>
                                </div>
                                <div class="form-group">
                                    <label for="cpass" class="col-form-label">Confirm Password:</label>
                                    <input class="form-control" type="password" name="cpass" placeholder="Re-Type your password"/>
                                </div>
                                <div class="form-group">
                                    <div class="col-form-label"></div>
                                    <p class="col-form-label">*Password must contain a minimum of 8 characters max of 20, at least one uppercase letter and at least one number (digit)</p>
                                </div>
                                <div class="row justify-content-center">
                                    <input class="btn btn-success m-1 regBtn" type="submit" name="staffSubmit" value="Register"/>
                                    <input class="btn btn-danger m-1 regBtn"type="reset" name="reset" value="Cancel"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            } else if ($_SESSION['status'] == 'student') {
                $stu = new Student();
                $uid = $stu->generateRandomId();
                ?>
                <div class="container box">
                    <div class="container card">
                        <div class="card-body">
                            <img src='../image/tarcBeyondEducation.png' width="243" height="127"  class="center"><br>
                            <h1 class="card-title"><b>Student Register</b></h1>
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo '<h5 style=color:red>' . $_SESSION['error'] . '</h5>';
                                unset($_SESSION['error']);
                            }
                            ?>
                            <form method="post" action="../Domain/ValidateRegsiter.php" style="height:580;">
                                <input type="hidden" name="id" value="<?= $uid ?>"/>
                                <div class="form-group">
                                    <label for="username" class="col-form-label">Username: </label> 
                                    <input class="form-control" type="text" name="name" placeholder="Enter your username"/>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email: </label>
                                    <input class="form-control" type="email" name="email" placeholder="example@domain.com"/>
                                </div>
                                <div class="form-group">
                                    <label for="pass" class="col-form-label">Password: </label> 
                                    <input class="form-control" type="password" name="pass" placeholder="Enter your password"/>
                                </div>
                                <div class="form-group">
                                    <label for="cpass" class="col-form-label">Confirm Password: </label>
                                    <input class="form-control" type="password" name="cpass" placeholder="Re-Type your password"/>
                                </div>
                                <div class="form-group">
                                    <label for="studid" class="col-form-label">Student ID: </label> 
                                    <input class="form-control" type="text" name="studid" placeholder="Enter your student id"/>
                                </div>
                                <div class="form-group">
                                    <div class="col-form-label"></div>
                                    <p class="col-form-label">*Password must contain a minimum of 8 characters max of 20, at least one uppercase letter and at least one number (digit)</p>
                                </div>
                                <div class="row justify-content-center">
                                    <input class="btn btn-success m-1 regBtn" type="submit" name="studentSubmit" value="Register"/> 
                                    <input class="btn btn-danger m-1 regBtn" type="reset" name="reset" value="Cancel"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            header("Location:../UI/HomePage.php");
        }
        ?>
    </body>
</html>
