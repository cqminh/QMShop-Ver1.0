<?php include('header.php');
    $doanhthu = 0;
    if (isset($_POST['ok'])) {
        $formDate = $toDate = '';
        $errors = array();
        if (isset($_POST['fromdate'])) $formDate = $_POST['fromdate'];
        if (isset($_POST['todate'])) $toDate = $_POST['todate'];

        if ($formDate == '') $errors['fromdate'] = "<div class='text-danger' style=\"font-size: 14px\">Vui lòng cho biết từ ngày nào!</div>";
        if ($toDate == '') $errors['todate'] = "<div class='text-danger' style=\"font-size: 14px\">Vui lòng cho biết đến ngày nào!</div>";
        
        if (!$errors){
            $sql = "SELECT `tinhDoanhThu`('$formDate', '$toDate') AS `tinhDoanhThu`";
            $res = mysqli_query($conn,$sql);
            if ($res == true) {
                $rows = mysqli_fetch_assoc($res);
                $doanhthu = $rows['tinhDoanhThu'];
            }
        }
    }
?>

<h2 class="mt-3">THỐNG KÊ DOANG SỐ</h2>
<hr>
<div class="mb-3">
    <form method="POST">
        <div class="mb-3">
            <label for="from" class="form-label">
                <b>Từ ngày: </b>
            </label>
            <input type="date" class="form-control" id="from" name="fromdate">
            <?php 
                if(isset($errors['fromdate'])){
                    echo $errors['fromdate'];
                }
            ?>
        </div>
        <div class="mb-3">
            <label for="to" class="form-label">
                <b>Đến ngày: </b>
            </label>
            <input type="date" class="form-control" id="to" name="todate">
            <?php 
                if(isset($errors['todate'])){
                    echo $errors['todate'];
                }
            ?>
        </div>

        <button name="ok" type="submit" class="btn btn-success bg-opacity-50 w-100">
            Xác nhận
        </button>
    </form>

    <h5 class="mt-2">Tổng doanh thu: <?php echo $doanhthu ?> đ</h5>
</div>

<?php include('footer.php') ?>