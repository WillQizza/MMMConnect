<?php
    class Requests extends Controller {
        public function index () {
            $friendRequestModel = $this->model("FriendRequests");
            $userModel = $this->model("Users");
            if (isset($_SESSION["id"])) {
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {

                    if (isset($_POST["action"]) && isset($_POST["id"])) {
                        $request = $friendRequestModel->getFriendRequestById($_POST["id"]);
                        if (isset($request)) {
                            if ($request["target"]["id"] == $user["id"]) {
                                if ($_POST["action"] == "Accept") {
                                    $friendRequestModel->acceptFriendRequest($request["author"]["id"], $user["id"]);
                                } else {
                                    $friendRequestModel->declineFriendRequest($request["author"]["id"], $user["id"]);
                                }
                                $friendRequestModel->declineFriendRequest($user["id"], $request["author"]["id"]);
                            }
                        }
                    }

                    $messages = $this->model("Messages")->getUnreadNotificationCount($user["id"]);
                    $notifications = $this->model("Notification")->getUnreadNotificationCount($user["id"]);
                    $friends = $friendRequestModel->getUnreadNotificationCount($user["id"]);

                    $this->view("requests", array(
                        "friendRequests" => $friendRequestModel->getFriendRequests($user["id"]),
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