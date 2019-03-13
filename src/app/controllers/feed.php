<?php
    class Feed extends Controller {
        public function index ($args) {

            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $user = $userModel->getUserById($_SESSION["id"]);
                if ($user) {
                    $this->view("feed", array(
                        "likes" => $user["num_likes"],
                        "posts" => $user["num_posts"],
                        "avatarURL" => $user["profile_pic"],
                        "profileURL" => "/profile/" . $user["username"] ,
                        "name" => $user["first_name"] . " " . $user["last_name"]
                    ));
                } else {
                    $this->redirect("/logout");
                }   
            } else {
                $this->redirect("/register");
            }
        }

        public function latest () {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $postsModel = $this->model("Posts");
                $user = $userModel->getUserById($_SESSION["id"]);

                $page = 0;
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                }

                if ($user) {
                    $posts = $postsModel->getFeedForUser($user["id"], $page);
                    $this->view("feed_latest", array(
                        "posts" => $posts
                    ));
                } else {
                    $this->redirect("/logout");
                }
            } else {
                $this->redirect("/register");
            }
        }
    }
?>