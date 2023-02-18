<?php include('header.php');

if(isset($_POST['save'])){
    $ori = '';
    if (isset($_POST['ori'])){
        $ori = $_POST['ori'];
    }

    $ori = str_replace('\'','\\\'',$ori);
    $errors = array();

    if ($ori == ''){
        $errors['ori'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập xuất sứ sản phẩm!</div>";
    }
    $sql = "SELECT * FROM xuatsusanpham where nameXs = '$ori'";
    $res = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($res);
    if($count >0){
        $errors['ori'] ="<div class='text-danger' style=\"font-size: 14px\">Xuất sứ sản phẩm đã tồn tại!</div>";
    }
    if(!$errors){
        $sql = "INSERT into xuatsusanpham(nameXs) values('$ori')";
        $res = mysqli_query($conn,$sql);
        if($res == true){
            $_SESSION['showmess']= "<div class='text-success mb-3'>Thêm xuất sứ thành công</div>";
            header('location: showproduct.php');
        }
    }else{
        $_SESSION['themxuatsu'] = "<div class='text-danger'>Thêm xuất sứ sản phẩm không thành công!</div>";
    }
}
?>

<h2 class="mt-3">THÊM XUẤT SỨ SẢN PHẨM</h2>
<hr>
<?php 
    if(isset($_SESSION['themxuatsu'])){
        echo $_SESSION['themxuatsu'];
        unset($_SESSION['themxuatsu']);
    }
?>
<div class="modal-body">
    <form method="POST">
        <div class="mb-3">
            <label for="namePro" class="form-label">
                <b>Tên xuất xứ sản phẩm: </b>
            </label>
            <input type="text" class="form-control" id="ori" name="ori" placeholder="Nhập tên xuất sứ sản phẩm" value="<?php if(isset($ori)){echo $ori;} ?>">
            <?php 
                if(isset($errors['ori'])){
                    echo $errors['ori'];
                }
            ?>
        </div>

        <button name="save" class="btn btn-success bg-opacity-50 w-100">
            Xác nhận
        </button>
    </form>
</div>

<?php include('footer.php') ?>