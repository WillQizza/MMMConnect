<?php
    class Messages extends Model {
        public function postMessage ($id, $data) {
            $message = htmlspecialchars($data["message"]);
            $this->query("INSERT INTO messages (author, target, body, opened, viewed, deleted, date_added) VALUES (:a, :t, :b, :o, :v, :d, :da)", array(
                "a" => $id,
                "t" => $data["target"],
                "b" => $message,
                "o" => false,
                "v" => false,
                "d" => false,
                "da" => date("Y-m-d H:i:s")
            ));
        }

        public function getMessages ($id, $target) {
            $messages = $this->query("SELECT * FROM messages WHERE (author=:a AND target=:b) OR (author=:d AND target=:c) ORDER BY id ASC", array(
                "a" => $id,
                "b" => $target,
                "c" => $id,
                "d" => $target
            ));
            $this->query("UPDATE messages SET opened=1 WHERE author=:a AND target=:b", array(
                "a" => $target,
                "b" => $id
            ));
            return $messages;
        }

        public function getConversations ($id) {
            $userModel = $this->model("Users");
            $ids = array();
            $conversations = array();
            $messages = $this->query("SELECT * FROM messages WHERE author=:a OR target=:b", array(
                "a" => $id,
                "b" => $id
            ));
            foreach ($messages as $message) {
                if ($message["author"]["id"] == $id && !in_array($message["target"]["id"], $ids)) {
                    $messages = $this->getMessages($message["author"]["id"], $message["target"]["id"]);

                    array_push($ids, $message["target"]["id"]);
                    array_push($conversations, array(
                        "user" => $message["target"],
                        "message" => $messages[count($messages) - 1]
                    ));
                } else if ($message["target"]["id"] == $id && !in_array($message["author"]["id"], $ids)) {
                    $messages = $this->getMessages($message["target"]["id"], $message["author"]["id"]);

                    array_push($ids, $message["author"]["id"]);
                    array_push($conversations, array(
                        "user" => $message["author"],
                        "message" => $messages[count($messages) - 1]
                    ));
                }
            }
            return $conversations;
        }

        protected function format ($data) {
            $userModel = $this->model("Users");
            return array(
                "author" => $userModel->getUserById($data["author"]),
                "target" => $userModel->getUserById($data["target"]),
                "body" => $data["body"],
                "opened" => $data["opened"],
                "viewed" => $data["viewed"],
                "deleted" => $data["deleted"],
                "timestamp" => $this->helper("Timestamp")::get($data["date_added"])
            );
        }
    }
?>