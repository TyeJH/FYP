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
    
    if ($nul == 'Update') {
        $announcement = new Announcement($id, $title, $content, $date, $author);
        $annda = new AnnounceDA();
        $annda->update($announcement);
        $_SESSION['message'] = 'Announcement Updated';
        echo '<script>location.href = "../UI/CreateAnnouncement.php";</script>';
        
    } else if ($nul == 'Delete') {
        $annda = new AnnounceDA();
        $annda->delete($id);
        $_SESSION['message'] = 'Announcement Deleted';
        echo '<script>location.href = "../UI/CreateAnnouncement.php";</script>';
        
    } else {
        $ann = new Announcement($id, $title, $content, $date, $author);
        $annda = new AnnounceDA();
        $annda->regsiter($ann);
        $_SESSION['message'] = 'Announcement Created';
        echo '<script>location.href = "../UI/CreateAnnouncement.php";</script>';
    }
}

