<?php include('header.php');

if (isset($_GET['idSp'])) {
    $idSp = $_GET['idSp'];
    $sql = 'SELECT idSp FROM sanpham';
    $res = mysqli_query($conn, $sql);
    $result = 0;
    while ($rows = mysqli_fetch_assoc($res)) {
        if ($idSp == $rows['idSp']) $result = 1;
    }
    if ($result == 0) {
        header('location: showproduct.php');
        die();
    }
    $sql = "SELECT * FROM sanpham WHERE idSp = $idSp";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if($count == 1){
        while($rows = mysqli_fetch_assoc($res)) {
            $name = $rows['nameSp'];
            $type = $rows['idL'];
            $ori = $rows['idXs'];
            $nameImg = $rows['imageSp'];
            $price = $rows['priceSp'];
            $sl = $rows['amountSp'];
        }
    }
}else {
    header('location: showproduct.php');
    die();
}

if (isset($_POST['save'])) {
    $name = $type = $ori = $price = $sl = '';
    $errors = array();
    if(isset($_GET['idSp'])) {
        $idSp = $_GET['idSp'];
    }
    if(isset($_POST['name'])) {
        $name = $_POST['name'];
    }
    if(isset($_FILES['img']['name'])){
        $nameImg = $_FILES['img']['name'];
        $explode = end(explode('.',$nameImg));
        $nameImg = "Sp".rand(000,999).'.'.$explode;
        $from = $_FILES['img']['tmp_name'];
        $to = "../img/product/".$nameImg;
        $upload = move_uploaded_file($from,$to);
        if($upload == false) {
            $errors['img']="<div class='text-danger' style=\"font-size: 14px\">Chưa tải hình ảnh được!</div>";
        }
    }
    if(isset($_POST['type'])) {
        $type = $_POST['type'];
    }
    if(isset($_POST['ori'])) {
        $ori = $_POST['ori'];
    }
    if(isset($_POST['price'])) {
        $price = $_POST['price'];
    }
    if(isset($_POST['sl'])) {
        $sl = $_POST['sl'];
    }

    $name = str_replace('\'','\\\'',$name);

    if ($name == ''){
        $errors['name'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập tên sản phẩm!</div>";
    }
    if ($price <= 0 || $price % 1000 != 0){
        $errors['price'] = "<div class='text-danger' style=\"font-size: 14px\">Vui lòng nhập giá lớn hơn 0 và chia hết cho 1000!</div>";
    }
    if ($price == ''){
        $errors['price'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập giá sản phẩm!</div>";
    }
    if ($sl == ''){
        $errors['sl'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập số lượng sản phẩm!</div>";
    }
    if ($sl <= 0){
        $errors['price'] = "<div class='text-danger' style=\"font-size: 14px\">Vui lòng nhập giá lớn hơn 0!</div>";
    }

    if(!$errors){
        $sql = "UPDATE `sanpham` SET `nameSp`='$name',`imageSp`='$nameImg',`idL`='$type',`idXs`='$ori',`priceSp`='$price',`amountSp`='$sl' WHERE idSp = $idSp";
        $res = mysqli_query($conn,$sql);
        if($res == true){
            $_SESSION['showmess']= "<div class='text-success mb-3'>Sửa sản phẩm thành công</div>";
            header('location: showproduct.php');
        }
    }else{
        $_SESSION['suasanpham'] = "<div class='text-danger'>Sửa sản phẩm không thành công!</div>";
    }
}
?>

<h2 class="mt-3">CHỈNH SỬA SẢN PHẨM</h2>
<hr>
<?php 
    if(isset($_SESSION['suasanpham'])){
        echo $_SESSION['suasanpham'];
        unset($_SESSION['suasanpham']);
    }
?>

<div class="modal-body">
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">
                <b>Tên sản phẩm: </b>
            </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên sản phẩm" value="<?php if(isset($name)){echo $name;} ?>">
            <?php 
                if(isset($errors['name'])){
                    echo $errors['name'];
                }
            ?>
        </div>
        <div class="mb-3">
            <label for="img" class="form-label">
                <b>Hình ảnh sản phẩm: </b>
            </label>
            <input type="file" class="form-control" id="img" name="img" value="<?php if(isset($nameImg)){echo $nameImg;} ?>">
            <?php 
                if(isset($errors['img'])){
                    echo $errors['img'];
                }
            ?>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">
                <b>Loại sản phẩm: </b>
            </label>
            <select name="type" id="type" class="form-control">
                <?php 
                    $sql1 = "SELECT * FROM loaisanpham";
                    $res1 = mysqli_query($conn, $sql1);
                    if ($res1 == true) {
                        while ($rows1 = mysqli_fetch_assoc($res1)) {
                            ?>
                            <option value="<?php echo $rows1['idL']?>"><?php echo $rows1['nameL']?></option>
                        <?php
                        }
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="ori" class="form-label">
                <b>Xuất sứ sản phẩm: </b>
            </label>
            <select name="ori" id="ori" class="form-control">
                <?php 
                    $sql2 = "SELECT * FROM xuatsusanpham";
                    $res2 = mysqli_query($conn, $sql2);
                    if ($res2 == true) {
                        while ($rows2 = mysqli_fetch_assoc($res2)) {
                            ?>
                            <option value="<?php echo $rows2['idXs']?>"><?php echo $rows2['nameXs']?></option>
                        <?php
                        }
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">
                <b>Giá sản phẩm: </b>
            </label>
            <input type="number" class="form-control" id="price" name="price" value="<?php if(isset($price)){echo $price;} ?>">
            <?php 
                if(isset($errors['price'])){
                    echo $errors['price'];
                }
            ?>
        </div>
        <div class="mb-3">
            <label for="sl" class="form-label">
                <b>Số lượng sản phẩm: </b>
            </label>
            <input type="number" class="form-control" id="sl" name="sl" value="<?php if(isset($sl)){echo $sl;} ?>">
            <?php 
                if(isset($errors['sl'])){
                    echo $errors['sl'];
                }
            ?>
        </div>

        <button name="save" class="btn btn-success bg-opacity-50 w-100">
            Xác nhận
        </button>
    </form>
</div>

<?php include('footer.php') ?>