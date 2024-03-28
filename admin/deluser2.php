<?
    include("../inc/init.php");
    if(Auth::isLoggedIn()){
        $conn = include("../inc/db.php");
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            if(User::deleteUserById($conn, $id)){
                Dialog::showAndRedirect("Xóa tài khoản khác hàng thành công.", "user.php");
            }else{
                Dialog::showAndRedirect("Xóa tài khoản khách hàng thất bại.", "user.php");
            }
        }
    }else{
        header("Location:index.php");
    }
?>