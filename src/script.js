
window.onload = function() {
  var userData = {
    name: "Manohar Bontha",
    id: "1002091309"
  };
    <script>
        // Fetch CSV file
        fetch('https://manoharbontha3001.blob.core.windows.net/quiz0/q0c.csv')
            .then(response => response.text())
            .then(data => {
                // Parse CSV data
                const rows = data.split('\n');
                const table = document.createElement('table');
                rows.forEach(row => {
                    const columns = row.split(',');
                    const tr = document.createElement('tr');
                    columns.forEach(column => {
                        const td = document.createElement('td');
                        td.textContent = column;
                        tr.appendChild(td);
                    });
                    table.appendChild(tr);
                });
                document.body.insertBefore(table, document.querySelector('footer')); // Insert table before footer
            })
            .catch(error => {
                console.error('Error fetching CSV file:', error);
            });
    </script>
