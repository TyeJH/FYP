<?php

include_once '../Domain/Validation.php';
include_once '../Domain/Society.php';
include_once '../Domain/Admin.php';
include_once '../DataAccess/SocietyDA.php';

session_start();

if (isset($_POST['socid'])) {
    if ($_SESSION['result']->adminID == 'DSA') {
        $output = '';
        $val = new Validation();
        $id = $val->test_input($_POST['socid']);

        $society = new SocietyDA();
        $edit = $society->login($id);
        $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
        $output .= '
     <tr>    
            <td width="30%"><label>Society ID</label></td>  
            <td width="70%">' . $edit->societyID . '</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Society Name</label></td>  
            <td width="70%">' . $edit->societyName . '</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Society Description</label></td>  
            <td width="70%">' . $edit->societyDesc . '</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Society Password</label></td>  
            <td width="70%"><input type="password" value="' . $edit->societyPass . '" style="border:none;outline:none;" readonly=""></td>  
        </tr>
     ';

        $output .= '</table></div>';
        echo $output;
    } else {
        $output = '';
        $val = new Validation();
        $id = $val->test_input($_POST['socid']);

        $society = new SocietyDA();
        $edit = $society->login($id);
        $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';
        $output .= '
     <tr>    
            <td width="30%"><label>Society ID</label></td>  
            <td width="70%">' . $edit->societyID . '</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Society Name</label></td>  
            <td width="70%">' . $edit->societyName . '</td>  
        </tr>
        <tr>  
            <td width="30%"><label>Society Account</label></td>  
            <td width="70%">' . number_format($edit->societyAcc, 2) . '</td>  
        </tr>
     ';

        $output .= '</table></div>';
        echo $output;
    }
}

