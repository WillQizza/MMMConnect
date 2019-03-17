<?php
    class Posts extends Model {

        private static $POSTS_PER_PAGE = 10;

        public function getFeedForUser ($id, $page = 0) {
            $userModel = $this->model("Users");
            $posts = $this->query("SELECT * FROM posts ORDER BY id DESC");
            $data = array_slice($posts, self::$POSTS_PER_PAGE * $page, self::$POSTS_PER_PAGE); 
            $feed = array();
            foreach ($data as $post) {
                if (!$post["deleted"] && ($post["author"]["id"] == $id || $userModel->isUserFriendsWith($id, $post["author"]["id"]))) {
                    array_push($feed, $post);
                }
            }
            return $feed;
        }

        public function postMessage ($id, $data) {
            $body = $data["body"];
            $userModel = $this->model("Users");
            $author = $userModel->getUserById($id);
            if (isset($data["target"])) {
                $target = $userModel->getUserById($data["target"]);
            }
            if (!isset($target)) {
                $target = $author;
            }
            $this->query("INSERT INTO posts (body, author, target, date_added, deleted, likes) VALUES (:b, :a, :t, :da, :d, :l)", array(
                "b" => $body,
                "a" => $author["id"],
                "t" => $target["id"],
                "da" => date("Y-m-d H:i:s"),
                "d" => false,
                "l" => 0
            ));
            $post = $this->query("SELECT * FROM posts WHERE author=:a ORDER BY id DESC LIMIT 1", array(
                "a" => $author["id"]
            ), false);
            $userModel->setPosts($author["id"], $author["posts"] + 1);
            return $post;

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
                "target" => $target
            );
        }
    }
?>