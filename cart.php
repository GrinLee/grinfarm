<?php

require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

require_once("includes/cartSession.php");

$account = new Account($con);

if(isset($_POST["submit_btn"])) {

    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    
    $sqlData = $account->login($username, $password);

    if($sqlData != null) {
        $_SESSION["user_id"] = $sqlData['user_id'];
        $_SESSION["loggedIn"] = $username;
        header('Location:  ' . $_SERVER['PHP_SELF']);
        location.reload();
    } else {
        echo "<script> popupfunc(); </script>";
    }
}

function math($num, $rate){
    return $rounded = round($num * $rate * 100) / 100;
}

function getInputValue($input) {
    if(isset($_POST[$input])) {
        echo $_POST[$input];
    }
}  
    

?>

    
    <?php require_once("includes/header.php"); ?>
    
    <div class="wrapper">
        <div class="hbgspace"></div>


        <!-- Cart -->
        <section class="cart_container container">

            <div class="cart_cont">


                <div class="cart_listL"><!------ cart L ----------------------->


                    <div class="getList" display="block">

                        <div class="cart_title mt-5">
                            <h1 class="font-weight-bold">Your Cart</h2>
                        </div>
                        <hr>

                        <div class="list_group">

                    <?php if(isset($_SESSION['cart'])){ 
                        foreach($_SESSION['cart'] as $key => $s_row){ ?>


                            <div class="list_item">
                                <img src="assets/img/products/<?php echo $s_row['p_image']; ?>"/>
                                <div class="item_name">
                                    <h4><?php echo $s_row['p_name']; ?></h4>
                                    <span><?php echo $s_row['p_desc']; ?></span>
                                </div>
                                <div class="item_qty">
                                    <form method="POST">
                                        <input type="number" name="edit_qty" value="<?php echo $s_row['p_qty'] ?>" min="1"/>
                                        <input type="hidden" name="product_id" value="<?php echo $s_row['p_id'] ?>"/>
                                        <input type="submit" name="edit_btn" class="edit_btn" value="edit" />
                                    </form>                         
                                </div>
                                <div class="item_price">
                                    <h5>$<?php echo $s_row['p_qty'] * $s_row['p_price'];?></h5>

                                    <div class="item_post">
                                        <form method='POST'>
                                            <input type="hidden" name="wishlist" value="<?php echo $s_row['p_id']?>"/>
                                            <input type="submit" class="form_btn" value="Move to wish list &nbsp; |"/>
                                        </form>
                                        <form method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo $s_row['p_id']?>"/>
                                            <input type="submit" class="form_btn" style="font-family: FontAwesome" name="remove_btn" value="&nbsp;&nbsp; &#xf829;" />
                                        </form>

                                    </div>

                                </div>
                            </div>

                        <?php } ?>

                        </div>

                    </div>



                </div><!----------------- L ----------------->


                <div class="cart_listR">
                    <div class="summ_title mt-5">
                        <h2 class="font-weight-bold">Order Summary</h2>
                    </div>
                    <hr>

                    <div class="summ_table">   <!-- table -->
                        <table>
                            <tbody>
                                <tr>
                                    <td>Subtotal:</td>
                                    <td><p style="text-align: right;"><?php echo isset($_SESSION['cart'])?"$ ".$_SESSION['total']:null; ?></p></td>
                                </tr>
                                <tr>
                                    <td>Shipping Estimate:</td>
                                    <td><p style="text-align: right;">TBD</p></td>
                                </tr>
                                <tr>
                                    <td>Tax Estimate:</td>
                                    <td><p style="text-align: right;">15%</p></td>
                                </tr>
                                <tr class="tr_top">
                                    <td>Total:</td>
                                    <td><h3 style="text-align: right;"><?php echo isset($_SESSION['cart'])?"$ ".math($_SESSION['total'], 1.15):null; ?></h3></td>
                                </tr>
                            </tbody>
                        </table>
                                            <!-- echo $_SESSION['qty'] -->
                        <span class="cart_price"></span>
                    </div>
                    <!-- <button class="call">Login Popup</button> -->
                    <div class="checkout_container">
                        <form method="POST">
                            <input type="hidden" name="loggedIn" value="<?php echo isset($_SESSION['loggedIn']) ? $_SESSION['loggedIn']:null; ?>" />
                            <button href=".cart_container" class="buy_btn check" type="submit" name="checkout">Checkout</button>
                            <div class="halfAlert"></div>
                        </form>
                    </div>

                    
                </div>

            <?php } ?> 

            </div>
          
            
        </section>
        <!-- Cart -->

 
        <!-- Related Products -->
        <?php include('includes/relateProduct.php'); ?>            
    
        <!-- Related Products -->
    </div><!-- wrapper -->
    
    <?php include('includes/footer.php'); ?>


    <!-- login Pop ---------------------------->

    <div class="overlay-login"></div>

    <section class="popup-login">
        <div class="popup-close-login"></div>
        <div class="popup-content"></div>
    </section>

    <div class="for-call-popup">
        <h2 class="login-h2">Log In</h2>
        <hr>
        <form class="login-popup" method="POST">
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
                <input type="submit" class="btn" id="login-btn" name="submit_btn" value="login" />
            </div>
            <div class="form-div">
                <a id="register-url" href="register.php" class="btn">Don't have account? Register</a>
            </div>
        </form>

    </div>
       
    <!-- Pop -->





<script>

$(document).ready(function(){

    $('.popup-close-login').click(function() {
        $('.popup-login').removeClass('open-login');
        $('.overlay-login').removeClass('open-overlay');
    });

    $('.overlay-login').click(function(e) {
        if (!$('.popup-login').is(e.target) && $('.popup-login').has(e.target).length === 0) {
            $('.popup-login').removeClass('open-login');
            $('.overlay-login').removeClass('open-overlay');
    }});
    


    $('.buy_btn.check').click(function(e){

        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "ajax/getShipInfo.php",
            beforeSend: function(jqXHR, opts){

                let logged = e.target.previousElementSibling.value;
                if(logged){
                    return true;
                } else {
                    popupfunc();
                    jqXHR.abort();
                }
            },
            success: function(data) {
                $('#prodRelated').hide();
                $('.cart_listL').html(data); 
            },
            error: function() {
                alert("Some Error happening with getShipInfo ajax");
            }
        });

    });






});

function popupfunc(){
    let form = $('.for-call-popup');
    $('.popup-content').html(form.html());
    $('.popup-login').addClass('open-login').fadeIn(1000);
    $('.overlay-login').addClass('open-overlay');
}



</script>      

</body>
</html>