<html>
    <head>
        <meta charset="UTF-8">
        <title>Home Page</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
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
                                    <a class="nav-link" href="../UI/HomePageEvents.php">Events</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/Announcement.php">Announcement</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="../UI/VenueList.php">Venue</a>
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
                                    <a class="nav-link" href="../UI/HomePageEvents.php">Events</a>
                                </li>
                                <li class="nav-item active">
                                    <a class="nav-link" href="">Announcement</a>
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
                                    <a class="nav-link" href="../UI/HomePageEvents.php">Events</a>
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
                                    <a class="nav-link" href="../UI/HomePageEvents.php">Events</a>
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
        } 
//        else {
//            $_SESSION['current'] = '';
//            header("Location:../UI/HomePage.php");
//        }
        ?>
    </body> 
</html>

