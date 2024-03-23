<?php
session_start();

if (isset($_POST['index']) && isset($_POST['quantity'])) {
    $index = $_POST['index'];
    $newQuantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$index])) {
        if (ctype_digit($newQuantity) && $newQuantity > 0) {
            $_SESSION['cart'][$index][4] = $newQuantity;
            echo "success"; 
            exit;
        }
    }
}

echo "error";
?>
