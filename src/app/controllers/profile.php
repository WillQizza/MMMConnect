<?php
    class Profile extends Controller {
        public function index ($parts) {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $user = $userModel->getUserById($_SESSION["id"]);
                if ($user) {
                    if (isset($parts[0])) {
                        $target = $userModel->getUserByUsername($parts[0]);
                        if ($target) {
                            if (isset($parts[1])) {
                                // Adding user as a friend.
                                
                            } else {
                                // Viewing profile.
                                if ($target["closed"]) {
                                    $this->view("profile_closed");
                                } else {
                                    $this->view("profile", array(
                                        "target" => $target
                                    ));
                                }
                            }
                        } else {
                            $this->view("notfound", array(
                                "text" => "Go back to your Feed",
                                "link" => $this->helper("URL")::create("feed")
                            ));
                        }
                    } else {
                        $this->redirect("profile/" . $user["username"]);
                    }
                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }
    }
?>