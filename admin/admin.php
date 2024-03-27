<?
require "../inc/init.php";
if (Auth::isLoggedIn()) {
    $conn = require("../inc/db.php");
    $total = Product::count($conn);
    $limit = 4;
    $currentpage = $_GET['page'] ?? 1;
    $config = [
        'total' => $total,
        'limit' => $limit,
        'full' => false,
    ];
}else{
    header("Location:../index.php");
}


$products = Product::getPaging($conn, $limit, ($currentpage - 1) * $limit);
require "inc/header.php";
?>
<!-- Table  -->
<div class="content">
    <table>
        <thead>
            <tr>
                <th>TT</th>
                <th>Tên Sản Phẩm</th>
                <th>Ảnh</th>
                <th>Giá Sản Phẩm</th>
                <th>Chi tiết</th>
                <th>Sửa</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <!-- các dòng dữ liệu ở đây -->
        <? static $i = 1; ?>
        <? foreach ($products as $p) : ?>
            <tr>
                <td align="center"><?= $i++ ?></td>
                <td align="center"><?= $p->productname ?></td>
                <td align="center">
                    <? if ($p->imagefile) : ?>
                        <img src="../uploads/<? echo $p->imagefile ?>" width="100">
                    <? else : ?>
                        <img src="../images/noimage.jpg" width="100">
                    <? endif; ?>
                <td align="center"><?= number_format($p->price, 0, '.', '.') ?> VND</td>
                <td align="center"><a style="margin-right :20px" ; class="btn" href="productdetail.php?id=<?= htmlspecialchars($p->id) ?>">Chi tiết sản phẩm</a></td>
                <td>
                    <div class="row">
                        <a style="margin-right: 5px" class="btn" href="editimage.php?id=<?= htmlspecialchars($p->id) ?>">Sửa Ảnh</a>
                        <a style="margin-right:18px" class="btn" href="editproduct.php?id=<?= htmlspecialchars($p->id) ?>">Sửa</a>
                    </div>
                </td>
                <td>
                    <a style="margin-right: 50px" class="btn" href="delproduct.php?id=<?= htmlspecialchars($p->id) ?>">Xóa</a>
                </td>
            </tr>
        <? endforeach; ?>
    </table>
</div>
<div class="content">
    <?
    //Khởi tạo chuyển trang
    $page = new Pagination($config);

    echo $page->getPagination();
    ?>
</div>

<? require "inc/footer.php" ?>