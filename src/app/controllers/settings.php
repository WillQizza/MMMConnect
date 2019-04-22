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