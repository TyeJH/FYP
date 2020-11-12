<?php

class Transaction {

    private $transID;
    private $transDate;
    private $amount;
    private $purpose;
    private $societyID;

    public function __construct($transID = "", $transDate = "", $amount = 0.00, $purpose = "", $societyID = "") {
        $this->transID = $transID;
        $this->transDate = $transDate;
        $this->amount = $amount;
        $this->purpose = $purpose;
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

    public function &__get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return false;
        }
    }

}
