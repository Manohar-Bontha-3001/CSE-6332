<?php
require 'db_connection.php'; // Include the database connection script

try {
    // Get blob.
    $blob = $blobClient->getBlob($containerName, $blobName);
    $content = stream_get_contents($blob->getContentStream());

    // Process CSV data.
    $rows = array_map("str_getcsv", explode("\n", $content));
    $header = array_shift($rows);

    // Display CSV data as HTML table
    echo "<table border='1'>";
    echo "<tr>";
    foreach ($header as $column) {
        echo "<th>" . htmlspecialchars($column) . "</th>";
    }
    echo "</tr>";

    foreach ($rows as $row) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} catch (ServiceException $e) {
    // Handle exception.
    echo "Error retrieving blob: " . $e->getMessage();
}
?>
