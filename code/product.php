<?php include('header.php');?>

<div class="header-pro text-center">
    <div class="search-pro">
        <form action="search.php" method="GET">
            <input type="text" name="search-content" placeholder="Bạn cần tìm gì?">
            <input type="submit" value="Tìm kiếm" name="search">      
        </form>
    </div>
</div>

<div class="body-pro">
    <div class="container">
        <h3 class="text-center">DANH SÁCH SẢN PHẨM</h3>
        <div class="row">
            <?php
            $sql = "SELECT * FROM sanpham ORDER BY idSp DESC";
            $res = mysqli_query($conn, $sql);
            if ($res == true) {
                while ($rows = mysqli_fetch_assoc($res)) {
                    $id = $rows['idSp'];
                    $ten = $rows['nameSp'];
                    $idL = $rows['idL'];
                    $idXs = $rows['idXs'];
                    $hinhanh = $rows['imageSp'];
                    $gia = $rows['priceSp'];
                    $sl = $rows['amountSp'];
                    $sql1 = "SELECT * FROM xuatsusanpham WHERE idXs = $idXs";
                    $res1 = mysqli_query($conn, $sql1);
                    $count = mysqli_num_rows($res1);
                    if ($count == 1) {
                        $row = mysqli_fetch_assoc($res1);
                        $xuatsu = $row['nameXs'];
                    }
                    if ($sl > 0) $btn = "btn-order";
                    else $btn = "btn-sold-out";
                    echo "
                    <div class='col-4 mt-3'>
                        <div class='pro-box'>
                            <div class='pro-img'>
                                <img src='./img/product/$hinhanh'>
                            </div>
                            <div class='pro-content'>
                                <h4>$ten</h4>
                                <p class='pro-price'>$gia đ</p>
                                <p class='pro-ori'>$xuatsu</p>
                                <div class='$btn'>
                                    <a href='detail.php?idSp=$id'>
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    ";
                }
            }
            ?>      
    </div>
</div>

<?php include('footer.php');?>