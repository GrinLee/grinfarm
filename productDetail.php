<?php 

require_once("includes/config.php");


if(isset($_GET['product_id'])){

    $p_id = $_GET['product_id'];

    $query = $con->prepare("SELECT * FROM products WHERE product_id =:pid");
    $query->bindValue(":pid", $p_id);
    $query->execute();

} else {
    header('location: index.php');
}


?>


    <?php require_once("includes/header.php"); ?>
    
    <div class="wrapper">
        <div class="hbgspace"></div>

        <!-- Product Details -->
        <section class="productDetail mx_container my-5 pt-5">
            <div class="dt_container">

        <?php while($row = $query->fetch(PDO::FETCH_ASSOC)){ ?>

                <div class="dt_sm_group">
                    <div>
                        <img src="assets/img/products/<?php echo $row['product_image2']; ?>" width="100%" class="small-img" />
                    </div>
                    <div>
                        <img src="assets/img/products/<?php echo $row['product_image3']; ?>" width="100%" class="small-img" />
                    </div>
                    <div>
                        <img src="assets/img/products/<?php echo $row['product_image4']; ?>" width="100%" class="small-img" />
                    </div>
                </div>
                <div class="p_d_group">

                    <img class="detailImg" src="assets/img/products/<?php echo $row['product_image1']; ?>" id="mainImg" />

                </div> <!-- detailBox -->




                <div class="prodInfoCont">
                    <h4><?php echo $row['product_category']; ?></h6>
                    <h1 class="py-4"><?php echo $row['product_name']; ?></h3>
                    <h2>$<?php echo $row['product_price']; ?></h2>

                    <form method="POST" action="cart.php">  
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
                        <input type="hidden" name="product_image1" value="<?php echo $row['product_image1']; ?>"/>
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/>
                        <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>
                        <input type="hidden" name="product_desc" value="<?php echo $row['product_thumb_desc']; ?>"/>

                        <input type="number" name="product_qty" value="1" min="1"/>
                        <button class="buy-btn" type="submit" name="submit">Add to Cart</button>
                    </form>

                    <h5 class="detailTitle">Product Details</h4>
                    <span><?php echo $row['product_description']; ?></span>
                    <br>
                    <span><?php echo $row['product_thumb_desc']; ?></span>

                    
                    <h5 class="detailTitle">Ingredient</h4>
                    <span><?php echo $row['ingredient']; ?></span>
                </div>

        <?php  
            require_once('includes/classes/GetProduct.php');
            $preview = new GetProduct($con);
            $qry = $preview->getProduct($_GET['product_id'], $row['product_category']);
        }?>

            </section> <!-- Single Product -->


        <!-- review -->
            <section id="review" class="mx-auto pb-5">
            <div class="mx_container text-center py-5">
                 <h2>Reviews</h3>
                 <hr class="rev_hr">
            </div>

            <div class="rev_container row mx-auto ">

    <?php  $qry_rv = $preview->getReview($_GET['product_id']);

                while($row_rv = $qry_rv->fetch(PDO::FETCH_ASSOC)){ 
                    $unixtime = strtotime($row_rv['review_date']);
                    $m = date('m', $unixtime); //month
                    $y = date('y', $unixtime );
    ?> 

                <div class="rev_cont">
                    <div class="rev_left col-lg-3 col-md-4 col-sm-12">
                        <div class="star">
                            <?php for( $i = 0; $i<$row_rv['star_rate']; $i++){  ?>
                                <i class="fas fa-star"></i>
                            <?php } ?>
                        </div>
                        <p class="rv_name"><?php echo $row_rv['username']; ?></p>
                        <p class="rv_date"><?php echo $m.'.'.$y.'.'; ?></p>
                        
                    </div>
                    <div class="rev_right">
                        <p><?php echo $row_rv['review_text']; ?></p>
                    </div>
                </div>
                
    <?php   }  ?>   
            </div>
        </section> <!-- Review -->



        <!-- Related Products -->
           <section id="prodRelated" class="mx-auto pb-5">
            <div class="mx_container text-center py-5">
                 <h2>Related Products</h3>
                 <hr class="mx-auto">
            </div>

            <div class="prd_container row mx-auto ">
    <?php while($rowK = $qry->fetch(PDO::FETCH_ASSOC)){ 
                    $rowKid = $rowK['product_id'];
    ?> 

                <div class="prd_rel text-center col-lg-3 col-md-4 col-sm-12">

                    <a href="productDetail.php?product_id=<?php echo $rowK['product_id']; ?>">

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
                                <?php } ?>

                            </div>  <!-- star -->
                            <h5 class="p-name"><?php echo $rowK['product_name']; ?></h5>
                            <h4 class="p-price">$<?php echo $rowK['product_price']; ?></h4>
                            <button class="buy-btn">Add To Cart</button>
                        
                        </a>

                    </div>

        <?php   }  ?>   
            </div>

        </section> <!-- Related Products -->
    </div>

    <?php include('includes/footer.php'); ?>


      
</body>
</html>