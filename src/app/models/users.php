<?php
    class Users extends Model {
        public function getUserByEmail ($email) {
            $user = $this->query("SELECT * FROM users WHERE email=:email", array(
                "email" => strtolower($email)
            ), false);
            return $user;
        }

        public function getUserByUsername ($username) {
            $user = $this->query("SELECT * FROM users WHERE username=:username", array(
                "username" => strtolower($username)
            ), false);
            return $user;
        }

        public function getUserById ($id) {
            $user = $this->query("SELECT * FROM users WHERE id=:id", array(
                "id" => $id
            ), false);
            return $user;
        }

        public function isUserAuthenticated ($identifier, $password) {
            $user = $this->getUserByEmail($identifier);
            if (!$user) {
                $user = $this->getUserByUsername($identifier);
            }
            if ($user && password_verify($password, $user["password"])) {
                return $user;
            }
            return false;
        }

        public function openAccount ($id) {
            $user = $this->getUserById($id);
            if ($user["closed"]) {
                $this->query("UPDATE users SET user_closed=:uc WHERE id=:id", array(
                    "id" => $id,
                    "uc" => 0
                ));
            }
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
                "u" => strtolower($username),
                "e" => strtolower($email),
                "p" => password_hash($password, PASSWORD_DEFAULT),
                "pp" => $avatar,
                "sud" => date("Y-m-d"),
                "uc" => false
            ));
        }

        public function isUserFriendsWith ($id, $checkId) {
            $user = $this->query("SELECT friend_array FROM users WHERE id=:id", array(
                "id" => $id
            ), false);
            
            return in_array($checkId, $user["friendIds"]);
        }

        public function updateUser ($id, $data) {
            $this->query("UPDATE users SET first_name=:fn, last_name=:ln, email=:email WHERE id=:id", array(
                "fn" => $data["firstName"],
                "ln" => $data["lastName"],
                "email" => $data["email"],
                "id" => $id
            ));
        }

        public function changePassword ($id, $newPassword) {
            $this->query("UPDATE users SET password=:p WHERE id=:id", array(
                "p" => password_hash($newPassword, PASSWORD_DEFAULT),
                "id" => $id
            ));
        }

        public function addFriend ($id, $friendId) {
            if (!$this->isUserFriendsWith($id, $friendId)) {
                $user = $this->getUserById($id);
                $friend = $this->getUserById($friendId);
                $userFriends = $user["friendIds"];
                $friendFriends = $friend["friendIds"];
                array_push($userFriends, $friend["id"]);
                array_push($friendFriends, $user["id"]);
                $userFriends = implode(",", $userFriends);
                $friendFriends = implode(",", $friendFriends);
                $this->query("UPDATE users SET friend_array=:fa WHERE id=:a", array(
                    "fa" => $userFriends,
                    "a" => $user["id"]
                ));
                $this->query("UPDATE users SET friend_array=:fa WHERE id=:a", array(
                    "fa" => $friendFriends,
                    "a" => $friend["id"]
                ));
            }
        }

        public function removeFriend ($id, $friendId) {
            if ($this->isUserFriendsWith($id, $friendId)) {
                $user = $this->getUserById($id);
                $friend = $this->getUserById($friendId);
                $userFriends = $user["friendIds"];
                $friendFriends = $friend["friendIds"];
                array_splice($userFriends, array_search($friend["id"], $userFriends), 1);
                array_splice($friendFriends, array_search($user["id"], $friendFriends), 1);
                $userFriends = implode(",", $userFriends);
                $friendFriends = implode(",", $friendFriends);
                $this->query("UPDATE users SET friend_array=:fa WHERE id=:a", array(
                    "fa" => $userFriends,
                    "a" => $user["id"]
                ));
                $this->query("UPDATE users SET friend_array=:fa WHERE id=:a", array(
                    "fa" => $friendFriends,
                    "a" => $friend["id"]
                ));
            }
        }

        public function getFriends ($id) {
            $user = $this->getUserById($id);
            $friends = array();
            foreach ($user["friendIds"] as $fId) {
                if ($id != "") {
                    array_push($friends, $this->getUserById($fId));
                }
            }
            return $friends;
        }

        public function getMutualFriends ($id, $targetId) {
            $user = $this->getUserById($id);
            $target = $this->getUserById($targetId);

            $friends = array();
            foreach ($user["friendIds"] as $id) {
                if ($id != "" && in_array($id, $target["friendIds"])) {
                    array_push($friends, $this->getUserById($id));
                }
            }
            return $friends;

        }

        public function setPosts ($id, $posts) {
            $this->query("UPDATE users SET num_posts=:p WHERE id=:id", array(
                "p" => $posts,
                "id" => $id
            ));
        }

        public function changeAvatar ($id, $url) {
            $this->query("UPDATE users SET profile_pic=:pp WHERE id=:id", array(
                "pp" => $url,
                "id" => $id
            ));
        }

        public function searchForUsers ($query) {
            $parts = explode(" ", $query);
            $firstName = $query;
            $lastName = $query;
            if (count($parts) == 1) {
                $firstName = $parts[0];
                $users = $this->query("SELECT * FROM users WHERE ((username LIKE :u) OR (username LIKE :uu) OR (first_name LIKE :fn OR last_name LIKE :ln)) AND user_closed=0 LIMIT 8", array(
                    "u" => "$query%",
                    "uu" => "%$query%",
                    "fn" => "$firstName%",
                    "ln" => "$firstName%"
                ));
            } else {
                if (count($parts) == 2) {
                    $firstName = $parts[0];
                    $lastName = $parts[1];
                }
                $users = $this->query("SELECT * FROM users WHERE ((username LIKE :u) OR (username LIKE :uu) OR (first_name LIKE :fn AND last_name LIKE :ln)) AND user_closed=0 LIMIT 8", array(
                    "u" => "$query%",
                    "uu" => "%$query%",
                    "fn" => "$firstName%",
                    "ln" => "$lastName%"
                ));
            }
            return $users;
        }

        public function closeAccount ($id) {
            $this->query("UPDATE users SET user_closed=1 WHERE id=:id", array(
                "id" => $id
            ));
        }

        protected function defaults () {
            return array(
                "id" => 0,
                "first_name" => "",
                "last_name" => "",
                "username" => "",
                "email" => "",
                "password" => "",
                "profile_pic" => "",
                "user_closed" => false,
                "signup_date" => date("Y-m-d"),
                "num_likes" => 0,
                "num_posts" => 0,
                "friend_array" => ","
            );
        }

        protected function format ($data) {
            return array(
                "id" => $data["id"],
                "firstName" => $data["first_name"],
                "lastName" => $data["last_name"],
                "name" => $data["first_name"] . " " . $data["last_name"],
                "username" => $data["username"],
                "email" => $data["email"],
                "password" => $data["password"],
                "avatar" => $this->helper("URL")::create($data["profile_pic"]),
                "closed" => $data["user_closed"],
                "signUpDate" => $data["signup_date"],
                "likes" => $data["num_likes"],
                "posts" => $data["num_posts"],
                "profileURL" => $this->helper("URL")::create("profile/" . $data["username"]),
                "friendIds" => explode(",", $data["friend_array"])
            );
        }
    }
?>