<?php
    abstract class Model {

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
            $results = $query->fetch();
            if ($results) {
                return $this->format(array_merge($this->defaults(), $results));
            } else {
                return false;
            }
        }

        protected function model ($modelName) {
            require_once(__DIR__ . "/../../app/models/" . strtolower($modelName) . ".php");
            return new $modelName($this->database);
        }

        protected function helper ($helperName) {
            require_once(__DIR__ . "/../../app/helpers/" . strtolower($helperName) . ".php");
            return $helperName;
        }
        
        protected abstract function format($data);
        protected abstract function defaults();
     }
?>