<?php

class SessionManagement {

    public static function sessionStarted() {
        if (session_id() == '') {
            return false;
        } else {
            return true;
        }
    }

    public static function sessionExists($session) {
        if (self::sessionStarted() == false) {
            session_start();
        }
        if (isset($_SESSION[$session])) {
            return true;
        } else {
            return false;
        }
    }

    public static function setSession($session, $value) {
        if (self::sessionStarted() != true) {
            session_start();
        }
        $_SESSION[$session] = $value;
        if (self::sessionExists($session) == false) {
            throw new Exception('Unable to Create Session');
        }
    }

    public static function getSession($session) {
        if (self::sessionExists($session)==true) {
            return $_SESSION[$session];
        } else {
            throw new Exception('Session does not exist');
        }
    }

    public static function sessionClosed() {
        session_destroy();
    }

    public static function unsetSession($session) {
        if(self::sessionExists($session)==true){
            unset($_SESSION[$session]);
        }else{
            throw new Exception('Session does not exist');
        }
    }
}
