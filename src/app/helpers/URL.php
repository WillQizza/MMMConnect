<?php
    class URL {
        public static function create ($path) {
            $baseUrl = substr(str_replace("\\", "/", realpath(__DIR__ . "/../../../")), strlen($_SERVER["DOCUMENT_ROOT"]));
            return $baseUrl . "/" . $path;
        }
    }
?>