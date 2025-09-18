<?php
session_start();
include '../config/db_connection.php';  // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your order history.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's order history
$sql = "SELECT o.order_id, o.total_price, o.created_at 
        FROM Orders o 
        WHERE o.user_id = ?
        ORDER BY o.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="../public/styles.css"> <!-- Link to your external CSS file -->
</head>
<body>
    <header>
        <h1>Your Order History</h1>
    </header>

    <?php if (!empty($orders)) { ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Order Date</th>
                <th>Details</th>
            </tr>
            <?php foreach ($orders as $order) { ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td>$<?php echo number_format($order['total_price'], 2); ?></td>
                <td><?php echo $order['created_at']; ?></td>
                <td><a href="order_details.php?order_id=<?php echo $order['order_id']; ?>">View Details</a></td>
            </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>You have no past orders. <a href="index.php">Continue shopping</a></p>
    <?php } ?>

    <footer>
        <a href="index.php">Back to Home</a>
    </footer>
</body>
</html>
