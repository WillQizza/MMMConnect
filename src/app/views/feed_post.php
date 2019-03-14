<?php
    $content = "";
    $post = $params["post"];
    if ($post["author"]["id"] != $post["target"]["id"]) {
        $targetText = "> <a href=\"" . $post["target"]["profileURL"] . "\">" . $post["target"]["name"] . "</a>";
    } else {
        $targetText = "";
    }
    $content .= "<article class=\"media\">
        <figure class=\"media-left\">
            <img class=\"image is-64x64\" src=\"" . $post["author"]["avatar"] ."\" />
        </figure>
        <div class=\"media-content\">
            <div class=\"content\">
                <p>
                    <a href=\"" . $post["author"]["profileURL"] . "\">" . $post["author"]["name"] . "</a> $targetText <i class=\"faded\">" . $post["timestamp"] ."</i><br />
                    " . $post["body"] . "
                </p>
            </div>
        </div>
    </article>";

    echo json_encode(array(
        "content" => $content,
        "postCount" => $params["count"]
    ));
?>