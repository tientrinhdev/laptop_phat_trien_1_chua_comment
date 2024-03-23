<!DOCTYPE html>
<html>
<head>
<title>Cửa hàng laptop</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/style.css?v=<?echo time();?>" />
    <link rel="stylesheet" href="css/style_form.css?v=<?echo time();?>" />
    <link rel="stylesheet" href="css/style_card.css?v=<?echo time();?>" />
    <script src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="vendors/font-awesome-4.7.0/css/font-awesome.min.css" />
</head>
<body>
    <div class="page">
        <div class="header fixed">
            <div class="multi-columns">
                <div class="left col-2">
                    <div class="brand">
                        <i class="icon"></i>
                        <h1 class="name">LAPTOP</h1>
                    </div>
                </div>
                <div class="right col-6">
                    <ul class="main-nav">
                    <? if(!Auth::isLoggedIn()): ?>
                        <li class="item"><a href="index.php" class="text">Trang chủ</a></li>
                        <li class="item"><a href="addcontact.php" class="text">Liên hệ</a></li>
                        <li class="item"><a href="adduser.php" class="text">Đăng kí</a></li>
                        <li class="item"><a href="login.php" class="text">Đăng nhập</a></li>
                        <?elseif(Auth::isLoggedIn()): ?>
                            <li class="item"><a href="index.php" class="text">Trang chủ</a></li>
                            <li class="item"><a href="addcontact.php" class="text">Liên hệ</a></li>
                            <li class="item"><a href="showorder.php" class="text">Đơn hàng</a></li>
                            <li class="item"><a href="cart.php" class="text">Giỏ hàng</a></li>
                            <li class="item"><a href="deluser.php" class="text">Xóa tài khoản</a></li>
                            <li class="item"><a href="editpassword.php" class="text">Đổi mật khẩu</a></li>
                            <li class="item"><a href="logout.php" class="text">Đăng xuất</a></li>   
                        <? endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="promotions">
                <div class="item">
                    <img class="photo" src="images\laptop.png" />
                    <div class="summary">
                        <h3 class="title">Công nghệ tiên phong, chất lượng hàng đầu</h3>
                        <p class="desc">Mang công nghệ đến mọi nhà <br/><br/>Laptop chất lượng, Giá trị bất tận</p>
                    </div>
                </div>
            </div>
        </div>