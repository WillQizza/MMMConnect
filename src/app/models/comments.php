<?php
    class Comments extends Model {
        public function getCommentsForPost ($id) {
            $comments = $this->query("SELECT * FROM comments WHERE post_id=:id", array(
                "id" => $id
            ));
            return $comments;
        }

        public function postComment ($userId, $data) {

        }
    }
?>