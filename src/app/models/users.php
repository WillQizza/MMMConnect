<?php
    class Users extends Model {
        public function getUserByEmail ($email) {
            $user = $this->query("SELECT * FROM users WHERE email=:email", array(
                "email" => $email
            ), false);
            return $user;
        }

        public function isUserAuthenticated ($email, $password) {
            $user = $this->getUserByEmail($email);
            return $user && password_verify($password, $user["password"]);
        }
    }
?>