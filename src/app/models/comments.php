<?php
    class Comments extends Model {
        public function getCommentsForPost ($id) {
            $comments = $this->query("SELECT * FROM comments WHERE post_id=:id", array(
                "id" => $id
            ));
            return $comments;
        }

        public function postComment ($userId, $data) {
            $userModel = $this->model("Users");
            if ($userModel->getUserById($userId)) {
                $this->query("INSERT INTO comments (post_body, author, date_added, deleted, post_id) VALUES (:pb, :a, :da, :d, :id)", array(
                    "pb" => htmlspecialchars($data["body"]),
                    "a" => $userId,
                    "da" => date("Y-m-d H:i:s"),
                    "d" => false,
                    "id" => $data["postId"]
                ));
                $comment = $this->query("SELECT * FROM comments WHERE author=:a ORDER BY id DESC LIMIT 1", array(
                    "a" => $userId
                ), false);
                return $comment;
            }
        }

        protected function format ($data) {
            $userModel = $this->model("Users");
            return array(
                "id" => $data["id"],
                "author" => $userModel->getUserById($data["author"]),
                "body" => $data["post_body"],
                "date_added" => new DateTime($data["date_added"]),
                "deleted" => $data["deleted"],
                "post_id" => $data["post_id"],
                "timestamp" => $this->helper("Timestamp")::get($data["date_added"])
            );
        }
    }
?>