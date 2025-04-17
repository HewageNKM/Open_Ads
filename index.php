<?php
// index.php - Complete CRUD with search, modal form, black overlay, centered & modern styling
include "./db/db_config.php";

// Handle Create and Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $imageData = null;

    // Handle image upload
    if (!empty($_FILES['image']['tmp_name'])) {
        $img = file_get_contents($_FILES['image']['tmp_name']);
        $imageData = base64_encode($img);
    }

    if ($action === 'create') {
        $post_id = uniqid();
        $stmt = $conn->prepare("INSERT INTO posts (post_id, title, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $post_id, $title, $description, $imageData);
        $stmt->execute();
    }

    if ($action === 'update') {
        $post_id = $_POST['id'];
        if ($imageData) {
            $stmt = $conn->prepare("UPDATE posts SET title = ?, description = ?, image = ? WHERE post_id = ?");
            $stmt->bind_param("ssss", $title, $description, $imageData, $post_id);
        } else {
            $stmt = $conn->prepare("UPDATE posts SET title = ?, description = ? WHERE post_id = ?");
            $stmt->bind_param("sss", $title, $description, $post_id);
        }
        $stmt->execute();
    }

    header('Location: ' . $_SERVER['PHP_SELF'] . (!empty($_GET['search']) ? '?search=' . urlencode($_GET['search']) : ''));
    exit;
}

// Handle Delete
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete') {
    $post_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM posts WHERE post_id = ?");
    $stmt->bind_param("s", $post_id);
    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF'] . (!empty($_GET['search']) ? '?search=' . urlencode($_GET['search']) : ''));
    exit;
}

// Handle Search Query
$search = '';
if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search = trim($_GET['search']);
    $like = "%{$search}%";
    $stmt = $conn->prepare("SELECT * FROM posts WHERE title LIKE ? OR description LIKE ? ORDER BY createdAt DESC");
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM posts ORDER BY post_id DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Open Ads</title>
    <style>
        :root {
            --primary: #4E9E3B;
            --secondary: #FFFFFF;
            --bg: #F9F9F9;
            --text: #333333;
            --card-shadow: rgba(0, 0, 0, 0.08);
        }

        :root {
            --primary: #4E9E3B;
            --secondary: #FFFFFF;
            --bg: #F9F9F9;
            --text: #333333;
            --card-shadow: rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            padding: 1rem;
            background: var(--primary);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.75rem;
        }

        .header h1 {
            color: var(--secondary);
            font-size: 1.5rem;
            flex: 1 1 100%;
        }

        .search-form {
            flex: 1 1 auto;
            display: flex;
            max-width: 100%;
        }

        .search-form input {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 6px 0 0 6px;
            min-width: 0;
        }

        .search-form button {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0 6px 6px 0;
            background: var(--secondary);
            color: var(--primary);
            cursor: pointer;
        }

        .search-form button:hover {
            background: #f0f0f0;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: var(--secondary);
            color: var(--primary);
        }

        .btn-primary:hover {
            transform: scale(1.05);
        }

        .posts_container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
            padding: 1.5rem;
            flex: 1;
        }

        .post_card {
            background: var(--secondary);
            border-radius: 12px;
            height: fit-content;
            width: fit-content;
            box-shadow: 0 4px 16px var(--card-shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.3s, transform 0.3s;
        }

        .post_card:hover {
            box-shadow: 0 8px 24px var(--card-shadow);
            transform: translateY(-4px);
        }

        .post_card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .post_card .info {
            padding: 1rem;
            flex: 1;
        }

        .post_card .info h3 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .post_card .info p {
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .post_card .actions {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-top: 1px solid #eee;
            flex-wrap: wrap;
        }

        .post_card .actions .btn {
            flex: 1;
            font-size: 0.85rem;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 999;
            padding: 1rem;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: var(--secondary);
            border-radius: 12px;
            padding: 2rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px var(--card-shadow);
        }

        .modal h2 {
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .footer {
            text-align: center;
            padding: 1rem;
            background: var(--secondary);
            border-top: 1px solid #eee;
        }

        .footer p {
            color: #777;
            font-size: 0.9rem;
        }

        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                align-items: stretch;
            }

            .search-form {
                flex-direction: column;
            }

            .search-form input,
            .search-form button {
                width: 100%;
                border-radius: 6px;
            }

            .search-form button {
                margin-top: 0.5rem;
            }

            .modal {
                padding: 1.5rem;
            }

            .modal-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .modal-footer .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Open Ads</h1>
        <form class="search-form" action="" method="GET">
            <input type="text" name="search" placeholder="Search ads..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
        <button class="btn btn-primary" onclick="openModal('create')">New Ad</button>
        <button class="btn btn-primary" onclick="window.location.href='index.php'">Refresh</button>
    </div>
    <div class="posts_container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post_card">
                <?php if ($row['image']): ?>
                    <img src="data:image/jpeg;base64,<?= $row['image'] ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                <?php endif; ?>
                <div class="info">
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p><?= htmlspecialchars($row['description']) ?></p>
                </div>
                <div class="actions">
                    <button class="btn btn-primary" onclick="openModal('update','<?= $row['post_id'] ?>','<?= addslashes($row['title']) ?>','<?= addslashes($row['description']) ?>')">Edit</button>
                    <button style="color: red;" class="btn btn-primary" onclick="if(confirm('Delete this ad?')) window.location='?action=delete&id=<?= $row['post_id'] ?>'">Delete</button>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Open Ads. All rights reserved.</p>
    </footer>
    <div id="modalOverlay" class="modal-overlay">
        <div class="modal">
            <h2 id="modalTitle">New Ad</h2>
            <form id="adForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" name="id" id="formId" value="">
                <div class="form-group">
                    <label for="titleInput">Title</label>
                    <input type="text" name="title" id="titleInput" required>
                </div>
                <div class="form-group">
                    <label for="descInput">Description</label>
                    <textarea name="description" id="descInput" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="imgInput">Image</label>
                    <input type="file" name="image" id="imgInput" accept="image/*">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const modalOverlay = document.getElementById('modalOverlay');
        const modalTitle = document.getElementById('modalTitle');
        const formAction = document.getElementById('formAction');
        const formId = document.getElementById('formId');
        const titleInput = document.getElementById('titleInput');
        const descInput = document.getElementById('descInput');

        function openModal(action, id = '', title = '', desc = '') {
            formAction.value = action;
            formId.value = id;
            modalTitle.textContent = action === 'create' ? 'New Ad' : 'Edit Ad';
            titleInput.value = title;
            descInput.value = desc;
            modalOverlay.classList.add('active');
        }

        function closeModal() {
            modalOverlay.classList.remove('active');
            document.getElementById('adForm').reset();
        }
    </script>
</body>

</html>