<?php
    include('config.php');
    if(isset($_POST['admin'])){
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $errors = array();

        if($user == ''){
            $errors['user'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập username!</div>";
        }
        if($pass == ''){
            $errors['pass'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập mật khẩu!</div>";
        }

        if(!$errors){
            $sql = "SELECT * FROM admin WHERE unAd='$user' AND pwAd='$pass'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                $_SESSION['showmess'] = "<div class='text-success' style=\"font-size: 14px\">Đăng nhập thành công!</div>";
                $_SESSION['user_admin'] = $user;
                header("location: admin/showfeedback.php");
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
                <form class="login-form" method="POST">
                    <h4>ADMIN ĐĂNG NHẬP</h4>
                    <?php 
                        if(isset($_SESSION['showmess'])){
                            echo $_SESSION['showmess'];
                            unset($_SESSION['showmess']);
                        }
                    ?>
                    <input class="mt-3" name="user" type="text" placeholder="Username"/>
                    <?php 
                        if(isset($errors['user'])){
                            echo $errors['user'];
                        }
                    ?>
                    <input name="pass" type="password" placeholder="Password"/>
                    <?php 
                        if(isset($errors['pass'])){
                            echo $errors['pass'];
                        }
                    ?>
                    <button name="admin">Đăng nhập</button>
                </form>
            </div>
            
            <div class="pen-footer">
                <a href="index.php">
                    <i class="material-icons">&lt;</i>
                    Về Trang chủ
                </a>
                <a href="login.php">
                    Tôi là khách hàng
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