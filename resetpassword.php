<?
include("inc/init.php");
$email = $_GET['email'];
$token = $_GET['token'];
$password_cu_Error = "";
$password_moi_Error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = require("inc/db.php");
    $user = User::getAllByEmailAndToken($conn, $email, $token);
    $username = $user->username;
    $password_moi = $_POST['password_moi'];
    $rpassword_moi = $_POST['rpassword_moi'];

    if (!empty($user)) {
        $pass_pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{5,}$/";
        if (!preg_match($pass_pattern, $password_moi)) {
            $password_moi_Error = "Có ít nhất 8 ký tự, ít nhất 1 kí tự hoa, ít nhất 1 kí tự thường, ít nhất 1 chữ số, ít nhất 1 kí tự đặc biệt.";
        }
        if ($password_moi != $rpassword_moi) {
            $password_moi_Error = "Thông tin mật khẩu nhập lại không đúng.";
        }
        if ($password_moi_Error == "") {
            if ($user->updatePassWord($conn, $username, $password_moi)) {
                Dialog::showAndRedirect("Đổi mật khẩu thành công.", "login.php");
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
    <form style="all: unset" action="" method="post" id="frmRESETPASSWORD">
        <fieldset>
            <legend><h2>Đổi mật khẩu</h2></legend>
           
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