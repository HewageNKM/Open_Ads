<?php
include "../db/db_config.php"; // Assuming this contains your database connection

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get and sanitize input data
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm-password'];
        
        // Validate input
        if (empty($email) || empty($password) || empty($confirmPassword)) {
            $error = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        } elseif ($password !== $confirmPassword) {
            $error = "Passwords do not match.";
        } else {
            // Generate a 10-character unique user ID
            $user_id = substr(uniqid(rand(), true), 0, 10);  // Generating a 10-character user_id
            
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Check if the email already exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $error = "Email is already registered.";
            } else {
                // Insert the new user into the database
                $stmt = $conn->prepare("INSERT INTO users (user_id, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $user_id, $email, $hashedPassword);

                if ($stmt->execute()) {
                    // Successfully registered, redirect to login page
                    $_SESSION['user_id'] = "{$user_id}";
                    $_SESSION['email'] = "{$email}";
                    header('Location: /auth/login.php');
                    exit;
                } else {
                    $error = "Something went wrong. Please try again later.";
                }
            }
        }
    }
} catch(Exception $e) {
    $error = "An error occurred: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/register.css">
    <title>Register</title>
</head>
<body>
    <main class="main-container">
        <section class="form-container">
            <h1>Create an Account</h1>

            <?php if (isset($error)): ?>
                <p style="color: red; margin-bottom: 10px; text-align: center;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <div class="input-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required placeholder="Confirm your password">
                </div>
                <button type="submit" class="submit-btn">Register</button>
            </form>

            <p class="redirect">Already have an account? <a href="../auth/login.php">Login here</a></p>
        </section>
    </main>
</body>
</html>
