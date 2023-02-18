<?php include('header.php');

if (isset($_POST['save'])) {
    $name = $type = $ori = $price = $sl = '';
    $errors = array();

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
        $errors['sl'] = "<div class='text-danger' style=\"font-size: 14px\">Vui lòng nhập số lượng lớn hơn 0!</div>";
    }

    if(!$errors){
        $sql = "INSERT into sanpham(nameSp,idL,idXs,imageSp,priceSp,amountSp) values('$name','$type','$ori','$nameImg','$price','$sl')";
        $res = mysqli_query($conn,$sql);
        if($res == true){
            $_SESSION['showmess']= "<div class='text-success mb-3'>Thêm sản phẩm thành công</div>";
            header('location: showproduct.php');
        }
    }else{
        $_SESSION['themsanpham'] = "<div class='text-danger'>Thêm sản phẩm không thành công!</div>";
    }
}
?>

<h2 class="mt-3">THÊM SẢN PHẨM</h2>
<hr>
<?php 
    if(isset($_SESSION['themsanpham'])){
        echo $_SESSION['themsanpham'];
        unset($_SESSION['themsanpham']);
    }
?>

<div class="modal-body">
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">
                <b>Tên sản phẩm: </b>
            </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên sản phẩm">
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
            <input type="file" class="form-control" id="img" name="img">
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
            <input type="number" class="form-control" id="price" name="price">
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
            <input type="number" class="form-control" id="sl" name="sl">
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