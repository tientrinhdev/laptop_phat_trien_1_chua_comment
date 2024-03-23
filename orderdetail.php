<?
include("inc/init.php");
if (Auth::isLoggedIn()) {
    $conn = include("inc/db.php");
    $id_order = $_GET['id'];
    $cart = Cart::getAllById_Order($conn, $id_order);
} else {
    Dialog::showAndRedirect("Vui lòng đăng nhập", "login.php");
}
include("inc/header.php");
?>
<div class="content">
    <fieldset>
        <legend>
            <h2>Đơn hàng</h2>
        </legend>
        <div class="content">
            <table>
                <thead>
                    <? if (!empty($cart)) : ?>
                        <tr>
                            <th>TT</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    <? endif; ?>
                </thead>
                <? $i = 1; ?>
                <? $tong = 0 ?>
                <? if (!empty($cart)) : ?>
                    <?php foreach ($cart as $cart) : ?>
                        <tr>
                            <? $total = $cart['price'] * $cart['quantity'] ?>
                            <td align="center"><?= $i++ ?></td>
                            <td align="center"><?= $cart['productname'] ?></td>
                            <td align="center"><img src="uploads/<?=$cart['imagefile'] ?>" width="100px"></td>
                            <td align="center"><?= $cart['price'] ?></td>
                            <td align="center"><?= $cart['quantity'] ?></td>
                            <td align="center"><?= $total ?></td>
                            <? $tong+=$total ?>
                        </tr>
                    <?php endforeach; ?>
                    <tfoot>
                        <th colspan="5">Tổng tiền:</th>
                        <th><?= $tong ?></th>
                    </tfoot>
                <? else : ?>
                    <h2>Không có đơn hàng nào!!!</h2>
                <? endif; ?>
            </table>
            <div class="row">
                    <a class="btn" href="showorder.php">Trở lại</a>
            </div>
        </div>
    </fieldset>
</div>
<?
include("inc/footer.php");
?>