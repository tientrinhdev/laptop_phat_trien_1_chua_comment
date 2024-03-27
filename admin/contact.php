<?php
require "../inc/init.php";

if (Auth::isLoggedIn()) {
    $conn = include("../inc/db.php");
    $contacts = Contact::getAll($conn);
    //Xóa 
    if (isset($_GET['delid']) && is_numeric($_GET['delid']) && $_GET['delid'] > 0) {
        $id = $_GET['delid'];
        $c = Contact::getAllbyId($conn, $id);
        if ($c->status != 'Chưa trả lời') {
            if ($c->deleteById($conn, $id)) {
                Dialog::showAndRedirect("Xóa thành công.", "contact.php");
            } else {
                Dialog::showAndRedirect("Xóa không thành công.", "contact.php");
            }
        } else {
            Dialog::showAndRedirect("Chưa trả lời liên hệ. Không thể xóa.", "contact.php");
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
            <h2>Liên hệ</h2>
        </legend>
        <div class="content">
            <table>
                <thead>
                    <? if (!empty($contacts)) : ?>
                        <tr>
                            <th>TT</th>
                            <th>Mã liên hệ</th>
                            <th>Ngày nhận</th>
                            <th>Trạng thái</th>
                            <th>Xóa</th>
                            <th>Chi tiết</th>
                        </tr>
                    <? endif; ?>
                </thead>
                <? $i = 1; ?>
                <? if (!empty($contacts)) : ?>
                    <?php foreach ($contacts as $c) : ?>
                        <tr>
                            <td align="center"><?= $i++ ?></td>
                            <td align="center"><?= $c->id_code ?></td>
                            <td align="center"><?= $c->created_day ?></td>
                            <td align="center"><?= $c->status ?></td>
                            <td><a style="margin-right:65px" class="btn" href="contact.php?delid=<?= $c->id ?>">Xóa</a> </td>
                            <td><a style="margin-right: 35px;" class="btn" href="contactdetail.php?id=<?= $c->id ?>">Chi tiết liên hệ</a></td>
                        </tr>
                    <?php endforeach; ?>
                <? else : ?>
                    <h2>Không có liên hệ nào!!!</h2>
                <? endif; ?>
            </table>
            <a class="btn" href="admin.php">Thoát</a>
        </div>
    </fieldset>
</div>
<?php require "inc/footer.php" ?>