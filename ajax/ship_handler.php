<?php
     require_once("../includes/config.php");
     require_once("../includes/classes/Account.php");
     
     $account = new Account($con);

     if(isset( $_POST['username'] )) {

          $user_id = $_SESSION['user_id'];


          /* card */
          $saveCard = $_POST['saveCard']; 
          $cvv = FormSanitizer::sanitizeFormCVV($_POST["cvv"]);
          $expire = FormSanitizer::sanitizeFormExpire($_POST["expire"]);
          $cardNumber = FormSanitizer::sanitizeFormCardNumber($_POST["cardNumber"]);
          $printName = FormSanitizer::sanitizeFormPrintName($_POST["printName"]);

          $card_id = $account->checkCard($user_id, $cvv, $expire, $cardNumber, $printName, $saveCard);


          /* order */
          $firstName = FormSanitizer::sanitizeFormString($_POST['firstName']);
          $lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);
          $phone = FormSanitizer::sanitizeFormPhone($_POST['phone']);
          $address = FormSanitizer::sanitizeFormString($_POST['address']);
          $address2 = FormSanitizer::sanitizeFormString($_POST['address2']);
          $city = FormSanitizer::sanitizeFormString($_POST['city']);
          $postal = FormSanitizer::sanitizeFormPostal($_POST['postal']);
          $prov = $_POST['prov'];
          $country = $_POST['country'];
          $order_cost = $_SESSION['total']; 
          $order_status = 'on_hold'; 
          $saveAddress = $_POST['saveAddress'];

          $order_id = $account->insertOrders($order_cost, $order_status, $user_id, $card_id, $firstName, $lastName, $phone, $address, $address2, $country, $prov, $city, $postal, $saveAddress);
          
          var_dump($order_id);
          
          if($order_id != null){
               $_SESSION['order_id'] = $order_id;
          }

          /* order item */
          $ordArr = array();
          if(is_array($_SESSION['cart'])){
               foreach($_SESSION['cart'] as $k => $v){ 
                    $res = $account->order_items($user_id, $order_id, $v['p_id'], $v['p_name'], $v['p_image'], $v['p_price'], $v['p_qty']);
                    array_push($ordArr, $res);
               }
          }
          if(!empty($ordArr)){
               echo true;
          } else {
               echo false;
          }
     }

?>