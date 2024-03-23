<?
 require "inc/init.php";

require "inc/header.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = require "inc/db.php";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $users = User::getByUsername($conn, $username, $password);
    if (User::authenticate($conn, $username, $password)) {
        if ($users->role == 1) {
            Auth::login($username);
            header("Location:admin/admin.php");
        }else{
            Auth::login($username);
            header("Location:index.php");
        }
    } else {
        Dialog::show("Sai tên người dùng hoặc mật khẩu hoặc tài khoản chưa được xác thực email");
    }
}

?>

<!-- form -->
<div class="content">
    <form style="all: unset" action="" method="post" id="frmLOGIN">
        <fieldset>
            <legend><h2>Đăng nhập</h2></legend>
            <div class="row">
                <!-- nhập tên người dùng -->
                <label for="username">Tên tài khoản</label>
                <span class="error">*</span>
                <input name="username" id="username" type="text" placeholder="Tên tài khoản">

            </div>
            <!-- nhập mật khẩu -->
            <div class="row">
                <label for="password">Mật khẩu</label>
                <span class="error">*</span>
                <input name="password" id="password" type="password" placeholder="Mật khẩu">
            </div>
            <div class="row">
                <input type="submit" class="btn" value="Đăng nhập">
                <input type="reset" class="btn" value="Thoát">
                <br><br>
                <a href="forgetpassword.php">Quên mật khẩu</a>
            </div>
        </fieldset>
    </form>
</div>

<? require "inc/footer.php"; ?>