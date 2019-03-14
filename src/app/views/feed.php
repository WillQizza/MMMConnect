<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Feed</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/bulma.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"]; ?>assets/css/feed.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feed.js"></script>
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

                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>"><i class="fas fa-user-friends"></i></a>
                    
                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>"><i class="fas fa-cogs"></i></a>

                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>logout"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </nav>
        <div id="content">
            <div class="box spacing-top" id="userInfo">
                <article class="media">
                    <figure class="media-left">
                        <p class="image is-128x128">
                            <img src="<?php echo $params["user"]["avatar"] ?>" />
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="content">
                            <a href="<?php echo $params["user"]["profileURL"] ?>" class="link"><?php echo $params["user"]["name"] ?></a><br />
                            Posts: <span data-stat="posts"><?php echo $params["user"]["posts"] ?></span><br />
                            Likes: <span data-stat="likes"><?php echo $params["user"]["likes"] ?></span>
                        </div>
                    </div>
                </article>
            </div>
            <div class="box spacing-top" id="activity">
                <form method="POST" action="/feed/post" id="postForm">
                    <textarea name="activityText" placeholder="What's on your mind?"></textarea>
                    <input type="submit" name="activitySubmit" value="Post" />
                </form><br /><br /><br /> <!-- MANY THE GOODS "CSS" -->
                <div class="line"></div>
                <div id="feed">
                </div>

                <img id="loading" src="assets/images/gifs/loading.gif" />
            </div>
        </div>
    </body>
</html.