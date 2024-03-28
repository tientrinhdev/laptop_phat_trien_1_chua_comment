<?php
require "../inc/init.php";

if (Auth::isLoggedIn()) {
    $conn = include("../inc/db.php");
    $users = User::getAll($conn);
}
require "inc/header.php";
?>
<!-- Table  -->
<div class="content">
    <fieldset>
        <legend>
            <h2>Quản lý tài khoản khách hàng</h2>
        </legend>
        <div class="content">
            <table>
                <thead>
                    <? if (!empty($users)) : ?>
                        <tr>
                            <th>TT</th>
                            <th>Tên tài khoản</th>
                            <th>Email</th>
                            <th>Xóa</th>
                        </tr>
                    <? endif; ?>
                </thead>
                <? $i = 1; ?>
                <? if (!empty($users)) : ?>
                    <?php foreach ($users as $users) : ?>
                        <tr>
                            <td align="center"><?= $i++ ?></td>
                            <td align="center"><?= $users->username ?></td>
                            <td align="center"><?= $users->email ?></td>
                            <td>
                            <a style="margin-right: 110px;" class="btn" href="deluser2.php?id=<?= $users->id ?>">Xóa</a>
                            </td>
                    <?php endforeach; ?>
                <? else : ?>
                    <h2>Không có tài khoản nào!!!</h2>
                <? endif; ?>
            </table>
            <a class="btn" href="admin.php">Thoát</a>
        </div>
    </fieldset>
</div>
<?php require "inc/footer.php" ?>
