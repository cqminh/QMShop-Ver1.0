<?php 
    include('header.php');
    // Show detail
    if (isset($_GET['idSp'])) {
        $id = $_GET['idSp'];
        $sql = "SELECT * FROM sanpham s JOIN xuatsusanpham x ON s.idXs = x.idXs
                                        JOIN loaisanpham l ON s.idL = l.idL
                                        WHERE idSp = $id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            $rows = mysqli_fetch_assoc($res);
            $ten = $rows['nameSp'];
            $idL = $rows['idL'];
            $loai = $rows['nameL'];
            $idXs = $rows['idXs'];
            $xuatsu = $rows['nameXs'];
            $hinhanh = $rows['imageSp'];
            $gia = $rows['priceSp'];
            $sl = $rows['amountSp'];

            $sql1 = "SELECT * FROM danhgia d JOIN khachhang k ON d.idKh = k.idKh
                    WHERE idSp = $id";
            $res1 = mysqli_query($conn, $sql1);
            $sodanhgia = mysqli_num_rows($res1);
        }
    }
    // ID Customer
    if (isset($_SESSION['email_dn'])) {
        $email = $_SESSION['email_dn'];
        $sql3 = "SELECT * FROM khachhang WHERE emailKh = '$email'";
        $res3 = mysqli_query($conn, $sql3);
        while ($rows3 = mysqli_fetch_assoc($res3)){
            $idKh = $rows3['idKh'];
        }
    }
    // Comment
    if (isset($_POST['post'])) {
        $cmt = $email = '';
        $errors_cmt = array();
        if (isset($_POST['cmt'])) $cmt = $_POST['cmt'];

        $cmt = str_replace('\'','\\\'',$cmt);
        if ($cmt == '') $errors_cmt['cmt'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập đánh giá!</div>";

        if(!$errors_cmt){
            $sql4 = "INSERT into danhgia(idKh,idSp,content) values('$idKh','$id','$cmt')";
            $res4 = mysqli_query($conn,$sql4);
            header("location: detail.php?idSp='$id'");
        }
    }
    // Order
    if (isset($_POST['order'])) {
        $dc = $amount = '';
        $errors_order = array();
        if (isset($_POST['dc'])) $dc = $_POST['dc'];
        if (isset($_POST['amount'])) $amount = $_POST['amount'];

        $dc = str_replace('\'','\\\'',$dc);
        if ($dc == '') $errors_order['dc'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập địa chỉ!</div>";
        if ($amount == '') $errors_order['amount'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập số lượng!</div>";
        if ($amount <= 0) $errors_order['amount'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn phải nhập số lượng lớn hơn 0!</div>";
        if ($amount > $sl) $errors_order['amount'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn phải nhập số lượng nhỏ hơn số lượng trong kho!</div>";
        
        if (!$errors_order) {
            $sql5 = "INSERT into hoadon(idKh,addressKh) values('$idKh','$dc')";
            $res5 = mysqli_query($conn, $sql5);
            if ($res5 == true) {
                $sql6 = "SELECT * FROM hoadon ORDER BY idHd DESC LIMIT 1";
                $res6 = mysqli_query($conn, $sql6);
                while ($rows6 = mysqli_fetch_assoc($res6)){
                    $idHd = $rows6['idHd'];
                }

                $sl -= $amount;
                $sql7 = "UPDATE `sanpham` SET `amountSp`='$sl' WHERE idSp = $id";
                $res7 = mysqli_query($conn, $sql7);
                if ($res7 == true) {
                    $sql8 = "INSERT into chitiethoadon(idHd, idSp, soluong) values('$idHd','$id','$amount')";
                    $res8 = mysqli_query($conn, $sql8);
                    if ($res8 == true){
                        $_SESSION['showmess'] = "<div class='text-success text-center'>Đặt hàng thành công! Xem lại đơn tại Cá nhân > Lịch sử mua hàng.</div>";
                    }
                }
            }
        } else $_SESSION['showmess'] = "<div class='text-danger text-center'>Đặt hàng không thành công!</div>";
    }
    // Cart
    if (isset($_POST['add'])){
        $amount_cart = '';
        $cart = $errors_cart = array();
        if (isset($_POST['dc'])) $dc_cart = $_POST['dc'];
        if (isset($_POST['amount'])) $amount_cart = $_POST['amount'];

        $dc_cart = str_replace('\'','\\\'',$dc_cart);
        if ($amount_cart == '') $errors_cart['amount'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập số lượng!</div>";
        if ($amount_cart <= 0) $errors_cart['amount'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn phải nhập số lượng lớn hơn 0!</div>";

        if (!$errors_cart) {
            if (isset($dc_cart)) $_SESSION['dc_cart'] = $dc_cart;
            $key = array($id);
            $val = array($amount_cart);
            $cart = array_combine($key, $val);

            if (isset($_SESSION['cart'])) $_SESSION['cart'] += $cart;
            else $_SESSION['cart'] = $cart;
            $_SESSION['showmess'] = "<div class='text-success text-center'>Đã thêm vào giỏ hàng! Xem lại tại Cá nhân > Giỏ hàng.</div>";
        } else $_SESSION['showmess'] = "<div class='text-danger text-center'>Thêm vào giỏ hàng không thành công!</div>";
    }
?>

<div class="main-detail">
    <?php 
        if(isset($_SESSION['showmess'])){
            echo $_SESSION['showmess'];
            unset($_SESSION['showmess']);
        }
    ?>
    <!-- Main product -->
    <div class="container row">
        <div class="detail-box offset-3 col-9 row">
            <div class="detail-img col-6">
                <img src="./img/product/<?php echo $hinhanh ?>">
            </div>
            <div class="detail-content col-6">
                <div class="detail-header">
                    <h3 class="mt-3"><?php echo $ten ?></h3>
                    <p><?php echo $sodanhgia ?> đánh giá</p>
                    <p>Xuất sứ: <?php echo $xuatsu ?></p>
                    <p>Phân loại: <?php echo $loai ?></p>
                </div>
                <hr>
                <div class="detail-order">
                    <h4><?php echo $gia ?>đ</h4>
                    <?php 
                        if ($sl > 0) echo "<p>Kho: $sl </p>";
                        else echo "<p style='color: #D63C2D'>Sản phẩm đã hết!</p>"
                    ?>
                    <form method="POST" class="info-order">
                        <div>
                            <label for="amount">Số lượng: </label>
                            <input type="number" id="amount" name="amount" value="1">
                            <?php 
                                if(isset($errors_order['amount'])){
                                    echo $errors_order['amount'];
                                }
                                if(isset($errors_cart['amount'])){
                                    echo $errors_cart['amount'];
                                }
                            ?>
                        </div>
                        <div class="mt-2">
                            <label for="dc">Địa chỉ: </label>
                            <input type="text" id="dc" name="dc" placeholder="Bạn muốn giao đến đâu?">
                            <?php 
                                if(isset($errors_order['dc'])){
                                    echo $errors_order['dc'];
                                }
                            ?>
                        </div>

                        <button <?php 
                                if(isset($_SESSION['email_dn'])) echo "name='add' type='submit'";
                                else echo "onclick='loginRequire()'";
                        ?> class="btn-add">
                            Thêm vào giỏ hàng
                        </button>
                        <button <?php 
                                if(isset($_SESSION['email_dn'])) echo "name='order' type='submit'";
                                else echo "onclick='loginRequire()'";
                                if ($sl <= 0) echo "disabled";
                        ?> class="btn-order">
                            Đặt hàng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Relate product -->
    <?php 
        $sql2 = "SELECT * FROM sanpham WHERE idSp IN
                (SELECT idSp FROM sanpham WHERE idL = $idL
                EXCEPT
                SELECT idSp FROM sanpham WHERE idSp = $id)
                LIMIT 3";
        $res2 = mysqli_query($conn, $sql2);
        $count2 = mysqli_num_rows($res2);
        if ($count2 > 0) {
            echo "
                <div class='container row'>
                    <div class='detail-box offset-3 col-9'>
                        <h3 class='mt-2'>Sản phẩm tương tự</h3>
                        <div class='row'>";
            while ($rows2 = mysqli_fetch_assoc($res2)){
                $id2 = $rows2['idSp'];
                $ten2 = $rows2['nameSp'];
                $hinhanh2 = $rows2['imageSp'];
                $gia2 = $rows2['priceSp'];

                echo "
                    <div class='col-4 mt-3'>
                        <div class='relate-box'>
                            <div class='relate-img'>
                                <img src='./img/product/$hinhanh2'>                             
                            </div>
                            <div class='relate-content'>
                                <a href='detail.php?idSp=$id2'>
                                    $ten2
                                </a>
                                <p class='pro-price'>$gia2 đ</p>
                            </div>
                        </div>
                    </div>";
            }
            echo "
                        <div class='text-center mt-2 mb-2'>
                                <a href='product.php'>Xem Thêm</a>
                            </div>
                        </div>
                    </div> 
                </div>";
        }
    ?>

    <!-- Comment -->
    <div class="container row">
        <div class="detail-box offset-3 col-9 row">
            <h3 class="mt-2">Đánh giá</h3>
            <div>
                <form class="add-cmt" method="POST">
                    <div>
                        <input type="text" id="cmt" name="cmt" placeholder="Bạn nghĩ gì về sản phẩm này?">
                        <button
                            <?php 
                                if(isset($_SESSION['email_dn'])) echo "name='post' type='submit'";
                                else echo "onclick='loginRequire()'";
                            ?>
                            class="btn-post">
                            Đăng
                        </button>
                    </div>
                    <?php 
                        if(isset($errors_cmt['cmt'])){
                            echo $errors_cmt['cmt'];
                        }
                    ?>
                </form>
            </div>

            <?php 
                if ($sodanhgia > 0) {
                    echo "<div class='cmt'>";
                    while ($rows1 = mysqli_fetch_assoc($res1)){
                        $tenKh = $rows1['nameKh'];
                        $noidung = $rows1['content'];

                        echo "
                            <div class='cmt-info'>
                                <hr>
                                <p class='cmt-name'>$tenKh</p>
                                <p class='cmt-content'>$noidung</p>
                            </div>";
                    }
                    echo "</div>";
                }
                else echo "
                    <div class='text-center'>
                        <hr>
                        <p>Sản phẩm chưa có đánh giá</p>
                    </div>";
            ?>          
        </div>
    </div>
</div>

<?php include('footer.php');?>