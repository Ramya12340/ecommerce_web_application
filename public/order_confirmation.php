<?php 
session_start();
include '../config/db_connection.php';  // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to proceed to checkout.";
    exit();
}

// Retrieve the last order ID from the session
$order_id = $_SESSION['last_order_id'] ?? null;

if (!$order_id) {
    echo "No order found.";
    exit();
}

// Fetch order details
$sql_order = "SELECT * FROM Orders WHERE order_id = ?";
$stmt_order = $pdo->prepare($sql_order);
$stmt_order->execute([$order_id]);
$order = $stmt_order->fetch();

if (!$order) {
    echo "Order not found.";
    exit();
}

// Fetch order items
$sql_items = "SELECT p.name, oi.quantity, oi.price FROM Order_Items oi JOIN Products p ON oi.product_id = p.product_id WHERE oi.order_id = ?";
$stmt_items = $pdo->prepare($sql_items);
$stmt_items->execute([$order_id]);
$order_items = $stmt_items->fetchAll();

// Calculate total price
$total_price = array_reduce($order_items, function($carry, $item) {
    return $carry + ($item['price'] * $item['quantity']);
}, 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../public/styles.css"> <!-- Link to the external CSS file -->
</head>
<body>
    <div class="container">
        <h1>Thank You for Your Order!</h1>
        <h2>Your Order Summary</h2>
        <p>Order ID: <strong><?php echo htmlspecialchars($order['order_id']); ?></strong></p>
        <p>Total Price: <strong>$<?php echo number_format($total_price, 2); ?></strong></p>
        <p>Order Date: <strong><?php echo htmlspecialchars($order['created_at']); ?></strong></p>

        <?php if (!empty($order['shipping_address'])): ?>
            <h3>Shipping Details</h3>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
            <p><strong>Shipment Details:</strong> <?php echo htmlspecialchars($order['shipment_details']); ?></p>
        <?php endif; ?>

        <h3>Items Ordered</h3>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php foreach ($order_items as $item) { 
                $item_total = $item['price'] * $item['quantity'];
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                <td>$<?php echo number_format($item['price'], 2); ?></td>
                <td>$<?php echo number_format($item_total, 2); ?></td>
            </tr>
            <?php } ?>
        </table>

        <a href="index.php" class="btn">Continue Shopping</a>
        <a href="order_history.php" class="btn">View Order History</a>
    </div>
</body>
</html>
