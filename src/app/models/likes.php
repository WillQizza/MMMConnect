<?php
    class Likes extends Model {
        public function getLikesForPost ($id) {
            $likes = $this->query("SELECT * FROM likes WHERE post_id=:id", array(
                "id" => $id
            ));
            return $likes;
        }

        public function likePost ($userId, $id) {
            if (!$this->hasLikedPost($userId, $id)) {
                $this->query("INSERT INTO likes (author, post_id) VALUES (:a, :pid)", array(
                    "a" => $userId,
                    "pid" => $id
                ));
            }
        }

        public function unlikePost ($userId, $id) {
            if ($this->hasLikedPost($userId, $id)) {
                $this->query("DELETE FROM likes WHERE author=:a AND post_id=:pid", array(
                    "a" => $userId,
                    "pid" => $id
                ));
            }
        }

        public function hasLikedPost ($userId, $id) {
            $likes = $this->getLikesForPost($id);
            foreach ($likes as $like) {
                if ($like["author"]["id"] == $userId && $like["post_id"] == $id) {
                    return true;
                }
            }
            return false;
        }

        protected function defaults () {
            return array(
                "id" => 0,
                "author" => 0,
                "post_id" => 0
            );
        }

        protected function format ($data) {
            $userModel = $this->model("Users");
            return array(
                "id" => $data["id"],
                "author" => $userModel->getUserById($data["author"]),
                "post_id" => $data["post_id"]
            );
        }
    }
?>