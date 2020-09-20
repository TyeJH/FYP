<?php

class EventOrganizer {
    
    private $eOrgID;
    private $name;
    private $desc;
    private $committee;
    private $societyID;

    public function __construct($eOrgID="", $name="", $desc="", $committee="", $societyID="") {
        $this->eOrgID = $eOrgID;
        $this->name = $name;
        $this->desc = $desc;
        $this->committee = $committee;
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
