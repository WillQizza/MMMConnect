<!DOCTYPE html>
<html>
    <head>
        <title>MMMConnect | Login</title>
        <link href="<?php echo $params["BASE"]; ?>assets/css/fa/css/all.css" rel="stylesheet" type="text/css" />  
        <link href="<?php echo $params["BASE"]; ?>assets/css/pizza.css" rel="stylesheet" type="text/css" />
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
        <div id="wrapper">
            <div class="one-third"></div>
            <div class="one-third" id="authenticationBox">
                <div class="box center">
                    <div class="box center center-text" id="loginHeader">
                        <h1><span>MMM</span>Connect</h1>
                        <p>Login or signup below</p>
                    </div>

                    <form method="POST" action="register" id="login">
                        <?php
                            if ($params["errors"]["login"]) {
                                echo "<div class=\"notification box is-red\">Your credentials were incorrect.</div>";
                            }
                        ?>
                        <div class="input">
                            <input type="text" name="identifier" placeholder="Email/Username" value="<?php echo $params["placeholders"]["identifier"] ?>" required />
                        </div>
                        <div class="input">
                            <input type="password" name="password" placeholder="Password" required />
                        </div>
                        <div class="input">
                            <input type="submit" class="button" name="submitLogin" value="Login" />    
                        </div>
                        <div class="center center-text"><a class="link" id="signupButton">Need an account?</a></div>
                    </form>
                    
                    <form method="POST" action="register" id="register">
                        <?php
                            if ($params["errors"]["emailExists"] || $params["errors"]["emailDoesNotMatch"] || $params["errors"]["firstNameNotLongEnough"] || $params["errors"]["lastNameNotLongEnough"] || $params["errors"]["passwordNotLongEnough"] || $params["errors"]["passwordDoesNotMatch"] || $params["errors"]["passwordEnglishOnly"] || $params["errors"]["registerSuccess"]) {
                                echo "<div class=\"notification box is-" . ($params["errors"]["registerSuccess"] ? "green" : "red") . "\">";
                                
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
                        <div class="input">
                            <input type="text" name="firstName" placeholder="First Name" value="<?php echo $params["placeholders"]["firstName"] ?>" required />
                        </div>
                        <div class="input">
                            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $params["placeholders"]["lastName"] ?>" required />
                        </div>
                        <div class="input">
                            <input type="email" name="email" placeholder="Email" value="<?php echo $params["placeholders"]["email"] ?>" required />
                        </div>
                        <div class="input">
                            <input type="email" name="confirmEmail" placeholder="Confirm your email" value="<?php echo $params["placeholders"]["confirmEmail"] ?>" required />
                        </div>
                        <div class="input">
                            <input type="password" name="password" placeholder="Password" required />
                        </div>
                        <div class="input">
                            <input type="password" name="confirmPassword" placeholder="Confirm your password" required />
                        </div>
                        <div class="input">
                            <input type="submit" class="button" name="submitRegister" value="Register" />    
                        </div>
                        <div class="center center-text"><a class="link" id="loginButton">Already have an account?</a></div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>