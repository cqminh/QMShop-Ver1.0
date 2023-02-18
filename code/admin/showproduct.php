<?php include('header.php') ?>

<h2 class="mt-3">QUẢN LÝ SẢN PHẨM</h2>
<?php 
    if(isset($_SESSION['showmess'])){
        echo $_SESSION['showmess'];
        unset($_SESSION['showmess']);
    }
?>
<hr>
<div class="add mb-2 row">
    <div class="add-pro col-4">
        <a href="addproduct.php" class="btn btn-lg text-white">
            + Thêm sản phẩm
        </a>
    </div>
    <div class="add-type col-4">
        <a href="addtype.php" class="btn btn-lg text-white">
            + Thêm loại
        </a>
    </div>
    <div class="add-original col-4">
        <a href="addoriginal.php" class="btn btn-lg text-white">
            + Thêm xuất sứ
        </a>
    </div>
</div>

<div class="mb-3">
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Hình ảnh</th>
                <th>Loại</th>
                <th>Xuất sứ</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $sql = "SELECT * FROM sanpham ORDER BY amountSp";
                $res = mysqli_query($conn, $sql);
                $index = 0;
                if ($res == true) {
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $index++;
                        $idSp = $rows['idSp'];
                        $idL = $rows['idL'];
                        $idXs = $rows['idXs'];
                        ?>
                        <tr>
                            <td><?php echo $index?></td>
                            <td><?php echo $rows['nameSp']?></td>
                            <td>
                            <?php
                                if($rows['imageSp'] != ''){
                                    ?>
                                    <img src="../img/product/<?php echo $rows['imageSp']?>" class="pro-img">
                                    <?php
                                }else {
                                    echo "Không có hình ảnh";
                                }
                            ?>
                            </td>
                            <td>
                                <?php
                                    $sql1 = "SELECT nameL FROM loaisanpham WHERE idL='$idL'";
                                    $res1 = mysqli_query($conn, $sql1);
                                    if($res1 == true) {
                                        while ($rows1 = mysqli_fetch_assoc($res1)){
                                            echo $rows1['nameL'];
                                        }
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $sql2 = "SELECT nameXs FROM xuatsusanpham WHERE idXs='$idXs'";
                                    $res2 = mysqli_query($conn, $sql2);
                                    if($res2 == true) {
                                        while ($rows2 = mysqli_fetch_assoc($res2)){
                                            echo $rows2['nameXs'];
                                        }
                                    }
                                ?>
                            </td>
                            <td><?php echo $rows['priceSp']."đ"?></td>
                            <td><?php echo $rows['amountSp']?></td>
                            <td>
                                <a href="editproduct.php?idSp=<?php echo $idSp ?>" class="btn-xs btn_warning">
                                    <i alt="Edit" class="fa fa-pencil"> Sửa</i>
                                </a>
                                <br>
                                <button class="btn-xs btn-danger">
                                    <a href="deleteproduct.php?idSp=<?php echo $idSp ?>">
                                        <i alt="Delete" class="fa fa-trash"> Xóa</i>
                                    </a>
                                </button>
                            </td>
                        </tr>
                    <?php
                    }
                }
            ?>
        </tbody>
    </table>
</div>                    

<?php include('footer.php') ?>