<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Not Found</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/fa/css/all.css" rel="stylesheet" type="text/css" />  
        <link href="<?php echo $params["BASE"]; ?>assets/css/notfound.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $params["BASE"]; ?>assets/css/pizza.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/markdown.js"></script>
    </head>
    <body>
        <div class="notification is-blue">
            <h1>Whoops! Where are you heading?</h1>
            <h3>I brought you a map!</h3>
            <br />
        </div>
        <h2 class="center-text">
            <a href="<?php echo $params["link"] ?>"><?php echo $params["text"] ?></a>
        </h2>
    </body>
</html>