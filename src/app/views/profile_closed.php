<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Feed</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/bulma.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"] ?>assets/css/pizza.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"] ?>assets/css/profile.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/notifications/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/timestamps.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/nav.js"></script>
    </head>
    <body>
        <?php
            require(dirname(__FILE__) . "/templates.php"); // I would have prefered this elsewhere. But it works.
            require(dirname(__FILE__) . "/nav.php");
        ?>
        
        <div id="wrapper" style="height: auto;">
            <div class="box">
                This user is suspended.
            </div>
        </div>
    </body>
</html>