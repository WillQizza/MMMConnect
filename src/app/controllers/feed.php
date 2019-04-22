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
                    $this->view("feed/latest", array(
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

        public function profile () {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $postsModel = $this->model("Posts");
                $user = $userModel->getUserById($_SESSION["id"]);

                $page = 0;
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                }

                if ($user) {
                    if (isset($_GET["profile"])) {
                        $target = $userModel->getUserByUsername($_GET["profile"]);
                        if (isset($target)) {
                            $posts = $postsModel->getProfileFeedForUser($target["id"], $page);
                            $this->view("feed/latest", array(
                                "posts" => $posts,
                                "page" => count($postsModel->getProfileFeedForUser($target["id"], $page + 1)) > 0 ? $page + 1 : null
                            ));
                        } else {
                            $this->view("notfound", array(
                                "link" => $this->helper("URL")::create("feed"),
                                "text" => "Back to your Feed"
                            ));
                        }

                    } else {
                        $this->view("notfound", array(
                            "link" => $this->helper("URL")::create("feed"),
                            "text" => "Back to your Feed"
                        ));
                    }
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
                    if (isset($_POST["message"])) {
                        $post = $postsModel->postMessage($user["id"], array(
                            "body" => $_POST["message"]
                        ));
                        $this->view("feed/post", array(
                            "post" => $post,
                            "count" => $userModel->getUserById($_SESSION["id"])["posts"]
                        ));
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

        public function postcomment () {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $postsModel = $this->model("Posts");
                $commentsModel = $this->model("Comments");
                $user = $userModel->getUserById($_SESSION["id"]);
                if ($user) {
                    if (isset($_POST["message"]) && isset($_POST["id"])) {
                        $comment = $commentsModel->postComment($user["id"], array(
                            "body" => $_POST["message"],
                            "postId" => $_POST["id"]
                        ));
                        $this->view("feed/comment", array(
                            "comment" => $comment
                        ));
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

        public function deletepost () {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $postsModel = $this->model("Posts");
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {
                    if (isset($_POST["postId"])) {
                        $post = $postsModel->getPostById($_POST["postId"]);
                        if ($post) {
                            if ($post["author"]["id"] == $user["id"]) {
                                $postsModel->deletePostById($_POST["postId"]);
                            }
                        }
                    }
                    $this->redirect("feed");
                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }

        public function deletecomment () {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $commentsModel = $this->model("Comments");
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {
                    if (isset($_POST["commentId"])) {
                        $comment = $commentsModel->getCommentById($_POST["commentId"]);
                        if ($comment) {
                            if ($comment["author"]["id"] == $user["id"]) {
                                $commentsModel->deleteCommentById($_POST["commentId"]);
                            }
                        }
                    }
                    $this->redirect("feed");
                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }

        public function likecomment () {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $likesModel = $this->model("Likes");
                $postsModel = $this->model("Posts");
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {
                    if (isset($_POST["postId"])) {
                        if ($likesModel->hasLikedPost($user["id"], $_POST["postId"])) {
                            $likesModel->unlikePost($user["id"], $_POST["postId"]);
                        } else {
                            $likesModel->likePost($user["id"], $_POST["postId"]);
                        }
                        $this->view("feed/post", array(
                            "post" => $postsModel->getPostById($_POST["postId"])
                        ));
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

        public function editpost () {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $postsModel = $this->model("Posts");
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {
                    if (isset($_POST["postId"]) && isset($_POST["body"])) {
                        $post = $postsModel->getPostById($_POST["postId"]);
                        if (isset($post) && $post["author"]["id"] == $user["id"]) {
                            $postsModel->editMessage($_POST["postId"], $_POST["body"]);
                        }
                        $this->redirect("feed");
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