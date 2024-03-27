<?php
require "../inc/init.php";

if(Auth::isLoggedIn()){
    if(!empty($_GET['id'])){
        $id = $_GET['id'];
        $conn = include("../inc/db.php");
        $contacts = Contact::getAllbyId($conn, $id);
    }else{
        header("Location:contact.php");
        exit(); 
    }
    //Gửi email trả lời
    if (isset($_GET['traloi'])) {
        $id = $_GET['id'];
        $email = $_GET['email'];
        $name = $_GET['name'];
        $feedback = $_GET['feedback'];
        require "../vendor/PHPMailer-master/src/PHPMailer.php";
        require "../vendor/PHPMailer-master/src/SMTP.php";
        require '../vendor/PHPMailer-master/src/Exception.php';
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
            $mail->addAddress($email, $name);
    
            $mail->isHTML(true);
            $mail->Subject = 'Email phản hồi từ laptop.com';
            $noidungthu = $feedback;
            $mail->Body = $noidungthu;
            $mail->send();
            $c = Contact::getAllbyId($conn, $id);
            $c->updateStatus($conn, $id);
            Dialog::showAndRedirect("Đã gửi", "contact.php");
        } catch (Exception $e) {
            echo "Lỗi khi gửi email: {$mail->ErrorInfo}";
        }
    }
}else{
    header("Location:../index.php");
}
require "inc/header.php";
?>
<!-- Table  -->
<div class="content">
    <fieldset>
        <legend>
            <h2>Mã liên hệ : <?= $contacts->id_code ?></h2>
        </legend>
        <div class="content">
            <table>
                <thead>
                    <? if (!empty($contacts)) : ?>
                        <tr>
                            <th>Tên người gửi</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Nội dung</th>
                            <th>Trả lời</th>
                        </tr>
                    <? endif; ?>
                </thead>
                <? $i = 1; ?>
                <? if (!empty($contacts)) : ?>
                    <tr>
                        <td align="center"><?= $contacts->name ?></td>
                        <td align="center"><?= $contacts->phone ?></td>
                        <td align="center"><?= $contacts->email ?></td>
                        <td align="center"><?= $contacts->feedback ?></td>
                        <td>
                            <form style="all: unset" action="contactdetail.php" method="get">
                                <input type="hidden" value="<?=$contacts->email?>" name="email">
                                <input type="hidden" value="<?=$contacts->name?>" name="name">
                                <input type="hidden" value="<?=$contacts->id?>" name = "id">
                                <div>
                                    <textarea name="feedback" id="feedback" type="text" placeholder="Nội dung trả lời" cols="30" rows="10"></textarea>
                                </div>
                                <input class="btn" type="submit" value="Gửi" name="traloi">
                            </form>
                        </td>
                    </tr>

                <? endif; ?>
            </table>

        </div>
    </fieldset>
</div>
<?php require "inc/footer.php" ?>