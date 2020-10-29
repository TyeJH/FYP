<?php

include_once '../Domain/Validation.php';
include_once '../Domain/Venue.php';
include_once '../DataAccess/VenueDA.php';

session_start();

if (isset($_POST['venueid'])) {
    $output='';
    $val = new Validation();
    $id = $val->test_input($_POST['venueid']);
    
    $venue = new VenueDA();
    $edit = $venue->retrieve($id);
    $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
     $output .= '
     <tr>  
            <td width="30%"><label>Venue ID</label></td>  
            <td width="70%">'.$edit->venueID.'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Venue Name</label></td>  
            <td width="70%">'.$edit->venueName.'</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Venue Description</label></td>  
            <td width="70%">'.$edit->venueDesc.'</td>  
        </tr>
     ';
    
    $output .= '</table></div>';
    echo $output;
}

