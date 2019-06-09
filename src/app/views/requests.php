<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Friend Requests</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"] ?>assets/css/pizza.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"] ?>assets/css/requests.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>

        <script>
            const ROOT = `${document.location.protocol}//${document.location.hostname}<?php echo $params["BASE"]; ?>`;
        </script>

        <script src="<?php echo $params["BASE"]; ?>assets/js/templates.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/notifications/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/nav.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/timestamp.js"></script>
        
    </head>
    <body>
        <?php
            require(dirname(__FILE__) . "/templates.php"); // I would have prefered this elsewhere. But it works.
            require(dirname(__FILE__) . "/nav.php");
        ?>
        <div id="wrapper" style="height: auto;">
            <div class="box">
                <h1>Friend Requests</h1>
                <?php
                    foreach ($params["friendRequests"] as $request) {
                        echo "<div class=\"post\">
                            <div class=\"avatar\">
                                <img src=\"" . $request["author"]["avatar"] . "\" class=\"image image-64x64\" />
                            </div>
                            <div class=\"content\">
                                <p><a href=\"" . $params["BASE"] . "profile/" . $request["author"]["username"] . "\"><strong>" . $request["author"]["name"] . "</strong></a> would like to be friends with you!</p>
                                <form action=\"" . $params["BASE"] . "requests\" method=\"POST\">
                                    <div class=\"buttons\">
                                        <div class=\"input is-green\"><input type=\"submit\" name=\"action\" value=\"Accept\" /></div>
                                        <div class=\"input is-red\"><input type=\"submit\" name=\"action\" value=\"Decline\" /></div>
                                    </div>
                                    
                                    <input type=\"hidden\" name=\"id\" value=\"" . $request["id"] . "\" />
                                </form>
                            </div>
                        </div>";
                    }
                ?>
            </div>
        </div>
    </body>
</html>