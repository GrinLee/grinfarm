<?php


if(isset($_POST['submit']) ){    // from productDetail.php 

    if(isset($_SESSION['cart'])){

       
        $s_id_arr = array_column($_SESSION['cart'], "p_id"); 
        
        if( !in_array($_POST['product_id'], $s_id_arr)){

            $p_id = $_POST['product_id'];

            $prd_array = array(
                'p_id' => $_POST['product_id'],
                'p_name' => $_POST['product_name'],
                'p_desc' => $_POST['product_desc'],
                'p_price' => $_POST['product_price'],
                'p_image' => $_POST['product_image1'],
                'p_qty' => $_POST['product_qty']
            );      

            $_SESSION['cart'][$p_id] = $prd_array; 
                

        } else {
            echo '<script>alert("This product is alreay in cart");</script>';
            echo '<script>window.Location="cart.php";</script>';
        }


    } else {    // no cart session  --------------------

        var_dump("no cart here");

        $p_id = $_POST['product_id'];

        $prd_array = array(
            'p_id' => $_POST['product_id'],
            'p_name' => $_POST['product_name'],
            'p_desc' => $_POST['product_desc'],
            'p_price' => $_POST['product_price'],
            'p_image' => $_POST['product_image1'],
            'p_qty' => $_POST['product_qty']
        );  

        $_SESSION['cart'][$p_id] = $prd_array;

    }
    
    calc_total();
    updateSess();

} else if (isset($_POST['remove_btn'])){

    $p_id = $_POST['product_id'];
    unset($_SESSION['cart'][$p_id]);
              
    calc_total();


} else if (isset($_POST['edit_btn'])){

    $p_id = $_POST['product_id'];
    $edit_qty = $_POST['edit_qty'];

    $p_array = $_SESSION['cart'][$p_id];    // EXACT inner Array
    $p_array['p_qty'] = $edit_qty;          // SELECT key   

    $_SESSION['cart'][$p_id] = $p_array;

    calc_total();


} else if (!isset($_SESSION['cart']) && !isset($_SESSION["loggedIn"])){

    echo '<script>alert("Cart is empty");</script>';
    header('Location: shop.php');      

}

function updateSess(){

    $urlget = isset($_GET['tab'])?"?tab=".$_GET['tab']:"";
    header('Location: ' . $_SERVER['PHP_SELF'].$urlget);
    location.reload();
}

function calc_total(){
    
    $total_price = 0;
    $total_qty = 0;
                                        
    if(is_array($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $key => $value){  // $v === $_SESSION['cart'][$k]
            $total_price = $total_price + ( $value['p_qty'] * $value['p_price'] );
            $total_qty = $total_qty + $value['p_qty']; }

        // while( $row = $_SESSION['cart'][$p_id]->fetch_assoc()){
        //     $total_price = $total + ($row['p_qty'] * $row['p_price']);
        //     $total_qty = $total_qty + $row['p_qty']; }

    }

    $_SESSION['total'] = $total_price;
    $_SESSION['qty'] = $total_qty;
}


?>

