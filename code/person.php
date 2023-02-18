<?php 
    include('header.php');
    // ID Customer
    if (isset($_SESSION['email_dn'])) {
        $email = $_SESSION['email_dn'];
        $sql3 = "SELECT * FROM khachhang WHERE emailKh = '$email'";
        $res3 = mysqli_query($conn, $sql3);
        while ($rows3 = mysqli_fetch_assoc($res3)){
            $idKh = $rows3['idKh'];
        }
    }
    // Delete Cart
    if (isset($_POST['delete'])) {
        $del = $_POST['delete'];
        unset($_SESSION['cart'][$del]);
        if (empty($_SESSION['cart'])) unset($_SESSION['cart']);
    }
    // Order
    if (isset($_POST['order'])) {
        $dc = '';
        $errors = array();
        if (isset($_POST['dc'])) $dc = $_POST['dc'];

        $dc = str_replace('\'','\\\'',$dc);
        if ($dc == '') $errors['dc'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập địa chỉ!</div>";
        foreach ($_SESSION['cart'] as $idSp => $soluong) {
            $sql5 = "SELECT * FROM sanpham WHERE idSp = '$idSp'";
            $res5 = mysqli_query($conn, $sql5);
            $rows5 = mysqli_fetch_assoc($res5);
            if ($soluong > $rows5['amountSp']){
                $errors['soluong'] = "<div class='text-danger text-center'>Đã có sản phẩm vượt số lượng trong kho!</div>";
            }
        }

        if (!$errors){
            $sql6 = "INSERT into hoadon(idKh,addressKh) values('$idKh','$dc')";
            $res6 = mysqli_query($conn, $sql6);
            if ($res6 == true) {
                $sql7 = "SELECT * FROM hoadon ORDER BY idHd DESC LIMIT 1";
                $res7 = mysqli_query($conn, $sql7);
                $rows7 = mysqli_fetch_assoc($res7);
                $idHdon = $rows7['idHd'];

                foreach ($_SESSION['cart'] as $idSp => $soluong) {
                    $sql8 = "SELECT * FROM sanpham WHERE idSp = '$idSp'";
                    $res8 = mysqli_query($conn, $sql8);
                    $rows8 = mysqli_fetch_assoc($res8);
                    $remain = $rows8['amountSp'];

                    $remain -= $soluong;
                    $sql9 = "UPDATE `sanpham` SET `amountSp`='$remain' WHERE idSp = $idSp";
                    $res9 = mysqli_query($conn, $sql9);
                    if ($res9 == true) {
                        $sql10 = "INSERT into chitiethoadon(idHd, idSp, soluong) values('$idHdon','$idSp','$soluong')";
                        $res10 = mysqli_query($conn, $sql10);
                        if ($res10 == true){
                            $_SESSION['showmess'] = "<div class='text-success text-center'>Đặt hàng thành công! Xem lại đơn tại Cá nhân > Lịch sử mua hàng.</div>";
                        }
                    }
                }
                unset($_SESSION['cart']);
            }
        } else $_SESSION['showmess'] = "<div class='text-danger text-center'>Đặt hàng không thành công!</div>";
    }
?>

<div class="container-fluid row">
    <div class="personal-nav col-2 text-center" id="nav-personal">
        <div class="nav-btn active" id="btn-cart">
            Giỏ hàng
        </div>
        <div class="nav-btn" id="btn-history">
            Lịch sử mua hàng
        </div>
    </div>
    <!-- Cart -->
    <div class="personal-content col-10">
        <div class="cart" id="cart">
            <h3 class="text-center">GIỎ HÀNG</h3>
            <?php
                if(isset($_SESSION['showmess'])){
                    echo $_SESSION['showmess'];
                    unset($_SESSION['showmess']);
                }
                if (isset($errors['soluong'])) echo $errors['soluong'];
                if (isset($_SESSION['cart'])){
                    echo "
                    <div class='cart-detail'>
                        <form method = 'POST'>
                            <div class='text-right ship-detail'>
                                <label for='dc'>Địa chỉ:</label>
                                <input type='text' name='dc' id='dc' placeholder='Bạn muốn giao đến đâu?'";
                            if (isset($_SESSION['dc_cart'])) {
                                $dc_cart = $_SESSION['dc_cart'];
                                echo "value='$dc_cart'";}
                                echo ">";
                        if (isset($errors['dc'])) echo $errors['dc'];
                        echo "</div>
                            <div class='mt-2 cart-detail'>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Hình ảnh</th>
                                            <th>Đơn giá</th>
                                            <th>Số lượng</th>
                                            <th>Thành tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    ";

                    $total = 0;
                    foreach ($_SESSION['cart'] as $key => $val) {
                        $sql1 = "SELECT * FROM sanpham WHERE idSp = '$key'";
                        $res1 = mysqli_query($conn, $sql1);
                        $count1 = mysqli_num_rows($res1);
                        if ($count1 == 1){
                            $rows1 = mysqli_fetch_assoc($res1);
                            $tenSp = $rows1['nameSp'];
                            $hinhanh = $rows1['imageSp'];
                            $gia = $rows1['priceSp'];
                            $money = $gia * $val;
                            $total += $money;
                        }
                        echo "
                            <tr>
                                <td>$tenSp</td>
                                <td>
                                    <img src='./img/product/$hinhanh' style='width: 100px'>
                                </td>
                                <td>$gia đ</td>
                                <td>$val</td>
                                <td>$money đ</td>
                                <td>
                                    <button name='delete' class='delete-cart' id='delete' value='$key'>
                                        Xóa
                                    </button>
                                </td>
                            </tr>
                        ";
                    }

                    echo "
                                    </tbody>
                                </table>
                            </div>

                            <div class='text-center mt-3'>
                                <h4>Tổng thanh toán: $total đ</h4>
                                <button class='order' name='order' id='order' type='submit'>
                                    Đặt hàng
                                </button>
                            </div>
                        </form>
                    </div>
                    ";
                }
                else echo "
                    <div class='cart-none text-center'>
                        <p>\"Hổng\" có gì trong giỏ hàng hết!</p>
                        <img src='./img/background/cart-none.png' style='width: 200px'>
                        <div>
                            <a href='product.php'>Mua sắm ngay</a>
                        </div>
                    </div>
                ";
            ?>
        </div>
        <!-- History -->
        <div class="history hide" id="history">
            <h3 class="text-center">LỊCH SỬ MUA HÀNG</h3>
            <?php
                $sql2 = "SELECT * FROM hoadon WHERE idKh = '$idKh' ORDER BY idHd DESC";
                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($res2);
                if ($count2 > 0) {
                    echo "<div class='history-content text-center'>";
                    while ($rows2 = mysqli_fetch_assoc($res2)){
                        $date = $rows2['created_at'];
                        $addressKh = $rows2['addressKh'];
                        $idHd = $rows2['idHd'];

                        echo "
                            <hr>
                            <h4>Đặt ngày: $date</h4>
                            <p>Giao đến: $addressKh</p>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Tên</th>
                                        <th>Hình ảnh</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                        ";

                        $tongcong = 0;
                        $sql4 = "SELECT * FROM chitiethoadon c JOIN sanpham s ON c.idSp = s.idSp
                                WHERE idHd = '$idHd'";
                        $res4 = mysqli_query($conn, $sql4);
                        while ($rows4 = mysqli_fetch_assoc($res4)){
                            $nameSp = $rows4['nameSp'];
                            $imageSp = $rows4['imageSp'];
                            $price = $rows4['priceSp'];
                            $sl = $rows4['soluong'];
                            $tong = $price * $sl;
                            $tongcong += $tong;

                            echo "
                                <tr>
                                    <td>$nameSp</td>
                                    <td>
                                        <img src='./img/product/$imageSp' style='width: 100px'>
                                    </td>
                                    <td>$price đ</td>
                                    <td>$sl</td>
                                    <td>$tong đ</td>
                                </tr>
                            ";
                        }

                        echo "
                                    </tbody>
                            </table>
                            <h4 class='mt-2'>Tổng tiền: $tongcong đ</h4>
                        ";
                    }
                    echo "</div>";
                }
                else echo "
                    <div class='history-none text-center'>
                        <p>Bạn chưa có đơn hàng nào!</p>
                        <img src='./img/background/history-none.png' style='width: 200px'>
                        <div>
                            <a href='product.php'>Mua hàng ngay</a>
                        </div>
                    </div>
                ";
            ?>
        </div>
    </div>
</div>

<?php include('footer.php');?>