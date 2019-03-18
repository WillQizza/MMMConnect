<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Feed</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/bulma.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"] ?>assets/css/nav.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"] ?>assets/css/profile.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feed.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feedComments.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/feedTimestamps.js"></script>
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

        <div id="profileInfo">
            <div id="profileAvatarContainer">
                <figure class="image is-square">
                    <img class="is-rounded" id="profileAvatar" src="<?php echo $params["user"]["avatar"]; ?>" />
                </figure>
            </div>
        </div>
        <div id="content">
            <div class="box">
                
            </div>
        </div>


    </body>
</html>