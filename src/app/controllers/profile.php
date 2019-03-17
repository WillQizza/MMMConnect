<?php
    class Profile extends Controller {
        public function index ($parts) {
            echo $parts[0];
            $this->view("profile");
        }
    }
?>