<?
include("../inc/init.php");
if(Auth::isLoggedIn()){
    if (!empty($_GET['id'])) {
        $conn = include("../inc/db.php");
        $id = $_GET['id'];
        $order = Order::getAllById($conn, $id);
        $cart = Cart::getAllById_Order($conn, $id);
    }else{
        header("Location:order.php");
        exit();
    }
}else{
    header("Location:../index.php");
}
include("inc/header.php");
?>
<div class="content">
    <fieldset>
        <legend>
            <h2>Thông tin đơn hàng</h2>
        </legend>
        <div class="content">
            <table align="center">
                    <tr>
                        <p>Người đặt hàng : <?= $order['name'] ?></p>
                        <p>Số điện thoại : <?= $order['phone'] ?></p>
                        <p>Email : <?= $order['email_order'] ?></p>
                        <p>Địa chỉ nhận hàng : <?= $order['address'] ?></p><br>
                        <table>
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Ảnh</th>
                                    <th>Số lương</th>
                                    <th>Giá</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <? $sum = 0 ?>
                            <? foreach ($cart as $c) : ?>
                                <tr>
                                    <? $total = $c['quantity'] * $c['price'] ?>
                                    <td align="center"><?= $c['productname'] ?></td>
                                    <td align="center"><img src="../uploads/<?=$c['imagefile']?>" alt="Ảnh laptop" width="100px"></td>
                                    <td align="center"><?= $c['quantity'] ?></td>
                                    <td align="center"><?= number_format($c['price'], 0, '.', '.') ?> VND</td>
                                    <td align="center"> <?= number_format($total, 0, '.', '.') ?> VND</td>
                                    <? $sum += $total;?>
                                </tr>
                            <? endforeach; ?>
                            <tfoot>
                                <th colspan="4">Tổng tiền:</th>
                                <th><?=number_format($sum, 0, '.', '.') ?> VND</th>
                            </tfoot>
                        </table>
                        <br>
                        <p>Ghi chú : <?= $order['note'] ?></p>
                    </tr>

                <a class="btn" href="order.php">Thoát</a>
            </table>

        </div>
    </fieldset>
</div>
<?php
include("inc/footer.php");
?>