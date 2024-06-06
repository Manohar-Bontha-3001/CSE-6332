async function uploadCSV() {
    const fileInput = document.getElementById('csvFile');
    const formData = new FormData();
    formData.append('file', fileInput.files[0]);

    try {
        const response = await fetch('/upload_csv', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            alert('CSV uploaded successfully');
        } else {
            const errorText = await response.text();
            alert(`Failed to upload CSV: ${errorText}`);
        }
    } catch (error) {
        alert(`Error: ${error.message}`);
    }
}

async function searchByName() {
    const name = document.getElementById('searchName').value;
    try {
        const response = await fetch(`/search?name=${name}`);
        if (response.ok) {
            const results = await response.json();
            displayResults(results);
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
        const response = await fetch(`/search?salary=${salary}`);
        if (response.ok) {
            const results = await response.json();
            displayResults(results);
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

function goToLogin() {
    window.location.href = '/login';
}

function logout() {
    window.location.href = '/logout';
}

document.getElementById('loginForm').addEventListener('submit', async (event) => {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const formData = new URLSearchParams();
    formData.append('username', username);
    formData.append('password', password);

    try {
        const response = await fetch('/login', {
            method: 'POST',
            body: formData,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });

        if (response.ok) {
            window.location.href = '/search_page';
        } else {
            const errorText = await response.text();
            alert(`Login failed: ${errorText}`);
        }
    } catch (error) {
        alert(`Error: ${error.message}`);
    }
});
