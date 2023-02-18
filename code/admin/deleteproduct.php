<?php
    include('../config.php');
    if(isset($_GET['idSp'])){
        $idSp = $_GET['idSp'];
        $sql = 'SELECT idSp from sanpham';
        $res = mysqli_query($conn, $sql);
        $result = 0;
        while ($rows = mysqli_fetch_assoc($res)) {
            if($idSp == $rows['idSp']) {
                $result = 1;
            }
        }
        if($result == 0) {
            header('location: showdrink.php');
            die();
        }
        $sql = "DELETE FROM sanpham where idSp =$idSp";
        mysqli_query($conn,$sql);
        $_SESSION['showmess'] = "<div class='text-success mb-3'>Xóa sản phẩm thành công</div>";
        header('location: showproduct.php');
    }else{
        header('location: showproduct.php');
            die();
    }
?>