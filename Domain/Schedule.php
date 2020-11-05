<?php

class Schedule {

    private $scheduleID;
    private $venue;
    private $startDate;
    private $startTime;
    private $endDate;
    private $endTime;
    private $unlimited;
    private $noOfParticipant;
    private $noOfJoined;
    private $scheduleStatus;
    private $eventID;

    public function __construct($scheduleID = "", $venue = "", $startDate = "", $startTime = "", $endDate = "", $endTime = "", $unlimited = "", $noOfParticipant = "", $noOfJoined = "", $scheduleStatus = "", $eventID = "") {
        $this->scheduleID = $scheduleID;
        $this->venue = $venue;
        $this->startDate = $startDate;
        $this->startTime = $startTime;
        $this->endDate = $endDate;
        $this->endTime = $endTime;
        $this->unlimited = $unlimited;
        $this->noOfParticipant = $noOfParticipant;
        $this->noOfJoined = $noOfJoined;
        $this->scheduleStatus = $scheduleStatus;
        $this->eventID = $eventID;
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
