<?php  
include "./db/db_config.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/index.css">
    <title>Home</title>
</head>
<body>
    <main class="main_container">

        <section class="header_container">
            <header class="header">
                <a href="#">Open Ads</a>
                <nav class="nav_container">
                    <ul class="header_menu">
                        <li><a href="./auth/login.php">Login</a></li>
                    </ul>
                </nav>
            </header>
        </section>

        <section class="body_container">
            <div class="search_container">
                <form action="/db/posts.php" method="GET">
                    <input required type="text" name="search" placeholder="Search ads">
                    <button type="submit">Search</Search></button>
                </form>
            </div>
            
            <div class="posts_container">
                <!-- Example post cards, dynamically populate this with PHP -->
                <div class="post_card">
                    <a href="/post-preview.php?id=1">Post Title 1</a>
                    <p>Description for post 1</p>
                </div>
                <div class="post_card">
                    <a href="/post-preview.php?id=2">Post Title 2</a>
                    <p>Description for post 2</p>
                </div>
                <!-- More posts -->
            </div>
        </section>
    </main>
</body>
</html>
