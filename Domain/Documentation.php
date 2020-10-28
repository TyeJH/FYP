<?php

include_once '../DataAccess/AdminDA.php';

class Documentation {

    private $docID;
    private $docName;
    private $mime;
    private $docContent;
    private $applyDate;
    private $societyID;
    private $status;

    public function __construct($docID = "", $docName = "", $mime = "", $docContent = "", $applyDate = "", $societyID = "", $status = "") {
        $this->docID = $docID;
        $this->docName = $docName;
        $this->mime = $mime;
        $this->docContent = $docContent;
        $this->applyDate = $applyDate;
        $this->societyID = $societyID;
        $this->status = $status;
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
