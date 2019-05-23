<?php
    class Notifications extends Controller {

        public function index () {
            $this->view("notfound", array(
                "link" => $this->helper("URL")::create("feed"),
                "text" => "Back to your Feed"
            ));
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

                    $this->view("conversations/all", array(
                        "conversations" => $conversations
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