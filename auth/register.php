<?php
include '../config/db_connection.php';  // Include the database connection
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash the password

    // Check if the email already exists
    $sql = "SELECT * FROM Users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        echo "<div class='error-message'>Email already exists. Please use a different email or <a href='login.php'>log in</a>.</div>";
    } else {
        // Insert the new user into the database
        $sql = "INSERT INTO Users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $password]);

        echo "<div class='success-message'>Registration successful! You can now <a href='login.php'>log in</a>.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../public/styles.css"> <!-- Link to the external CSS file -->
</head>
<body>

    <div class="container">
        <h1>Register</h1>
        <form method="post" action="">
            <label for="name">Name:</label>
            <input type="text" name="name" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Register</button>
        </form>
        <p>Don't have an account? <a href="login.php">Log in here</a>.</p>
    </div>

</body>
</html>
