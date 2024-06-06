<?php
require 'db_connection.php'; // Include the database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    
    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT name, cost, description, image FROM products WHERE name = ?");
    $stmt->execute([$name]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        echo "<h2>Product Details</h2>";
        echo "<p>Name: " . htmlspecialchars($product["name"]) . "</p>";
        echo "<p>Cost: $" . htmlspecialchars($product["cost"]) . "</p>";
        echo "<p>Description: " . htmlspecialchars($product["description"]) . "</p>";
        echo "<img src='" . htmlspecialchars($product["image"]) . "' alt='Product Image'>";
    } else {
        echo "No product found with the name " . htmlspecialchars($name);
    }
}
?>
