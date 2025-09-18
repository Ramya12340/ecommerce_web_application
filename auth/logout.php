<?php
session_start();
session_destroy();  // Destroy the session

// Redirect to the home page (adjust this path if needed)
header('Location: ../public/index.php');
exit();
?>
