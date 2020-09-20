<?php

class Documentation {
    
    private $docID;
    private $docName;
    private $docContent;
    private $eOrgID;
    private $eventID;
    
    public function __construct($docID="", $docName="", $docContent="", $eOrgID="", $eventID="") {
        $this->docID = $docID;
        $this->docName = $docName;
        $this->docContent = $docContent;
        $this->eOrgID = $eOrgID;
        $this->eventID = $eventID;
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
