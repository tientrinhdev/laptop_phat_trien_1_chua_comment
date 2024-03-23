<?
    include("inc/init.php");
    function send_password_reset($username, $email, $token){
        require "vendor/PHPMailer-master/src/PHPMailer.php"; 
    require "vendor/PHPMailer-master/src/SMTP.php"; 
    require 'vendor/PHPMailer-master/src/Exception.php'; 
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();  
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL; 
        $mail->Password = EMAIL_PASS; 
        $mail->SMTPSecure ="tls"; 
        $mail->Port = 587;   

        $mail->setFrom(EMAIL, EMAIL_NAME ); 
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = 'Email đổi mật khẩu từ web.com';
        $noidungthu = "Vui lòng nhấn vào link bên dưới để đổi đổi mật khẩu <br/>
        <a href='http://localhost/ct07_ww/Laptop_phat_trien/resetpassword.php?email=$email&token=$token'>Đổi mật khẩu</a>"; 
        $mail->Body = $noidungthu;
        $mail->send(); 
}
 if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $conn = include("inc/db.php");
     $email = $_POST['email'];
     $token = md5(rand());

    $user = User::getByEmail($conn, $email);
    if($user != null){
        $username = $user->username;
        if($user->updateVerify_Token($conn, $email, $token)){
            send_password_reset($username, $email, $token);
            Dialog::show("Kiểm tra email để cập nhật mật khẩu");
        }else{
            Dialog::show("Cập nhật thất bại.");
        }
    }else{
        Dialog::show("Email chưa được đăng kí.");
    }
}
    include("inc/header.php");
?>

<div class="content">
    <form style="all: unset" action="" method="post" id="frmFORGETPASSWORD">
        <fieldset>
            <legend><h2>Quên mật khẩu</h2></legend>
            <div class="row">
                <label for="email">Nhập email</label>
                <span class="error">*</span>
                <input name="email" id="email" type="email" placeholder="Email">
            </div>

            <div class="row">
                <input type="submit" class="btn" value="Gửi" name="gui">
                <input type="reset" class="btn" value="Thoát">
            </div>
        </fieldset>
    </form>
</div>

<?
    include("inc/footer.php");
?>