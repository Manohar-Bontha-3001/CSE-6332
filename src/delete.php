<?php
require 'db_connection.php'; // Include the database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    
    // Delete the user or picture from the database
    $stmt = $conn->prepare("DELETE FROM products WHERE name = ?");
    $result = $stmt->execute([$name]);
    
    if ($result) {
        echo "Deleted user or picture for " . htmlspecialchars($name);
    } else {
        echo "Failed to delete user or picture for " . htmlspecialchars($name);
    }
}
?>
