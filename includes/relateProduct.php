
<section id="prodRelated" class="mx-auto mt-5 pb-5">
            
            <div class="container prd text-center py-5">
                 <h2>You may also like</h3>
                 <hr class="mx-auto">
            </div>

            <div class="prd_container row mx-auto ">
    <?php 
        require_once('includes/classes/GetProduct.php');
        $preview = new GetProduct($con);

        $qry = $preview->getRandProduct();
            while($rowK = $qry->fetch(PDO::FETCH_ASSOC)){ 
    ?> 

            <div class="prd_rel text-center col-lg-3 col-md-4 col-sm-12">
                <img class="p_img mb-3" src="assets/img/products/<?php echo $rowK['product_image1']; ?>"/>
                <div class="star">

        <?php  
            $num = 0; $stars = 0; $starRate = 0;
            $qry_star = $preview->getStar($rowK['product_id']);

            if($qry_star->rowCount() > 0){
                while($rowSt = $qry_star->fetch(PDO::FETCH_ASSOC)){ 
                    $num += 1;
                    $stars += $rowSt['star_rate']; 
                }
                $starRate = $stars / $num;

                for( $i = 0; $i<$starRate; $i++){  ?>
                    <i class="fas fa-star"></i>

                <?php }
            } else {  ?>
                    <i class="fa fa-star-o"></i>
                    <span>no review</span>
                    <i class="fa fa-star-o"></i>
            <?php }?>
                    </div>  <!-- star -->
                    <h5 class="p-name"><?php echo $rowK['product_name']; ?></h5>
                    <h4 class="p-price">$<?php echo $rowK['product_price']; ?></h4>
                    <a  href="productDetail.php?product_id=<?php echo $rowK['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
                </div>

        <?php   }  ?>   
            </div>

        </section> 