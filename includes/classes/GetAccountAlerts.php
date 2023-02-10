<?php


class GetAccountAlerts {

        
    public static function getOrderlistAlert(){

        $html ='';
        $html .='<div class="m_sec ord"> 
                    <div class="ord_flex">
                        <a href="javascript:void(0)"><h3><i class=\'fa-solid fa-plus\'></i>&nbsp &nbsp Wish List</h3></a>
                    </div>
                    <hr class="order_hr">
                    <div class="ord_center">
                        <p>You haven\'t added any products to "New List"</p>
                        <button class="ord_buy"><a href="shop.php">Start Shopping</a></button>
                    </div>
                </div>';

        return $html;
    }

    public static function getAccountAlert(){

        $html ='';
        $html .='<div class="m_sec acc empty">
        
                    <div class="ord_center">
                        <p>There is no account info yet. 
                        </br></br> You can create it during the purchase process.</p>
                        </br>
                        <button class="ord_buy"><a href="shop.php">Start Shopping</a></button>
                        
                    </div>
                </div>';

        return $html;
    }


    public static function getSubscriptAlert($chked){

        $html ='';
        $html .='<div class="m_sec sub">
                    <div>
                        <form id="subscript" action="account.php" method="POST">
                            <input id="subinput" type="checkbox" checked />
                        </form>
                        <p id="signup">&nbsp Sign up to receive exclusive offers and news.</p> 
                    </div>
                    <div class="ord_center">
                        <p>To unsubscribe, uncheck the box at left and click 
                        <a href="account.php?tab=acc&sub='.$chked.'"><em>"update"</em></a>.</p>
                    </div>
                </div>';

        return $html;
    }


}
?>

