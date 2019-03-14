<?php
    class Controller {

        private $database;

        public function __construct ($database) {
            $this->database = $database;
        }
        
        protected function view ($file, $params = array()) {
            $params["BASE"] = $this->url("");
            require_once(__DIR__ . "/../../app/views/" . strtolower($file) . ".php");
        }

        protected function model ($modelName) {
            require_once(__DIR__ . "/../../app/models/" . strtolower($modelName) . ".php");
            return new $modelName($this->database);
        }

        protected function helper ($helperName) {
            require_once(__DIR__ . "/../../app/helpers/" . strtolower($helperName) . ".php");
        }

        protected function url ($url) {
            $baseUrl = substr(str_replace("\\", "/", realpath(__DIR__ . "/../../../")), strlen($_SERVER["DOCUMENT_ROOT"]));
            return $baseUrl . "/" . $url;
        }

        protected function redirect ($url) {
            header("Location: ./$url");
        }

    }
?>