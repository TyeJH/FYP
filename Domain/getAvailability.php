<?php
include_once '../Domain/Validation.php';
include_once '../Domain/Society.php';
include_once '../Domain/Admin.php';
include_once '../Domain/Booking.php';
include_once '../DataAccess/BookingDA.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />

<!--Data Table-->
<link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  

<?php
if (isset($_POST['venueid'])) {
    $output = '';
    $val = new Validation();
    $id = $val->test_input($_POST['venueid']);

    $booking = new BookingDA();
    $avail = $booking->checkVenue($id);
    $output .= '  
        <div class="table-responsive">  
            <table id="cTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>Booking Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Society ID</th>
                </tr>
            </thead>
            <tbody>';
    if (!empty($avail)) {
        foreach ($avail as $a) {
            $start = new DateTime($a->startTime);
            $end = new DateTime($a->endTime);
            $date = new DateTime($a->bookDate);
            $output .= '
        <tr>
            <td width="20%">' . date_format($date, 'd-M-Y') . '</td>  
            <td width="20%">' . date_format($start, 'H:i') . '</td>  
            <td width="20%">' . date_format($end, 'H:i') . '</td>  
            <td width="20%">' . $a->societyID . '</td>  
        </tr>';
        }
    }
    $output .= '</tbody></table></div>';
    echo $output;
}
?>
<script>
    $(document).ready(function () {
        $('#cTable').DataTable();
    });
</script>
