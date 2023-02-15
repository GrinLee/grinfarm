<?php
     require_once("../includes/config.php");
     require_once("../includes/classes/Account.php");
     // require_once("../includes/classes/FormSanitizer.php");
     
     $account = new Account($con);

     if(isset( $_POST['username'] )) {

          $user_id = $_SESSION['user_id'];


          /* card */
          $saveCard = $_POST['saveCard']; 
          $cvv = $_POST["cvv"];
          $expire = $_POST["expire"];
          $cardNumber = $_POST["cardNumber"];
          $printName = $_POST["printName"];

          $card_id = $account->checkCard($user_id, $cvv, $expire, $cardNumber, $printName, $saveCard);


          /* order */
          $firstName = $_POST['firstName'];
          $lastName = $_POST['lastName'];
          $phone = $_POST['phone'];
          $address = $_POST['address'];
          $address2 = $_POST['address2'];
          $city = $_POST['city'];
          $postal = $_POST['postal'];
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