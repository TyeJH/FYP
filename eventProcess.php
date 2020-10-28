<?php 
session_start();

include_once'Domain/Validation.php';

require_once 'DataAccess/DatabaseConnection.php';

$db = DatabaseConnection::getInstance()->getDb();

//Submit applicaiton form
if (isset($_POST['apply'])) {

    $allowed = array('docx', 'pdf');
    $filename = $_FILES['myfile']['name'];
    $mime = $_FILES['myfile']['type'];
    $content = file_get_contents($_FILES['myfile']['tmp_name']);
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $applyDate = date('Y-m-d H:i:s');
    $societyID = 123;
    $applyStatus = 'Pending';
    if ($_FILES['myfile']['error'] == 4) {
        //If file is empty
        $_SESSION['message'] = "<div class='alert alert-info'><strong>Please select a file.</strong></div>";
        header('location:ApplyNewEvent.php');
    } else if (!in_array($ext, $allowed)) {
        //If file type is not allowed
        $_SESSION['message'] = "<div class='alert alert-info'><strong>Sorry, only .docx or .pdf file type is accepted.</strong>";
        header('location:ApplyNewEvent.php');
    } else {
        $query = 'INSERT INTO documentation (docName, mime, docContent, applyDate, societyID, status) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $filename, PDO::PARAM_STR);
        $stmt->bindParam(2, $mime, PDO::PARAM_STR);
        $stmt->bindParam(3, $content);
        $stmt->bindParam(4, $applyDate);
        $stmt->bindParam(5, $societyID);
        $stmt->bindParam(6, $applyStatus, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $_SESSION['message'] = "<div class='alert alert-success'><strong>Success!</strong> Your application successfully submitted.</div>";
            header('location:ApplyNewEvent.php');
        } else {
            $_SESSION['message'] = "<div class='alert alert-danger'><strong>Failed!</strong> Sorry, currently cannot submit.</div>";
            header('location:ApplyNewEvent.php');
        }
    }
}
//Create Event
if (isset($_POST['createEvent'])) {
    $allowed = array('jpg', 'png');

    $val = new Validation();
    $eventName = $val->test_input($_POST['eventName']);
    $eventDesc = $val->test_input($_POST['eventDesc']);

    $filename = $_FILES['myfile']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $content = file_get_contents($_FILES['myfile']['tmp_name']);

    $eventCategory = $val->test_input($_POST['eventCategory']);
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $noOfParticipant = $_POST['noOfParticipant'];
    $noOfHelper = $_POST['noOfHelper'];
    $contactNo = $_POST['contactNo'];
    $societyID = 123;
    $venueID = 123;
    $userID = 123;
    $applyID = $_POST['applyID'];

    if (empty($eventName)) {
        $_SESSION['message'] = "<div class='alert alert-info'><strong>Please enter the event name</strong></div>";
        header("location:CreateEvent.php?applyID=$applyID");
    } else if (empty($eventDesc)) {
        $_SESSION['message'] = "<div class='alert alert-info'><strong>Please enter the event description</strong></div>";
        header("location:CreateEvent.php?applyID=$applyID");
    } else if ($_FILES['myfile']['error'] == 4) {
        //If file is empty
        $_SESSION['message'] = "<div class='alert alert-info'><strong>Please select an image</strong></div>";
        header("location:CreateEvent.php?applyID=$applyID");
    } else if (!in_array($ext, $allowed)) {
        //If file type is not allowed
        $_SESSION['message'] = "<div class='alert alert-info'><strong>Sorry, image file only jpg and png is accepted.</strong></div>";
        header("location:CreateEvent.php?applyID=$applyID");
    } else {

        $query = 'INSERT INTO event (eventName, eventDesc, eventCategory, startDate, endDate, image, noOfParticipant, noOfHelper, contactNo, societyID, venueID, userID, applyID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventName, PDO::PARAM_STR);
        $stmt->bindParam(2, $eventDesc, PDO::PARAM_STR);
        $stmt->bindParam(3, $eventCategory, PDO::PARAM_STR);
        $stmt->bindParam(4, $startDate);
        $stmt->bindParam(5, $endDate);
        $stmt->bindParam(6, $content);
        $stmt->bindParam(7, $noOfParticipant);
        $stmt->bindParam(8, $noOfHelper);
        $stmt->bindParam(9, $contactNo);
        $stmt->bindParam(10, $societyID);
        $stmt->bindParam(11, $venueID);
        $stmt->bindParam(12, $userID);
        $stmt->bindParam(13, $applyID);
        if ($stmt->execute()) {
            $_SESSION['message'] = "<div class='alert alert-success'><strong>Success!</strong> You have posted a new event.</div>";
            header("location:CreateEvent.php?applyID=$applyID");
        } else {
            $_SESSION['message'] = "<div class='alert alert-danger'><strong>Failed!</strong> Sorry, an unexpected error occured.</div>";
            header("location:CreateEvent.php?applyID=$applyID");
        }
    }
}

//Edit Event
if (isset($_POST['updateEvent'])) {
    $allowed = array('jpg', 'png');

    $eventID = $_POST['eventID'];

    $val = new Validation();
    $eventName = $val->test_input($_POST['eventName']);
    $eventDesc = $val->test_input($_POST['eventDesc']);

    $file = 0;

    if ($_FILES['myfile']['error'] == 4) {
        //If user didn't upload new image file, then use existing one
        $query = 'SELECT * FROM event WHERE eventID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventID);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $stmt->rowCount();
        if ($num > 0) {
            $content = $event['image'];
        }
    } else {
        //If user upload new image file, then use the uploaded one
        $filename = $_FILES['myfile']['name'];
        $mime = $_FILES['myfile']['type'];
        $content = file_get_contents($_FILES['myfile']['tmp_name']);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $file = 1;
    }
    $eventCategory = $val->test_input($_POST['eventCategory']);
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $noOfParticipant = $_POST['noOfParticipant'];
    $noOfHelper = $_POST['noOfHelper'];
    $contactNo = $_POST['contactNo'];


    if (empty($eventName)) {
        $_SESSION['message'] = "<div class='alert alert-info'><strong>Please enter the event name</strong></div>";
        header("location:editEvent.php?eventID=$eventID");
    } else if (empty($eventDesc)) {
        $_SESSION['message'] = "<div class='alert alert-info'><strong>Please enter the event description</strong></div>";
        header("location:editEvent.php?eventID=$eventID");
    } else if (!in_array($ext, $allowed) && $file == 1) {
        //If file type is not allowed
        $_SESSION['message'] = "<div class='alert alert-info'><strong>Sorry, image file only jpg and png is accepted.</strong></div>";
        header("location:editEvent.php?eventID=$eventID");
    } else {

        $query = 'UPDATE event SET eventName = ? , eventDesc = ? , eventCategory = ? , startDate = ? , endDate = ? , image = ? , noOfParticipant = ? , noOfHelper = ?, contactNo = ? WHERE eventID = ?';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventName, PDO::PARAM_STR);
        $stmt->bindParam(2, $eventDesc, PDO::PARAM_STR);
        $stmt->bindParam(3, $eventCategory, PDO::PARAM_STR);
        $stmt->bindParam(4, $startDate);
        $stmt->bindParam(5, $endDate);
        $stmt->bindParam(6, $content);
        $stmt->bindParam(7, $noOfParticipant);
        $stmt->bindParam(8, $noOfHelper);
        $stmt->bindParam(9, $contactNo);
        $stmt->bindParam(10, $eventID);
        if ($stmt->execute()) {
            $_SESSION['message'] = "<div class='alert alert-success'><strong>Successfully updated!</strong></div>";
            header("location:editEvent.php?eventID=$eventID");
        } else {
            $_SESSION['message'] = "<div class='alert alert-danger'><strong>Failed!</strong> Sorry, an unexpected error occured.</div>";
            header("location:editEvent.php?eventID=$eventID");
        }
    }
}

//Participate Event
if (isset($_POST['participate'])) {

    $eventID = $_POST['eventID'];
    $studID = 123;
    $applyStatus = "Pending";
    $applyDate = date('Y-m-d H:i:s'); //2020-10-22 03:53:54 sample format
    if (empty($eventID)) {
        //If students didn't select an event
        header("location:HomePage.php");
    } else if (empty($studID)) {
        //Student have to be logged in first.
    } else {
        $query = 'INSERT INTO participants (eventID, studID, applyDate, applyStatus) VALUES (?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventID, PDO::PARAM_STR);
        $stmt->bindParam(2, $studID, PDO::PARAM_STR);
        $stmt->bindParam(3, $applyDate);
        $stmt->bindParam(4, $applyStatus, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $_SESSION['message'] = "<script>alert('Thanks for joining us! An email had send to you.');</script>";
            header("location:../FYP/UI/EventDetails.php?eventID=$eventID");
        } else {
            $_SESSION['message'] = "<div class='alert alert-danger'><strong>Failed!</strong> Sorry, currently cannot submit.</div>";
            header("location:../FYP/UI/EventDetails.php?eventID=$eventID");
        }
    }
}

//Manage Participants Attendance
if (isset($_POST['studID']) && isset($_POST['attendanceStatus'])) {

    $attendanceStatus = $_POST['attendanceStatus'];
    $studID = $_POST['studID'];
    if ($attendanceStatus == "Attended") {
        //By default after approved then attendance status will absent.
        //Pending > Approved > Absent > Attend 
        $attendanceStatus = "Attended";
    } else {
        $attendanceStatus = "Absent";
    }
    $query = 'UPDATE participants SET attendanceStatus = ? WHERE studID = ?';
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $attendanceStatus);
    $stmt->bindParam(2, $studID);

    if ($stmt->execute()) {
        echo $studID . " marked as " . $attendanceStatus;
    } else {
        echo "Unexpected error occur. Please contact system administrator.";
    }
}

//Approve Participants Application
if (isset($_POST['studID']) && isset($_POST['applyStatus'])) {

    //initializes
    $applyStatus = $_POST['applyStatus'];
    $studID = $_POST['studID'];
    $attendanceStatus = '';
    if ($applyStatus == "Approved") {
        //By default after approved then absent.
        //Pending > Approved > Absent > Attend 
        $attendanceStatus = "Absent";
    } else {
        $attendanceStatus = "N/A";
    }
    $query = 'UPDATE participants SET applyStatus = ?, attendanceStatus = ? WHERE studID = ?';
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $applyStatus);
    $stmt->bindParam(2, $attendanceStatus);
    $stmt->bindParam(3, $studID);
    if ($stmt->execute()) {
        
    } else {
        echo "<script>alert('Unexpected error occur.');</script>";
    }
}

//Apply Helper
if (isset($_POST['applyHelper'])) {

    $eventID = $_POST['eventID'];
    $studID = 123;
    $applyStatus = "Pending";
    $applyDate = date('Y-m-d H:i:s'); //2020-10-22 03:53:54 sample format
    if (empty($eventID)) {
        header('location:HomePage.php');
    } else if (empty($studID)) {
        //Load to login page
    } else {
        //Insert into database
        $query = 'INSERT INTO helpers (eventID, studID, applyDate, applyStatus) VALUES (?, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $eventID, PDO::PARAM_STR);
        $stmt->bindParam(2, $studID, PDO::PARAM_STR);
        $stmt->bindParam(3, $applyDate);
        $stmt->bindParam(4, $applyStatus, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $_SESSION['message'] = "<script>alert('Thanks for joining us as Helper! An email had send to you.');</script>";
            header("location:../FYP/UI/EventDetails.php?eventID=$eventID");
        } else {
            $_SESSION['message'] = "<div class='alert alert-danger'><strong>Failed!</strong> Sorry, currently cannot submit.</div>";
            header("location:../FYP/UI/EventDetails.php?eventID=$eventID");
        }
    }
}
//view Feedback 
if (isset($_POST['docID'])) {
    $query = 'SELECT * FROM feedbacks WHERE docID = ?';
    $docID = $_POST['docID'];
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $docID);
    $stmt->execute();
    $num = $stmt->rowCount();
    if ($num != 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p>" . $row['content'] . "</p>";
    }
}

/* 
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

//method 2
//$conn = mysqli_connect('localhost', 'root', 'secret123', 'test');
//$result = mysqli_query($conn, $sql);

//$host = 'localhost';
//$dbName = 'test';
//$dbuser = 'root';
//$dbpassword = 'secret123';
//
//// set up DSN
//$dsn = "mysql:host=$host;dbname=$dbName";
//db = new PDO($dsn, $dbuser, $dbpassword);