<?php include('header.php') ?>

<h2 class="mt-3">QUẢN LÝ HÓA ĐƠN</h2>
<hr>
<div class="mb-3">
    <table>
        <thead>
            <tr>
                <th>Email khách hàng</th>
                <th>Mã hóa đơn</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Xem chi tiết</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $sql = "SELECT * FROM hoadon h JOIN khachhang k ON h.idKh = k.idKh
                        ORDER BY idHd DESC";
                $res = mysqli_query($conn, $sql);
                if ($res == true) {
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $id = $rows['idHd'];
                        $email = $rows['emailKh'];
                        $ngaydat = $rows['created_at'];
                        $sql1 = "SELECT `tinhTongHoaDon`('$id') AS `tinhTongHoaDon`";
                        $res1 =  mysqli_query($conn, $sql1);
                        $rows1 = mysqli_fetch_assoc($res1);
                        $total = $rows1['tinhTongHoaDon'];

                        echo "
                            <tr>
                                <td>$email</td>
                                <td>$id</td>
                                <td>$ngaydat</td>
                                <td>$total đ</td>
                                <td>
                                    <a href='detailbill.php?idHd=$id' class='btn-xs btn_warning'>
                                        <i alt='Edit' class='fa fa-eye'> Xem thêm</i>
                                    </a>
                                </td>
                            </tr>
                        ";
                    }
                }
            
            ?>
        </tbody>
    </table>
</div>

<?php include('footer.php') ?>