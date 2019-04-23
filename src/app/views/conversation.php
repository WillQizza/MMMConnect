<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Conversations</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/bulma.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"] ?>assets/css/nav.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"] ?>assets/css/conversation.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script>
            const ROOT = `${document.location.protocol}//${document.location.hostname}<?php echo $params["BASE"]; ?>`;
        </script>

        <script src="<?php echo $params["BASE"]; ?>assets/js/templates.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/latest.js"></script>
    </head>
    <body>
        <?php
            require(dirname(__FILE__) . "/templates.php"); // I would have prefered this elsewhere. But it works.
        ?>
        <nav class="navbar is-info">
            <div class="navbar-brand">
                <a class="navbar-item" href="<?php echo $params["BASE"]; ?>"><span>MMM</span>Connect</a>
            </div>
            <div class="navbar-menu">
                <div class="navbar-end">
                    <a class="navbar-item" href="<?php echo $params["user"]["profileURL"] ?>"><?php echo $params["user"]["name"] ?></a>

                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>"><i class="fas fa-home"></i></a>
                    
                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>"><i class="fas fa-bell"></i></a>
                    
                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>conversation"><i class="fas fa-envelope"></i></a>

                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>requests"><i class="fas fa-user-friends"></i></a>
                    
                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>settings"><i class="fas fa-cogs"></i></a>

                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>logout"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </nav>
        <div id="content">
            <div id="leftCol">
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
                <div class="box">
                    <h2 class="subtitle">Conversations</h2>
                    <hr class="conversation-line" />
                    <span id="conversations"></span>
                    <img src="<?php echo $params["BASE"]; ?>assets/images/gifs/loading.gif" data-field="conversations-loading" class="loading" />
                    <a href="<?php echo $params["BASE"]; ?>conversation">New Message</a>

                </div>
            </div>
            <div class="box" id="conversation">
                <h1 class="title">You and <a href="<?php echo $params["BASE"]; ?>profile/<?php echo $params["target"]["username"] ?>"><?php echo $params["target"]["name"]; ?></a></h1>
                <hr />
                <div id="messages"></div>
                <form id="conversationForm" action="<?php echo $params["BASE"]; ?>conversation/post/<?php echo $params["target"]["username"]; ?>" method="POST">
                    <textarea placeholder="What do you want to send?" name="message"></textarea>
                    <input value="Send Message" type="submit" />
                </form>
            </div>
        </div>
        
    </body>
</html>