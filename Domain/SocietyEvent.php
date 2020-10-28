<?php

include_once '../DataAccess/SocietyDA.php';

class SocietyEvent {

    private $eventID;
    private $eventName;
    private $eventDesc;
    private $eventCategory;
    private $startDate;
    private $endDate;
    private $image;
    private $noOfParticipant;
    private $noOfHelper;
    private $contactNo;
    private $societyID;
    private $applyID;

    public function __construct($eventID = "", $eventName = "", $eventDesc = "", $eventCategory = "", $startDate = "", $endDate = "", $image = "", $noOfParticipant = "", $noOfHelper = "", $contactNo = "", $societyID = "", $applyID = "") {
        $this->eventID = $eventID;
        $this->eventName = $eventName;
        $this->eventDesc = $eventDesc;
        $this->eventCategory = $eventCategory;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->image = $image;
        $this->noOfParticipant = $noOfParticipant;
        $this->noOfHelper = $noOfHelper;
        $this->contactNo = $contactNo;
        $this->societyID = $societyID;
        $this->applyID = $applyID;
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
