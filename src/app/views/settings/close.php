<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Settings - Avatar</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"]; ?>assets/css/pizza.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"]; ?>assets/css/settings-avatar.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"]; ?>assets/css/jcrop.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"]; ?>assets/css/settings.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo $params["BASE"]; ?>assets/js/jcrop.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/settings-avatar.js"></script>

        <script>
            const ROOT = `${document.location.protocol}//${document.location.hostname}<?php echo $params["BASE"]; ?>`;
        </script>

        <script src="<?php echo $params["BASE"]; ?>assets/js/templates.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/notifications/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/nav.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/timestamps.js"></script>
    </head>
    <body>
        <?php
            require(dirname(__FILE__) . "/../templates.php"); // I would have prefered this elsewhere. But it works.
            require(dirname(__FILE__) . "/../nav.php");
        ?>
        <div id="wrapper">
            <div class="one-quarter"></div>
            <div class="seven-tenths">
                <div class="box">
                   
                    <h1>Close Account</h1>
                    <p>Are you sure you want to close your account?</p>
                    <p>Closing your account will hide your profile and all of your activity from other users.</p>
                    <p>You can reopen your account at any time by simply logging in.</p>
                    <form method="POST">
                        <div class="input is-red" style="display: inline-block;">
                            <input name="delete" value="Close it" type="submit" />
                        </div>
                        <div class="input" style="display: inline-block;">
                            <input name="delete" value="Cancel" type="submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>