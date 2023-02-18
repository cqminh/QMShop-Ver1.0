<?php include('header.php');?>

<div class="header-pro text-center">
    <div class="search-pro">
        <form action="search.php" method="GET">
            <input type="text" name="search-content" placeholder="Bạn cần tìm gì?">
            <input type="submit" value="Tìm kiếm" name="search">      
        </form>
    </div>
    <?php
    if (isset($_GET['search'])) {
        $search_content = $_GET['search-content'];
        $sql = "SELECT * FROM sanpham s JOIN xuatsusanpham x ON s.idXs = x.idXs
            WHERE nameSp LIKE '%$search_content%'";
        echo "
            <div class='search-result'>
                Kết quả tìm kiếm cho: <span style='color: #03989E'>$search_content</span>
            </div>
        ";
    }
    ?>
</div>

<div class="body-pro">
    <div class="container">
        <?php 
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        if($count > 0) {
            echo "
                <h3 class='text-center'>DANH SÁCH SẢN PHẨM</h3>
                <div class='row'>
            ";
            while ($rows = mysqli_fetch_assoc($res)){
                $id = $rows['idSp'];
                $ten = $rows['nameSp'];
                $idL = $rows['idL'];
                $idXs = $rows['idXs'];
                $xuatsu = $rows['nameXs'];
                $hinhanh = $rows['imageSp'];
                $gia = $rows['priceSp'];
                $sl = $rows['amountSp'];

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
            echo "</div>";

            $sql1 = "SELECT * FROM sanpham s JOIN xuatsusanpham x ON s.idXs = x.idXs
                        WHERE idL = $idL
                    EXCEPT
                    SELECT * FROM sanpham s JOIN xuatsusanpham x ON s.idXs = x.idXs
                        WHERE nameSp LIKE '%$search_content%'";
            $res1 = mysqli_query($conn, $sql1);
            $count1 = mysqli_num_rows($res1);
            if ($count1 > 0) {
                echo "
                    <h3 class='text-center mt-5'>SẢN PHẨM CÓ LIÊN QUAN</h3>
                    <div class='row'>
                ";
                while ($rows = mysqli_fetch_assoc($res1)){
                    $id = $rows['idSp'];
                    $ten = $rows['nameSp'];
                    $idL = $rows['idL'];
                    $idXs = $rows['idXs'];
                    $xuatsu = $rows['nameXs'];
                    $hinhanh = $rows['imageSp'];
                    $gia = $rows['priceSp'];
                    $sl = $rows['amountSp'];
    
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
                echo "</div>";
            } 
        } elseif($_GET['search-content'] != '') {
            echo "
                <div class='text-center'>
                    <h5>Opss! Chúng tôi không có rồi!</h5>
                    <div>
                        <img src='./img/background/Unreachable.png' style='width: 300px;'>
                    </div>
                    <div>
                        <a href='product.php'>Tìm món khác</a>
                    </div>
                </div>
            ";
        }
        ?>
    </div>
</div>

<?php include('footer.php');?>