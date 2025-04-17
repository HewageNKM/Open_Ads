# Open Ads

Open Ads is a simple classified advertisement platform built using pure PHP and MySQL. It allows users to post, update, search, and delete ads with image uploads. No external PHP frameworks are used, making it ideal for learning or lightweight projects.

✨ Features
--------
🔍 Search functionality for browsing ads
📸 Image upload support (base64 encoded)
📝 Create, Read, Update, and Delete (CRUD) operations
🖼️ Responsive, modern design with modal form and black overlay
📦 Secure MySQL prepared statements
💻 Built using vanilla PHP, HTML, CSS, and minimal JavaScript

🧱 Technology Stack
------------------

| Component | Tech Used       |
|-----------|-----------------|
| Backend   | PHP (8.0+)      |
| Database  | MySQL / MariaDB |
| Frontend  | HTML, CSS, JS   |
| Server    | Apache / Nginx  |

⚙️ Setup Instructions
--------------------

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/EthanBlake00/Open_Ads.git open-ads
    cd open-ads
    ```

2.  **Configure the Database**
    *   Create a MySQL database (e.g., `open_ads`). You can use a tool like phpMyAdmin or the command line:
        ```sql
        CREATE DATABASE open_ads;
        ```
    *   Import the SQL schema located in the `database/` directory:
        ```bash
        # Replace 'root' with your MySQL username if different
        # You will be prompted for your MySQL password
        mysql -u root -p open_ads < database/schema.sql
        ```
        *(Make sure to replace `root` with your DB user and `open_ads` with your DB name if you chose differently.)*

3.  **Configure the Database Connection**
    Update the database credentials in `./db/db_config.php`:
    ```php
    <?php
    $host = "localhost"; // Or your DB host
    $user = "root";      // Your DB username
    $password = "";      // Your DB password
    $database = "open_ads"; // Your DB name

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
    ```

🚀 Usage
-------

1.  Place the `open-ads` project directory into your web server's document root (e.g., `htdocs` for XAMPP, `www` for WAMP/MAMP, or `/var/www/html` for standard Apache on Linux).
2.  Visit `http://localhost/open-ads/` (or the appropriate path based on where you placed the folder) in your web browser.
3.  Create a new ad using the "New Ad" button.
4.  View, edit, delete, and search posts directly from the main page.
5.  Uploaded images are stored in base64 format within the database.

📂 File Structure (Example)
--------------------------
```plaintext
open-ads/
├── index.php             # Main application file (UI, CRUD logic, Search)
├── db/
│   └── db_config.php     # Database connection configuration
├── database/
│   └── schema.sql        # MySQL database schema
├── assets/               # Optional: CSS, JS, or static image files
│   └── style.css         # (Example CSS file if used)
└── README.md             # This file
