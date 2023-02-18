<?php 
    include('../config.php');
    session_destroy();
    $_SESSION['showmess'] = "<div class='text-danger' style=\"font-size: 14px\">Admin phải đăng nhập trước!</div>";
    header('location: ../adminlogin.php');
?>