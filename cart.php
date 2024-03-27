<?
require "inc/init.php";
require "library.php";
$conn = include("inc/db.php");

if (isset($_SESSION['logged_in'])) {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (isset($_GET['delcart']) && ($_GET['delcart'] == 1)) array_splice($_SESSION['cart'], 0);
    if (isset($_GET['delid']) && ($_GET['delid'] >= 0)) {
        array_splice($_SESSION['cart'], $_GET['delid'], 1);
    }
    if (isset($_POST['addcart']) && ($_POST['addcart'])) {
        $idproduct = $_POST['idproduct'];
        $productname = $_POST['productname'];
        $imagefile = $_POST['imagefile'];
        $price = $_POST['price'];
        $number = $_POST['quantity'];
        $total;

        $fl = 0;
        for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
            if ($_SESSION['cart'][$i][1] == $productname) {
                $fl = 1;
                $numbernew = $number + $_SESSION['cart'][$i][4];
                $_SESSION['cart'][$i][4] = $numbernew;
                break;
            }
        }

        if ($fl == 0) {
            $sp = array($idproduct, $productname, $imagefile, $price, $number);
            $_SESSION['cart'][] = $sp;
        }
    }
} else {
    Dialog::showAndRedirect("Vui lòng đăng nhập.", 'login.php');
}

require "inc/header.php";
?>
<div class="content">
    <fieldset>
        <legend>
            <h2>Giỏ hàng</h2>
        </legend>
        <div class="content">
            <table>
                <thead>
                    <? if (!empty($_SESSION['cart'])) : ?>
                        <tr>
                            <th>TT</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xóa</th>
                        </tr>
                    <? endif; ?>
                </thead>
                <tbody>
                    <? showCart(); ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <form style="all: unset" action="addorder.php" method="post">
            <? if (!empty($_SESSION['cart'])) : ?>
                <div class="row">
                    <input type="submit" class="btn" value="Đặt hàng" name="dongydathang">
                </div>
                    <a class="btn" href="cart.php?delcart=1">Xóa giỏ hàng</a>
                <? endif; ?>
                <a class="btn" href="home.php">Tiếp tục mua hàng</a>
           

        </div>
        <? if (!empty($_SESSION['cart'])) : ?>
            <fieldset>
                <legend>
                    <h2>Thông tin nhận hàng</h2>
                </legend>
                <div class="row">
                    <label for="name">Họ tên</label>
                    <input name="name" id="name" type="text" placeholder="Họ tên" required>
                </div>
                <div class="row">
                    <label for="phone">Điện thoại</label>
                    <input name="phone" id="phone" type="text" placeholder="Điện thoại" required>
                </div>
                <div class="row">
                    <label for="address">Địa chỉ</label>
                    <input name="address" id="address" type="text" placeholder="Địa chỉ" required>
                </div>
                <div class="row">
                    <label for="email">Email</label>
                    <input name="email" id="email" type="email" placeholder="Email" required>
                </div>
                <div class="row">
                    <label for="note">Ghi chú</label>
                    <textarea name="note" id="note" type="text" placeholder="Ghi chú" cols="30" rows="10" required></textarea>
                </div>
                <div class="row">
                    <legend>
                        <h5>Phương thức thanh toán</h5>
                    </legend>
                    <input type="radio" name="pttt" value="1">Thanh toán khi nhận hàng<br>
                    <input type="radio" name="pttt" value="2">Thanh toán chuyển khoản<br>
                    <input type="radio" name="pttt" value="3">Thanh toán ví MoMo<br>
                </div>
                <div class="row">
                    <input type="submit" class="btn" value="Đặt hàng" name="dongydathang">
                </div>

</div>
</fieldset>
<? endif; ?>
</form>
</fieldset>
<? require "inc/footer.php" ?>

<script>
    var updateButtons = document.getElementsByClassName('update-btn');
    for (var i = 0; i < updateButtons.length; i++) {
        updateButtons[i].addEventListener('click', function(event) {
            var index = event.target.getAttribute('data-index');
            var quantityInput = document.querySelector('input[data-index="' + index + '"]');
            var newQuantity = parseInt(quantityInput.value);
            updateQuantity(index, newQuantity);
        });
    }

    function updateQuantity(index, newQuantity) {
        if (newQuantity >= 1 && newQuantity <= 10) {
            var url = 'updatequantity.php?index=' + index + '&quantity=' + newQuantity;
            window.location.href = url;
        } else {
            alert('Số lượng không hợp lệ. Vui lòng chọn từ 1 đến 10.');
        }
    }
</script>