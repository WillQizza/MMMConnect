<?php

    class Conversation extends Controller {
        public function index ($parts) {
            $messageModel = $this->model("Messages");
            $userModel = $this->model("Users");
            if (isset($_SESSION["id"])) {
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {

                    $messages = $messageModel->getUnreadNotificationCount($user["id"]);
                    $notifications = $this->model("Notification")->getUnreadNotificationCount($user["id"]);
                    $friends = $this->model("FriendRequests")->getUnreadNotificationCount($user["id"]);

                    if (isset($parts[0])) {
                        $target = $userModel->getUserByUsername($parts[0]);
                        if ($target) {
                            if ($userModel->isUserFriendsWith($user["id"], $target["id"])) {
                                $this->view("conversation", array(
                                    "target" => $target,
                                    "messages" => $messageModel->getMessages($user["id"], $target["id"]),
                                    "conversations" => $messageModel->getConversations($user["id"]),
                                    "notifications" => array(
                                        "messages" => $messages,
                                        "notifications" => $notifications,
                                        "friends" => $friends
                                    )
                                ));
                            } else {
                                $this->redirect("conversation");
                            }
                        } else {
                            $this->redirect("conversation");
                        }
                    } else {
                        $this->view("conversation-no-user", array(
                            "conversations" => $messageModel->getConversations($user["id"]),
                            "notifications" => array(
                                "messages" => $messages,
                                "notifications" => $notifications,
                                "friends" => $friends
                            )
                        ));
                    }
                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }

        public function suggestions () {
            $userModel = $this->model("Users");
            if (isset($_SESSION["id"])) {
                $user = $userModel->getUserById($_SESSION["id"]);
                if ($user) {
                    if (isset($_POST["query"])) {
                        $matching = array();
                        $mutual = array();
                        if ($_POST["query"] != "") {
                            $friends = $userModel->getFriends($user["id"]);
                            foreach ($friends as $friend) {
                                if (strpos(strtolower($friend["username"]), strtolower($_POST["query"])) > -1 || strpos(strtolower($friend["name"]), strtolower($_POST["query"])) > -1) {
                                    array_push($matching, $friend);
                                    $mutual[$friend["id"]] = count($userModel->getMutualFriends($friend["id"], $user["id"]));
                                }
                            }
                        }

                        
                        $this->view("conversation_suggestions", array(
                            "suggestions" => $matching,
                            "mutual" => $mutual
                        ));
                    } else {
                        $this->redirect("conversation");
                    }
                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }

        public function latest ($parts) {
            $userModel = $this->model("Users");
            $messageModel = $this->model("Messages");
            if (isset($_SESSION["id"])) {
                $user = $userModel->getUserById($_SESSION["id"]);
                if ($user) {
                    if (isset($parts[0]) && strlen($parts[0]) > 0) {
                        $target = $userModel->getUserByUsername($parts[0]);
                        if ($target) {
                            if ($userModel->isUserFriendsWith($user["id"], $target["id"]) || $user["id"] == $target["id"]) {

                                $lastId = 0;
                                if (isset($_GET["lastId"])) {
                                    $lastId = $_GET["lastId"];
                                }

                                $messages = $messageModel->getMessages($user["id"], $target["id"], $lastId);
                                $this->view("conversations/latest", array(
                                    "messages" => $messages,
                                    "target" => $target
                                ));

                            } else {
                                $this->redirect("conversation");
                            }
                        } else {
                            $this->redirect("conversation");
                        }
                    } else {
                        // Ok, they want all of our convos.
                        $this->view("conversations/all", array(
                            "conversations" => $messageModel->getConversations($user["id"])
                        ));
                    }
                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }

        public function post ($parts) {
            $userModel = $this->model("Users");
            $messageModel = $this->model("Messages");
            if (isset($_SESSION["id"])) {
                $user = $userModel->getUserById($_SESSION["id"]);
                if ($user) {
                    if (isset($parts[0])) {
                        $target = $userModel->getUserByUsername($parts[0]);
                        if ($target) {
                            if ($userModel->isUserFriendsWith($user["id"], $target["id"])) {
                                if (isset($_POST["message"])) {
                                    $message = $messageModel->postMessage($user["id"], array(
                                        "message" => $_POST["message"],
                                        "target" => $target["id"]
                                    ));
                                    $this->view("conversations/post", array(
                                        "message" => $message
                                    ));
                                } else {
                                    $this->redirect("conversation");
                                }
                            } else {
                                $this->redirect("conversation");
                            }
                        } else {
                            $this->redirect("conversation");
                        }
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