<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Conversations</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"] ?>assets/css/pizza.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"] ?>assets/css/conversation.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script>
            const ROOT = `${document.location.protocol}//${document.location.hostname}<?php echo $params["BASE"]; ?>`;
        </script>

        <script src="<?php echo $params["BASE"]; ?>assets/js/templates.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/latest.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/notifications/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/timestamps.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/nav.js"></script>
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
                    <span id="conversations"></span>
                    <img src="<?php echo $params["BASE"]; ?>assets/images/gifs/loading.gif" data-field="conversations-loading" class="loading" />
                    <a href="<?php echo $params["BASE"]; ?>conversation">New Message</a>
                </div>
            </div>
            <div class="seven-tenths">
                <div class="box" id="conversation">
                    <h1>You and <a class="link" href="<?php echo $params["BASE"]; ?>profile/<?php echo $params["target"]["username"] ?>"><?php echo $params["target"]["name"]; ?></a></h1>
                    <hr />
                    <div id="messages"></div>
                    <form id="conversationForm" action="<?php echo $params["BASE"]; ?>conversation/post/<?php echo $params["target"]["username"]; ?>" method="POST">
                        <textarea placeholder="What do you want to send?" name="message"></textarea>
                        <input value="Send" type="submit" />
                    </form>
                </div>
            </div>
        </div>

        
    </body>
</html>