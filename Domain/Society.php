<?php
include_once '../DataAccess/SocietyDA.php';

class Society {

    private $societyID;
    private $societyName;
    private $societyDesc;
    private $societyPass;

    public function __construct($societyID = "", $societyName = "", $societyDesc = "", $societyPass = "") {
        $this->societyID = $societyID;
        $this->societyName = $societyName;
        $this->societyDesc = $societyDesc;
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

    public function &__get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return false;
        }
    }
    
    public function generateRandomId() {
        $newId = 'SOC' . rand(0, 99999);
        if ($this->isIdDuplicate($newId)) {
            $this->generateRandomId();
        } else {
            return $newId;
        }
    }

    public function isIdDuplicate($newId) {
        $sc = new SocietyDA();
        return $sc->checkID($newId);
    }
}
