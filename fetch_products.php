<?php
// Include the database connection
include 'db_connection.php';

// SQL query to fetch products
$query = "SELECT * FROM Products";

// Execute the query
$stmt = $pdo->query($query);

// Start HTML output with inline CSS for styling
echo "
<style>
    table {
        width: 50%;
        margin: 20px auto;
        border-collapse: collapse;
        text-align: left;
    }
    th, td {
        padding: 10px;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    h1 {
        text-align: center;
    }
</style>
";

echo "<h1>Product List</h1>";
echo "<table>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
        </tr>";

// Fetch and display the results in a table
while ($row = $stmt->fetch()) {
    echo "<tr>
            <td>" . $row['name'] . "</td>
            <td>$" . $row['price'] . "</td>
          </tr>";
}

echo "</table>";
?>
