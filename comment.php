<?
include("inc/init.php");
$conn = include("inc/db.php");
$dsbl = Comment::getAll($conn, $_GET['idsp']);
if (Auth::isLoggedIn()) {
    $username = $_SESSION['logged_in'];
    $user = User::getByUsername($conn, $username);
    if (isset($_POST['guibinhluan']) && ($_POST['guibinhluan'])) {
        $idsp = $_POST['idsp'];
        $iduser = $user->id;
        $noidung = $_POST['noidung'];
        $comment = new Comment($idsp, $iduser, $noidung);
        if ($comment->add($conn)) {
            Dialog::showAndRedirect("Bình luận thành công.", "comment.php?idsp=" . $idsp);
        } else {
            Dialog::showAndRedirect("Bình luận thất bại.", "comment.php?idsp=" . $idsp);
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style_comment.css?v=<? echo time(); ?>" />
        <title>Bình luận</title>
    </head>

    <body>
        <div class="form">
            <hr>
            <form action="" method="post">
                <input class="input_text" type="text" name="name" value="<?= $username ?>">
                <input type="hidden" name="idsp" value="<?= $_GET['idsp'] ?>">
                <textarea class="textarea" name="noidung" id="" cols="20" rows="5" name="noidung" placeholder="Viết bình luận"></textarea>
                <input class="input_submit" type="submit" value="Gửi bình luận" name="guibinhluan">
            </form>
            <hr>
        </div>
    </body>

    </html>
<?php
} else {
    echo "<a href='login.php' target='_parent'>Bạn vui lòng đăng nhập để bình luận</a>";
}
?>

<?php if (!empty($dsbl)) : ?>
    <?php foreach ($dsbl as $bl) : ?>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style_comment.css?v=<? echo time(); ?>" />
            <title>Bình luận</title>
        </head>
        <br>
        <div class="content">
            <h2 style="margin-left:20px">Bình luận</h2>
        </div>
        <div class="form">
            <div class="comment-box">
                <div class="username"><?= $bl->username ?></div>
                <div class="comment"><?= $bl->comment ?></div>
                <div class="timestamp"><?= $bl->created_day ?></div>
            </div>
        </div>
    <?php endforeach; ?>
<? endif; ?>
<? if (empty($dsbl)) : ?>
    <h1>Chưa có bình luận nào</h1>
<? endif; ?>