<?php
session_start();
include '../config/db_connection.php';  // Include the database connection

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Update quantity if form is submitted
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantities'] as $product_id => $quantity) {
            $sql_update = "UPDATE Shopping_Cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([$quantity, $user_id, $product_id]);
        }
    }

    // Fetch products from the user's shopping cart
    $sql = "SELECT p.product_id, p.name, p.price, sc.quantity
            FROM Shopping_Cart sc
            JOIN Products p ON sc.product_id = p.product_id
            WHERE sc.user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $cart_items = $stmt->fetchAll();
} else {
    echo "Please log in to view your cart.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link rel="stylesheet" href="../public/styles.css"> <!-- Link to the external CSS file -->
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>

        <?php if (!empty($cart_items)) { ?>
            <form method="post" action="cart.php">
                <table class="cart-table">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                    $total_price = 0;
                    foreach ($cart_items as $item) {
                        $item_total = $item['price'] * $item['quantity'];
                        $total_price += $item_total;
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>
                            <input type="number" name="quantities[<?php echo $item['product_id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1">
                        </td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>$<?php echo number_format($item_total, 2); ?></td>
                        <td>
                            <a href="remove_from_cart.php?product_id=<?php echo $item['product_id']; ?>" class="remove-btn">Remove</a>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3">Total Price</td>
                        <td>$<?php echo number_format($total_price, 2); ?></td>
                        <td></td>
                    </tr>
                </table>
                <button type="submit" name="update_cart" class="update-btn">Update Cart</button>
            </form>

            <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        <?php } else { ?>
            <p>Your cart is empty. <a href="index.php">Continue shopping</a></p>
        <?php } ?>
    </div>
</body>
</html>
