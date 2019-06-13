<?php
    $post = $params["post"];

    $likedPost = false;
    foreach ($post["likes"] as $like) {
        if ($like["author"]["id"] == $params["user"]["id"]) {
            $likedPost = true;
            break;
        }
    }

    $comments = array();
    foreach ($post["comments"] as $comment) {
        array_push($comments, array(
            "id" => $comment["id"],
            "userSentThis" => $comment["author"]["id"] == $params["user"]["id"],
            "timestampMs" => $comment["date_added"]->getTimestamp() * 1000,
            "timestamp" => $comment["timestamp"],
            "avatar" => $comment["author"]["avatar"],
            "user" => array(
                "profile" => $comment["author"]["profileURL"],
                "name" => $comment["author"]["name"]
            ),
            "body" => $comment["body"]
        ));
    }

    $data = array(
        "post" => array(
            "id" => $post["id"],
            "avatar" => $post["author"]["avatar"],
            "body" => $post["body"],
            "comments" => $comments,
            "userSentThis" => $post["author"]["id"] == $params["user"]["id"],
            "targetedMessage" => $post["author"]["id"] != $post["target"]["id"],
            "timestampMs" => $post["date_added"]->getTimestamp() * 1000,
            "timestamp" => $post["timestamp"],
            "likes" => count($post["likes"]),
            "likedPost" => $likedPost,
            "user" => array(
                "profile" => $post["author"]["profileURL"],
                "name" => $post["author"]["name"]
            ),
            "target" => array(
                "profile" => $post["target"]["profileURL"],
                "name" => $post["target"]["name"]
            ),
            "attachment" => $post["attachment"],
            "edited" => $post["edited"]
        ),
        "postCount" => $params["count"]
    );

    echo json_encode($data);
?>