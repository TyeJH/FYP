<?php

class Booking {

    private $bookID;
    private $purpose;
    private $bookDate;
    private $startTime;
    private $endTime;
    private $bookStatus;
    private $societyID;
    private $venueID;
    private $venueName;

    public function __construct($bookID = "", $purpose = "", $bookDate = "", $startTime = "", $endTime = "", $bookStatus = "", $societyID = "", $venueID = "", $venueName = "") {
        $this->bookID = $bookID;
        $this->purpose = $purpose;
        $this->bookDate = $bookDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->bookStatus = $bookStatus;
        $this->societyID = $societyID;
        $this->venueID = $venueID;
        $this->venueName = $venueName;
    }

    public function __set($name, $value) {
        if (property_exists($this, $name)) {
            $this->$name = $value;
            return true;
        } else {
            return false;
        }
    }

    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return false;
        }
    }

}
