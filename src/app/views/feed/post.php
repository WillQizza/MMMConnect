<?php
    $post = $params["post"];
    $data = array(
        "post" => array(
            "id" => $post["id"],
            "avatar" => $post["author"]["avatar"],
            "body" => $post["body"],
            "comments" => array(),
            "userSentThis" => $post["author"]["id"] == $params["user"]["id"],
            "targetedMessage" => $post["author"]["id"] != $post["target"]["id"],
            "timestampMs" => $post["date_added"]->getTimestamp() * 1000,
            "timestamp" => $post["timestamp"],
            "likes" => count($post["likes"]),
            "likedPost" => false,
            "user" => array(
                "profile" => $post["author"]["profileURL"],
                "name" => $post["author"]["name"]
            ),
            "target" => array(
                "profile" => $post["target"]["profileURL"],
                "name" => $post["target"]["name"]
            ),
            "edited" => $post["edited"]
        ),
        "postCount" => $params["count"]
    );

    echo json_encode($data);
?>