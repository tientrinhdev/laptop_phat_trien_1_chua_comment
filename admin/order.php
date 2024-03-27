<?php
require "../inc/init.php";

if (Auth::isLoggedIn()) {
    $conn = include("../inc/db.php");
    $order = Order::getAll($conn);

    //hủy đơn 
    if (isset($_GET['delid']) && is_numeric($_GET['delid']) && $_GET['delid'] > 0) {
        $id = $_GET['delid'];
        $status = 'Đơn đã bị hủy';
        $order = Order::getAllById($conn, $id);
        if ($order['status'] == 'Đơn đã bị hủy') {
            Dialog::showAndRedirect("Đơn hàng đã bị hủy.", "order.php");
        } else if ($order['status'] == 'Giao hàng thành công') {
            Dialog::showAndRedirect("Đơn hàng đã giao thành công rồi.", "order.php");
        }else if($order['status'] == 'Đang giao hàng'){
            Dialog::showAndRedirect("Đơn hàng đang trong quá trình vận chuyển.", "order.php");
        } 
        else {
            if (Order::updateStatus($conn, $id, $status)) {
                Dialog::showAndRedirect("Hủy đơn hàng thành công.", "order.php");
            } else {
                Dialog::showAndRedirect("Hủy đơn hàng thất bại.", "order.php");
            }
        }
    }
    //xóa
    if (isset($_GET['del2id']) && is_numeric($_GET['del2id']) && $_GET['del2id'] > 0) {
        $id = $_GET['del2id'];
        $order = Order::getAllById($conn, $id);
        if ($order['status'] == 'Giao hàng thành công' || $order['status'] == 'Đơn đã bị hủy') {
            if (Order::deleteById($conn, $id)) {
                Dialog::showAndRedirect("Xóa đơn hàng thành công.", "order.php");
            } else {
                Dialog::show("Xóa đơn hàng không thành công.");
            }
        } else {
            Dialog::showAndRedirect("Đơn hàng chưa giao thành công. Không thể xóa.", "order.php");
        }
    }
    if (isset($_GET['giao']) && isset($_GET['id'])) {
        $order = Order::getAllById($conn, $_GET['id']);
        $status = 'Đang giao hàng';
        if ($order['status'] == 'Giao hàng thành công') {
            Dialog::showAndRedirect("Đơn hàng đã được giao thành công", "order.php");
        } else if ($order['status'] == 'Đơn đã bị hủy') {
            Dialog::showAndRedirect("Đơn hàng đã bị hủy.", "order.php");
        } else {
            if (Order::updateStatus($conn, $_GET['id'], $status)) {
                Dialog::showAndRedirect("Cập nhật trạng thái giao hàng thành công.", "order.php");
            } else {
                Dialog::showAndRedirect("Cập nhật trạng thái giao hàng thất bại", "order.php");
            }
        }
    } 
}else {
    header("Location:../index.php");
}
require "inc/header.php";
?>
<!-- Table  -->
<div class="content">
    <fieldset>
        <legend>
            <h2>Quản lý đơn hàng</h2>
        </legend>
        <div class="content">
            <table>
                <thead>
                    <? if (!empty($order)) : ?>
                        <tr>
                            <th>TT</th>
                            <th>Mã đơn hàng</th>
                            <th>Ngày nhận</th>
                            <th>Trạng thái</th>
                            <th>Cập nhật trạng thái giao hàng</th>
                            <th>Hủy đơn</th>
                            <th>Xóa</th>
                            <th>Chi tiết đơn hàng</th>
                        </tr>
                    <? endif; ?>
                </thead>
                <? $i = 1; ?>
                <? if (!empty($order)) : ?>
                    <?php foreach ($order as $o) : ?>
                        <tr>
                            <td align="center"><?= $i++ ?></td>
                            <td align="center"><?= $o['id_code'] ?></td>
                            <td align="center"><?= $o['created_order'] ?></td>
                            <td align="center"> <?= $o['status'] ?></td>
                            <td align="center">
                                <form style="all :unset;" action="" method="get">
                                    <div class="row">
                                        <input style="margin-right :25px" class="btn" type="submit" value="Giao hàng" name="giao">
                                        <input type="hidden" name="id" value="<?= $o['id'] ?>">
                                    </div>
                                </form>
                            </td>
                            <td>
                                <a style="margin-right:15px" class="btn" href="order.php?delid=<?= $o['id'] ?>">Hủy đơn hàng</a>
                            </td>
                            <td>
                                <a style="margin-right:38px" class="btn" href="order.php?del2id=<?= $o['id'] ?>">Xóa</a>
                            </td>
                            <td>
                                <a style="margin-right:10px" class="btn" href="orderdetail.php?id=<?= $o['id'] ?>">Chi tiết đơn hàng</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <? else : ?>
                    <h2>Không có đơn hàng nào!!!</h2>
                <? endif; ?>
            </table>
            <a class="btn" href="admin.php">Thoát</a>
        </div>
    </fieldset>
</div>
<?php require "inc/footer.php" ?>