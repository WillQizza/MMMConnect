<?php
    class Likes extends Model {
        public function getLikesForPost ($id) {
            $likes = $this->query("SELECT * FROM likes WHERE post_id=:id", array(
                "id" => $id
            ));
            return $likes;
        }

        protected function format ($data) {
            $userModel = $this->model("Users");
            return array(
                "id" => $data["id"],
                "author" => $userModel->getUserById($data["id"]),
                "post_id" => $data["post_id"]
            );
        }
    }
?>