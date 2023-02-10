<?php

require_once("../includes/config.php");
require_once("../includes/classes/FormSanitizer.php");
require_once("../includes/classes/Constants.php");
require_once("../includes/classes/Account.php");

$account = new Account($con);


if(isset($_SESSION["user_id"])){
    $u_id = $_SESSION["user_id"];
} else { 
    header('Location:index.php');
    exit; 
}


function getInputValue($input) {
    if(isset($_POST[$input])) {
        echo $_POST[$input];
    }
}  

if(isset($_POST["username"])){

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $address2 = $_POST['address2'];
    $country = $_POST['country'];
    $prov = $_POST['prov'];
    $city = $_POST['city'];
    $postal = $_POST['postal'];
    $saveAddress = $_POST['saveAddress'];

    $html = '';
    $html .='<div class="cart_title mt-5">
            <h1 class="font-weight-bold">Review & Place Order</h2>
        </div>
        <hr class="hr_address">

        <h4 class="revTitle"> Shipping Address </h4>
        <div class="review ship">
            <div class="div">
                <p class="row pt l_f"><span>first Name:</span>&nbsp;&nbsp;</p>
                <p class="row pv l_s"><span>'.$firstName.'</span></p>
                <p class="row pt r_f"><span>last Name:</span>&nbsp;&nbsp;</p>
                <p class="row pv r_e"><span>'.$lastName.'</span></p>
            </div>
            <div>
                <p class="row pt l_f"><span>phone:</span>&nbsp;&nbsp;</p>
                <p class="row pv l_e"><span>'.$phone.'</span></p>
            </div>
            <div>
                <p class="row pt l_f"><span>address:</span>&nbsp;&nbsp;</p>
                <p class="row pv l_e"><span>'.$address.'</span></p>
            </div>
            <div>
                <p class="row pt l_f"><span>address2:</span>&nbsp;&nbsp;</p>
                <p class="row pv l_e"><span>'.$address2.'</span></p>
            </div>
            <div class="div">
                <p class="row pt l_f"><span>city:</span>&nbsp;&nbsp;</p>
                <p class="row pv l_s"><span>'.$city.'</span></p>
                <p class="row pt r_f"><span>postal:</span>&nbsp;&nbsp;</p>
                <p class="row pv r_e"><span>'.$postal.'</span></p>
            </div>
            <div class="div">
                <p class="row pt l_f"><span>country:</span>&nbsp;&nbsp;</p>
                <p class="row pv l_s"><span>'.$country.'</span></p>
                <p class="row pt r_f"><span>province:</span>&nbsp;&nbsp;</p>
                <p class="row pv r_e"><span>'.$prov.'</span></p>
            </div>
        </div>


        <h4 class="revTitle"> Billing Address </h4>
        <div class="review bill">
            <div>
                <p>NAME :&nbsp;&nbsp;</p>
                <p class="row pv"><span>'.$firstName.'&nbsp;&nbsp;</span></p>
                <p class="row pv"><span>'.$lastName.'</span></p>
            </div>
            <div>
                <p>BILLING ADDRESS :&nbsp&nbsp</p>
                <p class="row pv"><span>'.$address.'</span>, &nbsp;</p>
                <p class="row pv"><span>'.$city.'</span>, &nbsp;</p>
                <p class="row pv"><span>'.$postal.'</span>, &nbsp;</p>
                <p class="row pv"><span>'.$country.'</span>, &nbsp;</p>
                <p class="row pv"><span>'.$prov.'</span></p>
            </div>

        </div>
        
        <h4 class="revTitle"> Payment Method </h4>
        <div class="review pay">

            <div class="ship-div-form">

                <form id="login-form" method="POST">
                    <input type="hidden" name="firstName" value="'.$firstName.'" />
                    <input type="hidden" name="lastName" value="'.$lastName.'" />
                    <input type="hidden" name="phone" value="'.$phone.'" />
                    <input type="hidden" name="address" value="'.$address.'" />
                    <input type="hidden" name="address2" value="'.$address2.'" />
                    <input type="hidden" name="country" value="'.$country.'" />
                    <input type="hidden" name="prov" value="'.$prov.'" />
                    <input type="hidden" name="city" value="'.$city.'" />
                    <input type="hidden" name="postal" value="'.$postal.'" />

                    <div class="form-div">
                        '.$account->getError(Constants::$cardNumberLength).'
                        <label>Credit Card Number</label>
                        <input type="text" class="form-input" value="'.getInputValue("cardNumber").'" name="cardNumber" placeholder="Credit Card Number" required />
                    </div>

                    <div class="form-div divided">              
                        <div class="form-div split">
                            '.$account->getError(Constants::$cvvCharLength).'
                            <label>CVV</label>
                            <input type="text" class="form-input" value="'.getInputValue("cvv").'" name="cvv" placeholder="CVV" required />
                        </div>
                        <div class="form-div split">
                            '.$account->getError(Constants::$expireCharLength).'
                            <label>Expiration</label>
                            <input type="text" class="form-input" value="'.getInputValue("expire").'" name="expire" placeholder="MM / YY" required />
                        </div>
                    </div>

                    <div class="form-div">
                        '.$account->getError(Constants::$printNameCharacters).'
                        <label>Name</label>
                        <input type="text" class="form-input" value="'.getInputValue("printName").'" name="printName" placeholder="Name (as shown on card)" required />
                    </div>

                    <div class="saveCard">
                        <input type="hidden" name="saveCard" value="0" />
                        <input type="checkbox" name="saveCard" value="1" />
                        <label class="saveCard">Save this credit card for future purchase</label><br>
                    </div>

                    <div class="checkCard">
                        <h3>Your Card Validated<em>!</em></h3>
                        <p>Proceed to the <span>Checkout</span> button on the right (or bottom)</p>
                    </div>

                    <div class="checkout_container">
                        <input type="hidden" name="username" value="'.$_SESSION['loggedIn'].'" />
                        <button class="buy_btn subm" type="submit" name="submitCheck">Check Card Info</button>
                    </div>
                </form>



            </div>

        </div>
        
        <h4 class="revTitle"> Delivery & Gift Options </h4>
        <div class="review option">
            <div class="div">
                <p class="row"><span>Economy Shipping - $9.95</span></p>
            </div>
        </div>
        <div class="review option">
            <div class="div">
                <p class="row"><span>In-Store Pickup - $9.95</span></p>
            </div>
        </div>';

    echo $html;

}


?>

<script>

$(document).ready(function(){

    $("#login-form").validate(
        {
            rules: {
                cardNumber: { rangelength: [12, 16], digits:true  },
                cvv:        { rangelength: [3, 3], digits:true  },
                expire:     { rangelength: [4, 4], digits:true  },
                printName:  { minlength: 2 }
            },
            messages: {
                cardNumber: { 
                            rangelength: "Card number length error", 
                            digits: "Input type error" },
                cvv: {      rangelength: "CVV length error", 
                            digits:"Input type error" },
                expire: {   rangelength: "Expire length error", 
                            digits:"Input type error"  },
                printName: { minlength: "Name length error" }
            },
            errorPlacement: function(err, element){
                element.parent().append(err.addClass('errorMessage'));
            }
    });

    function getvalues(f) {
        var form=$("#"+f);
        var str='';
        $("input:not('input:submit')", form).each(function(i){
            str+='\n'+$(this).prop('name')+': '+$(this).val();
        });
        return str;
    }

    $('#login-form').submit(function(e){

        var isvalid = $("#login-form").valid();
        if (isvalid) {
            e.preventDefault();
            // alert(getvalues("login-form"));
            popupcheckcard();
        }
    });



    $('.buy_btn.check').attr("form", "login-form");
    $('.buy_btn.check').click(function(e){

        e.preventDefault();
        let postData = $('#login-form').serialize();

        $.ajax({
            url : 'ajax/ship_handler.php',
            type : 'POST',
            data : postData,
            success : function(data){
                if(data){
                    window.location.href = "orderDetail.php"; 
                }
                return false;
            },
            fail: function() {
                alert("Ajax with ship_handler having Error");
            }

        });
    });


    $('#login-form').keydown(function() {
        closecheckcard();
    });

    $('.checkCard').click(function() {
        closecheckcard();
    });
}); 

function popupcheckcard(){
    $('.checkCard').addClass('active'); 
    $('.buy_btn.subm').addClass('hidden'); 
}

function closecheckcard(){
    $('input[type=checkbox]').removeAttr('checked');
    $('.checkCard').removeClass('active');
    $('.buy_btn.subm').removeClass('hidden'); 
}


</script>