<?php
    $content = "";
    foreach ($params["posts"] as $post) {
        if ($post["author"]["id"] != $post["target"]["id"]) {
            $targetText = "> <a href=\"" . $post["target"]["profileURL"] . "\">" . $post["target"]["name"] . "</a>";
        } else {
            $targetText = "";
        }

        $comments = "";
        foreach ($post["comments"] as $comment) {
            $comments .= "<article class=\"media\" data-timestamp=\"" . ($comment["date_added"]->getTimestamp() * 1000) . "\">
                <div class=\"media-left\">
                    <img class=\"image is-64x64\" src=\"" . $comment["author"]["avatar"] ."\" />
                </div>
                <div class=\"media-content\">
                <div class=\"content\">
                    <p>
                        <a href=\"" . $comment["author"]["profileURL"] . "\">" . $comment["author"]["name"] . "</a> <i class=\"faded\">" . $comment["timestamp"] ."</i><br />
                        " . $comment["body"] . "
                    </p>
                    </div>
                </div>
            </article>";
        }

        $likesText = "Like";
        foreach ($post["likes"] as $like) {
            if ($like["author"]["id"] == $params["user"]["id"]) {
                $likesText = "Unlike";
                break;
            }
        }

        $deleteText = "";
        if ($post["author"]["id"] == $params["user"]["id"]) {
            $deleteText = "<span class=\"is-pulled-right deletePost\"><a data-post=\"" . $post["id"] . "\" data-action=\"delete\"><i class=\"fa fa-trash\"></i></a></span>";
        }
    
        $content .= "<article class=\"media\" data-timestamp=\"" . ($post["date_added"]->getTimestamp() * 1000) ."\" data-post=\"" . $post["id"] . "\">
            <figure class=\"media-left\">
                <img class=\"image is-64x64\" src=\"" . $post["author"]["avatar"] ."\" />
            </figure>
            <div class=\"media-content\">
                <div class=\"content\">
                    $deleteText
                    <p>
                        <a href=\"" . $post["author"]["profileURL"] . "\">" . $post["author"]["name"] . "</a> $targetText <i class=\"faded\">" . $post["timestamp"] ."</i><br />
                        " . $post["body"] . "
                    </p>
                    <a data-post=\"" . $post["id"] . "\" data-action=\"comment\">Comments (" . count($post["comments"]) . ")</a> <a style=\"margin-left: 1em;\" data-post=\"" . $post["id"] . "\" data-action=\"like\">" . $likesText . " (" . count($post["likes"]) . ")</a>
                </div>
                <div class=\"commentsContainer\">
                    <span class=\"comments\">
                    $comments
                    </span>
                    <article class=\"media\">
                        <div class=\"media-content\">
                        <form class=\"commentForm\" action=\"" . $params["BASE"] . "feed/postcomment" . "\" method=\"POST\">
                            <textarea placeholder=\"What do you want to add?\" name=\"body\"></textarea>
                            <input type=\"submit\" value=\"Post\" />
                            <input type=\"hidden\" name=\"postId\" value=\"" . $post["id"] . "\" />
                        </form>
                        </div>
                    </article>
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