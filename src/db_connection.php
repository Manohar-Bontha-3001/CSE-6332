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
} catch (Exception $e) {
    echo "Error connecting to Blob Storage: " . $e->getMessage();
    exit;
}
?>
