<?php

    $messages = array();

    foreach ($params["messages"] as $message) {
        array_push($messages, array(
            "id" => $message["id"],
            "weSentThis" => $message["author"]["id"] == $params["user"]["id"],
            "body" => $message["body"],
            "timestamp" => $message["timestamp"]
        ));
    }

    echo json_encode(array(
        "messages" => $messages,
        "target" => array(
            "avatar" => $params["target"]["avatar"],
            "profile" => $params["target"]["profileURL"],
            "name" => $params["target"]["name"],
            "username" => $params["target"]["username"]
        )
    ));
?>