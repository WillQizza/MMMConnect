<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Login</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/bulma.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link href="<?php echo $params["BASE"]; ?>assets/css/register.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo $params["BASE"]; ?>assets/js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo $params["BASE"]; ?>assets/js/register.js"></script>
        <?php
            if ($params["submittedRegister"]) {
                echo "
                <script>
                    $(document).ready(function () {
                        $(\"#login\").hide();
                        $(\"#register\").show();
                    });
                </script>
                ";
            }
        ?>
    </head>
    <body>
        <section class="hero is-fullheight" id="wrapper">
            <div class="columns">

                <div class="column is-one-third"></div>
                <div class="column is-one-third is-vcentered">
                    <div class="box has-text-centered" id="loginBox">
                        <div class="box is-primary is-info" id="loginHeader">
                            <h1 class="title"><span>MMM</span>Connect</h1>
                            <p>Login or signup below</p>
                        </div>

                        <div id="login">
                            <?php
                                if ($params["errors"]["login"]) {
                                    echo "<div class=\"notification is-danger\">Your credentials were incorrect.</div>";
                                }
                            ?>
                            
                            <form method="POST" action="register">
                                <div class="field">
                                    <div class="control">
                                        <input type="text" name="identifier" placeholder="Email/Username" class="input" value="<?php echo $params["placeholders"]["identifier"] ?>" required />
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input type="password" name="password" placeholder="Password" class="input" required />
                                    </div>
                                </div>
                                <div class="field is-grouped-centered is-grouped">
                                    <div class="control">
                                        <input type="submit" class="button is-link" name="submitLogin" value="Login" />    
                                    </div>
                                </div>
                                <a href="#" id="signupButton">Need an account?</a>
                            </form>
                        </div>
                        <div id="register">
                            <?php
                                if ($params["errors"]["emailExists"] || $params["errors"]["emailDoesNotMatch"] || $params["errors"]["firstNameNotLongEnough"] || $params["errors"]["lastNameNotLongEnough"] || $params["errors"]["passwordNotLongEnough"] || $params["errors"]["passwordDoesNotMatch"] || $params["errors"]["passwordEnglishOnly"] || $params["errors"]["registerSuccess"]) {
                                    echo "<div class=\"notification is-" . ($params["errors"]["registerSuccess"] ? "success" : "danger") . "\">";
                                    
                                    if ($params["errors"]["emailExists"]) {
                                        echo "The email already exists.";
                                    } else if ($params["errors"]["emailDoesNotMatch"]) {
                                        echo "The emails provided do not match";
                                    } else if ($params["errors"]["firstNameNotLongEnough"]) {
                                        echo "Your first name must be within 2 and 25 characters.";
                                    } else if ($params["errors"]["lastNameNotLongEnough"]) {
                                        echo "Your last name must be within 2 and 25 characters.";
                                    } else if ($params["errors"]["passwordNotLongEnough"]) {
                                        echo "Your password  must be within 5 and 30 characters.";
                                    } else if ($params["errors"]["passwordDoesNotMatch"]) {
                                        echo "The passwords provided do not match.";
                                    } else if ($params["errors"]["passwordEnglishOnly"]) {
                                        echo "Your password can only contain english characters or numbers.";
                                    } else if ($params["errors"]["registerSuccess"]) {
                                        echo "Successfully registered! You are now able to login!<br />Your username is " . $params["username"];
                                    }
                                    echo "</div>";
                                }
                            ?>
                            <form method="POST" action="register">
                                <div class="field">
                                    <div class="control">
                                        <input type="text" name="firstName" placeholder="First Name" class="input" value="<?php echo $params["placeholders"]["firstName"] ?>" required />
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input type="text" name="lastName" placeholder="Last Name" class="input" value="<?php echo $params["placeholders"]["lastName"] ?>" required />
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input type="email" name="email" placeholder="Email" class="input" value="<?php echo $params["placeholders"]["email"] ?>" required />
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input type="email" name="confirmEmail" placeholder="Confirm your email" class="input" value="<?php echo $params["placeholders"]["confirmEmail"] ?>" required />
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input type="password" name="password" placeholder="Password" class="input" required />
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <input type="password" name="confirmPassword" placeholder="Confirm your password" class="input" required />
                                    </div>
                                </div>
                                <div class="field is-grouped-centered is-grouped">
                                    <div class="control">
                                        <input type="submit" class="button is-link" name="submitRegister" value="Register" />    
                                    </div>
                                </div>
                            </form>
                            <a href="#" id="loginButton">Already have an account?</a>
                        </div>

                        

                    </div>

                </div>
                <div class="column is-one-third"></div>

            </div>

        </section>
    </body>
</html>