<?php
    class Notification extends Model {

        public static $NOTIFICATIONS_PER_PAGE = 5;

        public function getNotifications ($id, $page = 0) {
            $results = $this->query("SELECT * FROM notifications WHERE target=:id", array(
                "id" => $id
            ));
            if ($page == "all") {
                return $results;
            }
            return array_slice($results, self::$NOTIFICATIONS_PER_PAGE * $page, self::$NOTIFICATIONS_PER_PAGE);
        }

        public function getUnreadNotificationCount ($id) {
            $notifications = $this->getNotifications($id, "all");
            $count = 0;
            foreach ($notifications as $n) {
                if (!$n["viewed"]) {
                    $count++;
                }
            }
            return $count;
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
            return array(
                "id" => 0,
                "author" => 0,
                "target" => 0,
                "message" => "",
                "link" => "",
                "date_added" => date("Y-m-d H:i:s"),
                "opened" => false,
                "viewed" => false
            );
        }

        protected function format ($data) {
            $userModel = $this->model("Users");
            return array(
                "id" => $data["id"],
                "author" => $userModel->getUserById($data["author"]),
                "target" => $userModel->getUserById($data["target"]),
                "message" => $data["message"],
                "link" => $data["link"],
                "timestamp" => $this->helper("Timestamp")::get($data["date_added"]),
                "opened" => $data["opened"],
                "viewed" => $data["viewed"]
            );
        }
    }
?>