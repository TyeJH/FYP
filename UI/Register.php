<?php
include_once '../Domain/SessionManagement.php';
include_once '../Domain/Admin.php';
include_once '../Domain/Student.php';
$session = new SessionManagement();
$session::sessionStarted();
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Register Account</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
        if ($session::sessionExists('current')) {
            if ($session::getSession('current') == "Admin") {
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
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/Announcement.php">Announcement</a>
                                </li>
                                <li class="nav-item dropdown active">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Admin
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="?view">View Profile</a>
                                        <a class="dropdown-item" href="?logout">Logout</a>
                                    </div>
                                    <?php
                                    if ($_SERVER['QUERY_STRING'] == 'view') {
                                            header("Location:../UI/ViewProfile.php");
                                        } else if ($_SERVER['QUERY_STRING'] == 'logout') {
                                            header("Location:../UI/Logout.php");
                                        }
                                    ?>
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
            } else if ($session::getSession('current') == "Society") {
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
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/Announcement.php">Announcement</a>
                                </li>
                                <li class="nav-item dropdown active">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Society
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="?view">View Profile</a>
                                        <a class="dropdown-item" href="?logout">Logout</a>
                                    </div>
                                    <?php
                                    if ($_SERVER['QUERY_STRING'] == 'view') {
                                            header("Location:../UI/ViewProfile.php");
                                        } else if ($_SERVER['QUERY_STRING'] == 'logout') {
                                            header("Location:../UI/Logout.php");
                                        }
                                    ?>
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
            } else if ($session::getSession('current') == "Student") {
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
                                        Student
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="?view">View Profile</a>
                                        <a class="dropdown-item" href="?logout">Logout</a>
                                    </div>
                                    <?php
                                    if ($_SERVER['QUERY_STRING'] == 'view') {
                                            header("Location:../UI/ViewProfile.php");
                                        } else if ($_SERVER['QUERY_STRING'] == 'logout') {
                                            header("Location:../UI/Logout.php");
                                        }
                                    ?>
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
                                            $session::setSession('role', 'staff');
                                            header("Location:../UI/Login.php");
                                        } else if ($_SERVER['QUERY_STRING'] == 'society') {
                                            $session::setSession('role', 'society');
                                            header("Location:../UI/Login.php");
                                        } else if ($_SERVER['QUERY_STRING'] == 'student') {
                                            $session::setSession('role', 'student');
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
                                            $session::setSession('status', 'staff');
                                            header("Location:../UI/Register.php");
                                        } else if ($_SERVER['QUERY_STRING'] == 'Rstudent') {
                                            $session::setSession('status', 'student');
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
            $session::setSession('current', '');
            header("Location:../UI/HomePage.php");
        }
        ?>
        <?php
        if ($session::sessionExists('status')) {
            if ($session::getSession('status') == 'staff') {
                $test = new Admin();
                $id = $test->generateRandomId();
        ?>
            <h1>Staff Account Register</h1>
            <form action="../Domain/ValidateRegsiter.php" method="post">
                <label>Admin ID:</label> <input type="text" value="<?= $id?>" readonly="readonly" name="adminid"/><br>
                <label>Role: </label>
                <select name="position">
                    <option value="Admin">Admin</option>
                    <option value="Staff">Staff</option>
                </select><br>
                <label>Password: </label><input type="password" name="pass" placeholder="Enter your password"/><br>
                <label>Confirm Password: </label><input type="password" name="cpass" placeholder="Re-Type your password"/><br>
                <label>Staff ID: </label><input type="text" name="staffid" placeholder="Enter your staff id" /><br>
                <input type="submit" name="rSubmit" value="Register"/> <input type="reset" name="reset" value="Cancel"/>
            </form>
        <?php
            
            } else if ($session::getSession('status') == 'student') {
                $stu = new Student();
                $sID = $stu->generateRandomId();
        ?>
            <h1>Student Account Register</h1>
            <form method="post" action="../Domain/ValidateRegsiter.php">
                <label>User ID: </label> <input type="text" name="id" value="<?= $sID?>" readonly=""/><br>
                <label>User Name: </label> <input type="text" name="username" placeholder="Enter your username"/><br>
                <label>Password: </label> <input type="password" name="pass" placeholder="Enter your password"/><br>
                <label>Confirm Password: </label><input type="password" name="cpass" placeholder="Re-Type your password"/><br>
                <label>Student ID: </label> <input type="text" name="studid" placeholder="Enter your student id"/><br>
                <input type="submit" name="sSubmit" value="Register"/> <input type="reset" name="reset" value="Cancel"/>
            </form>
        <?php        
            } 
        } else {
            header("Location:../UI/HomePage.php");
        }
        ?>
    </body>
</html>
