<?php include('header.php');

if(isset($_POST['save'])){
    $type = '';
    if (isset($_POST['type'])){
        $type = $_POST['type'];
    }

    $type = str_replace('\'','\\\'',$type);
    $errors = array();

    if ($type == ''){
        $errors['type'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập loại sản phẩm!</div>";
    }
    $sql = "SELECT * FROM loaisanpham where nameL = '$type'";
    $res = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($res);
    if($count >0){
        $errors['type'] ="<div class='text-danger' style=\"font-size: 14px\">Loại sản phẩm đã tồn tại!</div>";
    }
    if(!$errors){
        $sql = "INSERT into loaisanpham(nameL) values('$type')";
        $res = mysqli_query($conn,$sql);
        if($res == true){
            $_SESSION['showmess']= "<div class='text-success mb-3'>Thêm loại sản phẩm thành công</div>";
            header('location: showproduct.php');
        }
    }else{
        $_SESSION['themloai'] = "<div class='text-danger'>Thêm loại sản phẩm không thành công!</div>";
    }
}
?>

<h2 class="mt-3">THÊM LOẠI SẢN PHẨM</h2>
<hr>
<?php 
    if(isset($_SESSION['themloai'])){
        echo $_SESSION['themloai'];
        unset($_SESSION['themloai']);
    }
?>
<div class="modal-body">
    <form method="POST">
        <div class="mb-3">
            <label for="namePro" class="form-label">
                <b>Tên loại sản phẩm: </b>
            </label>
            <input type="text" class="form-control" id="type" name="type" placeholder="Nhập tên loại sản phẩm" value="<?php if(isset($type)){echo $type;} ?>">
            <?php 
                if(isset($errors['type'])){
                    echo $errors['type'];
                }
            ?>
        </div>

        <button name="save" class="btn btn-success bg-opacity-50 w-100">
            Xác nhận
        </button>
    </form>
</div>

<?php include('footer.php') ?>