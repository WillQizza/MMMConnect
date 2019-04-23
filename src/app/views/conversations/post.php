<?php
    $message = $params["message"];
    echo json_encode(array(
        "id" => $message["id"],
        "weSentThis" => $message["author"]["id"] == $params["user"]["id"],
        "body" => $message["body"],
        "timestamp" => $message["timestamp"]
    ));
?>