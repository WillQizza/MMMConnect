<?php
    class Search extends Controller {
        public function index () {
            $userModel = $this->model("Users");
            $mutual = array();
            $suggestions = array();

            if (isset($_POST["query"]) && strlen($_POST["query"]) > 0) {
                // Get JSON data.
                $users = $userModel->searchForUsers($_POST["query"]);
                if (isset($_SESSION["id"])) {
                    $user = $userModel->getUserById($_SESSION["id"]);
                    if (isset($user)) {
                        foreach ($users as $u) {
                            if ($user["id"] != $u["id"]) {
                                $mutual[$u["id"]] = count($userModel->getMutualFriends($user["id"], $u["id"]));
                                array_push($suggestions, $u);
                            }
                        }
                    }
                }
    

                // Too tired to change this to an api format. Soooo we're keeping it like this. lmao I'm so good at this. *cries*
                $this->view("search-suggestions", array(
                    "mutual" => $mutual,
                    "suggestions" => $suggestions
                ));
            } else {
                // Search results.
                if (isset($_SESSION["id"])) {
                    $user = $userModel->getUserById($_SESSION["id"]);
                    if (isset($user)) {
                        $users = $userModel->searchForUsers($_GET["query"]);
                        $friendModel = $this->model("FriendRequests");
                        $statuses = array();

                        foreach ($users as $u) {
                            if ($user["id"] != $u["id"]) {
                                $mutual[$u["id"]] = count($userModel->getMutualFriends($user["id"], $u["id"]));
                                if ($friendModel->sentFriendRequestTo($user["id"], $u["id"])) {
                                    $statuses[$u["id"]] = 2;
                                } else if ($userModel->isUserFriendsWith($user["id"], $u["id"])) {
                                    $statuses[$u["id"]] = 1;
                                } else {
                                    $statuses[$u["id"]] = 0;
                                }
                                array_push($suggestions, $u);
                            }
                        }

                        $messages = $this->model("Messages")->getUnreadNotificationCount($user["id"]);
                        $notifications = $this->model("Notification")->getUnreadNotificationCount($user["id"]);
                        $friends = $this->model("FriendRequests")->getUnreadNotificationCount($user["id"]);
                        $this->view("search", array(
                            "notifications" => array(
                                "messages" => $messages,
                                "notifications" => $notifications,
                                "friends" => $friends
                            ),
                            "results" => $suggestions,
                            "mutual" => $mutual,
                            "friendStatus" => $statuses
                        ));
                    } else {
                        $this->redirect("logout");
                    }
                } else {
                    $this->redirect("register");
                }
            }
        }
    }
?>