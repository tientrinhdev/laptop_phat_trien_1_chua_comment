<?
include("inc/init.php");
if (Auth::isLoggedIn() == false) {
    Dialog::showAndRedirect("Vui lòng đăng nhập", "login.php");
} else {
    $username = $_SESSION['logged_in'];
    $passwordError = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password = $_POST['password'];

        $conn = require("inc/db.php");
        if (User::authenticate($conn, $username, $password)) {
            if (User::deleteUser($conn, $username, $password)) {
                Auth::logout();
                Dialog::showAndRedirect("Xóa tài khoản thành công.", "index.php");
            } else {
                Dialog::show("Xóa tài khoản không thành công.");
            }
        } else {
            Dialog::show("Mật khẩu không đúng.");
        }
    }
}
include("inc/header.php");
?>


<!-- form xóa user-->
<div class="content">
    <form style="all: unset" action="" method="post" id="frmDELUSER">
        <fieldset>
            <legend>
                <h2>Xóa tài khoản</h2>
            </legend>
            <div class="row">
                <!-- Nhập lại mật khẩu -->
                <label for="password">Nhập lại mật khẩu</label>
                <span class="error">*</span>
                <input name="password" id="password" type="password" placeholder="Nhập lại mật khẩu">
                <? echo "<span class = 'error'>$passwordError</span>"; ?>
            </div>
            <div class="row">
                <input type="submit" class="btn" value="Xóa Tài Khoản">
                <input type="reset" class="btn" value="Thoát">
            </div>
        </fieldset>
    </form>
</div>

<?
include("inc/footer.php");
?>