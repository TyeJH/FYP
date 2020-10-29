<?php
include_once '../DataAccess/AnnounceDA.php';

class Announcement {

    private $annID;
    private $annTitle;
    private $annContent;
    private $annDate;
    private $adminID;

    public function __construct($annID = "", $annTitle = "", $annContent = "", $annDate = "", $adminID = "") {
        $this->annID = $annID;
        $this->annTitle = $annTitle;
        $this->annContent = $annContent;
        $this->annDate = $annDate;
        $this->adminID = $adminID;
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
        $newId = 'ANN' . rand(0, 99999);
        if ($this->isIdDuplicate($newId)) {
            $this->generateRandomId();
        } else {
            return $newId;
        }
    }

    public function isIdDuplicate($newId) {
        $ann = new AnnounceDA();
        return $ann->checkID($newId);
    }
}
