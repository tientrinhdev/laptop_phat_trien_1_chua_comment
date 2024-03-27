<?
include("inc/init.php");
$conn = include("inc/db.php");
if (Auth::isLoggedIn()) {
   $user = $_SESSION['logged_in'];
   $pass = $_SESSION['pass'];
   $users = User::getByUsernamePass($conn, $user, $pass);
   if (User::authenticate($conn, $user, $pass)) {
      if ($users->role == 1) {
         header("Location:admin/admin.php");
      } else {
         header("Location:home.php");
      }
   }
} else {
   $total = Product::count($conn);
   $limit = 8;
   $currentpage = $_GET['page'] ?? 1;
   $config = [
      'total' => $total,
      'limit' => $limit,
      'full' => false,
   ];
   $products = Product::getPaging($conn, $limit, ($currentpage - 1) * $limit);
}


include("inc/header.php");
?>
<div class="content">
   <h2 style="text-align: center; background-color:#aec5c7">Danh sách sản phẩm</h2>
</div>
<div class="content">
   <div class="content1">
      <? foreach ($products as $p) : ?>
         <div class="cart">
            <a href="productdetail.php?id=<?= $p->id ?>">
               <img src="uploads/<?= $p->imagefile ?>" class="cart-image">
            </a>
            <a href="productdetail.php?id=<?= $p->id ?>">
               <p> <?= $p->productname ?></p>
            </a>
            <a href="productdetail.php?id=<?= $p->id ?>">
               <p><?= number_format($p->price, 0, '.', '.') ?> VND</p>
            </a>

         </div>
      <? endforeach; ?>
   </div>
</div>
<div class="content">
   <?
   //Khởi tạo chuyển trang
   $page = new Pagination($config);

   echo $page->getPagination();
   ?>
</div>

<? include("inc/footer.php") ?>