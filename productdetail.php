<?
include("inc/init.php");
if (isset($_GET['id'])) {
    $conn = include("inc/db.php");
    $id = $_GET['id'];
    $product = Product::getById($conn, $id);
}

include("inc/header.php");
?>

<div class="product-container">
    <div class="product-image">
        <img src="uploads/<?= $product->imagefile ?>" width="400px" height="400px">
    </div>
    <div class="product-details">
        <h1 class="product-title"><?= $product->productname ?></h1>
        <p class="product-description">Hãng : <?= $product->branch ?></p>
        <p class="product-description"><?= $product->description ?></p>
        <p class="product-price">Giá: <?= number_format($product->price, 0, '.', '.') ?> VND</p>
        <form style="all: unset;" action="cart.php" method="post">
            <div class="row">
                <input style="height: 35px" type="number" value="1" name="quantity" min="1" max="10" style="width: 20px;">
                <input class="product-button" type="submit" value="Thêm vào giỏ hàng" name="addcart">
                <input type="hidden" name="idproduct" value="<?= $product->id ?>">
                <input type="hidden" name="productname" value="<?= $product->productname ?>">
                <input type="hidden" name="imagefile" value="<?= $product->imagefile ?>">
                <input type="hidden" name="price" value="<?= $product->price ?>">
            </div>
        </form>
    </div>
</div>
<div class="comment-container">
    <iframe src="comment.php?idsp=<?= $product->id ?>" frameborder="0"></iframe>
</div>
<? include("inc/footer.php") ?>