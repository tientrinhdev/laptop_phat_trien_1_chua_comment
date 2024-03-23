<?php
class Dialog {
    public static function showAndRedirect($msg, $url) {
        echo "<script>alert('$msg'); window.location.href = '$url';</script>";
        exit(); 
    }

    public static function show($msg){
        echo "<script>alert('{$msg}')</script>";
    }
}
?>
