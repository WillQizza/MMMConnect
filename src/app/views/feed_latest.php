<?php
    $content = "";
    foreach ($params["posts"] as $post) {
        $content .= "<article class=\"media\">
            
        </article>";
    }

    echo json_encode(array(
        "content" => $content
    ));
?>