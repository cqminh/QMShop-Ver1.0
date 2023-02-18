<?php include('header.php');?>

<div class="text-center index-search">       
    <div class="search">
        <form action="search.php" method="GET">
            <div>
                <input type="text" name="search-content" placeholder="Bạn muốn tìm gì?">
                <input type="submit" value="Tìm kiếm" name="search">  
            </div>
        </form>
    </div>
</div>

<!-- Banner -->
<div class="text-center mt-5">
    <h2>Thông tin được quan tâm</h2>
</div>
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" alt="First slide" src="img/background/Banner-3.png"/>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" alt="Second slide" src="img/background/Banner-2.png"/>
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" alt="Third slide" src="img/background/Banner-1.png"/>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="index-recommend">
    <div class="container">
        <div class="index-most-buy row">
            <h4>Sản phẩm hot</h4>
            <?php 
                $sql1 = "CALL `top3BanChay`()";
                $res1 = mysqli_query($conn, $sql1);
                while ($rows1 = mysqli_fetch_assoc($res1)) {
                    $ten = $rows1['nameSp'];
                    $hinhanh = $rows1['imageSp'];
                    $gia = $rows1['priceSp'];
                    $id = $rows1['idSp'];

                    echo "
                        <div class='col-4'>
                            <div class='pro-index d-flex'>
                                <div>
                                    <img src='./img/product/$hinhanh' style='width: 100px'>
                                </div>
                                <div class='pro-index-content'>
                                    <a href='detail.php?idSp=$id'>$ten</a>
                                    <p>$gia đ</p>
                                </div>
                            </div>
                        </div>
                    ";
                }
            ?>
            <div class="text-center mt-3">
                <a href="product.php">Xem thêm</a>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php');?>