<?php 

require_once("includes/config.php");
require_once("includes/classes/GetProduct.php");

$preview = new GetProduct($con);

$tot_nb_pgs = $preview::$tot_nb_pgs;
$p_nb = $preview::$p_nb;


if(isset($_POST['search'])){
    
    if(isset($_GET['page_no']) && $_GET['page_no'] !=""){
        $p_nb = $_GET['page_no'];

    }else{
        $p_nb = 1;
    }

    $p_range = isset($_POST['price_range']) ? $_POST['price_range'] : 200;
    $category = isset($_POST['category']) ? $_POST['category'] : 'breadSweet';

    $query = $preview->getSearchProduct($p_range, $category);
    

} else {

    if(isset($_GET['page_no']) && $_GET['page_no'] !=""){
        $p_nb = $_GET['page_no'];

    }else{
        $p_nb = 1;
    }

    $query = $preview->getSearchProduct(null, null);

}

$prev_page = $p_nb - 1;
$next_page = $p_nb + 1;

?>

    <?php require_once('includes/header.php'); ?>

    <div class="wrapper">


        <div class="shopContainer">
            
            <!-- Search -->
            <section class="searchSect">
                <div class="searchSticky">

                    <div class="searchTitle">
                        <p>Search Products</p>
                        <hr>
                    </div>

                    <form action="shop.php" method="POST">

                        <div class="searchCateCont">
                            <div class="searchCate">
                            
                                <p class="searchP">Category</P>
                                
                                <div class="form-check">
                                    <input class="searchInput" value="foodbox" type="radio" 
                                        name="category" <?php echo (isset($category) && $category =='foodbox')?'checked':''; ?> >
                                    <label class="cate-label" for="flexRadioDefault1">Footbox</label>
                                </div>

                                <div class="form-check">
                                    <input class="searchInput" value="diary" type="radio" 
                                        name="category" <?php echo (isset($category) && $category =='diary')?'checked':''; ?> >
                                    <label class="cate-label" for="flexRadioDefault1">Diary</label>
                                </div>

                                <div class="form-check">
                                    <input class="searchInput" value="meat" type="radio" 
                                        name="category" <?php echo (isset($category) && $category =='meat')?'checked':''; ?> >
                                    <label class="cate-label" for="flexRadioDefault1">Meat</label>
                                </div>

                                <div class="form-check">
                                    <input class="searchInput" value="breadSweet" type="radio" 
                                        name="category" <?php echo (isset($category) && $category =='breadSweet')?'checked':''; ?> >
                                    <label class="cate-label" for="flexRadioDefault1">Bead & Sweet</label>
                                </div>

                                <div class="form-check">
                                    <input class="searchInput" value="vegetables" type="radio" 
                                        name="category" <?php echo (isset($category) && $category =='vegetables')?'checked':''; ?> >
                                    <label class="cate-label" for="flexRadioDefault1">Vegetables</label>
                                </div>

                                <div class="form-check">
                                    <input class="searchInput" value="fruits" type="radio" 
                                        name="category" <?php echo (isset($category) && $category =='fruits')?'checked':''; ?> >
                                    <label class="cate-label" for="flexRadioDefault1">Fruits</label>
                                </div>

                            </div>
                        </div> 
                        
                        <div class="rangeCont">
                            <div class="range-slider">
                                <p class="searchP">Price</p>
                                <span id="rs-bullet" class="rs-label">0</span>
                                <input id="rs-range-line" class="rs-range" 
                                    name="price_range" type="range" 
                                    value="<?php echo isset($p_range)?$p_range:'0'; ?>" 
                                    min="0" 
                                    max="200">
                            </div>
                            <div class="box-minmax">
                                <span>0</span><span>200</span>
                            </div>
                        </div>


                        <div class="searchBtn">
                            <input type="submit" name="search" value="Search" >
                        </div>
                    </form>
                </div>
            </section>
            <!-- Search -->



            <!-- Feature -->
            <section class="listContainer">

                <div class="listLabel">
                    <h3>Our Products</h3>
                    <p>Here you can check out our products</p>
                </div>

                <div class="listTable">

        <?php while($row = $query->fetch(PDO::FETCH_ASSOC)) { 
                    $randW = mt_rand(150, 220);     // math.random()
                    $randW2 = mt_rand(10, 80);
            ?>

                    <div class="listItem">
                        <img 
                            href="<?php echo "productDetail.php?product_id=".$row['product_id']; ?>"
                            src="assets/img/products/<?php 
                            echo $row['product_image1'];?>" style="width:<?php 
                            echo $randW ?>px; height:<?php 
                            echo $randW + $randW2 * 2 -$randW/2 ?>px;" />

                        <div class="star">

                        <?php  

                            $num = 0; $stars = 0; $starRate = 0;
                            $qry_star = $preview->getStar($row['product_id']);

                            if($qry_star->rowCount() > 0){

                                while($row_star = $qry_star->fetch(PDO::FETCH_ASSOC)){ 
                                    $num += 1;
                                    $stars += $row_star['star_rate']; 
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

                        </div>
                        <h5><?php echo $row['product_name']; ?></h5>
                        <h4>$<?php echo $row['product_price']; ?></h4>
                        <a class="button buyBtn"href="<?php echo "productDetail.php?product_id=".$row['product_id']; ?>">Buy Now</a>
                    </div>

        <?php } ?>
            <!-- Feature -->


                <!-- Pagination -->
                <div class="pageNavCont">
                    <div class="pagination">
                        <a href="<?php echo ($p_nb <= 1)?"#":"shop.php?page_no=".$prev_page ?>" <?php echo ($p_nb <= 1)?'disabled':''; ?>>Prev</a>

                    <?php for( $i= 0; $i < $tot_nb_pgs; $i++ ){   ?>
                        <a href="<?php echo "shop.php?page_no=".$i+1; ?>" ><?php echo $i+1; ?></a>
                    <?php } ?>
            
                        <a href="<?php echo ($p_nb >= $tot_nb_pgs)?"#":"shop.php?page_no=".$next_page ?>" <?php echo ($p_nb >= $tot_nb_pgs)?'disabled':''; ?>>Next</a>
                    </div>
                </div>

            </section>
        </div>

    </div><!-- wrapper -->

    <?php
        require_once("includes/footer.php");
    ?>


<script>
    
var rangeSlider = document.getElementById("rs-range-line");
var rangeBullet = document.getElementById("rs-bullet");

rangeSlider.addEventListener("input", showSliderValue, false);

function showSliderValue() {
  rangeBullet.innerHTML = rangeSlider.value;
  var bulletPosition = (rangeSlider.value /rangeSlider.max);
  rangeBullet.style.left = (bulletPosition * 108) + "px";
}

</script>

 
</body>
</html>
