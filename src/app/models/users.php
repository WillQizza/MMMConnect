<?php
    class Users extends Model {
        public function getUserByEmail ($email) {
            $user = $this->query("SELECT * FROM users WHERE email=:email", array(
                "email" => $email
            ), false);
            return $user;
        }

        public function getUserByUsername ($username) {
            $user = $this->query("SELECT * FROM users WHERE username=:username", array(
                "username" => $username
            ), false);
            return $this->format($user);
        }

        public function getUserById ($id) {
            $user = $this->query("SELECT * FROM users WHERE id=:id", array(
                "id" => $id
            ), false);
            return $user;
        }

        public function isUserAuthenticated ($email, $password) {
            $user = $this->getUserByEmail($email);
            return $user && password_verify($password, $user["password"]);
        }

        public function generateUsername ($firstName, $lastName) {
            $username = $firstName . "_" . $lastName;
            $ogUsername = $username;
            $num = 1;
            while ($this->getUserByUsername($username)) {
                $username = $ogUsername . $num;
                $num++;
            }
            return $username;
        }

        public function createUser ($data) {
            $username = $data["username"];
            $firstName = $data["firstName"];
            $lastName = $data["lastName"];
            $email = $data["email"];
            $password = $data["password"];
            $avatar = $data["avatar"];
            $this->query("INSERT INTO users (first_name, last_name, username, email, password, profile_pic, signup_date, user_closed) VALUES (:fn, :ln, :u, :e, :p, :pp, :sud, :uc)", array(
                "fn" => $firstName,
                "ln" => $lastName,
                "u" => $username,
                "e" => $email,
                "p" => password_hash($password, PASSWORD_DEFAULT),
                "pp" => $avatar,
                "sud" => date("Y-m-d"),
                "uc" => false
            ));
        }

        protected function format ($data) {
            return array(
                "id" => $data["id"],
                "firstName" => $data["first_name"],
                "lastName" => $data["last_name"],
                "name" => $data["first_name"] . " " . $data["last_name"],
                "email" => $data["email"],
                "password" => $data["password"],
                "avatar" => $data["profile_pic"],
                "closed" => $data["user_closed"],
                "signUpDate" => $data["signup_date"],
                "likes" => $data["num_likes"],
                "posts" => $data["num_posts"],
                "profileURL" => "/profile/" . $data["username"]
            );
        }
    }
?>