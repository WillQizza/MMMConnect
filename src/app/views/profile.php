<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Feed</title>
        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"]; ?>assets/css/pizza.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"]; ?>assets/css/profile.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"]; ?>assets/css/profile-feed.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"]; ?>assets/css/conversation.css" rel="stylesheet" type="text/css" />
        <script>
            const ROOT = `${document.location.protocol}//${document.location.hostname}<?php echo $params["BASE"]; ?>`;
        </script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/profile.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/latest.js"></script>

        <script src="<?php echo $params["BASE"]; ?>assets/js/templates.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feed/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feed/common.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feed/profile.js"></script>
        
        <script src="<?php echo $params["BASE"]; ?>assets/js/notifications/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/messages.js"></script>
    </head>
    <body>
        <?php
            require(dirname(__FILE__) . "/templates.php"); // I would have prefered this elsewhere. But it works.
        ?>
        <div class="nav is-blue">
            <div class="nav-left">
                <a href="<?php echo $params["BASE"]; ?>"><span>MMM</span>Connect</a>
            </div>
            <div class="nav-right">
                <a href="<?php echo $params["user"]["profileURL"] ?>"><?php echo $params["user"]["name"] ?></a>
                <a href="<?php echo $params["BASE"]; ?>"><i class="fas fa-home"></i></a>
                <a href="<?php echo $params["BASE"]; ?>"><i class="fas fa-bell"></i></a>
                <a href="<?php echo $params["BASE"]; ?>requests"><i class="fas fa-user-friends"></i></a>
                <a href="<?php echo $params["BASE"]; ?>conversation" class="dropdown"><i class="fas fa-envelope"></i></a>
                <a href="<?php echo $params["BASE"]; ?>settings"><i class="fas fa-cogs"></i></a>
                <a href="<?php echo $params["BASE"]; ?>logout"><i class="fas fa-sign-out-alt"></i></a>
            </div>
            
        </div>
        <div class="nav-dropdown"></div>
        <div id="wrapper">
            <div class="one-quarter">
                <div id="userInfo">
                    <div id="avatar">
                        <img src="<?php echo $params["target"]["avatar"]; ?>" />
                    </div>
                    <div id="stats" class="center-text">
                        Posts: <?php echo $params["target"]["posts"] ?><br />
                        Likes: <?php echo $params["target"]["likes"] ?><br />
                        Friends: <?php echo count($params["target"]["friendIds"]) - 1; ?>
                    </div>
                    <?php
                        if ($params["isFriend"]) {
                            echo "<div class=\"input is-green center-text\">
                                    <input id=\"postMessage\" type=\"button\" value=\"Post Message\" />
                            </div>";
                        }
                        if ($params["target"]["id"] != $params["user"]["id"]) {
                            echo "<form id=\"friendRequestForm\" method=\"POST\" action=\"" . $params["BASE"] ."profile/" . $params["target"]["username"] . "/friend\">";
                            if ($params["sentFriendRequest"]) {
                                echo "<div class=\"input is-red center-text\">
                                    <input id=\"friendRequestButton\" type=\"submit\" name=\"friend\" value=\"Cancel Friend Request\" />
                                </div>";
                            } else if ($params["isFriend"]) {
                                echo "<div class=\"input is-green center-text\">
                                    <input id=\"friendRequestButton\" type=\"submit\" name=\"friend\" value=\"Remove Friend\" />
                                </div>";
                            } else {
                                echo "<div class=\"input is-green center-text\">
                                    <input id=\"friendRequestButton\" type=\"submit\" name=\"friend\" value=\"Add As Friend\" />
                                </div>";
                            }
                            echo "</form>";
                            $mutualFriends = count($params["mutualFriends"]);
                            if ($mutualFriends == 1) {
                                echo "<p id=\"mutualFriends\" class=\"center-text\">1 mutual friend</p>";
                            } else {
                                echo "<p id=\"mutualFriends\" class=\"center-text\">" . $mutualFriends . " mutual friends" . "</p>";
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="seven-tenths">
                <div class="box" id="dataBox">
                    <div class="tabs">
                        <!-- I really didn't feel like remaking this entire page to fit bootstrap smh. Custom CSS let's go. -->
                        <ul>
                            <a class="link" data-tab="newsfeed"><li <?php if (!$params["messageTab"]) { echo "class=\"is-active\""; } ?>>Newsfeed</li></a>
                            <?php
                                if ($params["user"]["id"] != $params["target"]["id"]) {
                                    if ($params["messageTab"]) {
                                        echo "<a class=\"link\" data-tab=\"messages\"><li class=\"is-active\">Messages</li></a>";
                                    } else {
                                        echo "<a class=\"link\" data-tab=\"messages\"><li>Messages</li></a>";
                                    }
                                }
                            ?>
                            
                        </ul>
                        <hr />
                    </div>
                    <div data-tab="newsfeed" <?php if ($params["messageTab"]) { echo "style=\"display:none;\""; } ?>>
                        <div id="feed"></div>
                
                        <img class="loading" src="<?php echo $params["BASE"]; ?>assets/images/gifs/loading.gif" />
                    </div>
                    <div data-tab="messages" <?php if (!$params["messageTab"]) { echo "style=\"display:none;\""; } ?>>
                        <h1>You and <a href="<?php echo $params["BASE"]; ?>profile/<?php echo $params["target"]["username"] ?>"><?php echo $params["target"]["name"]; ?></a></h1>
                        <hr />
                        <div id="messages"></div>
                        <form id="conversationForm" action="<?php echo $params["BASE"]; ?>profile/<?php echo $params["target"]["username"]; ?>" method="POST">
                            <textarea placeholder="What do you want to send?" name="message"></textarea>
                            <input value="Send Message" type="submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="postModal">
            <div class="background"></div>
            <div class="content">
                <div class="box">
                    <a class="link"><span class="keep-right">X</span></a>
                    <h1>Post something!</h1>
                    <hr />
                    <p>This will appear on the user's profile page and their newsfeed for your friends to see!</p>
                    <form action="<?php echo $params["BASE"] ?>profile/<?php echo $params["target"]["username"]; ?>/post" data-form="feed-message" method="POST">
                        <textarea name="message" style="width: 90%; min-height: 5em; padding: 1%; margin-left: 1em;" placeholder="What's on your mind?"></textarea><br />
                        <div class="input is-green">
                            <input name="submit" value="Post" type="submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="deleteModal">
            <div class="background"></div>
            <div class="content">
                <div class="box">
                    <a class="link"><span class="keep-right">X</span></a>
                    <p>Are you sure you want to delete this?</p>
                    <hr />
                    <form method="POST">
                        <div class="input is-red">
                            <input name="delete" value="Delete" type="submit" />
                        </div>
                        <input name="isPost" type="hidden" />
                        <input name="commentId" type="hidden" />
                        <input name="postId" type="hidden" />
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="editModal">
            <div class="background"></div>
            <div class="content">
                <div class="box">
                    <a class="link"><span class="keep-right">X</span></a>
                    <p>What would you like to edit this to?</p>
                    <hr />
                    <form method="POST" action="<?php echo $params["BASE"] ?>feed/editpost">
                        <textarea style="width: 90%; min-height: 10em; padding: 1%;" name="message" placeholder="What do you want to change this comment to?"></textarea><br />
                        <div class="input is-green">
                            <input name="edit" value="Edit" type="submit" />
                        </div>
                        <input name="id" type="hidden" />
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>