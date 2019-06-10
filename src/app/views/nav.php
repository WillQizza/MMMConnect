<?php
    // Because I got tired of typing the nav over and over.
?>
<div class="nav is-blue">
    <div class="nav-left">
        <a class="logo" href="<?php echo $params["BASE"]; ?>"><span>MMM</span>Connect</a>
        <form class="search" method="GET" action="<?php echo $params["BASE"] ?>search">
            <input type="text" name="query" class="input" autocomplete="off" />
            <i class="fas fa-search"></i>
            <div class="search-dropdown">
                <span class="results"></span>
                <a class="link moreResults">See All Results</a>
            </div>
        </form>
    </div>
    <div class="nav-right">
        <a href="<?php echo $params["user"]["profileURL"] ?>"><?php echo $params["user"]["name"] ?></a>
        <a href="<?php echo $params["BASE"]; ?>"><i class="fas fa-home"></i></a>
        <a href="<?php echo $params["BASE"]; ?>" class="dropdown" data-notification="notifications">
            <i class="fas fa-bell"></i>
            <div class="message-notification" data-notification="notifications">
                <?php if ($params["notifications"]["notifications"]) echo $params["notifications"]["notifications"]; ?>
            </div>
        </a>
        <a href="<?php echo $params["BASE"]; ?>requests">
            <i class="fas fa-user-friends"></i>
            <div class="message-notification">
                <?php if ($params["notifications"]["friends"]) echo $params["notifications"]["friends"]; ?>
            </div>
        </a>
        <a href="<?php echo $params["BASE"]; ?>conversation" class="dropdown" data-notification="messages">
            <i class="fas fa-envelope"></i>
            <div class="message-notification" data-notification="messages">
                <?php if ($params["notifications"]["messages"]) echo $params["notifications"]["messages"]; ?>
            </div>
        </a>
        <a href="<?php echo $params["BASE"]; ?>settings"><i class="fas fa-cogs"></i></a>
        <a href="<?php echo $params["BASE"]; ?>logout"><i class="fas fa-sign-out-alt"></i></a>
    </div>
</div>
<div class="nav-dropdown"></div>