<?php 

require_once("includes/config.php");
require_once('includes/classes/GetProduct.php');
require_once('includes/classes/GetOrders.php');
require_once("includes/cartSession.php"); 

if(isset($_SESSION['order_id'])){   

    unset($_SESSION['cart'], $_SESSION['total'], $_SESSION['qty']);

    $preview = new GetProduct($con);
    $qry = $preview->getOrderedProduct($_SESSION['order_id']); 
    
} else {
    // var_dump("no orderid");
    header('Location: index.php');
    exit;
}

function calc_order_total($od){

    $total = 0;
    foreach($od as $row){     

        $p_price = $row['product_price'];
        $p_qty = $row['product_quantity'];
        $total = $total + ($p_price * $p_qty);
    }
    return $total;
}

?>

    <?php require_once("includes/header.php"); ?>
    
    <div class="wrapper">
        <div class="hbgspace"></div>

        <!-- Order details -->
        <section class="orders container my-5 py-3">
            <div class="container">
                <h2 class="font-weight-bold text-center">Your Orders</h2>
                <!-- <hr class="mx-auto"> -->

                <div class="getList order" display="block">
                    <hr>
                    <div class="list_group">

                    <?php
                        $html ="";
                        while($row = $qry->fetch(PDO::FETCH_ASSOC)){    
                            $cell = GetOrders::getOrderDetail($row, $con);
                            $html .= $cell;
                        }
                        echo $html;
                    ?>

                    </div>
                </div>
            </div>
            <?php include('includes/relateProdSide.php'); ?>            
    
        </section>
        <!-- Order details --> 
    </div>
    
<?php include('includes/footer.php'); ?>

   
</body>
</html>