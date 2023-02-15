<?php

require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

if(isset($_SESSION['loggedIn'])){
    header('Location: account.php');
    exit;          
}




$account = new Account($con);

if(isset($_POST["submitButton"])) {

    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    
    $sqlData = $account->login($username, $password);

    if($sqlData != null) {
        $_SESSION["user_id"] = $sqlData['user_id'];
        $_SESSION["loggedIn"] = $username;
        header("Location: index.php");
    }
    
}

function getInputValue($in) {
    if(isset($_POST[$in])) {
        echo $_POST[$in];
    }
}  


?>


    <?php require_once("includes/header.php"); ?>


<div class="wrapper">
    <div class="hbgspace"></div>
    
    <section>
        
        <div class="login-container">
            <h2 class="login-h2">Log In</h2>
            <hr>
        
            <div class="login-div-form">

            <form id="login-form" method="POST">

                <?php echo $account->getError(Constants::$loginFailed); ?>
                <div class="form-div">
                    <label>User Name</label>
                    <input type="text" class="form-input" value="<?php getInputValue("email"); ?>" name="username" placeholder="Username" required />
                </div>
                <div class="form-div">
                    <label>Password</label>
                    <input type="password" class="form-input" name="password" placeholder="Password" required />
                </div>
                <div class="form-div">
                    <input type="submit" class="btn" id="login-btn" name="submitButton" value="login" />
                </div>
                <div class="form-div">
                    <a id="register-url" href="register.php" class="btn">Don't have account? Register</a>
                </div>


                </form>


            </div>
        </div>
    </section>
<!-- Login -->



</div>  <!-- wrapper -->

<?php
require_once("includes/footer.php");
?>




</body>
</html>