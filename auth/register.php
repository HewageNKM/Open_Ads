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
            <form action="/register" method="POST">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required placeholder="Enter your username">
                </div>
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
