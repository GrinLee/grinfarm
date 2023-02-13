<?php
require_once("includes/classes/GetProduct.php");

class GetOrders {

    public static function getOrderDetail($row, $con){

/* 
$order_id = $row['order_id'];       $order_cost = $row['order_cost'];
$user_id = $row['user_id'];         $address2 = $row['address2'];    
$address = $row['address'];         $phone = $row['phone']; 
$country = $row['country'];         $city = $row['city'];
$prov = $row['prov'];               $postal = $row['postal'];   
$item_id = $row['item_id'];         $card_id = $row['card_id'];
$saveAddress = $row['saveAddress']; 

*/
        $order_status = $row['order_status'];   $username = $row['username'];
        $date = $row['order_date'];             
        $product_id = $row['product_id'];       $order_myId = $row['order_myId'];   
        $product_name = $row['product_name'];   $product_image1 = $row['product_image1'];
        $product_price = $row['product_price']; $product_quantity = $row['product_quantity']; 

        $total = $product_price * $product_quantity;
        $getP = new GetProduct($con);
        $qry = $getP->getProduct($product_id);
        $res = $qry->fetch(PDO::FETCH_ASSOC);  
        $product_desc = $res['product_description'];    
        $product_thumb = $res['product_thumb_desc'];   

        $time=strtotime($date);
        $month=date("F",$time);
        $year=date("Y",$time);
        $day=date("j",$time);

        $html ='';
        $html .='<div class="orderinfo_row">

                    <div class="oi_1r_1c">
                        <table id="ord_table">
                            <tbody>
                                <tr>
                                    <th>'.strtoupper($order_status).'</th>
                                    <th>TOTAL</th>
                                    <th>SHIP TO</th>
                                </tr>
                                <tr>
                                    <td>'.$day.', '.$month.'</td>
                                    <td>CAD $'.$total.'</td>
                                    <td>'.$username.'</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="oi_1r_2c">
                        <table id="ord_table">
                            <tbody>
                                <tr>
                                    <th>ORDER ID: '.strtoupper($order_myId).'</th>
                                </tr>
                                <tr>
                                    <td><a href="javascript:void(0)">View order details</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="oi_2r_1c">
                        <img src="assets/img/products/'.$product_image1.'"/>
                        <div class="item_name order">
                            <h4>'.$product_name.'</h4>
                            <p>'.$product_thumb.'</p>
                            <p id="tip">Return items: Eligible utill 15 days afterward</p>
                            <div>
                                <button class="ord_buy cart"><a href="productDetail.php">
                                    <i class="fa-solid fa-rotate" style="margin-right: 10px"></i>Buy it again</a></button>
                                <button><a href="javascript:void(0)">View your item</a></button>
                            </div>
                        </div>
                    </div>

                    <div class="oi_2r_2c">
                        <div class="item_btn order">
                            <button><a href="javascript:void(0)">Return items</a></button>
                            <button><a href="javascript:void(0)">Share gift receipt</a></button>
                            <button><a href="javascript:void(0)">Get help</a></button>
                            <button><a href="javascript:void(0)">Write a product review</a></button>
                        </div>
                    </div>
                    
                </div>';

        return $html;
        
    }



}
?>
        
