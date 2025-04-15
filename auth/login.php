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
            <form action="/login" method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit" class="submit-btn">Login</button>
            </form>
            <p class="redirect">Don't have an account? <a href="../auth/register.php">Register here</a></p>
        </section>
    </main>
</body>
</html>
