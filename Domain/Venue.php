<?php

include_once '../DataAccess/VenueDA.php';

class Venue {

    private $venueID;
    private $venueName;
    private $venueDesc;

    public function __construct($venueID = "", $venueName = "", $venueDesc = "") {
        $this->venueID = $venueID;
        $this->venueName = $venueName;
        $this->venueDesc = $venueDesc;
    }

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
            return true;
        } else {
            return false;
        }
    }

    public function &__get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return false;
        }
    }
   
    public function generateRandomId() {
        $newId = 'VEN' . rand(0, 99999);
        if ($this->isIdDuplicate($newId)) {
            $this->generateRandomId();
        } else {
            return $newId;
        }
    }

    public function isIdDuplicate($newId) {
        $vn = new VenueDA();
        return $vn->checkID($newId);
    }
}
