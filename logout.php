<?php
session_start();

// Delete user's wishlist data from the database
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $conn = mysqli_connect('localhost', 'root', 'root', 'petstore');
    $query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    mysqli_close($conn);
}

// Destroy the session
session_destroy();

// Redirect to the login page or elsewhere
header("Location: login.php");
exit();
?>