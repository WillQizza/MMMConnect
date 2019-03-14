<?php
    class Model {

        private $database;

        public function __construct ($database) {
            $this->database = $database;
        }

        protected function query ($statement, $params = array(), $fetchAll = true) {
            $query = $this->database->prepare($statement);
            foreach ($params as $param => &$paramValue) {
                $query->bindParam($param, $paramValue);
            }
            $query->execute();
            if ($fetchAll) {
                $results = $query->fetchAll();
                return array_map(function ($data) {
                    return $this->format($data);
                }, $results);
            }
            return $this->format($query->fetch());
        }

        protected function model ($modelName) {
            require_once(__DIR__ . "/../../app/models/" . strtolower($modelName) . ".php");
            return new $modelName($this->database);
        }

        protected function format ($data) {
            return $data;
        }
     }
?>