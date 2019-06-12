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
                    <?php
                        if ($params["errors"]["emailExists"] || $params["errors"]["firstNameNotLongEnough"] || $params["errors"]["lastNameNotLongEnough"] || $params["errors"]["passwordNotLongEnough"] || $params["errors"]["passwordDoesNotMatch"] || $params["errors"]["newPasswordDoesNotMatch"] || $params["errors"]["passwordEnglishOnly"] || $params["errors"]["success"]) {
                            echo "<div class=\"notification box is-" . ($params["errors"]["success"] ? "green" : "red") . "\">";

                            if ($params["errors"]["emailExists"]) {
                                echo "The email already exists.";
                            } else if ($params["errors"]["firstNameNotLongEnough"]) {
                                echo "Your first name must be within 2 and 25 characters.";
                            } else if ($params["errors"]["lastNameNotLongEnough"]) {
                                echo "Your last name must be within 2 and 25 characters.";
                            } else if ($params["errors"]["passwordNotLongEnough"]) {
                                echo "Your password  must be within 5 and 30 characters.";
                            } else if ($params["errors"]["passwordDoesNotMatch"]) {
                                echo "Your password does not match your current password.";
                            } else if ($params["errors"]["newPasswordDoesNotMatch"]) {
                                echo "The new passwords provided do not match.";
                            } else if ($params["errors"]["passwordEnglishOnly"]) {
                                echo "Your password can only contain english characters or numbers.";
                            } else {
                                echo "Settings changed successfully!";
                            }

                            echo "</div>";
                        }
                    ?>
                    <h1>Account Settings</h1>
                    <span id="avatarContainer">
                        <img src="<?php echo $params["user"]["avatar"] ?>" class="image" />
                        <a class="link" href="<?php echo $params["BASE"]; ?>settings/upload">Upload new profile picture</a>
                    </span>
                    <br />
                    <form method="POST" action="<?php echo $params["BASE"] ?>settings/edit">
                        <div class="input">
                            First Name:
                            <input name="firstName" type="text" value="<?php echo $params["user"]["firstName"]; ?>" />
                        </div>
                        <div class="input">
                            Last Name:
                            <input name="lastName" type="text" value="<?php echo $params["user"]["lastName"]; ?>" />
                        </div>
                        <div class="input">
                            Email:
                            <input name="email" type="email" value="<?php echo $params["user"]["email"]; ?>" />
                        </div>
                        <div class="input is-blue">
                            <input type="submit" value="Update Details" />
                        </div>
                    </form>
                    <h2>Change Password</h2>
                    <form method="POST" action="<?php echo $params["BASE"]; ?>settings/edit">
                        <div class="input">
                            Old Password:
                            <input name="oldPassword" type="password" />
                        </div>
                        <div class="input">
                            New Password:
                            <input name="newPassword" type="password" />
                        </div>
                        <div class="input">
                            New Password Again:
                            <input name="newPasswordAgain" type="password" />
                        </div>
                        <div class="input is-blue">
                            <input type="submit" value="Update Password" />
                        </div>
                    </form>
                    <h2>Close Account</h2>
                    <a href="<?php echo $params["BASE"] ?>settings/close" class="link" id="closeAccount">Close Account</a>
                    <br /><br /><br />
                </div>
            </div>
        </div>
    </body>
</html>