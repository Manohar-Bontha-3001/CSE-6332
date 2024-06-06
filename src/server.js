// server.js

const express = require('express');
const bodyParser = require('body-parser');
const azure = require('azure-storage');
const csv = require('csv-parser');

const app = express();
const PORT = process.env.PORT || 3000;

// Initialize Azure Blob Storage client
const blobService = azure.createBlobService();

// Middleware
app.use(bodyParser.json());

// Endpoint to get CSV data
app.get('/get_csv_data', (req, res) => {
    const containerName = 'your-container-name'; // Replace with your container name
    const blobName = 'people.csv'; // Replace with your CSV file name

    const blobStream = blobService.createReadStream(containerName, blobName);

    const results = [];
    blobStream.pipe(csv())
        .on('data', (data) => results.push(data))
        .on('end', () => {
            res.json(results);
        })
        .on('error', (error) => {
            console.error('Error reading CSV:', error);
            res.status(500).send('Error reading CSV');
        });
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
