<?php

class Helpers {

    private $eventID;
    private $userID;
    private $applyDate;
    private $applyStatus;

    public function __construct($eventID = "", $userID = "", $applyDate = "", $applyStatus = ""){
        $this->eventID = $eventID;
        $this->userID = $userID;
        $this->applyDate = $applyDate;
        $this->applyStatus = $applyStatus;
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
