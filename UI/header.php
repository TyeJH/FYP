<?php
require_once '../Domain/Admin.php';
require_once '../Domain/Society.php';
require_once '../Domain/Student.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <!--        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="../css/headerStackpath.css">

        <!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />-->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </head>  
    <body>
        <?php
        if (isset($_SESSION['current'])) {
            if ($_SESSION['current'] == "Admin") {
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
                                    <a class="nav-link" href="../UI/HomePage.php">Events</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/CreateAnnouncement.php">Announcement</a>
                                </li>
                                <?php
                                if (isset($_SESSION['result'])) {
                                    if ($_SESSION['result']->adminID === 'DSA') {
                                        ?>
                                        <li class="nav-item active">
                                            <a class="nav-link" href="../UI/AdminViewBooking.php">Booking</a>
                                        </li>
                                        <li class="nav-item active">
                                            <a class="nav-link" href="../UI/AdminViewDocument.php">Document</a>
                                        </li>
                                        <li class="nav-item active">
                                            <a class="nav-link" href="../UI/VenueList.php">Venue</a>
                                        </li>
                                        <li class="nav-item active">
                                            <a class="nav-link" href="../UI/CreateSociety.php">Society</a>
                                        </li>
                                        <?php
                                    } else if ($_SESSION['result']->adminID === 'BUR') {
                                        ?>
                                        <li class="nav-item active">
                                            <a class="nav-link" href="../UI/CreateSociety.php">Society</a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                                <li class="nav-item dropdown active">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php
                                        if (isset($_SESSION['result'])) {
                                            $role = $_SESSION['result'];
                                            echo $role->adminID;
                                        }
                                        ?>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="../UI/UserProfile.php">View Profile</a>
                                        <a class="dropdown-item" href="../UI/Logout.php">Logout</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <?php
            } else if ($_SESSION['current'] == "Society") {
                ?>
                <header>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="EventOrganizerHome.php">Event Management System</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/EventOrganizerHome.php">Event Management</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/CreateAnnouncement.php">Announcement</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/VenueList.php">Venue</a>
                                </li>
                                <li class="nav-item dropdown active">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Society
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="../UI/UserProfile.php">View Profile</a>
                                        <a class="dropdown-item" href="../UI/eventHistory.php">History</a>
                                        <a class="dropdown-item" href="../UI/Logout.php">Logout</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <?php
            } else if ($_SESSION['current'] == "Student") {
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
                                    <a class="nav-link" href="../UI/HomePage.php">Events</a>
                                </li>
                                <li class="nav-item dropdown active">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Student
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="../UI/UserProfile.php">View Profile</a>
                                        <a class="dropdown-item" href="../UI/eventHistory.php">History</a>
                                        <a class="dropdown-item" href="../UI/Logout.php">Logout</a>
                                    </div>
                                </li>
                            </ul>
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
                                    <a class="nav-link" href="../UI/HomePage.php">Events</a>
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
                        </div>
                    </nav>
                </header>

                <?php
            }
        } else if ($_SESSION['current'] == '' && $_SESSION['role'] != '') {
            $_SESSION['current'] = '';
            header("Location:../UI/Login.php");
        } else{
            $_SESSION['current'] = '';
            header("Location:../UI/HomePage.php");
        }
        ?>
    </body> 
</html>

