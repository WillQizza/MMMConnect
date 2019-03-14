<?php
    class Timestamp {
        public static function get ($date) {
            if (!isset($date)) {
                $date = date("Y-m-d H:i:s");
            }
            $prev = new DateTime($date);
            $now = new DateTime(date("Y-m-d H:i:s"));
            $diff = $now->diff($prev);
            if ($diff->y >= 1) {
                if ($diff->y == 1) {
                    return "1 year ago";
                } else {
                    return $diff->y . " years ago";
                }
            } else if ($diff->m >= 1) {
                $dayText = "";
                if ($diff->d == 1) {
                    $dayText = "& 1 day ago";
                } else if ($diff->d != 0) {
                    $dayText = $diff->d . "& days ago";
                }
                if ($diff->m == 1) {
                    return "1 month ago " . $dayText;
                } else {
                    return $diff->m . " months ago " . $dayText;
                }
            } else if ($diff->d >= 1) {
                if ($diff->d == 1) {
                    return "Yesterday";
                } else {
                    return $diff->d . " days ago";
                }
            } else if ($diff->h >= 1) {
                if ($diff->h == 1) {
                    return "1 hour ago";
                } else {
                    return $diff->h . " hours ago";
                }
            } else if ($diff->i >= 1) {
                if ($diff->i == 1) {
                    return "1 minute ago";
                } else {
                    return $diff->i . " minutes ago";
                }
            } else {
                if ($diff->s <= 30) {
                    return "Just now";
                } else {
                    return $diff->s . " seconds ago";
                }
            }
        }
    }
?>