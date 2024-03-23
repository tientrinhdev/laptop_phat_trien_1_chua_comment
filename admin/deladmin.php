<?
    include("../inc/init.php");
    if (Auth::isLoggedIn() == false) {
        header("location:../login.php");
        exit();
    }
    $username = $_SESSION['logged_in'];
    $passwordError = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $password = $_POST['password'];

        $conn = require("../inc/db.php");
        $user = User::getByUsername($conn, $username, $password);
        if(!empty($user)){
            if($user->deleteUser($conn, $username)){
                Auth::logout();
                header("Location:admin.php");
            }

        }else{
            Dialog::show("Mật khẩu không đúng.");
        }
    }
    include("inc/header.php");
?>


<!-- form xóa user-->
<div class="content">
    <form style="all: unset" action="" method="post" id="frmDELADMIN">
        <fieldset>
            <legend><h2>Xóa tài khoản</h2></legend>
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