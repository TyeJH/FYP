<?php

class EventNotification {
    
    private $notiID;
    private $notiName;
    private $notiContent;
    private $adminID;
    private $eOrgID;
    private $docID;
    
    public function __construct($notiID="", $notiName="", $notiContent="", $adminID="", $eOrgID="", $docID="") {
        $this->notiID = $notiID;
        $this->notiName = $notiName;
        $this->notiContent = $notiContent;
        $this->adminID = $adminID;
        $this->eOrgID = $eOrgID;
        $this->docID = $docID;
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
