<?php
    class Register extends Controller {
        public function index () {
            $identifier = "";
            $passwordLogin = "";
            $firstName = "";
            $lastName = "";
            $emailRegister = "";
            $emailConfirmRegister = "";
            $passwordRegister = "";
            $passwordConfirmRegister = "";

            $errors = array(
                "login" => false,
                "emailExists" => false,
                "emailDoesNotMatch" => false,
                "firstNameNotLongEnough" => false,
                "lastNameNotLongEnough" => false,
                "passwordNotLongEnough" => false,
                "passwordDoesNotMatch" => false,
                "passwordEnglishOnly" => false,
                "registerSuccess" => false
            );
            $userModel = $this->model("Users");
            if (isset($_POST["submitLogin"]) && isset($_POST["identifier"]) && isset($_POST["password"])) {
                $identifier = strtolower(str_replace(" ", "", htmlspecialchars($_POST["identifier"])));
                $passwordLogin = $_POST["password"];
                $user = $userModel->isUserAuthenticated($identifier, $passwordLogin);
                if ($user) {
                    $_SESSION["id"] = $user["id"];
                    $this->redirect("feed");
                } else {
                    $errors["login"] = true;
                }
            } else if (isset($_POST["submitRegister"]) && isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["email"]) && isset($_POST["confirmEmail"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])) {
                $firstName = strip_tags(ucfirst(strtolower(str_replace(" ", "", htmlspecialchars($_POST["firstName"])))));
                $lastName = strip_tags(ucfirst(strtolower(str_replace(" ", "", htmlspecialchars($_POST["lastName"])))));
                $emailRegister = strip_tags(strtolower(str_replace(" ", "", htmlspecialchars($_POST["email"]))));
                $emailConfirmRegister = strip_tags(strtolower(str_replace(" ", "", htmlspecialchars($_POST["confirmEmail"]))));
                $passwordRegister = $_POST["password"];
                $passwordConfirmRegister = $_POST["confirmPassword"];
                if ($userModel->getUserByEmail($emailRegister)) {
                    $errors["emailExists"] = true;
                } else if ($emailRegister != $emailConfirmRegister) {
                    $errors["emailDoesNotMatch"] = true;
                } else if (strlen($firstName) > 25 || strlen($firstName) < 2) {
                    $errors["firstNameNotLongEnough"] = true;
                } else if (strlen($lastName) > 25 || strlen($lastName) < 2) {
                    $errors["lastNameNotLongEnough"] = true;
                } else if ($passwordRegister != $passwordConfirmRegister) {
                    $errors["passwordDoesNotMatch"] = true;
                } else if (preg_match("/[^A-Za-z0-9]/", $passwordRegister)) {
                    $errors["passwordEnglishOnly"] = true;
                } else if (strlen($passwordRegister) > 30 || strlen($passwordRegister) < 5) {
                    $errors["passwordNotLongEnough"] = true;
                } else {
                    $username = $userModel->generateUsername($firstName, $lastName);

                    if (rand(0, 1)) {
                        $avatar = "head_deep_blue.png";
                    } else {
                        $avatar = "head_emerald.png";
                    }
                    $avatar = "assets/images/profile_pics/$avatar";

                    $userModel->createUser(array(
                        "username" => $username,
                        "firstName" => $firstName,
                        "lastName" => $lastName,
                        "email" => $emailRegister,
                        "password" => $passwordRegister,
                        "avatar" => $avatar
                    ));
                    $errors["registerSuccess"] = true;
                }

            }
            $this->view("register", array(
                "submittedRegister" => isset($_POST["submitRegister"]),
                "errors" => $errors,
                "placeholders" => array(
                    "identifier" => $identifier,
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "email" => $emailRegister,
                    "confirmEmail" => $emailConfirmRegister
                ),
                "username" => isset($username) ? $username : null
            ));
        }
    }
?>