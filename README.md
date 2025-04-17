# Open Ads

Open Ads is a web application built with **pure PHP** that allows registered users to post classified advertisements. Visitors can browse and view these ads freely. This project serves as a simple platform for users to list items or services they want to offer, developed without the use of external PHP frameworks.

## Features

*   **User Management:**
    *   User Registration
    *   User Login / Logout
    *   Secure Password Hashing (`password_hash` and `password_verify`)
*   **Ad Management (Registered Users Only):**
    *   Create New Ads (Title, Description, Category, Price, Image Upload)
    *   View Own Ads
    *   Edit Own Ads
    *   Delete Own Ads
*   **Public Ad Viewing:**
    *   Browse a list of all active ads
    *   View detailed information for a single ad
    *   (Optional: Add Search/Filtering capabilities here later)
*   **Image Uploads:** Users can upload images associated with their ads.

## Technology Stack

*   **Backend:** PHP (Specify version, e.g., PHP 8.0+)
*   **Database:** MySQL / MariaDB
*   **Frontend:** HTML, CSS, JavaScript (Vanilla JS or minimal libraries)
*   **Web Server:** Apache or Nginx

## Prerequisites

Before you begin, ensure you have met the following requirements:

*   PHP (Version specified above)
*   MySQL or MariaDB database server
*   A web server (Apache or Nginx)
*   Git (for cloning the repository)
*   (Optional) Composer, if you decide to include specific libraries (e.g., for routing or validation) later.

## Installation

Follow these steps to get your development environment set up:

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/EthanBlake00/Open_Ads.git open-ads
    cd open-ads
    ```

2.  **Configure Environment:**
    *   Locate the configuration file (e.g., `config.php`, `includes/config.php`, or similar). You might need to copy an example file if provided:
        ```bash
        # Example if an example config is provided
        cp config.example.php config.php
        ```
    *   Edit the configuration file (`config.php` or equivalent) with your database credentials:
        *   Database Host (e.g., `DB_HOST` or `$db_host`)
        *   Database Name (e.g., `DB_NAME` or `$db_name`)
        *   Database Username (e.g., `DB_USER` or `$db_user`)
        *   Database Password (e.g., `DB_PASS` or `$db_pass`)
        *   (Optional) Base URL of the application if needed in the config.

3.  **Database Setup:**
    *   Create a new database in MySQL/MariaDB with the name you specified in the configuration file.
    *   Import the database schema using an SQL file (e.g., `database/schema.sql`):
        ```bash
        mysql -u <your_db_username> -p <your_db_name> < database/schema.sql
        ```
        *(Adjust the path `database/schema.sql` if your schema file is located elsewhere. Replace `<your_db_username>` and `<your_db_name>`)*

## Usage

1.  Access the application through the URL configured in your web server (e.g., `http://localhost/open-ads/` or `http://open-ads.test`).
2.  Browse existing ads on the homepage or ads listing page.
3.  Click on an ad title or "View" button to see its details.
4.  Click "Register" to create a new user account.
5.  Click "Login" to access your account.
6.  Once logged in, you should see options to "Post New Ad", view "My Ads", and potentially edit/delete your existing ads.

## Database Schema Overview (Simplified)

*   **`users` table:** Stores user information (id, username, email, password_hash, created_at, updated_at).
*   **`ads` table:** Stores ad details (id, user_id (foreign key), title, description, price, category, image_path, created_at, updated_at).
*   **(Optional):** `categories` table if implementing distinct categories.

## Contributing (Optional)

Contributions are welcome! If you'd like to contribute, please follow these steps:

1.  Fork the repository.
2.  Create a new branch (`git checkout -b feature/your-feature-name`).
3.  Make your changes.
4.  Commit your changes (`git commit -m 'Add some feature'`).
5.  Push to the branch (`git push origin feature/your-feature-name`).
6.  Open a Pull Request.

## License (Optional)

This project is licensed under the MIT License - see the LICENSE.md file for details (or choose another license).