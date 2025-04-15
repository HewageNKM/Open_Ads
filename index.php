<?php  
include "./db/db_config.php";

$posts = null;
$stm = $conn->prepare("SELECT * FROM posts");
$stm->execute();
$posts = $stm->get_result();

function fetchPosts() {
    if (isset($posts)) {
        foreach ($posts as $post) {
            echo 
            "<div class='post_card'>

            <div>";
        }
    }else{
        echo "<p>No posts found</p>";
    }
}
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
                        <?php 
                        if (isset($_SESSION['user_id'])) {
                            echo "<li><button onClick='showModal()'>Post Ad</button></li>";
                        }else{
                            echo "<li><a href='./auth/login.php'>Login</a></li>";
                        }
                        ?>
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
                <?php fetchPosts(); ?>
            </div>
        </section>
        <modal class="post_modal_disabled post_modal" id="modal_post">
  <div class="post_modal_container">
    <form action="./db/create_post.php" method="POST" enctype="multipart/form-data" class="modal_form">
      <h2>Post a New Ad</h2>

      <!-- Image Upload -->
      <label for="image">Upload Image</label>
      <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" required />
      <img id="imagePreview" src="" alt="Image Preview" style="max-width: 100%; margin-top: 10px; display: none;" />

      <!-- Title -->
      <label for="title">Title</label>
      <input type="text" id="title" name="title" required />

      <!-- Description -->
      <label for="description">Description</label>
      <textarea id="description" name="description" rows="4" required></textarea>

      <!-- Buttons -->
      <div class="modal_buttons">
        <button type="submit">Post</button>
        <button type="button" onclick="hideModal()">Cancel</button>
      </div>
    </form>
  </div>
</modal>

    </main>
<script src="./js/script.js" type="text/javascript"></script>
</body>
</html>