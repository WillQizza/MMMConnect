<?php
    class Search extends Controller {
        public function index () {
            if (isset($_POST["query"]) && strlen($_POST["query"]) > 0) {
                // Get JSON data.
                $userModel = $this->model("Users");
                $users = $userModel->searchForUsers($_POST["query"]);
                
                $mutual = array();
                foreach ($users as $user) {
                    $mutual[$user["id"]] = 0;
                }

                // Too tired to change this to an api format. Soooo we're keeping it like this. lmao I'm so good at this. *cries*
                $this->view("conversation_suggestions", array(
                    "mutual" => $mutual,
                    "suggestions" => $users
                ));
            } else {
                // Search results.
            }
        }
    }
?>