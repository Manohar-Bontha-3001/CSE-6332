<?php
require 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=manoharbontha3001;AccountKey=lxe8KMUdlOG7NpjW/8OMqDlNdcGmxFRl6R5Ta/25R0H1lUgLrt6zSwpaAarKFc2Rt8wECtaV/yQN+ASt+UyWzg==;EndpointSuffix=core.windows.net";
$containerName = "quiz1";
$blobName = "q0c.csv";

try {
    // Create blob client.
    $blobClient = BlobRestProxy::createBlobService($connectionString);

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
    echo "Error: " . $e->getMessage();
}
?>
