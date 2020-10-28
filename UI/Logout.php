<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        session_unset();
        session_destroy();
        session_write_close();
        session_regenerate_id(true);
        echo '<script>alert("Logout Successfully.");location.href = "../UI/HomePage.php";</script>';
        ?>
    </body>
</html>
