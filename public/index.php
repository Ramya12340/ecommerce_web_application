<?php
// Include the database connection
include '../config/db_connection.php';
session_start();  // Start the session to check if the user is logged in

// Fetch all products
$query = "SELECT p.product_id, p.name, p.price, p.description, p.image_url, c.category_name 
          FROM Products p 
          JOIN Categories c ON p.category_id = c.category_id"; // Join with Categories table
$stmt = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Home</title>
    <link rel="stylesheet" href="../public/styles.css"> <!-- Link to the external CSS file -->
</head>
<body>

    <!-- User Authentication Links or Welcome Message -->
    <header>
        <h1>E-Commerce Store</h1>
        <nav>
            <?php
            if (isset($_SESSION['name'])) {
                echo "<h2>Welcome, " . htmlspecialchars($_SESSION['name']) . "!</h2>";
                echo "<a href='../auth/logout.php'>Logout</a>";
                echo " | <a href='cart.php'>My Cart</a>"; // Add cart link
                echo " | <a href='order_history.php'>My Orders</a>"; // Add orders link
            } else {
                echo "<a href='../auth/login.php'>Login</a> | <a href='../auth/register.php'>Register</a>";
            }
            ?>
        </nav>
    </header>

    <!-- Product List -->
    <main>
        <h2>Product List</h2>
        <table>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $stmt->fetch()) { ?>
            <tr>
                <td>
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="max-width: 100px; max-height: 100px;" /> <!-- Display product image -->
                </td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>$<?php echo number_format($row['price'], 2); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td>
                    <!-- Add to Cart Form -->
                    <form method="post" action="add_to_cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <button type="submit">Add to Cart</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 E-Commerce Store. All rights reserved.</p>
    </footer>

</body>
</html>
