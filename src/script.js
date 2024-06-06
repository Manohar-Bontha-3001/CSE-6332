// script.js

async function searchByName() {
    const name = document.getElementById('searchName').value;
    try {
        const response = await fetch(`/get_csv_data`);
        if (response.ok) {
            const results = await response.json();
            const filteredResults = results.filter(person => person.Name.toLowerCase().includes(name.toLowerCase()));
            displayResults(filteredResults);
        } else {
            const errorText = await response.text();
            alert(`Search failed: ${errorText}`);
        }
    } catch (error) {
        alert(`Error: ${error.message}`);
    }
}

async function searchBySalary() {
    const salary = document.getElementById('searchSalary').value;
    try {
        const response = await fetch(`/get_csv_data`);
        if (response.ok) {
            const results = await response.json();
            const filteredResults = results.filter(person => parseInt(person.Salary) < parseInt(salary));
            displayResults(filteredResults);
        } else {
            const errorText = await response.text();
            alert(`Search failed: ${errorText}`);
        }
    } catch (error) {
        alert(`Error: ${error.message}`);
    }
}

function displayResults(results) {
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '';
    results.forEach(person => {
        const img = document.createElement('img');
        img.src = `/get_image/${person.Picture}`;
        resultsDiv.appendChild(img);
    });
}
