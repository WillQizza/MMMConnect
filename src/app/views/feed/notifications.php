<?php
    $data = array(
        "notifications" => array(),
        "unread" => $params["unread"]
    );

    foreach ($params["notifications"] as $notification) {
        array_push($data["notifications"], array(
            "message" => $notification["message"],
            "link" => $notification["link"],
            "user" => array(
                "avatar" => $notification["author"]["avatar"],
                "name" => $notification["author"]["name"],
                "username" => $notification["author"]["username"]
            ),
            "timestamp" => $notification["timestamp"],
            "timestampMs" => $notification["date_added"]->getTimestamp() * 1000,
            "opened" => $notification["opened"]
        ));
    }

    echo json_encode($data);
?>