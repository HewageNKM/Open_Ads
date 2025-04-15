<?php
include "../db/db_config.php"; // Assuming this contains your database connection
try{
    if (isset($_POST['login_button'])) {
        // Sanitize input to prevent SQL Injection
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
    
        if (empty($email) || empty($password)) {
            $error = "Please enter both email and password.";
        } else {
            // Use MySQLi prepared statement
            if ($stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1")) {
                // Bind the parameters (s for string)
                $stmt->bind_param("s", $email);
    
                // Execute the query
                $stmt->execute();
    
                // Get the result
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
    
                // Check if user exists
                if ($user) {
                    // Verify the password
                    if (password_verify($password, $user['password'])) {
                        // Store user info in the session
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['email'] = $user['email'];
    
                        // Redirect to dashboard or other page
                        header('Location: /open_ads');
                        exit;
                    } else {
                        $error = "Incorrect password.";
                    }
                } else {
                    $error = "User not found.";
                }
    
                // Close the prepared statement
                $stmt->close();
            } else {
                $error = "Error with database query.";
            }
        }
    }
}catch(Exception $e){
    $error = "An error occurred: ". $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/login.css">
    <title>Login</title>
</head>
<body>
    <main class="main-container">
        <section class="form-container">
            <h1>Login to Your Account</h1>

            <?php if (!empty($error)): ?>
                <p style="color: red; margin-bottom: 10px; text-align: center;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit" class="submit-btn" name="login_button">Login</button>
            </form>
            <p class="redirect">Don't have an account? <a href="../auth/register.php">Register here</a></p>
        </section>
    </main>
</body>
</html>
