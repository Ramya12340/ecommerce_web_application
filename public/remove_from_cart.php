<?php
session_start();
include '../config/db_connection.php';  // Include the database connection

if (isset($_GET['product_id']) && isset($_SESSION['user_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['user_id'];

    // Delete the product from the cart
    $sql_delete = "DELETE FROM Shopping_Cart WHERE user_id = ? AND product_id = ?";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute([$user_id, $product_id]);

    // Redirect back to cart
    header('Location: cart.php');
    exit();
} else {
    echo "Error removing item from cart.";
}
?>
