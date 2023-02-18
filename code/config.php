<?php
    session_start();
    $conn = mysqli_connect('localhost','root','','phutungxe');
    $charset =  mysqli_set_charset($conn, "UTF8");
?>