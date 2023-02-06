<?php

require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

$account = new Account($con);

if(isset($_POST["submitButton"])) {
    
    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);
    
    $newid = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);
    if($newid != null){
        $_SESSION["user_id"] = $newid;
        $_SESSION["username"] = $username;
        header("Location: index.php");
    }
}

function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo $_POST[$name];
    }
}  


?>

    <?php require_once("includes/header.php"); ?>
    <div class="wrapper">
        

    <section>
        <div class="login-container">
            <h2 class="login-h2 reg">Register</h2>
            <hr>
        
            <div class="login-div-form">
                <form id="login-form" method="POST">
                    <div class="form-div divided">              
                        <div class="form-div split">
                            <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                            <label>First Name</label>
                            <input type="text" class="form-input" value="<?php getInputValue("firstName"); ?>" name="firstName" placeholder="Enter First Name" required />
                        </div>
                        <div class="form-div split">
                            <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                            <label>Last Name</label>
                            <input type="text" class="form-input" value="<?php getInputValue("lastName"); ?>" name="lastName" placeholder="Enter Last Name" required />
                        </div>
                    </div>
                    <div class="form-div">
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                        <label>User Name</label>
                        <input type="text" class="form-input" value="<?php getInputValue("username"); ?>" name="username" placeholder="Enter User Name" required />
                    </div>
                    <div class="form-div">
                        <?php echo $account->getError(Constants::$emailsDontMatch); ?>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>
                        <label>Email</label>
                        <input type="email" class="form-input" value="<?php getInputValue("email"); ?>" name="email" placeholder="Enter Email" required />
                    </div>
                    <div class="form-div">
                        <label>Email 2</label>
                        <input type="email" class="form-input" value="<?php getInputValue("email2"); ?>" name="email2" placeholder="Enter Confirm Email" required />
                    </div>

                    <div class="form-div">
                        
                        <?php echo $account->getError(Constants::$passwordsDontMatch); ?>
                        <?php echo $account->getError(Constants::$passwordLength); ?>
                        <label>Password</label>
                        <input type="password" class="form-input" id="password" name="password" placeholder="Enter Password" required />
                    </div>
                    <div class="form-div">
                        <label>Password 2</label>
                        <input type="password" class="form-input" id="password2" name="password2" placeholder="Enter Confirm Password" required />
                    </div>

                    <div class="form-div">
                        <input type="submit" class="btn" id="login-btn" name="submitButton" value="register" />
                    </div>
                    <div class="form-div">
                        <a id="register-url" href="login.php" class="btn">Already have an account? Sign in</a>
                    </div>
                </form>

            </div>
        </div>
    </section>





</div>  <!-- wrapper -->

<?php
require_once("includes/footer.php");
?>

</body>
</html>