<?php
    class App {

        private $databaseName;
        private $databaseUsername;
        private $databasePassword;

        public function __construct ($databaseName, $username, $password) {
            spl_autoload_register(function ($class) {
                require_once(__DIR__ . "/classes/" . $class . ".php");
            });
            $this->databaseName = $databaseName;
            $this->databaseUsername = $username;
            $this->databasePassword = $password;
        }

        /**
         * Starts the app routing.
         */
        public function start () {

            $database = new PDO("mysql:host=localhost;dbname=" . $this->databaseName, $this->databaseUsername, $this->databasePassword);
            $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


            if (!isset($_GET["_path"])) {
                $path = "feed";
            } else {
                $path = strtolower($_GET["_path"]);
            }
            if (strlen($path) == 0 || $path == "/") {
                $path = "feed"; // Default.
            }
            $parts = explode("/", $path);
            $className = strtoupper($parts[0][0]) . substr($parts[0], 1);
            if (!file_exists(__DIR__ . "/../" . "app/controllers/" . strtolower($className) . ".php")) {
                $className = "NotFound"; // Default.
            }
            require_once(__DIR__ . "/../" . "app/controllers/" . strtolower($className) . ".php");
            $parts = array_slice($parts, 1);
            if (count($parts) == 0) {
                array_push($parts, "index");
            }

            $action = $parts[0];
            if (!$action) {
                $action = "index";
            }
            $args = array_slice($parts, 1);
                     
            $controller = new $className($database);
            if (!method_exists($controller, $action)) {
                $action = "index";
            }
            session_start();
            ob_start();
            $controller->$action($args);
            
        }
    }
?>