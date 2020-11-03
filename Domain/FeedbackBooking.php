<?php

class FeedbackBooking {

    private $feedbackBookingID;
    private $content;
    private $adminID;
    private $bookingID;
    private $societyID;

    public function __construct($feedbackBookingID = "", $content = "", $adminID = "", $bookingID = "", $societyID = "") {
        $this->feedbackBookingID = $feedbackBookingID;
        $this->content = $content;
        $this->adminID = $adminID;
        $this->bookingID = $bookingID;
        $this->societyID = $societyID;
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
