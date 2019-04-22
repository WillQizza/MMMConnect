<?php
    $comment = $params["comment"];
    $data = array(
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
    );
    
    echo json_encode($data);
?>