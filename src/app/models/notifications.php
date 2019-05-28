<?php
    class Notifications extends Model {
        public function getNotifications ($id) {
            
        }

        public function addNotification ($id, $targetId, $pId, $type) {
            
            $userModel = $this->model("Users");

            $author = $userModel->getUserById($id);
            $target = $userModel->getUserById($targetId);

            switch ($type) {
                case "comment":
                    $message = $author["name"] . " commented on your post";
                break;
                case "like":
                    $message = $author["name"] . " liked a post you posted";
                break;
                case "profilePost":
                    $message = $author["name"] . " posted on your profile";
                break;
                case "commentComment":
                    $message = $author["name"] . " commented on a post you commented on";
                break;
                case "profileComment":
                    $message = $author["name"] . " commented on your profile post";
                break;
            }

            $link = $this->helper("URL")::create("notifications/post?id=" . $pId);

            $this->query("INSERT INTO notifications (author, target, message, link, date_added, opened, viewed) VALUES (:id, :tId, :m, :l, :da, :o, :v)", array(
                "id" => $id,
                "tId" => $targetId,
                "m" => $message,
                "l" => $link,
                "da" => date("Y-m-d H:i:s"),
                "o" => false,
                "v" => false
            ));
        }

        protected function defaults () {
            return array();
        }

        protected function format ($data) {
            $userModel = $this->model("Users");
            return array(
                
            );
        }
    }
?>