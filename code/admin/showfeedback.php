<?php include('header.php') ?>

<h2 class="mt-3">PHẢN HỒI CỦA KHÁCH HÀNG</h2>
<hr>
<div class="mb-3">
    <table>
        <thead>
            <tr>
                <th>Email khách hàng</th>
                <th>Nội dung</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $sql = "SELECT * FROM phanhoi ORDER BY idPh DESC";
                $res = mysqli_query($conn, $sql);
                while ($rows = mysqli_fetch_assoc($res)) {
                    $email = $rows['emailKh'];
                    $content = $rows['content'];

                    echo "
                        <tr>
                            <td>$email</td>
                            <td>$content</td>
                        </tr>
                    ";
                }
            ?>
        </tbody>
    </table>
</div>

<?php include('footer.php') ?>