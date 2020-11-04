<?php

class FeedbackDocument {

    private $feedbackDocumentID;
    private $content;
    private $adminID;
    private $docID;
    private $societyID;

    public function __construct($feedbackBookingID = "", $content = "", $adminID = "", $docID = "", $societyID = "") {
        $this->feedbackDocumentID = $feedbackBookingID;
        $this->content = $content;
        $this->adminID = $adminID;
        $this->docID = $docID;
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
