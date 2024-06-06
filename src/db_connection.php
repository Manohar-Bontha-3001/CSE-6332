<?php
$serverName = "manoharbontha.database.windows.net";
$database = "Manoharbontha";
$username = "manoharb";
$password = "Santimanu1*";

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
