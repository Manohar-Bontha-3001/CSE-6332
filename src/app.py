from flask import Flask, request, jsonify, send_file, render_template, redirect, url_for
from flask_login import LoginManager, UserMixin, login_user, login_required, logout_user, current_user
from werkzeug.security import generate_password_hash, check_password_hash
from azure.storage.blob import BlobServiceClient
import os
import csv
import io

app = Flask(__name__)
app.secret_key = 'your_secret_key'

login_manager = LoginManager()
login_manager.init_app(app)
login_manager.login_view = 'login'

# Initialize Azure Blob Service Client
connect_str = os.getenv('AZURE_STORAGE_CONNECTION_STRING')
blob_service_client = BlobServiceClient.from_connection_string(connect_str)
container_name = os.getenv('AZURE_STORAGE_CONTAINER_NAME')

# In-memory data storage for the CSV data
people_data = []

def load_csv():
    global people_data
    blob_client = blob_service_client.get_blob_client(container=container_name, blob="people.csv")
    download_stream = blob_client.download_blob()
    people_data = list(csv.DictReader(io.StringIO(download_stream.content_as_text())))

class User(UserMixin):
    def __init__(self, id, username, password):
        self.id = id
        self.username = username
        self.password = password

# Simple user store
users = {
    "admin": User("1", "admin", generate_password_hash("password"))
}

@login_manager.user_loader
def load_user(user_id):
    return users.get(user_id)

@app.route('/')
def home():
    return render_template('index.html')

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']
        user = next((u for u in users.values() if u.username == username), None)
        if user and check_password_hash(user.password, password):
            login_user(user)
            return redirect(url_for('search_page'))
        else:
            return 'Invalid credentials', 401
    return render_template('login.html')

@app.route('/logout')
@login_required
def logout():
    logout_user()
    return redirect(url_for('home'))

@app.route('/search_page')
@login_required
def search_page():
    return render_template('search.html')

@app.route('/upload_csv', methods=['POST'])
@login_required
def upload_csv():
    file = request.files['file']
    blob_client = blob_service_client.get_blob_client(container=container_name, blob="people.csv")
    blob_client.upload_blob(file, overwrite=True)
    load_csv()
    return "CSV uploaded successfully", 200

@app.route('/search', methods=['GET'])
@login_required
def search():
    try:
        name = request.args.get('name')
        salary = request.args.get('salary')
        results = [person for person in people_data if (name and person['Name'] == name) or (salary and int(person['Salary']) < int(salary))]
        return jsonify(results), 200
    except Exception as e:
        return str(e), 500

@app.route('/get_image/<filename>', methods=['GET'])
@login_required
def get_image(filename):
    try:
        blob_client = blob_service_client.get_blob_client(container=container_name, blob=filename)
        stream = io.BytesIO()
        blob_client.download_blob().readinto(stream)
        stream.seek(0)
        return send_file(stream, mimetype='image/jpeg')
    except Exception as e:
        return str(e), 500

@app.route('/update', methods=['POST'])
@login_required
def update():
    try:
        data = request.json
        name = data.get('name')
        new_data = data.get('new_data')
        for person in people_data:
            if person['Name'] == name:
                person.update(new_data)
                break
        # Update the CSV in the cloud
        csv_buffer = io.StringIO()
        writer = csv.DictWriter(csv_buffer, fieldnames=people_data[0].keys())
        writer.writeheader()
        writer.writerows(people_data)
        blob_client = blob_service_client.get_blob_client(container=container_name, blob="people.csv")
        blob_client.upload_blob(csv_buffer.getvalue(), overwrite=True)
        return "Data updated successfully", 200
    except Exception as e:
        return str(e), 500

if __name__ == '__main__':
    load_csv()
    app.run(host='0.0.0.0', port=5000)

