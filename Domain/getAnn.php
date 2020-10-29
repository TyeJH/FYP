<?php

include_once '../Domain/Validation.php';
include_once '../Domain/Announcement.php';
include_once '../DataAccess/AnnounceDA.php';

session_start();

if (isset($_POST['annid'])) {
    $output='';
    $val = new Validation();
    $id = $val->test_input($_POST['annid']);
    
    $announce = new AnnounceDA();
    $edit = $announce->retrieve($id);
    $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
     $output .= '
     <tr>  
            <td width="30%"><label>Announcement ID</label></td>  
            <td width="70%">'.$edit->annID.'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Announcement Title</label></td>  
            <td width="70%">'.$edit->annTitle.'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Announcement Description</label></td>  
            <td width="70%">'.$edit->annContent.'</td>  
        </tr><tr>  
            <td width="30%"><label>Announcement Date</label></td>  
            <td width="70%">'.$edit->annDate.'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Announcement Author</label></td>  
            <td width="70%">'.$edit->adminID.'</td>  
        </tr>
     ';
    
    $output .= '</table></div>';
    echo $output;
}

