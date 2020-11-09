<?php

class Validation {
    public function passwordIsValid($input) {
        $pattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/';
        if (preg_match($pattern, $input)) {
            return true;
        } else {
            return false;
        }
    }

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function securePassword($pass) {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public function comparePass($pass, $securePass) {
        if (password_verify($pass, $securePass)) {
            return true;
        } else {
            return true;
        }
    }
}
