<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Settings - Avatar</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/bulma.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"] ?>assets/css/nav.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"] ?>assets/css/settings-avatar.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/settings-avatar.js"></script>
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
                <h1 class="title">Change Your Profile Picture</h1>
                <figure class="image is-128x128 is-pulled-left">
                    <img src="<?php echo $params["user"]["avatar"]; ?>" />
                </figure><br /><br /><br /><br /><br /><br />
                <form method="POST" action="<?php echo $params["BASE"] ?>settings/upload" enctype="multipart/form-data">
                    <div class="file">
                        <label class="file-label">
                            <input name="avatar" type="file" class="file-input" />
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label">Choose a file...</span>
                            </span>
                            <span class="file-name">
                                No file specified
                            </span>
                        </label>
                    </div>
                    <div class="field" id="submitButton">
                        <div class="control">
                            <input name="submit" value="Submit" class="button is-link" type="submit" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>