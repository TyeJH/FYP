<?php

include_once '../DataAccess/SocietyDA.php';

class SocietyEvent {

    private $eventID;
    private $eventName;
    private $eventDesc;
    private $eventCategory;
    private $image;
    private $noOfHelper;
    private $contactNo;
    private $societyID;
    private $applyID;

    public function __construct($eventID = "", $eventName = "", $eventDesc = "", $eventCategory = "", $image = "", $noOfHelper = "", $contactNo = "", $societyID = "", $applyID = "") {
        $this->eventID = $eventID;
        $this->eventName = $eventName;
        $this->eventDesc = $eventDesc;
        $this->eventCategory = $eventCategory;
        $this->image = $image;
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
