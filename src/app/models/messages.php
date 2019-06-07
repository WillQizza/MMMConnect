<?php
    class Messages extends Model {

        public static $CONVERSATIONS_PER_PAGE = 5;

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

            return $this->query("SELECT * FROM messages WHERE author=:a AND target=:t ORDER BY ID DESC LIMIT 1", array(
                "a" => $id,
                "t" => $data["target"]
            ), false);
        }

        public function getMessages ($id, $target, $lastId = 0, $opened = true) {
            $messages = $this->query("SELECT * FROM messages WHERE ((author=:a AND target=:b) OR (author=:d AND target=:c)) AND id > :l ORDER BY id ASC", array(
                "a" => $id,
                "b" => $target,
                "c" => $id,
                "d" => $target,
                "l" => $lastId
            ));
            $this->query("UPDATE messages SET opened=1 WHERE author=:a AND target=:b", array(
                "a" => $target,
                "b" => $id
            ));
            return $messages;
        }

        public function markRead ($id) {
            $this->query("UPDATE messages SET viewed=1 WHERE id=:id", array(
                "id" => $id
            ));
        }

        public function getNotifications ($id, $page = 0, $markRead = true) {
            $conversations = $this->getConversations($id, false);
            foreach ($conversations as $conversation) {
                if ($conversation["message"]["author"]["id"] != $id && !$conversation["message"]["viewed"] && $markRead) {
                    $this->markRead($conversation["message"]["id"]);
                }
            }
            if ($page == "all") {
                return $conversations;
            }
            return array_slice($conversations, self::$CONVERSATIONS_PER_PAGE * $page, self::$CONVERSATIONS_PER_PAGE);
        }

        public function getUnreadNotificationCount ($id) {
            $notifications = $this->getNotifications($id, "all", false);
            $count = 0;
            foreach ($notifications as $n) {
                if (!$n["viewed"] && $n["message"]["author"]["id"] != $id) {
                    $count++;
                }
            }
            return $count;
        }

        public function getConversations ($id, $markOpened = true) {
            $userModel = $this->model("Users");
            $ids = array();
            $conversations = array();
            $messages = $this->query("SELECT * FROM messages WHERE author=:a OR target=:b", array(
                "a" => $id,
                "b" => $id
            ));
            foreach ($messages as $message) {
                if ($message["author"]["id"] == $id && !in_array($message["target"]["id"], $ids) && $userModel->isUserFriendsWith($message["author"]["id"], $message["target"]["id"])) {
                    $messages = $this->getMessages($message["author"]["id"], $message["target"]["id"], 0, $markOpened);
                    array_push($ids, $message["target"]["id"]);
                    array_push($conversations, array(
                        "user" => $message["target"],
                        "message" => $messages[count($messages) - 1],
                        "viewed" => $messages[count($messages) - 1]["viewed"]
                    ));
                } else if ($message["target"]["id"] == $id && !in_array($message["author"]["id"], $ids) && $userModel->isUserFriendsWith($message["author"]["id"], $message["target"]["id"])) {
                    $messages = $this->getMessages($message["target"]["id"], $message["author"]["id"], 0, $markOpened);

                    array_push($ids, $message["author"]["id"]);
                    array_push($conversations, array(
                        "user" => $message["author"],
                        "message" => $messages[count($messages) - 1],
                        "viewed" => $messages[count($messages) - 1]["viewed"]
                    ));
                }
            }
            return $conversations;
        }

        protected function defaults () {
            return array(
                "id" => 0,
                "author" => 0,
                "target" => 0,
                "body" => "",
                "opened" => false,
                "viewed" => false,
                "deleted" => false,
                "date_added" => date("Y-m-d H:i:s")
            );
        }

        protected function format ($data) {
            $userModel = $this->model("Users");
            return array(
                "id" => $data["id"],
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