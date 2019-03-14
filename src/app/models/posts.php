<?php
    class Posts extends Model {

        private static $POSTS_PER_PAGE = 10;

        public function getFeedForUser ($id, $page = 0) {
            $posts = $this->query("SELECT * FROM posts ORDER BY id DESC");
            $data = array_slice($posts, self::$POSTS_PER_PAGE * $page, self::$POSTS_PER_PAGE); 
            $feed = array();
            foreach ($data as $post) {
                if (!$post["deleted"]) {
                    array_push($feed, $post);
                }
            }
            return $feed;
        }

        protected function format ($data) {
            $userModel = $this->model("Users");
            $author = $userModel->getUserById($data["author"]);
            if ($data["author"] == $data["target"]) {
                $target = $author;
            } else {
                $target = $userModel->getUserById($data["target"]);
            }
            return array(
                "id" => $data["id"],
                "body" => $data["body"],
                "date_added" => $data["date_added"],
                "deleted" => $data["deleted"],
                "likes" => $data["likes"],
                "author" => $author,
                "target" => $target
            );
        }
    }
?>