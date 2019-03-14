<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Not Found</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/bulma.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"]; ?>assets/css/notfound.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <section class="hero is-info is-bold">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <h1 class="title">Whoops! Where are you heading?</h1>
                    <h2 class="subtitle">I brought you a map!</h2>
                </div>
            </div>
        </section>
        <div class="container">
            <h2 class="subtitle has-text-centered" id="refer-back"><a href="<?php echo $params["link"] ?>"><?php echo $params["text"] ?></a></h2>
        </div>
    </body>
</html>