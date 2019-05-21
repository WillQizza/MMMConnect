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
        <div class="nav is-blue">
            <div class="nav-left">
                <a href="<?php echo $params["BASE"]; ?>"><span>MMM</span>Connect</a>
            </div>
            <div class="nav-right">
                <a href="<?php echo $params["user"]["profileURL"] ?>"><?php echo $params["user"]["name"] ?></a>
                <a href="<?php echo $params["BASE"]; ?>"><i class="fas fa-home"></i></a>
                <a href="<?php echo $params["BASE"]; ?>"><i class="fas fa-bell"></i></a>
                <a href="<?php echo $params["BASE"]; ?>requests"><i class="fas fa-user-friends"></i></a>
                <a href="<?php echo $params["BASE"]; ?>conversation"><i class="fas fa-envelope"></i></a>
                <a href="<?php echo $params["BASE"]; ?>settings"><i class="fas fa-cogs"></i></a>
                <a href="<?php echo $params["BASE"]; ?>logout"><i class="fas fa-sign-out-alt"></i></a>
            </div>
            
        </div>
        <div id="wrapper">
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
                        <textarea class="form-textarea" name="body" placeholder="What's on your mind?"></textarea>
                        <input type="submit" class="input submitButton" name="activitySubmit" value="Post" />
                    </form>
                    <hr />
                    <div id="feed"></div>
                    <img class="loading" src="<?php echo $params["BASE"]; ?>assets/images/gifs/loading.gif" />
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
    </body>
</html>