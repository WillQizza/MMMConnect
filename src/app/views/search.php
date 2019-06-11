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
        <script src="<?php echo $params["BASE"]; ?>assets/js/conversations/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/notifications/index.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/nav.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/timestamps.js"></script>

        <script>
            $(document).ready(() => {


                $(".friendRequestForm").submit(function () {
                    
                    const element = $(this).find("input");
                    const container = element.parent();

                    const friendValue = element.val();
                    
                    $.ajax({
                        url: $(this).attr("action"),
                        type: "POST",
                        cache: false,
                        data: {
                            friend: friendValue
                        }
                    });

                    switch (friendValue) {
                        case "Cancel Friend Request":
                            element.val("Add As Friend");
                            container.removeClass("is-red");
                            container.addClass("is-green");
                        break;
                        case "Add As Friend":
                            element.val("Cancel Friend Request");
                            container.removeClass("is-green");
                            container.addClass("is-red");
                        break;
                        case "Remove Friend":
                            element.val("Add As Friend");
                            container.removeClass("is-red");
                            container.addClass("is-green");
                        break;
                    }

                    return false;
                });
            });
        </script>

    </head>
    <body>
        <?php
            require(dirname(__FILE__) . "/templates.php"); // I would have prefered this elsewhere. But it works.
            require(dirname(__FILE__) . "/nav.php");
        ?>
        <div id="wrapper">
            <div class="one-third"></div>
            <div class="half">
                <div class="box">
                    <h1>Search Results</h1>
                    <p><?php echo count($params["results"]); ?> search result<?php if (count($params["results"]) != 1) echo "s"; ?> found.</p>
                    <p class="faded-dark">Try searching for: <a class="link">Usernames</a> or <a class="link">Names</a></p>
                    <?php /* I'm getting time constrainted... TODO: Make this better in the future */ ?>
                    <?php 
                        foreach ($params["results"] as $user) {

                            switch ($params["friendStatus"][$user["id"]]) {
                                case 2:
                                    $class = "is-red";
                                    $value = "Cancel Friend Request";
                                break;
                                case 1:
                                    $class = "is-red";
                                    $value = "Remove Friend";
                                break;
                                case 0:
                                    $class = "is-green";
                                    $value = "Add As Friend";
                                break;
                            }

                            echo "<div class=\"post\">
                                <div class=\"avatar\">
                                    <img class=\"image image-64x64\" src=\"" . $user["avatar"] . "\" />
                                </div>
                                <div class=\"content\">
                                    <div class=\"half keep-left\">
                                        <a class=\"link\" href=\"" . $user["profileURL"] . "\">" . $user["name"] . "</a><br />
                                        <span class=\"faded-dark\">" . $user["username"] . "</span><br />
                                        " . $params["mutual"][$user["id"]] . " friends in common
                                    </div>
                                    <div class=\"keep-right\">
                                        <form class=\"friendRequestForm\" method=\"POST\" action=\"" . $params["BASE"] . "profile/" . $user["username"] . "/friend\">
                                            <span class=\"input $class\">
                                                <input value=\"$value\" name=\"friend\" type=\"submit\" />
                                            </span>
                                        </form>
                                    </div>
                                </div>
                            </div><br />";
                        }
                    ?>
                </div>
            </div>
        </div>


    </body>
</html>