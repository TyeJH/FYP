<?php
include_once '../Domain/Admin.php';
include_once '../Domain/Society.php';
include_once '../Domain/Student.php';

session_start();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>User Profile</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
        if (isset($_SESSION['current'])) {
            if ($_SESSION['current'] == "Admin") {
                $admin = $_SESSION['result'];
                ?>
                <header>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="../UI/HomePage.php">Event Management System</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/ViewEvent.php">Events</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/Announcement.php">Announcement</a>
                                </li>
                                <li class="nav-item dropdown active">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Admin
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="../UI/UserProfile.php">View Profile</a>
                                        <a class="dropdown-item" href="../UI/Logout.php">Logout</a>
                                    </div>
                                </li>
                            </ul>
                            <form class="form-inline my-2 my-lg-0">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div>
                    </nav>
                </header>
                <form action="../Domain/updateAcc.php" method="POST">
                    <b>Admin Profile</b>
                    <a href="#" class="edit">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                    </a>
                    <br>
                    <table>
                        <tr>
                            <th>Admin ID</th>
                            <td><input type="text" name="aID" value="<?= $admin->adminID ?>" readonly="" style="border:none;outline:none"></td>
                        </tr>
                        <tr>
                            <th>Admin Password</th>
                            <td><input type="text" name="password" class="pass" value="<?= $admin->password ?>" readonly="" style="border: none;outline:none"></td>
                        </tr>
                    </table>
                    <input type="submit" name="staffUpdate" value="Save" class="save" style="display: none"/>
                    <input type="reset" value="Cancel" class="cancel" style="display: none"/>
                </form>
                <script>
                    $('.edit').click(function () {
                        $(this).siblings('.save, .cancel').show();
                        $('.pass').removeAttr("readonly");
                        $('.pass').attr("style", "border:1px solid;outline:1px solid");
                        $('.pass').focus();
                    });
                    $('.cancel').click(function () {
                        $(this).siblings('.save').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                    $('.save').click(function () {
                        $(this).siblings('.cancel').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                </script>
                <?php
            } else if ($_SESSION['current'] == "Society") {
                $society = $_SESSION['result'];
                ?>
                <header>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="../UI/HomePage.php">Event Management System</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/ViewEvent.php">Events</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/Announcement.php">Announcement</a>
                                </li>
                                <li class="nav-item dropdown active">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Society
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="../UI/UserProfile.php">View Profile</a>
                                        <a class="dropdown-item" href="../UI/Logout.php">Logout</a>
                                    </div>
                                </li>
                            </ul>
                            <form class="form-inline my-2 my-lg-0">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div>
                    </nav>
                </header>
                <form action="../Domain/updateAcc.php" method="POST">
                    <b>Society Profile</b>
                    <a href="#" class="edit">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg></a>
                    <br>
                    <table>
                        <tr>
                            <th>Society ID</th>
                            <td><input type="text" name="sID" value="<?= $society->societyID ?>" readonly="" style="border:none;outline: none"></td>
                        </tr>
                        <tr>
                            <th>Society Name</th>
                            <td><input type="text" name="sName" class="name" value="<?= $society->societyName ?>" readonly="" style="border:none;outline:none"></td>
                        </tr>
                        <tr>
                            <th>Society Description</th>
                            <td><input type="text" name="sDesc" class="desc" value="<?= $society->societyDesc ?>" readonly="" style="border:none;outline:none"></td>
                        </tr>
                        <tr>
                            <th>Society Password</th>
                            <td><input type="text" name="sPass" class="pass" value="<?= $society->societyPass ?>" readonly="" style="border: none;outline: none"></td>
                        </tr>
                    </table>
                    <input type="submit" name="societyUpdate" value="Save" class="save" style="display: none"/>
                    <input type="reset" value="Cancel" class="cancel" style="display: none"/>
                </form>
                <script>
                    $('.edit').click(function () {
                        $(this).siblings('.save, .cancel').show();
                        $('.pass, .name, .desc').removeAttr("readonly");
                        $('.pass, .name, .desc').attr("style", "border:1px solid;outline:1px solid");
                        $('.name').focus();
                    });
                    $('.cancel').click(function () {
                        $(this).siblings('.save').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                    $('.save').click(function () {
                        $(this).siblings('.cancel').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                </script>
                <?php
            } else if ($_SESSION['current'] == "Student") {
                $stud = $_SESSION['result'];
                ?>
                <header>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="../UI/HomePage.php">Event Management System</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/ViewEvent.php">Events</a>
                                </li>
                                <li class="nav-item dropdown active">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Student
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="../UI/UserProfile.php">View Profile</a>
                                        <a class="dropdown-item" href="../UI/Logout.php">Logout</a>
                                    </div>
                                </li>
                            </ul>
                            <form class="form-inline my-2 my-lg-0">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div>
                    </nav>
                </header>
                <form action="../Domain/updateAcc.php" method="POST">
                    <b>Student Profile</b>
                    <a href="#" class="edit">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg></a>
                    <br>
                    <table>
                        <tr>
                            <th>User ID</th>
                            <td><input type="text" name="uID" value="<?= $stud->studID ?>" readonly="" style="border:none; outline: none"></td>
                        </tr>
                        <tr>
                            <th>User Password</th>
                            <td><input type="text" name="password" class="pass" value="<?= $stud->password ?>" readonly="" style="border: none; outline:none"></td>
                        </tr>
                        <tr>
                            <th>Student ID:</th>
                            <td><input type="text" name="studid" value="<?= $stud->uniStudID ?>" readonly="" style="border: none; outline:none"></td>
                        </tr>
                    </table>
                    <input type="submit" name="studentUpdate" value="Save" class="save" style="display: none"/>
                    <input type="reset" value="Cancel" class="cancel" style="display: none"/>
                </form>
                <script>
                    $('.edit').click(function () {
                        $(this).siblings('.save, .cancel').show();
                        $('.pass').removeAttr("readonly");
                        $('.pass').attr("style", "border:1px solid;outline:1px solid");
                        $('.pass').focus();
                    });
                    $('.cancel').click(function () {
                        $(this).siblings('.save').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                    $('.save').click(function () {
                        $(this).siblings('.cancel').hide();
                        $(this).hide();
                        $('.pass').attr("style", "border:none;outline:none");
                        $('.pass').attr("readonly", "readonly");
                    });
                </script>
                <?php
            } else {
                ?>
                <header>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="../UI/HomePage.php">Event Management System</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/HomePage.php">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/ViewEvent.php">Events</a>
                                </li>
                                <li class="nav-item dropdown active">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Login
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="?staff">Staff</a>
                                        <a class="dropdown-item" href="?society">Society</a>
                                        <a class="dropdown-item" href="?student">Student</a>
                                        <?php
                                        if ($_SERVER['QUERY_STRING'] == 'staff') {
                                            $_SESSION['role'] = 'staff';
                                            header("Location:../UI/Login.php");
                                        } else if ($_SERVER['QUERY_STRING'] == 'society') {
                                            $_SESSION['role'] = 'society';
                                            header("Location:../UI/Login.php");
                                        } else if ($_SERVER['QUERY_STRING'] == 'student') {
                                            $_SESSION['role'] = 'student';
                                            header("Location:../UI/Login.php");
                                        }
                                        ?>
                                    </div>
                                </li>
                                <li class="nav-item dropdown active">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Register
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="?Rstaff">Staff</a>
                                        <a class="dropdown-item" href="?Rstudent">Student</a>
                                        <?php
                                        if ($_SERVER['QUERY_STRING'] == 'Rstaff') {
                                            $_SESSION['status'] = 'staff';
                                            header("Location:../UI/Register.php");
                                        } else if ($_SERVER['QUERY_STRING'] == 'Rstudent') {
                                            $_SESSION['status'] = 'student';
                                            header("Location:../UI/Register.php");
                                        }
                                        ?>
                                    </div>
                                </li>
                            </ul>
                            <form class="form-inline my-2 my-lg-0">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div>
                    </nav>
                </header>
                <?php
            }
        } else {
            $_SESSION['current'] = '';
            header("Location:../UI/HomePage.php");
        }
        ?>
    </body>
</html>
