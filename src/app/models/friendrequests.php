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

                $userModel->addFriend($userId, $targetId);
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
    }
?>