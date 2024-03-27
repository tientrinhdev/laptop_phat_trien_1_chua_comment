<?
require "../inc/init.php";
if(Auth::isLoggedIn()){
    if (isset($_GET['id'])) {
        $conn = require("../inc/db.php");
        $product = Product::getById($conn, $_GET['id']);
        if (!$product) {
            Dialog::show('Không tìm thấy sản phẩm');
            return;
        }
    } else {
        header("Location:admin.php");
        exit();
     }
     
    
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try{
            $fullname = Uploadfile::process();
            if(!empty($fullname)){
                $oldimage = $product->imagefile;
                $product->imagefile = $fullname;
                $product->id = $_GET['id'];
                if($product->updateImage($conn, $_GET['id'], $fullname)){
                    if($oldimage){
                        unlink("../uploads/$oldimage");
                    }
                    header("Location:admin.php");
                    exit();
                }
            }  
        }catch(PDOException $e){
            Dialog::show($e->getMessage());
        }
    }
}else{
    header("Location:../index.php");
}
?>
<? require "inc/header.php"; ?>

<div class="content">
    <form style="all:unset" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend><h2>Sửa ảnh sản phẩm</h2></legend>
            <? if ($product->imagefile) : ?>
                <div class="row">
                    <img src="../uploads/<?=$product->imagefile ?>" width="180" height="180">
                </div>
            <? else : ?>
                <img src="images/noimage.jpg" width="180" height="180">
            <? endif; ?>
            <div class="row">
                <label for="file">File hình ảnh</label>
                <input type="file" name="file" id="file">
            </div>
            <div class="row">
                    <input class="btn" type="submit" value="Cập nhật"/>
                    <input class="btn" type="button" value="Thoát" 
                            onclick="parent.location='index.php'"/>       
                </div>
        </fieldset>
    </form>
</div>

<? require "inc/footer.php"; ?>