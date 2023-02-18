<?php include('config.php');?> 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- font -->
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Raleway&display=swap" rel="stylesheet">

        <!-- fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="css/style.css">

        <link rel="shortcut icon" href="img/logo/favicons/favicon-16x16.png">
        <!-- title -->
        <title>QM Shop</title>
    </head>
    <body>
        <!-- Navbar -->
        <header>
            <section class="my-navbar">
                <div class="container">
                    <div class="logo">
                        <img src="img/logo/logo.png" alt="Shop Logo" class="img-responsive">
                    </div>
                    <div class="menu text-right">
                        <ul>
                            <li>
                                <a href="index.php">TRANG CHỦ</a>
                            </li>
                            <li>
                                <a href="intro.php">GIỚI THIỆU</a>
                            </li>
                            <li>
                                <a href="product.php">SẢN PHẨM</a>
                            </li>
                            <li>
                                <a href="contact.php">LIÊN HỆ</a>
                            </li>
                            <li>
                                <?php include('checklogin.php');?>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix">
    
                    </div>
                </div>
            </section>
            <div class="padding"></div>
        </header>