<?php

require_once("../includes/config.php");
require_once("../includes/classes/FormSanitizer.php");
require_once("../includes/classes/Constants.php");
require_once("../includes/classes/Account.php");

$account = new Account($con);

/* if(isset($_POST["submitSave"])) {
    $result = $account->orders($firstName, $lastName, $phone, $address, $address2, $country, $prov, $city, $postal);
    if($result === false) {
        echo "<script>alert('Error in input data')</script>";
    }
} */

function getInputValue($input) {
    if(isset($_POST[$input])) {
        echo $_POST[$input];
    }
}  

$html = '';
$html .= '<div class="getInfo" display="block">

    <div class="cart_title mt-5">
        <h1 class="font-weight-bold">Review & Place Order</h2>
    </div>
    <hr class="hr_address">
    <h4> Shipping Address </h4>

    <div class="ship-div-form">

        <form id="login-form" method="POST">
            <div class="form-div divided">              
                <div class="form-div split">
                    '.$account->getError(Constants::$firstNameCharacters).'
                    <label>First Name</label>
                    <input type="text" class="form-input" value="'.getInputValue("firstName").'" name="firstName" placeholder="Enter First Name" required />
                </div>
                <div class="form-div split">
                    '.$account->getError(Constants::$lastNameCharacters).'
                    <label>Last Name</label>
                    <input type="text" class="form-input" value="'.getInputValue("lastName").'" name="lastName" placeholder="Enter Last Name" required />
                </div>
            </div>
            <div class="form-div">
                '.$account->getError(Constants::$phoneCharacters).'
                <label>Phone Number</label>
                <input type="text" class="form-input" value="'.getInputValue("phone").'" name="phone" placeholder="Enter Phone Number" required />
            </div>
            <div class="form-div">
                '.$account->getError(Constants::$addressCharacters).'
                <label>Street Address</label>
                <input type="text" class="form-input" value="'.getInputValue("address").'" name="address" placeholder="Enter Street Address" required />
            </div>
            <div class="form-div">
                <label>Street Address 2</label>
                <input type="text" class="form-input" value="'.getInputValue("address2").'" name="address2" placeholder="Enter Address Line 2 (optional)" />
            </div>
            <div class="form-div divided">              
                <div class="form-div split">
                    <label>Country</label>
                    <select class="form-input" name="country" required >
                        <option value="">Select Country</option>
                        <option value="CANADA" selected>Canada</option>
                        <option value="KOREA">Korean</option>
                    </select>
                </div>
                <div class="form-div split">
                    <label>Province/State</label>
                    <select class="form-input" name="prov" required >
                        <option value="">Select Provinces</option>
                        <option value="AL">Alberta</option>
                        <option value="BC">British Columbia</option>
                        <option value="MA">Manitoba</option>
                        <option value="NB">New Brunswick</option>
                        <option value="NF">Newfoundland and Labrador</option>
                        <option value="ON" selected>Ontario</option>
                        <option value="NO">Northwest Territories</option>
                        <option value="NS">Nova Scotia</option>
                        <option value="NU">Nunavut</option>
                    </select>
                </div>
            </div>
            <div class="form-div divided">              
                <div class="form-div split">
                    '.$account->getError(Constants::$cityCharacters).'
                    <label>City</label>
                    <input type="text" class="form-input" value="'.getInputValue("city").'" name="city" placeholder="Enter City" required />
                </div>
                <div class="form-div split">
                    '.$account->getError(Constants::$postalCharacters).'
                    <label>Postal Code</label>
                    <input type="text" class="form-input" value="'.getInputValue("postal").'" name="postal" placeholder="Enter Postal Code" required />
                </div>
            </div>
            <div class="">   
                <input type="hidden" name="saveAddress" value="0" /> 
                <input type="checkbox" name="saveAddress" value="1" />
                <label for="vehicle1"> Set as default shipping address</label><br>
            </div>
            <div class="checkout_container">
                <input type="hidden" name="username" value="'.$_SESSION['loggedIn'].'" />
                <button href=".summ_table" class="buy_btn save" type="submit" name="submitSave"> Save $ Continue </button>
            </div>
            <label class="address_cancel">Cancel</label><br>

        </form>
    </div>

    </div>';


echo $html;

?>

<script>

$(document).ready(function(){

    $("#login-form").validate(
        {
            rules: {
                firstName:  { minlength: 2 },
                lastName:   { minlength: 2 },
                phone:      { minlength: 2, number: true },
                address:    { minlength: 2 },
                city:       { minlength: 2 },
                postal:     { rangelength: [6, 6] },
                username:   { minlength: 2 }
            },
            messages: {
                firstName:  { minlength: "First Name length error" },
                lastName:   { minlength: "LastName length error" },
                phone:      { minlength: "Phone length error", number: "Phone type must be Number" },
                address:    { minlength: "Address length error" },
                city:       { minlength: "City length error" },
                postal:     { rangelength: "Postal length error" },
                username:   { minlength: "Name length error" }
            },
            errorPlacement: function(err, element){
                  element.parent().append(err.addClass('errorMessage'));
            }
    });

    $('.address_cancel').click(function(){
        window.history.back();
    });


    $('#login-form').submit(function(e){

        var isvalid = $("#login-form").valid();
        if (isvalid) {

            e.preventDefault();

            let postData = $('#login-form').serialize();
            
            $.ajax({
                url : 'ajax/getReview.php',
                type : 'POST',
                data : $("#login-form").serialize(),
                success : function(data, status){
                            $('.getInfo').hide();
                            $('.cart_listL').html(data); 
                            $('#prodRelated').hide();
                            return false;
                },
                error: function() {
                        alert("Ajax request failed");
                }

            });
        }
    });
}); 


</script>