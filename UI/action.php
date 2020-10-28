<?php

include_once '../DataAccess/VenueDA.php';
include_once '../Domain/Venue.php';

$input = filter_input_array(INPUT_POST);


if ($input['action'] == 'edit') {
    $v = new Venue($input['venueID'],$input['venueName'], $input['venueDesc']);
    $vda = new VenueDA();
    $vda->update($v);
}
else if ($input['action'] == 'delete') {
    $vda = new VenueDA();
    $vda->delete($id);
}
echo json_encode($input);

