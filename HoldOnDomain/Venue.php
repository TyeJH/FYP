<?php

class Venue {
    
    private $venueID;
    private $name;
    private $desc;
    private $status;
    private $location;
    
    public function __construct($venueID="", $name="", $desc="", $status="", $location="") {
        $this->venueID = $venueID;
        $this->name = $name;
        $this->desc = $desc;
        $this->status = $status;
        $this->location = $location;
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
