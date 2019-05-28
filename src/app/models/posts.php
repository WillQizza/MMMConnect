<?php
    class Posts extends Model {

        private static $POSTS_PER_PAGE = 10;

        public function getFeedForUser ($id, $page = 0) {
            $userModel = $this->model("Users");
            $posts = $this->query("SELECT * FROM posts ORDER BY id DESC");
            $feed = array();
            foreach ($posts as $post) {
                if (!$post["deleted"] && ($post["author"]["id"] == $id || $userModel->isUserFriendsWith($id, $post["author"]["id"]))) {
                    array_push($feed, $post);
                }
            }
            return array_slice($feed, self::$POSTS_PER_PAGE * $page, self::$POSTS_PER_PAGE);
        }

        public function getProfileFeedForUser ($id, $page = 0) {
            $posts = $this->query("SELECT * FROM posts WHERE author=:a OR target=:t ORDER BY id DESC", array(
                "a" => $id,
                "t" => $id
            ));
            $data = array_slice($posts, self::$POSTS_PER_PAGE * $page, self::$POSTS_PER_PAGE); 
            $feed = array();
            foreach ($data as $post) {
                if (!$post["deleted"]) {
                    array_push($feed, $post);
                }
            }
            return $feed;
        }

        public function getPostById ($id) {
            return $this->query("SELECT * FROM POSTS WHERE id=:id", array(
                "id" => $id
            ), false);
        }

        public function postMessage ($id, $data) {
            $body = htmlspecialchars($data["body"]);
            $userModel = $this->model("Users");
            $author = $userModel->getUserById($id);
            if (isset($data["target"])) {
                $target = $userModel->getUserById($data["target"]);
            }
            if (!isset($target)) {
                $target = $author;
            }
            $this->query("INSERT INTO posts (body, author, target, date_added, deleted, likes, edited) VALUES (:b, :a, :t, :da, :d, :l, :e)", array(
                "b" => $body,
                "a" => $author["id"],
                "t" => $target["id"],
                "da" => date("Y-m-d H:i:s"),
                "d" => false,
                "l" => 0,
                "e" => false
            ));
            $post = $this->query("SELECT * FROM posts WHERE author=:a ORDER BY id DESC LIMIT 1", array(
                "a" => $author["id"]
            ), false);

            if ($data["target"] != $id) {
                $nModel = $this->model("Notifications");
                $nModel->addNotification($id, $data["target"], $post["id"], "profilePost");
            }

            $userModel->setPosts($author["id"], $author["posts"] + 1);
            return $post;

        }

        public function editMessage ($id, $newMessage) {
            $message = htmlspecialchars($newMessage);
            $this->query("UPDATE posts SET body=:m, edited=:edited WHERE id=:id", array(
                "id" => $id,
                "m" => $message,
                "edited" => true
            ));
        }

        public function deletePostById ($id) {
            $post = $this->getPostById($id);
            if ($post) {

                $this->model("Users")->setPosts($post["author"]["id"], $post["author"]["posts"] - 1);

                $this->query("UPDATE posts SET deleted=1 WHERE id=:id", array(
                    "id" => $id
                ));
    
                $this->model("Comments")->deleteCommentsForPost($id);

            }
        }

        protected function defaults () {
            return array(
                "id" => 0,
                "body" => 0,
                "date_added" => date("Y-m-d H:i:s"),
                "deleted" => false,
                "edited" => false
            );
        }

        protected function format ($data) {
            $userModel = $this->model("Users");
            $likesModel = $this->model("Likes");
            $author = $userModel->getUserById($data["author"]);
            if ($data["author"] == $data["target"]) {
                $target = $author;
            } else {
                $target = $userModel->getUserById($data["target"]);
            }

            return array(
                "id" => $data["id"],
                "body" => $data["body"],
                "date_added" => new DateTime($data["date_added"]),
                "timestamp" => $this->helper("Timestamp")::get($data["date_added"]),
                "deleted" => $data["deleted"],
                "likes" => $likesModel->getLikesForPost($data["id"]),
                "comments" => $this->model("Comments")->getCommentsForPost($data["id"]),
                "author" => $author,
                "target" => $target,
                "edited" => $data["edited"]
            );
        }
    }
?>