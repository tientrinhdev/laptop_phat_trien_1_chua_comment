<?
require "inc/init.php";
$conn = require("inc/db.php");
$total = Product::count($conn);
$limit = 4;
$currentpage = $_GET['page'] ?? 1;
$config = [
    'total' =>$total,
    'limit' => $limit,
    'full' => false,
];
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
                <th>Hãng</th>
                <th>Mô tả</th>
                <th>Giá Sản Phẩm</th>
                <th>Ảnh</th>
                <th>Mua</th>
            </tr>
        </thead>
        <!-- các dòng dữ liệu ở đây -->
        <? static $i = 1; ?>
        <? foreach ($products as $p) : ?>
            <tr>
                <td align="center"><?= $i++ ?></td>
                <td align="center"><?= $p->productname ?></td>
                <td align="center"><?= $p->branch ?></td>
                <td align="center"><a href="description.php?id=<?=htmlspecialchars($p->id)?>">Mô tả sản phẩm</a></td>
                <td align="center"><?= $p->price ?></td>
                <td align="center">
                    <? if ($p->imagefile) : ?>
                        <img src="uploads/<? echo $p->imagefile ?>" width="100">
                    <? else : ?>
                        <img src="images/noimage.jpg" width="100">
                    <? endif; ?>
                </td>
                <td align="center">
                        <form style="all: unset;" action="cart.php" method="post">
                        <div class="row">
                            <input  type="number" value="1" name="quantity" min="1" max="10" style="width: 40px;"><br>
                            <input style="margin-right: 15px;" class="btn" type="submit" value="Thêm vào giỏ hàng" name="addcart">
                            <input type="hidden" name="idproduct" value="<?=$p->id?>">
                            <input type="hidden" name="productname" value="<?=$p->productname?>">
                            <input type="hidden" name="imagefile" value="<?=$p->imagefile?>">
                            <input type="hidden" name="price" value="<?=$p->price?>">
                        </div>
                        </form>
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

<? require "inc/footer.php"?>
