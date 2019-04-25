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
        <script src="<?php echo $params["BASE"]; ?>assets/js/feed/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feed/common.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feed/feed.js"></script>

    </head>
    <body>
        <?php
            require(dirname(__FILE__) . "/templates.php"); // I would have prefered this elsewhere. But it works.
        ?>
        <div id="wrapper">
            <nav class="nav is-blue">
                <div class="nav-left">
                    <a href="<?php echo $params["BASE"]; ?>"><p><span>MMM</span>Connect</p></a>
                </div>
                <div class="nav-right">
                    <a href="<?php echo $params["BASE"]; ?>logout"><p><i class="fas fa-sign-out-alt"></i></p></a>
                    <a href="<?php echo $params["BASE"]; ?>settings"><p><i class="fas fa-cogs"></i></p></a>
                    <a href="<?php echo $params["BASE"]; ?>requests"><p><i class="fas fa-user-friends"></i></p></a>
                    <a href="<?php echo $params["BASE"]; ?>conversation"><p><i class="fas fa-envelope"></i></p></a>
                    <a href="<?php echo $params["BASE"]; ?>"><p><i class="fas fa-bell"></i></p></a>
                    <a href="<?php echo $params["BASE"]; ?>"><p><i class="fas fa-home"></i></p></a>
                    <a href="<?php echo $params["user"]["profileURL"] ?>"><p><?php echo $params["user"]["name"] ?></p></a>
                </div>
            </nav>
            <!-- <div id="content"> -->
                <div class="one-quarter">
                    <div class="box">
                        <div class="half">
                            <img class="image image-128x128" src="<?php echo $params["user"]["avatar"] ?>" />
                        </div>
                        <div class="one-quarter" id="userInfo">
                            <span><a href="<?php echo $params["user"]["profileURL"] ?>" class="link"><?php echo $params["user"]["name"] ?></a></span><br />
                            <span>Posts: <span data-stat="posts"><?php echo $params["user"]["posts"] ?></span></span><br />
                            <span>Likes: <span data-stat="likes"><?php echo $params["user"]["likes"] ?></span></span>
                        </div>
                    </div>
                </div>
                <div class="seven-tenths">
                    <div class="box">
                        <form method="POST" action="<?php echo $params["BASE"]; ?>feed/post" id="postForm" data-form="feed-message">
                            <textarea name="body" placeholder="What's on your mind?"></textarea>
                            <input class="input" type="submit" class="submitButton" name="activitySubmit" value="Post" />
                        </form>
                        <hr />
                        <div id="feed">
                            
                        </div>
                        <img class="loading" src="<?php echo $params["BASE"]; ?>assets/images/gifs/loading.gif" />
                    </div>
                </div>
            </div>
        <!-- </div> -->
    </body>
</html>