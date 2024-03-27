<?
include("inc/init.php");

function SendMail($email, $username, $verify_token)
{
    require "vendor/PHPMailer-master/src/PHPMailer.php";
    require "vendor/PHPMailer-master/src/SMTP.php";
    require 'vendor/PHPMailer-master/src/Exception.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL;
        $mail->Password = EMAIL_PASS;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom(EMAIL, EMAIL_NAME);
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = 'Email xác thực từ web.com';
        $noidungthu = "Vui lòng nhấn vào link để xác thực email <br/>
        <a href='http://localhost/ct07_ww/Laptop_phat_trien/verify.php?email=$email&verify_token=$verify_token'>Xác nhận</a>";
        $mail->Body = $noidungthu;
        $mail->send();
    } catch (Exception $e) {
        echo "Lỗi khi gửi email: {$mail->ErrorInfo}";
    }
}

if (isset($_POST['gui'])) {
    $email = $_GET['email'];
    $username = $_GET['username'];
    $verify_token = $_GET['verify_token'];
    if (isset($_POST['gui'])) {
        SendMail($email, $username, $verify_token);
        Dialog::showAndRedirect("Gửi email thành công vui lòng nhấp vào đường liên kết để xác thực email.", "verifyreset.php?email=$email&username=$username&verify_token=$verify_token");
    } else {
        Dialog::show("Gửi email thất bại");
    }
}


include("inc/header.php");
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style_verify.css">
</head>

<body>
    <div class="form-container">
        <form style="all:unset;" action="" method="post">
            <div class="email-form">
                <h2>Vui lòng xác nhận địa chỉ email của bạn : <?= $_GET['email'] ?></h2>
                <input type="submit" value="Gửi Lại Email" name="gui">
            </div>
        </form>
    </div>
</body>

</html>
<?
include("inc/footer.php");
?>