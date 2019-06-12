<?php
    class Settings extends Controller {
        public function index () {
            $userModel = $this->model("Users");
            if (isset($_SESSION["id"])) {
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {

                    $messages = $this->model("Messages")->getUnreadNotificationCount($user["id"]);
                    $notifications = $this->model("Notification")->getUnreadNotificationCount($user["id"]);
                    $friends = $this->model("FriendRequests")->getUnreadNotificationCount($user["id"]);

                    $this->view("settings/settings", array(
                        "notifications" => array(
                            "messages" => $messages,
                            "notifications" => $notifications,
                            "friends" => $friends
                        )
                    ));

                } else {
                    $this->redirect("logout");
                }

            } else {
                $this->redirect("register");
            }
        }

        public function personal () {
            $userModel = $this->model("Users");

            if (isset($_SESSION["id"])) {
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {
                    $errors = array(
                        "login" => false,
                        "emailExists" => false,
                        "emailDoesNotMatch" => false,
                        "firstNameNotLongEnough" => false,
                        "lastNameNotLongEnough" => false,
                        "passwordNotLongEnough" => false,
                        "passwordDoesNotMatch" => false,
                        "passwordEnglishOnly" => false,
                        "success" => false
                    );

                    if (isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["email"])) {
                        $firstName = strip_tags(ucfirst(strtolower(str_replace(" ", "", htmlspecialchars($_POST["firstName"])))));
                        $lastName = strip_tags(ucfirst(strtolower(str_replace(" ", "", htmlspecialchars($_POST["lastName"])))));
                        $email = strip_tags(strtolower(str_replace(" ", "", htmlspecialchars($_POST["email"]))));
                        if ($userModel->getUserByEmail($email) && $user["email"] != $email) {
                            $errors["emailExists"] = true;
                        } else if (strlen($firstName) > 25 || strlen($firstName) < 2) {
                            $errors["firstNameNotLongEnough"] = true;
                        } else if (strlen($lastName) > 25 || strlen($lastName) < 2) {
                            $errors["lastNameNotLongEnough"] = true;
                        } else {
                            // Success!
                            $errors["success"] = true;
                            $userModel->updateUser($user["id"], array(
                                "email" => $email,
                                "firstName" => $firstName,
                                "lastName" => $lastName
                            ));
                        }
                    }

                    $messages = $this->model("Messages")->getUnreadNotificationCount($user["id"]);
                    $notifications = $this->model("Notification")->getUnreadNotificationCount($user["id"]);
                    $friends = $this->model("FriendRequests")->getUnreadNotificationCount($user["id"]);

                    $this->view("settings/settings", array(
                        "notifications" => array(
                            "messages" => $messages,
                            "notifications" => $notifications,
                            "friends" => $friends
                        )
                    ));
                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }

        public function upload () {

            $userModel = $this->model("Users");

            if (isset($_SESSION["id"])) {
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {
                    
                    if (isset($_FILES["avatar"]) && isset($_POST["x"]) && isset($_POST["y"]) && isset($_POST["height"]) && isset($_POST["width"])) {
                        $data = $_FILES["avatar"];
                        $newPath = "assets/images/profile_pics/" . $user["username"] . "_avatar.png";

                        // Had to look online as gifs apparently had no type?....

                        if ($data["type"] == "image/jpeg") {
                            $image = imagecreatefromjpeg($data["tmp_name"]);
                        } else if ($data["type"] == "image/png") {
                            $image = imagecreatefrompng($data["tmp_name"]);
                        }
                        if (isset($image)) {
                            $image = imagecrop($image, array(
                                "x" => $_POST["x"],
                                "y" => $_POST["y"],
                                "width" => $_POST["width"],
                                "height" => $_POST["height"]
                            ));
                            if ($image) {
                                imagepng($image, $newPath);
                                $userModel->changeAvatar($user["id"], $newPath);
                                $this->redirect("profile/" . $user["username"]);
                            }
                            
                        }
                        
                    }
                    $messages = $this->model("Messages")->getUnreadNotificationCount($user["id"]);
                    $notifications = $this->model("Notification")->getUnreadNotificationCount($user["id"]);
                    $friends = $this->model("FriendRequests")->getUnreadNotificationCount($user["id"]);
                    $this->view("settings/upload", array(
                        "notifications" => array(
                            "messages" => $messages,
                            "notifications" => $notifications,
                            "friends" => $friends
                        )
                    ));

                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }
    }
?>