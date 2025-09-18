<?php
session_start();
include '../config/db_connection.php';  // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view order details.";
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details including shipment details
    $sql = "SELECT oi.product_id, p.name, oi.quantity, oi.price, o.shipping_address, o.shipment_details
            FROM Order_Items oi
            JOIN Products p ON oi.product_id = p.product_id
            JOIN Orders o ON oi.order_id = o.order_id
            WHERE oi.order_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$order_id]);
    $order_items = $stmt->fetchAll();

    // Fetch shipment details
    if (!empty($order_items)) {
        $shipping_address = $order_items[0]['shipping_address'];
        $shipment_details = $order_items[0]['shipment_details'];
    }
} else {
    echo "No order ID specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="../public/styles.css"> <!-- Link to the external CSS file -->
</head>
<body>
    <h1>Order Details</h1>

    <?php if (!empty($order_items)) { ?>
        <h2>Shipping Address</h2>
        <p><?php echo htmlspecialchars($shipping_address); ?></p>
        
        <h2>Shipment Details</h2>
        <p><?php echo htmlspecialchars($shipment_details); ?></p>

        <h2>Order Summary</h2>
        <table border="1" cellspacing="0" cellpadding="10">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php 
            $total_price = 0;
            foreach ($order_items as $item) {
                $item_total = $item['price'] * $item['quantity'];
                $total_price += $item_total;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                <td>$<?php echo number_format($item['price'], 2); ?></td>
                <td>$<?php echo number_format($item_total, 2); ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="3">Total Price</td>
                <td>$<?php echo number_format($total_price, 2); ?></td>
            </tr>
        </table>
    <?php } else { ?>
        <p>No items found for this order.</p>
    <?php } ?>

    <!-- Buttons for navigation -->
    <div class="button-container">
        <a href="../public/index.php" class="button">Back to Home</a>
        <a href="order_history.php" class="button">Order History</a>
    </div>
</body>
</html>
