<?
    require "../inc/init.php";
    if(isset($_GET['id'])){
        $conn = require ("../inc/db.php");
        $product = Product::getById($conn, $_GET['id']);
        if(!$product){
            Dialog::show('Không tìm thấy sản phẩm');
            return;
        }
    }else{
        Dialog::show('Vui lòng nhập ID');
        return;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $product->id = $_GET['id'];
        $product->productname = $_POST['productname'];
        $product->branch = $_POST['branch'];
        $product->description = $_POST['description'];
        $product->price = $_POST['price'];
        if($product->update($conn)){
            header("Location:admin.php");
            exit();
        }
        }
    
    require "inc/header.php";
?>



<div class="content">
    <form style="all: unset" method="post" id="frmEDITPRODUCT">
        <fieldset>
        <legend><h2>Sửa thông tin sản phẩm</h2></legend>
            <div class="row">
                <label for="productname">Tên Sản Phẩm</label>
                <span class="error">*</span>
                <input type="text" name="productname" id="productname" value="<?=htmlspecialchars($product->productname)?>">
            </div>

            <div class="row">
                <label for="branch">Hãng</label>
                <span class="error">*</span>
                <input type="text" name="branch" id="branch" value="<?=htmlspecialchars($product->branch)?>">
            </div>

            <div class="row">
                <label for="description">Description</label>
                <span class="error">*</span>
                <input type="text" name="description" id="description" value="<?=htmlspecialchars($product->description)?>">
            </div>

            <div class="row">
                <label for="price">Giá Sản Phẩm</label>
                <span class="error">*</span>
                <input type="text" name="price" id="price" value="<?=htmlspecialchars($product->price)?>">
            </div>


            <div class="row">
                <input class="btn" type="submit" value="Cập nhật"/>
                <input class="btn" type="button" value="Thoát"
                onclick="parent.location='admin.php'"/>
                
            </div>
        </fieldset>
    </form>
</div>

<?
    require "inc/footer.php";
?>