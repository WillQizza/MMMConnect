<?php
    $content = "";
    foreach ($params["suggestions"] as $friend) {

        if ($params["mutual"][$friend["id"]] == 1) {
            $mutualText = "1 friend in common";
        } else {
            $mutualText = $params["mutual"][$friend["id"]] . " friends in common";
        }
        $content .= "<a href=\"" . $params["BASE"] . "profile/" . $friend["username"] . "\"><div class=\"post\">
            <div class=\"avatar\">
                <img class=\"image image-64x64\" src=\"" . $friend["avatar"] . "\" />
            </div>
            <div class=\"content\">
                <span class=\"link\">" . $friend["name"] . "</span><br />
                <span class=\"link\">" . $friend["username"] . "</span><br />
                <span class=\"faded\">$mutualText</span>
            </div>
        </div></a>";

    }

    echo json_encode(array(
        "content" => $content
    ));
?>