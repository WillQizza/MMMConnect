<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Feed</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/bulma.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"]; ?>assets/css/nav.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"]; ?>assets/css/profile.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"]; ?>assets/css/profile-feed.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/profile.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/profile-feed.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feedComments.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feedTimestamps.js"></script>
        <script>
            const ROOT = "<?php echo $params["BASE"]; ?>";
        </script>
    </head>
    <body>
        <nav class="navbar is-info">
            <div class="navbar-brand">
                <a class="navbar-item" href="<?php echo $params["BASE"]; ?>"><span>MMM</span>Connect</a>
            </div>
            <div class="navbar-menu">
                <div class="navbar-end">
                    <a class="navbar-item" href="<?php echo $params["user"]["profileURL"] ?>"><?php echo $params["user"]["name"] ?></a>

                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>"><i class="fas fa-home"></i></a>
                    
                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>"><i class="fas fa-bell"></i></a>
                    
                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>"><i class="fas fa-envelope"></i></a>

                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>requests"><i class="fas fa-user-friends"></i></a>
                    
                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>settings"><i class="fas fa-cogs"></i></a>

                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>logout"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </nav>

        <div id="profileInfo">
            <div id="profileAvatarContainer">
                <figure class="image is-square">
                    <img class="is-rounded" id="profileAvatar" src="<?php echo $params["target"]["avatar"]; ?>" />
                </figure>
            </div>
            <div id="profileStats" class="is-size-4">
                <p>
                    Posts: <?php echo $params["target"]["posts"] ?><br />
                    Likes: <?php echo $params["target"]["likes"] ?><br />
                    Friends: <?php echo count($params["target"]["friendIds"]) - 1; ?>
                </p>
            </div>
            <?php
                if ($params["isFriend"]) {
                    echo "<a class=\"button is-success\" id=\"postMessage\">Post Message</a>";
                }
                if ($params["target"]["id"] != $params["user"]["id"]) {
                    echo "<form id=\"friendRequestForm\" method=\"POST\" action=\"" . $params["BASE"] ."profile/" . $params["target"]["username"] . "/friend\">";
                    if ($params["sentFriendRequest"]) {
                        echo "<input class=\"button is-danger\" id=\"friendRequestButton\" type=\"submit\" name=\"friend\" value=\"Cancel Friend Request\">";
                    } else if ($params["isFriend"]) {
                        echo "<input class=\"button is-success\" id=\"friendRequestButton\" type=\"submit\" name=\"friend\" value=\"Remove Friend\">";
                    } else {
                        echo "<input class=\"button is-success\" id=\"friendRequestButton\" type=\"submit\" name=\"friend\" value=\"Add As Friend\">";
                    }
                    echo "</form>";
                    $mutualFriends = count($params["mutualFriends"]);
                    if ($mutualFriends == 1) {
                        echo "<p class=\"content\" id=\"mutualFriends\">1 mutual friend</p>";
                    } else {
                        echo "<p class=\"content\" id=\"mutualFriends\">" . $mutualFriends . " mutual friends" . "</p>";
                    }
                }
            ?>
        </div>
        <div id="profileBlue"></div>
        <div id="profile-content">
            <div class="box" id="feed">
                
                <img id="loading" src="<?php echo $params["BASE"]; ?>assets/images/gifs/loading.gif" />

            </div>
        </div>
        <div class="modal" id="postModal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <a><span class="is-pulled-right">X</span></a>
                    <h1 class="subtitle">Post something!</h1>
                    <hr />
                    <p>This will appear on the user's profile page and their newsfeed for your friends to see!</p>
                    <form action="<?php echo $params["BASE"] ?>profile/<?php echo $params["target"]["username"]; ?>/post" method="POST">
                        <textarea name="message" placeholder="What's on your mind?"></textarea>
                        <input name="submit" value="Post" class="button is-info" style="width: 5em;" type="submit" />
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="deleteModal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <a><span class="is-pulled-right">X</span></a>
                    <p>Are you sure you want to delete this?</p>
                    <hr />
                    <form method="POST">
                        <input class="button is-danger" name="delete" value="Delete" type="submit" />
                        <a class="button">Cancel</a>
                        <input name="id" type="hidden" />
                    </form>
                </div>
            </div>
        </div>


    </body>
</html>