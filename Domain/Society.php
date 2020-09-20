<?php

class Society {

    private $societyID;
    private $societyName;
    private $societyDesc;
    private $societyMember;
    private $societyPass;

    public function __construct($societyID = "", $societyName = "", $societyDesc = "", $societyMember = "", $societyPass = "") {
        $this->societyID = $societyID;
        $this->societyName = $societyName;
        $this->societyDesc = $societyDesc;
        $this->societyMember = $societyMember;
        $this->societyPass = $societyPass;
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
