<?php
require "../inc/init.php";

if (Auth::isLoggedIn()) {
    $conn = include("../inc/db.php");
    $orders = Order::getAll($conn);
    //xác nhận
    if (isset($_GET['capnhat']) && isset($_GET['id'])) {
        $id = $_GET['id'];
        $order = Order::getAllById($conn, $id);
        if($order['status'] == 'Chờ người bán xác nhận đơn hàng'){
            $status = 'Người bán đang chuẩn bị hàng';
            Order::updateStatus($conn, $id, $status);
            Dialog::show("Đã chấp nhận đơn hàng.");
        }else if($order['status'] == 'Người bán đang chuẩn bị hàng'){
            $status = 'Đơn hàng đang vận chuyển';
            Dialog::show("Đã cập nhật trạng thái đơn hàng thành công.");
            Order::updateStatus($conn, $id, $status);
        }else if($order['status'] == 'Đơn hàng đang vận chuyển'){
            $status = 'Đơn hàng đã giao đến bạn';
            Order::updateStatus($conn, $id, $status);
            Dialog::show("Đã cập nhật trạng thái đơn hàng thành công.");
        }else if($order['status'] == 'Đã giao'){
            Dialog::show("Đơn hàng đã giao thành công");
        }else {
            header("Location:order.php");
            exit();
        }
    }
    //hủy đơn 
    if (isset($_GET['delid']) && is_numeric($_GET['delid']) && $_GET['delid'] > 0) {
        $id = $_GET['delid'];
        $status = 'Đơn đã bị hủy';
        $order = Order::getAllById($conn, $id);
        if ($order['status'] == 'Chờ người bán xác nhận đơn hàng') {
            if (Order::updateStatus($conn, $id, $status)) {
                Dialog::showAndRedirect("Hủy đơn hàng thành công.", "order.php");
            } else {
                Dialog::showAndRedirect("Hủy đơn hàng thất bại.", "order.php");
            }
        } else if($order['status'] == 'Đã giao'){
            Dialog::show("Đơn hàng đã giao thành công.");
        }else if($order['status'] == 'Đơn đã bị hủy'){
            Dialog::show("Đơn hàng đã bị hủy");
        }else{
            Dialog::show("Đơn hàng đang giao, không thể hủy");
        }
    }
    //xóa
    // if (isset($_GET['del2id']) && is_numeric($_GET['del2id']) && $_GET['del2id'] > 0) {
    //     $id = $_GET['del2id'];
    //     $order = Order::getAllById($conn, $id);
    //     if ($order['status'] == 'Giao hàng thành công' || $order['status'] == 'Đơn đã bị hủy') {
    //         if (Order::deleteById($conn, $id)) {
    //             Dialog::showAndRedirect("Xóa đơn hàng thành công.", "order.php");
    //         } else {
    //             Dialog::show("Xóa đơn hàng không thành công.");
    //         }
    //     } else {
    //         header("Location:order.php");
    //         exit();
    //     }
    // }
    
} else {
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
                    <? if (!empty($orders)) : ?>
                        <tr>
                            <th>TT</th>
                            <th>Mã đơn hàng</th>
                            <th>Ngày nhận</th>
                            <th>Trạng thái</th>
                            <th>Cập nhật trạng thái giao hàng</th>
                            <th>Hủy đơn</th>
                            <th>Chi tiết đơn hàng</th>
                        </tr>
                    <? endif; ?>
                </thead>
                <? $i = 1; ?>
                <? if (!empty($orders)) : ?>
                    <?php foreach ($orders as $o) : ?>
                        <tr>
                            <td align="center"><?= $i++ ?></td>
                            <td align="center"><?= $o['id_code'] ?></td>
                            <td align="center"><?= $o['created_order'] ?></td>
                            <td align="center"> <?= $o['status'] ?></td>
                            <td align="center">
                                <form style="all :unset;" action="" method="get">
                                    <div class="row">
                                        <input style="margin-right :32px" class="btn" type="submit" value="Cập nhật" name="capnhat">
                                        <input type="hidden" name="id" value="<?= $o['id'] ?>">
                                    </div>
                                </form>
                            </td>
                            <td>
                                <a style="margin-right:15px" class="btn" href="order.php?delid=<?= $o['id'] ?>">Không nhận đơn</a>
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