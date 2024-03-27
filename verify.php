<?
    include("inc/init.php");
    if(isset($_GET['email']) && isset($_GET['verify_token'])){
        $conn = include("inc/db.php");
        $email = $_GET['email'];
        $verify_token = $_GET['verify_token'];

        $result = User::getAllByEmailAndToken($conn, $email, $verify_token);
        if($result->verify_status == 0){
            if($users = User::getAllByEmailAndToken($conn, $email, $verify_token)){
                if($users->updateVerify_status($conn, $email, $verify_token)){
                   echo "<h1>Đã xác thực thành công.Quay lại trang web để đăng nhập.</h1>";
                }else{
                    echo "Xác thực không thành công.";
                }
            }
        }else{
            Dialog::showAndRedirect("Email đã được xác minh. Bạn có thể đăng nhập.", "login.php");
        }
    }
  


