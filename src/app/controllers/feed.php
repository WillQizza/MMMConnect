<?php
    class Feed extends Controller {
        public function index ($args) {

            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $user = $userModel->getUserById($_SESSION["id"]);
                if ($user) {
                    $this->view("feed", array(
                        "user" => $user
                    ));
                } else {
                    $this->redirect("logout");
                }   
            } else {
                $this->redirect("register");
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
                        "posts" => $posts,
                        "page" => count($postsModel->getFeedForUser($user["id"], $page + 1)) > 0 ? $page + 1 : null
                    ));
                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }
        
        public function post () {
            if (isset($_SESSION["id"])) {

                $userModel = $this->model("Users");
                $postsModel = $this->model("Posts");
                $user = $userModel->getUserById($_SESSION["id"]);
                if ($user) {
                    if (isset($_POST["body"])) {
                        $post = $postsModel->postMessage($user["id"], array(
                            "body" => $_POST["body"]
                        ));
                        if (isset($_GET["json"])) {
                            $refetchedUser = $userModel->getUserById($_SESSION["id"]);
                            $this->view("feed_post", array(
                                "count" => $refetchedUser["posts"],
                                "post" => $post
                            ));
                        } else {
                            $this->redirect("feed");
                        }
                    } else {
                        $this->redirect("feed");
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