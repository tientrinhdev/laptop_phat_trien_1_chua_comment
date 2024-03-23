<?
    include("inc/init.php");
    include("library.php");
    if(isset($_POST['dongydathang']) && ($_POST['dongydathang'])){
        $username = $_SESSION['logged_in'];
        $conn = include("inc/db.php");
        $user = User::getByUsername($conn, $username);
        //Thông tin 
        $id_user = $user->id;
        $id_order = "BAHOZONE".rand(0,9999999);
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $note = $_POST['note'];
        $total =  totalOrder();
        $pttt = $_POST['pttt'];
        $order = new Order($id_order, $id_user, $name,$email, $phone, $address, $note, $total, $pttt);
        $iddh = $order->add($conn);
        if(!empty($iddh)){
            if(isset($_SESSION['cart']) && (count($_SESSION['cart']) > 0)){
                for ($i = 0; $i < sizeof($_SESSION['cart']); $i++){
                        $carts = new Cart($iddh, $_SESSION['cart'][$i][0], $_SESSION['cart'][$i][4], $_SESSION['cart'][$i][3]);
                        $carts->add($conn);
                }
                unset($_SESSION['cart']);
                Dialog::showAndRedirect("Đặt hàng thành công", "showorder.php");
            }
         }
        //else{
        //     Dialog::showAndRedirect("Thêm đơn hàng thất bại!", "cart.php");
        // }
    }
?>

