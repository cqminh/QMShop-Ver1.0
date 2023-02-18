<?php
    include('config.php');
    if(isset($_POST['dangky'])){
        $name = $email = $pass = $phone = '';

        if(isset($_POST['email'])){
            $email = $_POST['email'];
        }
        if(isset($_POST['name'])){
            $name = $_POST['name'];
        }
        if(isset($_POST['pass'])){
            $pass = $_POST['pass'];
        }
        if(isset($_POST['phone'])){
            $phone = $_POST['phone'];
        }

        $name = str_replace('\'','\\\'',$name);
        $email = str_replace('\'','\\\'',$email);
        $pass = str_replace('\'','\\\'',$pass);
        $phone = str_replace('\'','\\\'',$phone);

        $errors = array();
        if ($name == '') {
            $errors['name']="<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập tên!</div>";
        }
        if ($email == '') {
            $errors['email']="<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập email!</div>";
        }
        if ($pass == '') {
            $errors['pass']="<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập password!</div>";
        }
        if ($phone == '') {
            $errors['phone']="<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập số điện thoại!</div>";
        }

        $sql1 = "SELECT * FROM khachhang WHERE emailKh = '$email'";
        $res1 = mysqli_query($conn, $sql1);
        $count = mysqli_num_rows($res1);
        if($count == 1) {
            $errors['email'] = "<div class='text-danger' style=\"font-size: 14px\">Email đã tồn tại!</div>";
        }
        if(!$errors){
            $sql = "INSERT INTO khachhang(emailKh, nameKh, pwKh, pnKh) values('$email','$name','$pass','$phone')";
            $res = mysqli_query($conn,$sql);
            if($res == true){
                $_SESSION['showmess'] = "<div class='text-success style=\"font-size: 14px\"'>Đăng ký thành công. Bạn có thể đăng nhập ngay bây giờ!</div>";
            }
        } else{
            $_SESSION['showmess'] = "<div class='text-danger' style=\"font-size: 14px\">Đăng ký thất bại. Vào phần Đăng ký để biết thêm chi tiết!</div>";
        }
    }

    if(isset($_POST['dangnhap'])){
        $email_dn = $_POST['email_dn'];
        $pass_dn = $_POST['pass_dn'];
        $errors = array();

        if($email_dn == ''){
            $errors['email_dn'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập email!</div>";
        }
        if($pass_dn == ''){
            $errors['pass_dn'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập mật khẩu!</div>";
        }

        if(!$errors){
            $sql = "SELECT * FROM khachhang WHERE emailKh='$email_dn' AND pwKh='$pass_dn'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                $_SESSION['showmess'] = "<div class='text-success' style=\"font-size: 14px\">Đăng nhập thành công!</div>";
                $_SESSION['email_dn'] = $email_dn;
                header("location: index.php");
            }
            else {
                $_SESSION['showmess'] = "<div class='text-danger' style=\"font-size: 14px\">Tài khoản và mật khẩu không tồn tại!</div>";
            }
        } else {
            $_SESSION['showmess'] = "<div class='text-danger' style=\"font-size: 14px\">Đăng nhập thất bại!</div>";
        }
    }
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
        <link rel="stylesheet" href="css/login1.css">

        <link rel="shortcut icon" href="img/logo/favicons/favicon-16x16.png">
        <!-- title -->
        <title>QM Shop</title>
    </head>
    <body>
    <main>
        <div class="login-page">
            <div class="form">
                <form class="register-form" method="POST">
                    <h4>ĐĂNG KÝ</h4>
                    <input class="mt-3" type="email" name="email" placeholder="Email"/>
                    <?php 
                        if(isset($errors['email'])){
                            echo $errors['email'];
                        }
                    ?>
                    <input type="text" name="name" placeholder="Tên"/>
                    <?php 
                        if(isset($errors['name'])){
                            echo $errors['name'];
                        }
                    ?>
                    <input type="password" name="pass" placeholder="Password"/>
                    <?php 
                        if(isset($errors['pass'])){
                            echo $errors['pass'];
                        }
                    ?>
                    <input type="text" name="phone" placeholder="Số điện thoại"/>
                    <?php 
                        if(isset($errors['phone'])){
                            echo $errors['phone'];
                        }
                    ?>
                    <button name="dangky">Đăng ký</button>
                    <p class="message">Bạn đã có tài khoản? <a>Đăng nhập</a></p>
                </form>
                <form class="login-form" method="POST">
                    <h4>ĐĂNG NHẬP</h4>
                    <?php 
                        if(isset($_SESSION['showmess'])){
                            echo $_SESSION['showmess'];
                            unset($_SESSION['showmess']);
                        }
                    ?>
                    <input class="mt-3" name="email_dn" type="email" placeholder="Email"/>
                    <?php 
                        if(isset($errors['email_dn'])){
                            echo $errors['email_dn'];
                        }
                    ?>
                    <input name="pass_dn" type="password" placeholder="Password"/>
                    <?php 
                        if(isset($errors['pass_dn'])){
                            echo $errors['pass_dn'];
                        }
                    ?>
                    <button name="dangnhap">Đăng nhập</button>
                    <p class="message">Bạn chưa có tài khoản? <a>Đăng ký</a></p>
                </form>
            </div>
            
            <div class="pen-footer">
                <a href="index.php">
                    <i class="material-icons">&lt;</i>
                    Về Trang chủ
                </a>
                <a href="adminlogin.php">
                    Tôi là admin
                    <i class="material-icons">&gt;</i>
                </a>
            </div>
        </div>
    </main>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="js/login.js"></script>
    </body>
</html>