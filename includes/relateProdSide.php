<?php 
require_once("includes/cartSession.php"); 
?>

        <div class="sideContainer cart mt-5 pb-5">
            
            <div class="side arr py-5">
                 
                 <h3>Featured items You may like</h3>
                 <hr class="side mx-auto">
            </div>

            <div class="prd_container side row mx-auto ">
    <?php 
        require_once('includes/classes/GetProduct.php');
        $preview = new GetProduct($con);

        $qryR = $preview->getRandProduct();
            while($rowR = $qryR->fetch(PDO::FETCH_ASSOC)){ 
    ?> 
            <div class="prd_rel side cart">
                <img class="p_img side mb-3" src="assets/img/products/<?php echo $rowR['product_image1']; ?>"/>
                <div class="order side cart">
                    <p class="p-name side "><?php echo $rowR['product_name']; ?></p>
                    <p class="p-desc side "><?php echo $rowR['product_thumb_desc']; ?></p>
                    <p class="p-price side ">$<?php echo $rowR['product_price']; ?></p>

                    <form method="POST" id="addCartform">  
                        <input type="hidden" name="product_id" value="<?php echo $rowR['product_id']; ?>"/>
                        <input type="hidden" name="product_image1" value="<?php echo $rowR['product_image1']; ?>"/>
                        <input type="hidden" name="product_name" value="<?php echo $rowR['product_name']; ?>"/>
                        <input type="hidden" name="product_price" value="<?php echo $rowR['product_price']; ?>"/>
                        <input type="hidden" name="product_desc" value="<?php echo $rowR['product_thumb_desc']; ?>"/>
                        <input type="hidden" name="product_qty" value="1"/>
                        <button class="buy-btn" type="submit" name="submit">Add to Cart</a></button>
                    </form>
                    
                </div>
            </div>

        <?php }  ?>   
            </div>

        </div> 
