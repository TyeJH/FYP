<?php
include_once '../DataAccess/AdminDA.php';

class Admin {

    private $adminID;
    private $password;
    private $role;
    private $uniStaffID;

    public function __construct($adminID = "", $password = "", $role = "", $uniStaffID = "") {
        $this->adminID = $adminID;
        $this->password = $password;
        $this->role = $role;
        $this->uniStaffID = $uniStaffID;
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

    public function generateRandomId() {
        $newId = 'ADM' . rand(0, 99999);
        if ($this->isIdDuplicate($newId)) {
            $this->generateRandomId();
        } else {
            return $newId;
        }
    }

    public function isIdDuplicate($newId) {
        $ad = new AdminDA();
        return $ad->checkID($newId);
    }

}
