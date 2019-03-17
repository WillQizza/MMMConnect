<?php
    $content = "<article class=\"media\" data-timestamp=\"" . ($params["comment"]["date_added"]->getTimestamp() * 1000) . "\">
        <div class=\"media-left\">
            <img class=\"image is-64x64\" src=\"" . $params["comment"]["author"]["avatar"] ."\" />
        </div>
        <div class=\"media-content\">
        <div class=\"content\">
            <p>
                <a href=\"" . $params["comment"]["author"]["profileURL"] . "\">" . $params["comment"]["author"]["name"] . "</a> <i class=\"faded\">" . $params["comment"]["timestamp"] ."</i><br />
                " . $params["comment"]["body"] . "
            </p>
            </div>
        </div>
    </article>";
    echo json_encode(array(
        "content" => $content
    ));
?>