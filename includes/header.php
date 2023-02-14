<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=1.0, user-scalable=no" /> 
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link rel="icon" href="assets/img/logo/ficon.png" type="image/ico">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu|Ubuntu+Condensed|+Mono" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
    <script src="https://kit.fontawesome.com/396b632669.js" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <title>Grin Farm</title>
</head>

<body>

    <header>
        <div class="headContainer">
            <div class="headLogo">
                <a href="index.php">
                    <img src="assets/img/logo/logo.png" alt="logo">
                    <h2>Grin<br> Farmer</h2>
                </a>
            </div>
            <div class="headNav">
                <ul>
                    <li><a href="javascript:void(0)">FARMS</a></li>  
                    <li><a href="javascript:void(0)">WHAT WE DO</a></li>
                    <li><a href="shop.php">FRESH PRODUCE</a></li>

                    <li><a href="cart.php"><i class="fa-solid fa-cart-shopping">
                    <?php if(isset($_SESSION['qty']) && $_SESSION['qty'] != 0) { ?>
                        <span class="cart-qty"><?php echo $_SESSION['qty']; ?></span>
                    <?php } ?></i></a></li>

                    <li><?php echo isset($_SESSION['loggedIn'])?"<a id='user'>".$_SESSION['loggedIn']."</a>":"<a 
                    href='login.php'><i class='fa-regular fa-user'></i>"; ?></a></li>

                    <li><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>
                </ul>
             
            </div>

            <div class="hbgbox">
                <div class="hbger"></div>
            </div>            

            <div class="overlay-acc"  aria-haspopup="true"></div>
            <div class="dropAccount"  aria-haspopup="true">
                <!-- <h3>Your Account</h3>
                <hr> -->
                <ul>
                    <li><i class='fa-solid fa-plus'></i><a href='account.php?tab=acc'>Your Account</a></li>
                    <li><i class='fa-solid fa-plus'></i><a href="account.php?tab=ord">Your Orders</a></li>
                    <li><i class='fa-solid fa-plus'></i><a href="javascript:void(0)">Your Recommendations</a> </li>
                    <li><i class='fa-solid fa-plus'></i><a href="javascript:void(0)">Your Prime Membership</a> </li>
                    <li><i class='fa-solid fa-plus'></i><a href="javascript:void(0)">Your Apps & Devices</a></li>
                    <li><i class='fa-solid fa-plus'></i><a href="logout.php">Sign Out</a> </li>
                </ul>
            </div>
 

            
            <!-- <div id="topback"></div> -->
        </div>
    </header>

    