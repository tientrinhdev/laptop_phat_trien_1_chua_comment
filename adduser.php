<? require "inc/init.php";
function SendMail($email,$username, $verify_token){       
    require "vendor/PHPMailer-master/src/PHPMailer.php"; 
    require "vendor/PHPMailer-master/src/SMTP.php"; 
    require 'vendor/PHPMailer-master/src/Exception.php'; 
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();  
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL; 
        $mail->Password = EMAIL_PASS; 
        $mail->SMTPSecure ="tls"; 
        $mail->Port = 587;   

        $mail->setFrom(EMAIL, EMAIL_NAME); 
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = 'Email xác thực từ web.com';
        $noidungthu = "Cảm ơn đã đăng kí. Vui lòng nhấn vào link để xác thực email <br/>
        <a href='http://localhost/ct07_ww/Laptop_phat_trien/verify.php?email=$email&verify_token=$verify_token'>Xác nhận</a>"; 
        $mail->Body = $noidungthu;
        $mail->send();
    } catch (Exception $e) {
        echo "Lỗi khi gửi email: {$mail->ErrorInfo}";
    }
 }

$usernameError = "";
$passwordError = "";
$emailError = "";
$role = 0;
$verify_token = md5(rand());

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $user_pattern = '/^[A-Za-z0-9]{5,}$/';
    if (!preg_match($user_pattern, $username)) {
        $usernameError = "Tên người dùng phải có ít nhất 5 kí tự.";
    }
    $password = $_POST['password'];
    $pass_pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{5,}$/";
    if (!preg_match($pass_pattern, $password)) {
        $passwordError = "Có ít nhất 8 ký tự, ít nhất 1 kí tự hoa, ít nhất 1 kí tự thường, ít nhất 1 chữ số, ít nhất 1 kí tự đặc biệt.";
    } else if ($_POST['password'] != $_POST['rpassword']) {
        $passwordError = "Thông tin mật khẩu nhập lại không đúng.";
    }
    $email = $_POST['email'];
    $email_pattern = '/^\\S+@\\S+\\.\\S+$/';
    if(!preg_match($email_pattern, $email)){
        $emailError = "Email không hợp lệ.";
    }
    if ($usernameError == "" && $passwordError == "" && $emailError =="") {
        $conn = require "inc/db.php";
        $e = User::getByEmail($conn, $email);
        if($e == null){
            $user = new User($username, $password, $email, $role, $verify_token, 0);
        try {
            if ($user->addUser($conn)) {
                SendMail($email,$username, $verify_token);
                Dialog::showAndRedirect("Vui lòng kiểm tra email để xác thực tài khoản.", "login.php");
            } else {
                Dialog::show("Không thể thêm người dùng.");
            }
        } catch (PDOException $e) {
            Dialog::show($e->getMessage());
        }
        }else{
            Dialog::show("Email đã được đăng kí");
        }
    } else {
        Dialog::show('Error !!!');
    }
}

require "inc/header.php";
?>

<div class="content">
    <form style="all: unset" action="" method="post" id="frmADDUSER">
        <fieldset>
            <legend><h2>Đăng Kí Người Dùng</h2></legend>
            <div class="row">
                <!-- Nhập tên tài khoản -->
                <label for="username">Tên tài khoản</label>
                <input name="username" id="username" type="text" placeholder="Tên tài khoản">
                <? echo "<span class = 'error'> $usernameError </span>"; ?>
            </div>
            <!-- Nhập mật khẩu -->
            <div class="row">
                <label for="password">Mật khẩu</label>
                <input name="password" id="password" type="password" placeholder="Mật khẩu">
                <? echo "<span class = 'error'> $passwordError </span>"; ?>
            </div>
            <!-- Nhập lại mật khẩu -->
            <div class="row">
                <label for="rpassword">Nhập lại mật khẩu</label>
                <input name="rpassword" id="rpassword" type="password" placeholder="Nhập lại mật khẩu">
                <? echo "<span class = 'error'> $passwordError </span>"; ?>
            </div>
            <div class="row">
                <!-- Nhập Email-->
                <label for="email">Email</label>
                <input name="email" id="email" type="text" placeholder="Email">
                <? echo "<span class = 'error'> $usernameError </span>"; ?>
            </div>
            <div class="row">
                <input class="btn" type="submit" value="Đăng kí">
                <input class="btn" type="reset" value="Thoát">
            </div>
        </fieldset>
    </form>
</div>

<? require "inc/footer.php"; ?>