<?php
    $data = array(
        "convos" => array(),
        "unread" => $params["unread"]
    );

    foreach ($params["conversations"] as $convo) {
        array_push($data["convos"], array(
            "user" => array(
                "avatar" => $convo["user"]["avatar"],
                "name" => $convo["user"]["name"],
                "username" => $convo["user"]["username"]
            ),
            "message" => array(
                "id" => $convo["message"]["id"],
                "weSentThis" => $convo["message"]["author"]["id"] == $params["user"]["id"],
                "body" => $convo["message"]["body"],
                "timestamp" => $convo["message"]["timestamp"]
            ),
            "viewed" => $convo["viewed"],
            "timestampMs" => $convo["timestampMs"]
        ));
    }

    echo json_encode($data);
?>