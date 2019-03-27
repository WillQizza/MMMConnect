<?php
    class Profile extends Controller {
        public function index ($parts) {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $friendRequestModel = $this->model("FriendRequests");
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {
                    if (isset($parts[0])) {
                        $target = $userModel->getUserByUsername($parts[0]);
                        if ($target) {
                            if (isset($parts[1])) {
                                // Adding user as a friend.
                                if ($parts[1] == "friend") {
                                    if (isset($_POST["friend"])) {
                                        if ($_POST["friend"] == "Cancel Friend Request") {
                                            $friendRequestModel->declineFriendRequest($user["id"], $target["id"]);
                                        } else if ($_POST["friend"] == "Add As Friend" && !$userModel->isUserFriendsWith($user["id"], $target["id"])) {
                                            $friendRequestModel->sendFriendRequest($user["id"], $target["id"]);
                                        } else if ($_POST["friend"] == "Remove Friend") {
                                            $userModel->removeFriend($target["id"], $user["id"]);
                                        }
                                    }
                                    $this->redirect("profile/" . $target["username"]);
                                } else {
                                    $this->view("notfound", array(
                                        "text" => "Go back to your Feed",
                                        "link" => $this->helper("URL")::create("feed")
                                    ));
                                }
                            } else {
                                // Viewing profile.
                                if ($target["closed"]) {
                                    $this->view("profile_closed");
                                } else {
                                    $this->view("profile", array(
                                        "target" => $target,
                                        "sentFriendRequest" => $friendRequestModel->sentFriendRequestTo($user["id"], $target["id"]),
                                        "isFriend" => $userModel->isUserFriendsWith($user["id"], $target["id"])
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