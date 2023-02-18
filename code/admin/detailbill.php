<?php 
    include('header.php'); 
    if (isset($_GET['idHd'])) {
        $id = $_GET['idHd'];
        $sql = "SELECT * FROM hoadon h JOIN khachhang k ON h.idKh = k.idKh WHERE idHd = '$id'";
        $res = mysqli_query($conn, $sql);
        while ($rows = mysqli_fetch_assoc($res)) {
            $tenKh = $rows['nameKh'];
            $emailKh = $rows['emailKh'];
            $sdtKh = $rows['pnKh'];
            $dc = $rows['addressKh'];
            $ngay = $rows['created_at'];
        }
    }
?>

<h2 class="mt-3">CHI TIẾT HÓA ĐƠN <?php echo $id?></h2>
<h4>Tên khách hàng: <?php echo $tenKh?></h4>
<h5>
    Số điện thoại: <?php echo $sdtKh?> - Email: <?php echo $emailKh?>
</h5>
<h5>Giao đến: <?php echo $dc?></h5>
<h5>Ngày đặt: <?php echo $ngay?></h5>
<hr>
<div class="mb-3">
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
            <?php 
                $tongcong = 0;
                $sql4 = "SELECT * FROM chitiethoadon c JOIN sanpham s ON c.idSp = s.idSp
                        WHERE idHd = '$id'";
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
                                <img src='../img/product/$imageSp' style='width: 100px'>
                            </td>
                            <td>$price đ</td>
                            <td>$sl</td>
                            <td>$tong đ</td>
                        </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
</div>

<div class="text-center">
    <h4>Tổng cộng: <?php echo $tongcong?></h4>
</div>

<?php include('footer.php') ?>