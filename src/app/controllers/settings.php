<?php
    class Settings extends Controller {
        public function index () {
            $this->redirect("settings/upload");
        }

        public function upload () {

            $userModel = $this->model("Users");

            if (isset($_SESSION["id"])) {
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {
                    if (isset($_FILES["avatar"])) {
                        $data = $_FILES["avatar"];
                        $newPath = "assets/images/profile_pics/" . $user["username"] . "_avatar.png";
                        if ($data["type"] == "image/jpeg") {
                            $image = imagecreatefromjpeg($data["tmp_name"]);
                        } else if ($data["type"] == "image/png") {
                            $image = imagecreatefrompng($data["tmp_name"]);
                        } else if ($data["type"] == "image/gif") {
                            $image = imagecreatefromgif($data["tmp_name"]);
                        }
                        if (isset($image)) {
                            $image = imagecrop($image, array(
                                "x" => 0,
                                "y" => 0,
                                "width" => 128,
                                "height" => 128
                            ));
                            if ($image) {
                                imagepng($image, $newPath);
                                $userModel->changeAvatar($user["id"], $newPath);
                            }
                            
                        }
                        
                    }
                    $this->view("settings-avatar");
                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }
    }
?>