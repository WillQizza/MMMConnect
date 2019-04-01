<?php
    $content = "";

    foreach ($params["suggestions"] as $friend) {
        if ($params["mutual"][$friend["id"]] == 1) {
            $mutualText = "1 friend in common";
        } else {
            $mutualText = $params["mutual"][$friend["id"]] . " friends in common";
        }
        $content .= "<a href=\"" . $params["BASE"] . "conversation/" . $friend["username"] . "\"><article class=\"media\">
            <figure class=\"media-left\">
                <p class=\"image is-64x64\">
                    <img src=\"" . $friend["avatar"] . "\" />
                </p>
            </figure>
            <div class=\"media-content\">
                <div class=\"content\">
                    <span class=\"is-size-6 suggestion-name\" href=\"\">" . $friend["name"] . "</span><br />
                    <span class=\"is-size-7 suggestion-name\">" . $friend["username"] . "</span><br />
                    <span class=\"is-size-7 suggestion-mutual-count\">$mutualText</span>
                </div>
            </div>
        </article><hr /></a>";
    }

    echo json_encode(array(
        "content" => $content
    ));
?>