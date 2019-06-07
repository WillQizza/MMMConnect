<?php
    class Notifications extends Controller {

        public function index () {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $notificationModel = $this->model("Notification");
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {
                    $page = 0;
                    if (isset($_GET["page"])) {
                        $page = $_GET["page"];
                    }
                    $notifications = $notificationModel->getNotifications($user["id"], $page);
                    $unread = $notificationModel->getUnreadNotificationCount($user["id"]);

                    $this->view("feed/notifications", array(
                        "notifications" => $notifications,
                        "unread" => $unread
                    ));
                } else {
                    $this->redirect("logout");
                }
            } else {
                $this->redirect("register");
            }
        }


        public function messages () {
            if (isset($_SESSION["id"])) {
                $userModel = $this->model("Users");
                $messagesModel = $this->model("Messages");
                $user = $userModel->getUserById($_SESSION["id"]);
                if (isset($user)) {
                    $page = 0;
                    if (isset($_GET["page"])) {
                        $page = $_GET["page"];
                    }
                    $conversations = $messagesModel->getNotifications($user["id"], $page);
                    $unread = $messagesModel->getUnreadNotificationCount($user["id"]);

                    $this->view("conversations/notifications", array(
                        "conversations" => $conversations,
                        "unread" => $unread
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