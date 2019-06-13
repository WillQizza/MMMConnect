<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Conversations</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/fa/css/all.css" rel="stylesheet" type="text/css" /> 
        <link href="<?php echo $params["BASE"] ?>assets/css/pizza.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"] ?>assets/css/no-conversation.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversation-suggest.js"></script>
        <script>
            const ROOT = `${document.location.protocol}//${document.location.hostname}<?php echo $params["BASE"]; ?>`;
        </script>

        <script src="<?php echo $params["BASE"]; ?>assets/js/templates.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/notifications/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/timestamps.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/nav.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/markdown.js"></script>
    </head>
    <body>

        <?php
            require(dirname(__FILE__) . "/templates.php"); // I would have prefered this elsewhere. But it works.
            require(dirname(__FILE__) . "/nav.php");
        ?>

        <div id="wrapper">
            <div class="one-quarter">
                <div class="box">
                    <div class="half">
                        <img class="image image-128x128" src="<?php echo $params["user"]["avatar"] ?>" />
                    </div>
                    <div class="one-quarter">
                        <span><a href="<?php echo $params["user"]["profileURL"] ?>" class="link"><?php echo $params["user"]["name"] ?></a></span><br />
                        <span>Posts: <span data-stat="posts"><?php echo $params["user"]["posts"] ?></span></span><br />
                        <span>Likes: <span data-stat="likes"><?php echo $params["user"]["likes"] ?></span></span>
                    </div>
                </div>
                <div class="box">
                    <h2>Conversations</h2>
                    <hr />
                    <?php
                        foreach ($params["conversations"] as $conversation) {
                            $who = "You";
                            if ($conversation["message"]["author"]["id"] != $params["user"]["id"]) {
                                $who = "They";
                            }
                            $body = $conversation["message"]["body"];
                            if (strlen($body) > 10) {
                                $body = substr($body, 0, 10) . "...";
                            }
                            echo "<a href=\"" . $params["BASE"] . "conversation/" . $conversation["user"]["username"] . "\"><div class=\"post\">
                                <div class=\"avatar\">
                                    <img class=\"image image-64x64\" src=\"" . $conversation["user"]["avatar"] . "\" />
                                </div>
                                <div class=\"content\">
                                    <span class=\"link\">" . $conversation["user"]["name"] . "</span> <i class=\"faded\">" . $conversation["message"]["timestamp"] . "</i><br />
                                    $who said " . $body . "
                                </div>
                            </div></a><hr />";
                            
                        }
                    ?>
                    <a href="<?php echo $params["BASE"]; ?>conversation">New Message</a>
                </div>
            </div>
            <div class="seven-tenths">
                <div class="box">
                    <h1>New Conversation</h1>
                    <hr />
                    <div class="center-text"> 
                        <p>Search for the friend you would like to message...</p>
                        <div class="input">
                            <input type="text" placeholder="Type a username..." />
                        </div>
                    </div>
                    <div id="suggestions"></div>
                </div>
            </div>
        </div>

    </body>
</html>