<?php
session_start();

// Function to delete a product from the database table
function deleteProductFromCartTable($product_id) {
    $conn = mysqli_connect('localhost','root', '', 'petstore');

    // Sanitize the input to prevent SQL injection (you should use prepared statements for better security)
    $product_id = mysqli_real_escape_string($conn, $product_id);

    // Perform the DELETE query
    $sql = "DELETE FROM cart WHERE product_id = '$product_id'";
    mysqli_query($conn, $sql);

    // Close the database connection
    mysqli_close($conn);
}

if (isset($_SESSION['cart']) && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    // Debugging statement
    echo "Product ID to be removed: " . $product_id;
    
    if (isset($_SESSION['cart'][$product_id])) {
        // Remove the product from the cart
        unset($_SESSION['cart'][$product_id]);

        // Remove the product from the cart table
        deleteProductFromCartTable($product_id);
        
        // Debugging statement
        echo "Product removed from cart and database.";
    } else {
        // Debugging statement
        echo "Product not found in cart.";
    }
}
