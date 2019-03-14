<?php
    class NotFound extends Controller {
        public function index () {
            if (isset($_SESSION["id"])) {
                $this->view("NotFound", array(
                    "link" => $this->url("feed"),
                    "text" => "Back to your Feed"
                ));
            } else {
                $this->view("NotFound", array(
                    "link" => $this->url("register"),
                    "text" => "Login or Register"
                ));
            }
        }
    }
?>