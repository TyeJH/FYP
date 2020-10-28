<?php

class Admin {

    private $adminID;
    private $password;


    public function __construct($adminID = "", $password = "") {
        $this->adminID = $adminID;
        $this->password = $password;
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
