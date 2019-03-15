<?php
    $content = "";
    foreach ($params["posts"] as $post) {
        if ($post["author"]["id"] != $post["target"]["id"]) {
            $targetText = "> <a href=\"" . $post["target"]["profileURL"] . "\">" . $post["target"]["name"] . "</a>";
        } else {
            $targetText = "";
        }
        $content .= "<article class=\"media\" data-timestamp=\"" . ($post["date_added"]->getTimestamp() * 1000) ."\" data-post=\"" . $post["id"] . "\">
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
                <div class=\"commentsContainer\">
                    <form action=\"" . $params["BASE"] . "feed/postcomment" . "\" method=\"POST\">
                        <textarea placeholder=\"What do you want to add?\" name=\"body\"></textarea>
                        <input type=\"submit\" name=\"submitComment\" value=\"Post\" />
                        <input type=\"hidden\" name=\"postId\" value=\"" . $post["id"] . "\" />
                    </form>
                </div>
            </div>
        </article>";
    }
    if (isset($params["page"])) {
        $content .= "<input type=\"hidden\" name=\"page\" value=\"" . $params["page"] ."\" />";
    }

    echo json_encode(array(
        "content" => $content
    ));
?>