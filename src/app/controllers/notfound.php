<?php
    class NotFound extends Controller {
        public function index () {
            if (isset($_SESSION["id"])) {
                $this->view("NotFound", array(
                    "link" => $this->helper("URL")::create("feed"),
                    "text" => "Back to your Feed"
                ));
            } else {
                $this->view("NotFound", array(
                    "link" => $this->helper("URL")::create("register"),
                    "text" => "Login or Register"
                ));
            }
        }
    }
?>