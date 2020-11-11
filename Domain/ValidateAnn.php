<?php

include_once '../Domain/Validation.php';
include_once '../Domain/Announcement.php';
include_once '../DataAccess/AnnounceDA.php';

session_start();

if (!empty($_POST)) {
    
    $val = new Validation();
    $id = $val->test_input($_POST['aid']);
    $title = $val->test_input($_POST['atitle']);
    $content = $val->test_input($_POST['acontent']);
    $date = $val->test_input($_POST['adate']);
    $author = $val->test_input($_POST['aauthor']);
    $nul = $_POST['announceid'];
    
    $dbDate = date('Y-m-d', strtotime($date));
    
    if ($nul == 'Update') {
        $announcement = new Announcement($id, $title, $content, $dbDate, $author);
        $annda = new AnnounceDA();
        $annda->update($announcement);
        $_SESSION['annmessage'] = 'Announcement Updated';
        echo '<script>location.href = "../UI/CreateAnnouncement.php";</script>';
        
    } else if ($nul == 'Delete') {
        $annda = new AnnounceDA();
        $annda->delete($id);
        $_SESSION['annmessage'] = 'Announcement Deleted';
        echo '<script>location.href = "../UI/CreateAnnouncement.php";</script>';
        
    } else {
        $ann = new Announcement($id, $title, $content, $dbDate, $author);
        $annda = new AnnounceDA();
        $annda->regsiter($ann);
        $_SESSION['annmessage'] = 'Announcement Created';
        echo '<script>location.href = "../UI/CreateAnnouncement.php";</script>';
    }
}

