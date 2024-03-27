<?php
session_start();

if (isset($_GET['index']) && isset($_GET['quantity'])) {
    $index = $_GET['index'];
    $newQuantity = $_GET['quantity'];

    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        if (array_key_exists($index, $_SESSION['cart'])) {
            $_SESSION['cart'][$index][4] = $newQuantity;
        }
    }
}

header('Location: cart.php');
exit;
?>