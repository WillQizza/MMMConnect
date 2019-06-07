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
            )
        ));
    }

    echo json_encode($data);
?>