<?php
session_start();

// Check if the 'cart' session array exists
if (isset($_SESSION['cart']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);

    // Check if the product is in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // Update the quantity of the product in the cart
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    }
}
?>