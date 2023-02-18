<?php 
include('../config.php');
include ('checklogin.php');
?> 

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

        <link rel="shortcut icon" href="../img/logo/favicons/favicon-16x16.png">
        <!-- title -->
        <title>QM Shop - admin</title>
    </head>
    <body>
        <div class="container-fluid row mt-2">
            <div class="col-2 navigation">
                <div class="logo col-10 offset-2 mt-2">
                    <img src="../img/logo/logo_transparent.png" class="img-responsive" alt="">
                </div>
                <div class="nav mt-5" id="nav">
                    <button class="btn">
                        <a href="showfeedback.php">Thư phản hồi</a>
                    </button>
                    <button class="btn">
                        <a href="showproduct.php">Quản lý sản phẩm</a>
                    </button>
                    <button class="btn">
                        <a href="showbill.php">Quản lý hóa đơn</a>
                    </button>
                    <button class="btn">
                        <a href="sales.php">Doanh số</a>
                    </button>
                    <button class="btn">
                        <a href="logout.php">Đăng xuất</a>
                    </button>
                </div>
            </div>
            
            <div class="col-10 content">             
                <div class="container main mt-5 mb-5">
                    <!--Main content-->