<?php
require "inc/init.php";
require "library.php";
if (Auth::isLoggedIn()) {
    $conn = include("inc/db.php");
    $username = $_SESSION['logged_in'];
    $user = User::getByUsername($conn, $username);
    $order = Order::getAll($conn, $user->id);
//Xóa đơn hàng
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $orders = Order::getAllById($conn, $_GET['id']);
    $id = $_GET['id'];
    if ($orders['status'] == 'Chờ người bán xác nhận đơn hàng') {
        if (Order::deleteById($conn, $id)) {
            Dialog::showAndRedirect("Hủy đơn hàng thành công.", "showorder.php");
        } else {
            Dialog::showAndRedirect("Hủy đơn hàng thất bại.", "showorder.php");
        }
    } else if ($orders['status'] == 'Đơn đã bị hủy') {
        Dialog::showAndRedirect("Đơn hàng đã bị hủy", "showorder.php");
    } else if ($orders['status'] == 'Đang giao hàng') {
        Dialog::showAndRedirect("Đơn hàng đang trên đường đến, không thể hủy.", "showorder.php");
    }else if($orders['status'] == 'Người bán đang chuẩn bị hàng' || $orders['status'] == "Đơn hàng đã giao đến bạn"){
        header("Location:showorder.php");
        exit();
    } else {
        Dialog::showAndRedirect("Đã nhận thành công đơn hàng", "showorder.php");
    }
}


//Xác nhận đơn hàng
    if (isset($_GET['update']) && isset($_GET['id'])) {
        $orders = Order::getAllById($conn, $_GET['id']);
        $id = $_GET['id'];
        $status = 'Đã giao';
        if ($orders['status'] == 'Đơn hàng đã giao đến bạn') {
            if (Order::updateStatus($conn, $id, $status)) {
                Dialog::showAndRedirect("Xác nhận đơn hàng thành công", "showorder.php");
            } else {
                Dialog::showAndRedirect("Xác nhận đơn hàng thất bại", "showorder.php");
            }
        } else{
            header("Location:showorder.php");
            exit();
        }
    }
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
                            <th>Trạng thái</th>
                            <th>Hủy đơn hàng</th>
                            <th>Xác nhận đã nhận hàng</th>
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
                            <td align="center"><?= $o['created_order'] ?></td>
                            <td align="center"><?= $o['status'] ?></td>
                           <td>
                                <form style="all: unset" action="showorder.php" method="get">
                                    <div class="row">
                                        <input style="margin-right: 23px" class="btn" type="submit" value="Hủy đơn hàng" name="delete">
                                        <input type="hidden" value="<?= $o['id'] ?>" name="id">
                                    </div>
                                </form>
                            </td>
                            <td>
                                <form style="all: unset" action="showorder.php" method="get">
                                    <div class="row">
                                        <input style="margin-right: 35px" class="btn" type="submit" value="Xác nhận" name="update">
                                        <input type="hidden" value="<?= $o['id'] ?>" name="id">
                                    </div>
                                </form>
                            </td>
                            <td><a style="margin-right: 20px;" class="btn" href="orderdetail.php?id=<?= $o['id'] ?>">Chi tiết đơn hàng</a></td>
                            <? $tong++ ?>
                        </tr>
                    <?php endforeach; ?>
                    <tfoot>
                        <th colspan="6">Tổng số đơn hàng:</th>
                        <th><?= $tong ?></th>
                    </tfoot>
                <? else : ?>
                    <h2>Không có đơn hàng nào!!!</h2>
                <? endif; ?>
            </table>
            <div class="row">
                <a class="btn" href="index.php">Trở lại</a>
            </div>
        </div>
    </fieldset>
</div>
<?php require "inc/footer.php" ?>