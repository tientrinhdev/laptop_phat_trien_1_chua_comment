<?
    require "inc/init.php";
    Auth::logout();
    header("Location: home.php");
?>