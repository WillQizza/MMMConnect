<?php
    class Controller {

        private $database;

        public function __construct ($database) {
            $this->database = $database;
        }
        
        protected function view ($file, $params = array()) {
            require_once(__DIR__ . "/../../app/views/" . strtolower($file) . ".php");
        }

        protected function model ($modelName) {
            require_once(__DIR__ . "/../../app/models/" . strtolower($modelName) . ".php");
            return new $modelName($this->database);
        }

    }
?>