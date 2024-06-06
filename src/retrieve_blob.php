<?php
require 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=your_account_name;AccountKey=your_account_key;EndpointSuffix=core.windows.net";
$containerName = "your_container_name";
$blobName = "your_file.csv";

try {
    // Create blob client.
    $blobClient = BlobRestProxy::createBlobService($connectionString);

    // Get blob contents.
    $blob = $blobClient->getBlob($containerName, $blobName);
    $content = stream_get_contents($blob->getContentStream());

    // Output contents (for testing).
    echo $content;
} catch (ServiceException $e) {
    echo "Error retrieving blob: " . $e->getCode() . ": " . $e->getMessage();
}
?>
