<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Feed</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"]; ?>assets/css/pizza.css" rel="stylesheet" type="text/css" />  
        <link href="<?php echo $params["BASE"]; ?>assets/css/feed.css" rel="stylesheet" type="text/css" />  
        <script>
            const ROOT = `${document.location.protocol}//${document.location.hostname}<?php echo $params["BASE"]; ?>`;
        </script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/templates.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/notifications/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/nav.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/timestamps.js"></script>

    </head>
    <body>
        <?php
            require(dirname(__FILE__) . "/templates.php"); // I would have prefered this elsewhere. But it works.
            require(dirname(__FILE__) . "/nav.php");
        ?>
        <div id="wrapper">
            <div class="half">
                <div class="box">
                    <h1>Search Results</h1>
                    <p><?php echo count($params["results"]); ?> search result<?php if (count($params["results"]) != 1) echo "s"; ?> found.</p>
                    <p class="faded-dark">Try searching for: <a class="link">Usernames</a> or <a class="link">Names</a></p>
                    <?php /* I'm getting time constrainted... TODO: Make this better in the future */ ?>
                    <?php 
                        foreach ($params["results"] as $user) {
                            echo "<div class=\"post\">
                                <div class=\"avatar\">
                                    <img class=\"image image-64x64\" src=\"" . $user["avatar"] . "\" />
                                </div>
                                <div class=\"content\">
                                    <div class=\"one-third\">
                                        <a class=\"link\" href=\"" . $user["profileURL"] . "\">" . $user["name"] . "</a><br />
                                        <span class=\"faded-dark\">" . $user["username"] . "</span><br />
                                        " . $params["mutual"][$user["id"]] . " friends in common
                                    </div>
                                    <div class=\"one-third keep-right\">
                                        <span class=\"input is-green\">
                                            <input value=\"Add As Friend\" type=\"button\" />
                                        </span>
                                    </div>
                                </div>
                            </div><br />";
                        }
                    ?>
                </div>
            </div>
        </div>


    </body>
</html>