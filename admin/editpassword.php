<?
include("../inc/init.php");
if (Auth::isLoggedIn() == false) {
    header("location:../login.php");
    exit();
}
$username = $_SESSION['logged_in'];
$password_cu_Error = "";
$password_moi_Error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password_cu = $_POST['password_cu'];
    $password_moi = $_POST['password_moi'];
    $rpassword_moi = $_POST['rpassword_moi'];

    $conn = require("../inc/db.php");
    $user = User::getByUsernamePass($conn, $username, $password_cu);
    if (!empty($user)) {
        $pass_pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{5,}$/";
        if (!preg_match($pass_pattern, $password_moi)) {
            $password_moi_Error = "Có ít nhất 8 ký tự, ít nhất 1 kí tự hoa, ít nhất 1 kí tự thường, ít nhất 1 chữ số, ít nhất 1 kí tự đặc biệt.";
        }
        if ($password_moi != $rpassword_moi) {
            $password_moi_Error = "Thông tin mật khẩu nhập lại không đúng.";
        }
        if ($password_cu_Error == "" && $password_moi_Error == "") {
            if ($user->updatePassWord($conn, $username, $password_moi)) {
                Dialog::show("Đổi mật khẩu thành công.");
            }
        }
    } else {
        $password_cu_Error = "Mật khẩu cũ không đúng.";
    }
}


include("inc/header.php");
?>

<!-- form đổi mật khẩu -->
<div class="content">
    <form style="all: unset" action="" method="post" id="frmEDITPASSWORD">
        <fieldset>
            <legend><h2>Đổi mật khẩu</h2></legend>

            <div class="row">
                <!-- Nhập lại mật khẩu cũ -->
                <label for="password_cu">Mật khẩu cũ</label>
                <span class="error">*</span>
                <input value="<? if (isset($password_cu) == true) echo $password_cu ?>" name="password_cu" id="password_cu" type="password" placeholder="Mật khẩu cũ">
                <? echo "<span class = 'error'> $password_cu_Error </span>"; ?>
            </div>
            <!-- Nhập mật khẩu mới -->
            <div class="row">
                <label for="password_moi">Mật khẩu mới</label>
                <span class="error">*</span>
                <input name="password_moi" id="password_moi" type="password" placeholder="Mật khẩu mới">
                <? echo "<span class = 'error'> $password_moi_Error </span>"; ?>
            </div>
            <!-- Nhập lại mật khẩu mới -->
            <div class="row">
                <label for="rpassword_moi">Nhập lại mật khẩu mới</label>
                <span class="error">*</span>
                <input name="rpassword_moi" id="rpassword_moi" type="password" placeholder="Nhập lại mật khẩu mới">
                <? echo "<span class = 'error'> $password_moi_Error </span>"; ?>
            </div>
            <div class="row">
                <input type="submit" class="btn" value="Cập nhật">
                <input type="reset" class="btn" value="Thoát">
            </div>
        </fieldset>
    </form>
</div>

<?
include("inc/footer.php");
?>