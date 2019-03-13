<?php
    class Model {

        protected $database;

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
                return $query->fetchAll();
            }
            return $query->fetch();
        }
    }
?>