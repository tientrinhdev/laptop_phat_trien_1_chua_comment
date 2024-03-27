<?
    include("inc/init.php");
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id_code = "FEEDBACK".rand(0,9999999);
       $name = $_POST['name'];
       $phone = $_POST['phone'];
       $email = $_POST['email'];
       $feedback = $_POST['feedback'];
       $conn = include("inc/db.php");
       $contact = new Contact($id_code,$name, $phone, $email, $feedback);
       try {
        if ($contact->add($conn)) {
            Dialog::showAndRedirect("Gửi thành công.", "addcontact.php");
        } else {
            Dialog::show("Gửi thất bại.");
        }
    } catch (PDOException $e) {
        Dialog::show($e->getMessage());
    }
    }
    
    include("inc/header.php");
?>



<div class="content">
<form style="all: unset" action="" method="post" id="frmCONTACT">
        <fieldset>
            <legend><h2>Liên hệ với chúng tôi</h2></legend>
            <div class="row">
                <label for="name">Họ và tên</label>
                <input name="name" id="name" type="text" placeholder="Họ và tên">
            </div>
            <div class="row">
                <label for="phone">Số điện thoại</label>
                <input name="phone" id="phone" type="text" placeholder="Số điện thoại">
            </div>
            <div class="row">
                <label for="email">Email</label>
                <input name="email" id="email" type="text" placeholder="Email">
            </div>
            <div class="row">
                <label for="feedback">Nội dung liên hệ</label>
                <textarea name="feedback" id="feedback" type="text" placeholder="Nội dung" cols="30" rows="10"></textarea>
            </div>
            <div class="row">
                <input type="submit" class="btn" value="Gửi" name="btn">
            </div>
        </fieldset>
    </form>
</div>

<?
    include("inc/footer.php");
?>