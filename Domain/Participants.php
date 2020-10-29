<?php

class Participants {

    private $scheduleID;
    private $userID;
    private $applyDate;
    private $applyStatus;
    private $attendanceStatus;

    public function __construct($scheduleID = "", $userID = "", $applyDate = "", $applyStatus = "", $attendanceStatus = "") {
        $this->scheduleID = $scheduleID;
        $this->userID = $userID;
        $this->applyDate = $applyDate;
        $this->applyStatus = $applyStatus;
        $this->attendanceStatus = $attendanceStatus;
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

}
