<?php 
    if(isset($_SESSION['email_dn'])){
        echo "
            <a href='person.php'>CÁ NHÂN</a>
        </li>
        <li>
            <a href='logout.php'>ĐĂNG XUẤT</a>
        ";
    }else{
        echo "<a href='login.php'>ĐĂNG NHẬP</a>";
    }
?>