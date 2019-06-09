<?php
    class Comments extends Model {
        public function getCommentsForPost ($id) {
            $comments = $this->query("SELECT * FROM comments WHERE post_id=:id AND deleted=0 ORDER by date_added ASC", array(
                "id" => $id
            ));
            return $comments;
        }

        public function deleteCommentsForPost ($id) {
            $this->query("UPDATE comments SET deleted=1 WHERE post_id=:id", array(
                "id" => $id
            ));
        }

        public function deleteCommentById ($id) {
            $this->query("UPDATE comments SET deleted=1 WHERE id=:id", array(
                "id" => $id
            ));
        }

        public function getCommentById ($id) {
            $comment = $this->query("SELECT * FROM comments WHERE id=:id", array(
                "id" => $id
            ), false);
            return $comment;
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

                $comments = $this->getCommentsForPost($data["postId"]);
                $post = $this->model("Posts")->getPostById($data["postId"]);
                $nModel = $this->model("Notification");

                $notifyUsers = array();
                

                foreach ($comments as $postedComment) {
                    // We are not the person who posted the comment and we aren't the person who posted this post.
                    if ($postedComment["author"]["id"] != $userId && $post["author"]["id"] != $postedComment["author"]["id"]) {
                        if (!in_array($postedComment["author"]["id"], $notifyUsers)) {
                            array_push($notifyUsers, $postedComment["author"]["id"]);
                            $nModel->addNotification($userId, $postedComment["author"]["id"], $data["postId"], "commentComment");
                        }
                    }
                }

                
                if ($userId != $post["author"]["id"]) {
                    if ($post["author"]["id"] == $post["target"]["id"]) {
                        $nModel->addNotification($userId, $post["author"]["id"], $data["postId"], "comment");
                    } else {
                        $nModel->addNotification($userId, $post["author"]["id"], $data["postId"], "profileComment");
                    }
                }

                return $comment;
            }
        }

        protected function defaults () {
            return array(
                "id" => 0,
                "author" => 0,
                "post_body" => "",
                "date_added" => date("Y-m-d H:i:s"),
                "deleted" => false,
                "post_id" => false
            );
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