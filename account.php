
<?php
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/GetOrders.php");
require_once("includes/classes/GetProduct.php");
require_once("includes/classes/AccountSub.php");
require_once("includes/classes/GetAccountAlerts.php");
require_once("includes/classes/FormSanitizer.php");


$account = new Account($con);

if(isset($_SESSION["user_id"])){

    $u_i = $_SESSION["user_id"];
    $data = $account->getUserInfo($u_i);

    $preview = new GetProduct($con);
    $qry = $preview->getOrderLists($u_i); 

    if(!empty($data)){
        $username = $data['username'];
        $firstName = $data['firstName'];
      
    } else {
        $username = $_SESSION["loggedIn"];
        $firstName = null;
    }

} else {
    header('Location: login.php');
    exit;
}


if(isset($_POST["submitPwd"])) {
    $fname = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lname = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);
    $oldpassword = FormSanitizer::sanitizeFormPassword($_POST["oldpassword"]);
    $sqlData = $account->updatePassword($u_i, $fname, $lname, $oldpassword, $password, $password2);

    if($sqlData) {
        $_SESSION["loggedIn"] = $username;
        echo "<script>alert('Updated successfully');</script>";
    } 
}
if(isset($_POST["submitSub"])) {
    $phone = FormSanitizer::sanitizeFormPhone($_POST["phone"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $bd = mktime(0, 0, 0, $_POST['year'], $_POST['month'], $_POST['day']);
    $bod = date("Y-m-d h:i:sa", $bd);
    
    $sqlData = $account->registSubscript($u_i, $phone, $email, $bod);

    if($sqlData) {
        echo "<script>alert('Updated successfully');</script>";
    } 
}
if(isset($_POST["submitAdd"])) {

    $phone = FormSanitizer::sanitizeFormPhone($_POST["phone"]);
    $add = FormSanitizer::sanitizeFormString($_POST["address"]);
    $add2 = FormSanitizer::sanitizeFormString($_POST["address2"]);
    $city = FormSanitizer::sanitizeFormString($_POST["city"]);
    $postal = FormSanitizer::sanitizeFormPostal($_POST["postal"]);
    $prov = $_POST["prov"];
    $country = $_POST["country"];
    
    $sqlData = $account->updateAccAddress($u_i, $phone, $add, $add2, $city, $postal, $prov, $country);

    if($sqlData) {
        echo "<script>alert('Updated successfully');</script>";
    } 
}

$sub = false;

if(isset($_GET['sub'])){
    if($_GET['sub'] == 1)
    $sub = true;

    unset($_COOKIE['subchecked']); 
}

$chked = 0;

if(isset($_COOKIE['subchecked'])){

    $chked = $_COOKIE['subchecked'];
    unset($_COOKIE['subchecked']); 
    // echo "<script>$('#subinput').prop('checked', false);</script>";
}


function getInputValue($in) {
    if(isset($_POST[$in])) {
        echo $_POST[$in];
    }
}  

?>


    <?php require_once("includes/header.php"); ?>

    <div class="wrapper acc">
        <div class="hbgspace"></div>

        <!-- Account -->
        <section class="accContainer ">  

            <div class="naviTab">
                <a class="<?php echo ($_GET['tab']=='ord')?'tab':'' ?>" 
                    href="<?php echo "account.php?tab=ord" ?>"><h3>Order History</h3></a>
                <a class="<?php echo ($_GET['tab']=='acc')?'tab':'' ?>" 
                    href="<?php echo "account.php?tab=acc" ?>"><h3>Account Info</h3></a>
                <a class="<?php echo ($_GET['tab']=='sub')?'tab':'' ?>" 
                    href="<?php echo "account.php?tab=sub" ?>"><h3>Subscriptions &</h3></a>
            </div>
            <hr>


            <!-- col1 -------------------------------------->
            <div class="mainAnchor t_ord <?php echo ($_GET['tab']=='ord')?'':'hidden' ?>" >

                <div class="main_cont">
                    
                    <div class="left_sec ord">
                        <?php include('includes/relateProdSide.php'); ?> 

                    </div>

                    <div class="main_sec">
                        <h2 class="main_title">Order </br> History</h2>
                        <hr class="order_hr">
                        <?php
                            $html ="";
                            if(!empty($row = $qry->fetch(PDO::FETCH_ASSOC))){
                                
                                while($row = $qry->fetch(PDO::FETCH_ASSOC)){ 
                                        $cell = GetOrders::getOrderDetail($row, $con);
                                        $html .= $cell;
                                    }
                                    echo $html;
                            } else {
                                $cell = GetAccountAlerts::getOrderlistAlert();
                                $html .= $cell;
                                echo $html;
                            }
                        ?>

                    </div>  <!-- main_sec -->

                </div>  <!-- main_cont -->

            </div>  <!-- mainAnchor -->


            <!-- page -->








            <!-- col2 ----------------------------------->

            <div class="mainAnchor t_acc <?php echo ($_GET['tab']=='acc')?'':'hidden' ?>">

                <div class="main_cont">

                    <div class="left_sec acc">
                        <div class="input_ ad">
                            <input id="input_ad" type="checkbox" >
                            <label for="input_ad">Edit My Address</label>

                            <div class="hiddendiv div_ad">
                                <form id="login-form-ad" method="POST">

                                
                                    <?php if($firstName){ 
                                            echo AccountSub::getAddressContainer($data, $con);
                                    } else {  ?>

                                        <p class="row pv r_e"><span>No address saved</span></p>
                                    <?php } ?>

                                    <div class="form-div">
                                        <input type="submit" class="btn" id="login-btn-ad" name="submitAdd" value="Change Address Info" />
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="input_ se">
                            <input id="input_se" type="checkbox" >
                            <label for="input_se">My Subscription Info</label>

                            <div class="hiddendiv div_se">
                                <form id="login-form-se" method="POST">

                                    <label for="input_se">Hi! <?php echo isset($username)?$username:''; ?></label>
                                    </br>
                                    <div class="form-div acc">
                                    <?php echo $account->getError(Constants::$emailInvalid); ?>
                                        <label>Email</label>
                                        <input type="text" class="form-input acc" value="<?php echo isset($email)?$email:''; ?>" name="email" placeholder="Email" required />
                                    </div>

                                    <div class="form-div acc">
                                        <div class="dob">
                                            <label>DOB</label>

            <?php 
                echo AccountSub::dobContainer();
            ?>

                                        </div>
                                    </div>                
                                    <div class="form-div">
                                        <input type="submit" class="btn" id=ad" name="submitSub" value="Change Subscription Info" />
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="input_ pw">
                            <input id="input_pw" type="checkbox" >
                            <label for="input_pw">Change Name & Password</label>
                           
                            <div class="hiddendiv div_pw">
                                <form id="login-form-pw" method="POST">
                                    <?php echo $account->getError(Constants::$passwordsDontMatch); ?>
                                    <?php echo $account->getError(Constants::$passwordLength); ?>
                
            <?php 
                echo AccountSub::changePassword($data, $con);
            ?>
                                    <div class="form-div acc">
                                        <input type="submit" class="btn" id="login-btn-pw" name="submitPwd" value="Change Password" />
                                    </div>
                                </form>
                            </div>

                        </div>    

                    </div>  

                    <div class="main_sec">
                        <h2 class="main_title">Account</br> information</h2>
                        <hr class="order_hr">

                        <?php if(isset($firstName)){ ?>
                            <div class="m_sec acc">  

                            <?php
                                echo AccountSub::accountInfoCont($data);
                            ?>

                            </div>
                        <?php } else if(!isset($firstName) && ($sub == true)){ ?>

                            <div class="m_sec acc">  

                                <table>
                                <tbody>
                                    <tr>
                                        <td class="tbl pt l_f"><span>Phone:</span></td>
                                        <td class="tbl pv l_e"><input type="" value="" name=""></td>
                                    </tr>
                                    <tr>
                                        <td class="tbl pt l_f"><span>Address:</span></td>
                                        <td class="tbl pv l_e"><input type="" value="" name=""></td>
                                    </tr>
                                    <tr>
                                        <td class="tbl pt l_f"><span>Address2:</span></td>
                                        <td class="tbl pv l_e"><input type="" value="" name=""></td>
                                    </tr>
                                    <tr>
                                        <td class="tbl pt l_f"><span>Email:</span></td>
                                        <td class="tbl pv l_e"><input type="" value="" name=""></td>
                                    </tr>
                                    <tr>
                                        <td class="tbl pt l_f"><span>City:</span></td>
                                        <td class="tbl pv l_s"><input type="" value="" name=""></td>
                                        <td class="tbl pt r_f"><span>Postal:</span></td>
                                        <td class="tbl pv r_e"><input type="" value="" name=""></td>
                                    </tr>
                                    <tr>
                                        <td class="tbl pt l_f"><span>Country:</span></td>
                                        <td class="tbl pv l_s"><input type="" value="" name=""></td>
                                        <td class="tbl pt r_f"><span>Province:</span></td>
                                        <td class="tbl pv r_e"><input type="" value="" name=""></td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>

                        <?php } else {  

                            $html ="";
                            $cell = GetAccountAlerts::getAccountAlert();
                            $html .= $cell;
                            echo $html;
                        } ?>

                    </div>
                </div>
            </div>

















            <!-- col3 ----------------------------------->

            <div class="mainAnchor t_sub <?php echo ($_GET['tab']=='sub')?'':'hidden' ?>">

                <div class="main_cont">

                    <div class="left_sec sub">
                    </div>

                    <div class="main_sec">
                        <h2 class="main_title">Newsletter </br> Subscriptions</h2>      
                        <hr class="order_hr">
                        <?php 
                            echo GetAccountAlerts::getSubscriptAlert($chked);
                        ?>

                    </div>
                </div>
            </div>
        </section>   
        
    </div><!-- wrap ----------------------> 

<?php
require_once("includes/footer.php");
?>


<script>

$(document).ready(function(){

    $('#subinput').prop('checked', true);

    $("#subscript").on("change", function(e){
        e.preventDefault();
        if ($('#subinput').is(":checked")) {
            console.log(1);
            document.cookie="subchecked=1";
        } else {
            console.log(0);
            document.cookie="subchecked=0";
        }
    });
});

</script>

</body>
</html>