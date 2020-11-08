<?php

include_once '../DataAccess/StudentDA.php';

class Student {

    private $studID;
    private $username;
    private $password;
    private $studEmail;
    private $uniStudID;

    public function __construct($studID = "", $username ="", $password = "", $studEmail = "", $uniStudID = "") {
        $this->studID = $studID;
        $this->username = $username;
        $this->password = $password;
        $this->studEmail = $studEmail;
        $this->uniStudID = $uniStudID;
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
        $newId = 'STU' . rand(0, 99999);
        if ($this->isIdDuplicate($newId)) {
            $this->generateRandomId();
        } else {
            return $newId;
        }
    }

    public function isIdDuplicate($newId) {
        $sc = new StudentDA();
        return $sc->checkID($newId);
    }

}
