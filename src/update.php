<?php
require 'db_connection.php'; // Include the database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $newDescription = $_POST['description'];
    
    // Update the description in the database
    $stmt = $conn->prepare("UPDATE products SET description = ? WHERE name = ?");
    $result = $stmt->execute([$newDescription, $name]);
    
    if ($result) {
        echo "Description updated for " . htmlspecialchars($name);
    } else {
        echo "Failed to update description for " . htmlspecialchars($name);
    }
}
?>
