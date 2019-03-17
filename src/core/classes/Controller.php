<?php
    class Controller {

        private $database;

        public function __construct ($database) {
            $this->database = $database;
        }
        
        protected function view ($file, $params = array()) {
            $userModel = $this->model("Users");
            $params["BASE"] = $this->helper("URL")::create(""); // Technically the base controller class shouldn't do this.
            if (isset($_SESSION["id"])) {
                $params["user"] = $userModel->getUserById($_SESSION["id"]);
            }
            require_once(__DIR__ . "/../../app/views/" . strtolower($file) . ".php");
        }

        protected function model ($modelName) {
            require_once(__DIR__ . "/../../app/models/" . strtolower($modelName) . ".php");
            return new $modelName($this->database);
        }

        protected function helper ($helperName) {
            require_once(__DIR__ . "/../../app/helpers/" . strtolower($helperName) . ".php");
            return $helperName;
        }

        protected function redirect ($url) {
            header("Location: " . $this->helper("URL")::create($url));
        }

    }
?>