<?  
    require ("../inc/init.php");
    if(isset($_GET['id'])){
        $conn = require("../inc/db.php");
        $product = Product::getById($conn, $_GET['id']);
        if(!$product){
            Dialog::show("Không tìm thấy sản phẩm.");
        }
    }else{
        Dialog::show("Vui lòng nhập ID");
    }

?>
<?require ("inc/header.php")?>
<!-- Thông tin sản phẩm -->

<div class="content">
    <table>
        <thead>
            <tr>
                <th>Mô tả sản phẩm</th>
            </tr>
            <tr>
            <td align="center"><?= $product->description ?><br>
            <?if($product->imagefile):?>
                <img src="../uploads/<? echo $product->imagefile ?>" width="500">
            <?else:?>
                <img src="../images/noimage.jpg" width="500">
            <?endif;?>
            </td>
            
            </tr>
        </thead>
    </table>
</div>


<?require ("inc/footer.php")?>