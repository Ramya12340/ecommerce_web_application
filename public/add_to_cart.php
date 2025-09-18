<?php
session_start();
include '../config/db_connection.php';  // Include the database connection

// Check if product_id and user_id are set
if (isset($_POST['product_id']) && isset($_SESSION['user_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the product is already in the user's cart
    $sql_check = "SELECT * FROM Shopping_Cart WHERE user_id = ? AND product_id = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$user_id, $product_id]);
    $item_in_cart = $stmt_check->fetch();

    if ($item_in_cart) {
        // If the product is already in the cart, increase the quantity
        $sql_update = "UPDATE Shopping_Cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([$user_id, $product_id]);
    } else {
        // If the product is not in the cart, insert it with quantity 1
        $sql_insert = "INSERT INTO Shopping_Cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute([$user_id, $product_id]);
    }

    echo "Product added to cart! <a href='index.php'>Continue shopping</a>";
} else {
    echo "Please log in to add products to your cart.";
}
?>
