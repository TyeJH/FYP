
<?php

session_start();
session_unset();
session_destroy();
echo '<script>alert("Logout Successfully.");location.href = "../UI/HomePage.php";</script>';

