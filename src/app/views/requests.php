<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Friend Requests</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/bulma.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"] ?>assets/css/nav.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"] ?>assets/css/requests.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
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
                    
                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>conversation"><i class="fas fa-envelope"></i></a>

                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>requests"><i class="fas fa-user-friends"></i></a>
                    
                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>settings"><i class="fas fa-cogs"></i></a>

                    <a class="navbar-item" href="<?php echo $params["BASE"]; ?>logout"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="box spacing-top">
                <h1 class="title">Friend Requests</h1>
                <?php
                    foreach ($params["friendRequests"] as $request) {
                        echo "<article class=\"media\">
                                <figure class=\"media-left\">
                                    <img class=\"image is-64x64\" src=\"" . $request["author"]["avatar"] ."\" />
                                </figure>
                                <div class=\"media-content\">
                                    <div class=\"content\">
                                        <p><a href=\"" . $params["BASE"] . "profile/" . $request["author"]["username"] . "\"><strong>" . $request["author"]["name"] . "</strong></a> would like to be friends with you!</p>
                                        <form action=\"" . $params["BASE"] . "requests\" method=\"POST\">
                                            <input type=\"submit\" class=\"button is-success\" name=\"action\" value=\"Accept\" />
                                            <input type=\"submit\" class=\"button is-danger\" name=\"action\" value=\"Decline\" />
                                            <input type=\"hidden\" name=\"id\" value=\"" . $request["id"] . "\" />
                                        </form>
                                    </div>
                                </div>
                            </article>";
                    }
                ?>
            </div>
        </div>
    </body>
</html>