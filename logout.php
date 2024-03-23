<?
    require "inc/init.php";
    Auth::logout();
    header("Location: index.php");
?>