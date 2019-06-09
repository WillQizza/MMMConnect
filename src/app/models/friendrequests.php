<?php
    class FriendRequests extends Model {
        public function sendFriendRequest ($userId, $targetId) {
            if (!$this->sentFriendRequestTo($userId, $targetId)) {
                $this->query("INSERT INTO friend_requests (author, target) VALUES (:a, :t)", array(
                    "a" => $userId,
                    "t" => $targetId
                ));
            }
        }

        public function acceptFriendRequest ($userId, $targetId) {
            if ($this->sentFriendRequestTo($userId, $targetId)) {
                $userModel = $this->model("Users");
                
                $this->query("DELETE FROM friend_requests WHERE author=:a AND target=:t", array(
                    "a" => $userId,
                    "t" => $targetId
                ));

                $userModel->addFriend($targetId, $userId);
            }
        }

        public function declineFriendRequest ($userId, $targetId) {
            if ($this->sentFriendRequestTo($userId, $targetId)) {
                $this->query("DELETE FROM friend_requests WHERE author=:a AND target=:t", array(
                    "a" => $userId,
                    "t" => $targetId
                ));
            }
        }

        public function sentFriendRequestTo ($userId, $targetId) {
            $results = $this->query("SELECT * FROM friend_requests WHERE target=:t AND author=:a", array(
                "t" => $targetId,
                "a" => $userId
            ), false);
            return !!$results;
        }
 
        public function getFriendRequests ($userId) {
            $results = $this->query("SELECT * FROM friend_requests WHERE target=:a", array(
                "a" => $userId
            ));
            return $results;
        }

        public function getUnreadNotificationCount ($id) {
            $requests = $this->getFriendRequests($id);
            return count($requests);
        }

        public function getFriendRequestById ($id) {
            $result = $this->query("SELECT * FROM friend_requests WHERE id=:id", array(
                "id" => $id
            ), false);
            return $result;
        }

        protected function defaults () {
            return array(
                "target" => 0,
                "author" => 0,
                "id" => 0
            );
        }

        protected function format ($data) {
            $userModel = $this->model("Users");
            return array(
                "target" => $userModel->getUserById($data["target"]),
                "author" => $userModel->getUserById($data["author"]),
                "id" => $data["id"]
            );
        }

    }
?>