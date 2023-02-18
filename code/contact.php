<?php 
    include('header.php');
    if (isset($_POST['submit'])) {
        $email = $content = '';
        $errors = array();
        if (isset($_POST['email'])) $email = $_POST['email'];
        if (isset($_POST['content'])) $content = $_POST['content'];

        $email = str_replace('\'','\\\'',$email);
        $content = str_replace('\'','\\\'',$content);
        if ($email == ''){
            $errors['email'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập email!</div>";
        }
        if ($content == ''){
            $errors['content'] = "<div class='text-danger' style=\"font-size: 14px\">Bạn chưa nhập nội dung!</div>";
        }

        if (!$errors) {
            $sql = "INSERT INTO phanhoi(emailKh, content) VALUES ('$email', '$content')";
            $res = mysqli_query($conn,$sql);
            if ($res == true) {
                $_SESSION['showmess']= "<div class='text-success mb-3'>Đã gửi thành công! Cảm ơn bạn đã đánh giá!</div>";
            } 
        } else {
            $_SESSION['showmess'] = "<div class='text-danger'>Gửi ý kiến không thành công!</div>";
        }
    }
?>

<div class="container-fluid container-contact">
    <h3 class="text-center">THÔNG TIN LIÊN HỆ</h3>
    <div class="text-center">
        <?php 
            if(isset($_SESSION['showmess'])){
                echo $_SESSION['showmess'];
                unset($_SESSION['showmess']);
            }
        ?>
    </div>
    <div class="row">
        <div class="col-6 contact-col-left">
            <h5 class="text-center">Trụ sở chính</h5>
            <div class="contact-content">
                <div class="contact-address">
                    Địa chỉ: Số 1, Đường X, Phường Y, Quận Z, TP.Cần Thơ
                </div>
                <br>
                <div class="contact-phone">
                    Tel: 1234 5678
                </div>
                <div class="contact-email">
                    Email: qmshop@gmail.com
                </div>
            </div>
        </div>
        <div class="col-6 contact-col-right">
            <h5 class="text-center">Xem trên map</h5>
            <div class="contact-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d8568.788963881454!2d105.77671880857076!3d10.032760949820632!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1649639017132!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <hr>
    <div class="text-center contact-form">
        <h4>Ý kiến đóng góp</h4>
        <div>
            Điền vào form bên dưới để chúng tôi hoàn thiện hơn
        </div>
        <div class="form-contact">
            <form method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="email">Email:</label>
                        </td>
                        <td>
                            <input type="text" name="email" id="email" placeholder="Nhập email của bạn">
                                <?php 
                                    if(isset($errors['email'])){
                                        echo $errors['email'];
                                    }
                                ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="content">Nội dung:</label>
                        </td>
                        <td>
                            <textarea cols="20" rows="5" name="content" id="content" placeholder="Nhập nội dung đóng góp"></textarea>
                            <?php 
                                if(isset($errors['content'])){
                                    echo $errors['content'];
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="submit">Gửi</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>


<?php include('footer.php');?>