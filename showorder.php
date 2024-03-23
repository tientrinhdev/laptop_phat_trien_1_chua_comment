<?php
require "inc/init.php";
require "library.php";
if (Auth::isLoggedIn()) {
    $conn = include("inc/db.php");
    $username = $_SESSION['logged_in'];
    $user = User::getByUsername($conn, $username);
    $order = Order::getAll($conn, $user->id);
} else {
    Dialog::showAndRedirect("Vui lòng đăng nhập", "login.php");
}

require "inc/header.php";
?>
<!-- Table  -->
<div class="content">
    <fieldset>
        <legend>
            <h2>Đơn hàng</h2>
        </legend>
        <div class="content">
            <table>
                <thead>
                    <? if (!empty($order)) : ?>
                        <tr>
                            <th>TT</th>
                            <th>Mã đơn hàng</th>
                            <th>Thời gian đặt hàng</th>
                            <th>Chi tiết</th>
                        </tr>
                    <? endif; ?>
                </thead>
                <? $i = 1; ?>
                <? $tong = 0 ?>
                <? if (!empty($order)) : ?>
                    <?php foreach ($order as $o) : ?>
                        <tr>
                            <? $total ?>
                            <td align="center"><?= $i++ ?></td>
                            <td align="center"><?= $o['id_code'] ?></td>
                            <td align="center"><?=$o['created_order']?></td>
                            <td><a style="margin-right: 80px;" class="btn" href="orderdetail.php?id=<?= $o['id'] ?>">Chi tiết đơn hàng</a></td>
                            <? $tong++ ?>
                        </tr>
                    <?php endforeach; ?>
                    <tfoot>
                        <th colspan="3">Tổng số đơn hàng:</th>
                        <th><?= $tong ?></th>
                    </tfoot>
                <? else : ?>
                    <h2>Không có đơn hàng nào!!!</h2>
                <? endif; ?>
            </table>
            
        </div>
    </fieldset>
</div>
<?php require "inc/footer.php" ?>