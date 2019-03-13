<?php
    class Posts extends Model {

        private static $POSTS_PER_PAGE = 10;

        public function getFeedForUser ($id, $page = 0) {
            $posts = $this->query("SELECT * FROM posts");
            $feed = array_slice($posts, self::$POSTS_PER_PAGE * $page, self::$POSTS_PER_PAGE); 
            return $feed;
        }
    }
?>