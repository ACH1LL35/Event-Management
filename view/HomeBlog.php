<?php
if(!defined('APP_RUNNING')) define('APP_RUNNING', true);
session_start();

if (!isset($_SESSION['id'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Blog - EventX</title>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Outfit', sans-serif; background: #f8fafc; margin: 0; padding: 0; }
            .login-prompt { display: flex; justify-content: center; align-items: center; height: 60vh; }
            .card { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); text-align: center; max-width: 400px; border: 1px solid #e2e8f0; }
            h2 { color: #0f172a; margin-top: 0; }
            a { color: #2563eb; text-decoration: none; font-weight: 600; }
        </style>
    </head>
    <body>
        <?php include 'includes/HomeTopBar.php'; ?>
        <div class="login-prompt">
            <div class="card">
                <h2>Access Denied</h2>
                <p>Please <a href="UserLogin">Sign In</a> to join the conversation.</p>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>
    </body>
    </html>
    <?php exit();
}

$id = $_SESSION['id'];
include 'includes/db.php';

$query = "SELECT username FROM credential WHERE id = '$id'";
$result = $conn->query($query);
$username = ($row = $result->fetch_assoc()) ? $row['username'] : "User";

if (isset($_POST['title']) && isset($_POST['content'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $conn->query("INSERT INTO posts (posted_by_id, posted_by_username, title, content, status) VALUES ('$id', '$username', '$title', '$content', '1')");
}

if (isset($_POST['post']) && isset($_POST['comment'])) {
    $postId = intval($_POST['post']);
    $comment = $conn->real_escape_string($_POST['comment']);
    $conn->query("INSERT INTO comments (posted_by_id, posted_by_username, post_id, comment, status) VALUES ('$id', '$username', '$postId', '$comment', '1')");
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy(); header("Location: UserLogin"); exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - EventX</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; margin: 0; color: #1e293b; }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .blog-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .post-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 30px; margin-bottom: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .post-form { background: #eff6ff; border: 1px solid #dbeafe; }
        h2, h3 { color: #0f172a; margin-top: 0; }
        input[type="text"], textarea { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; margin-bottom: 15px; box-sizing: border-box; }
        input[type="submit"] { background: #2563eb; color: #fff; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s; }
        input[type="submit"]:hover { background: #1d4ed8; }
        .post-title { color: #2563eb; margin-bottom: 10px; font-size: 1.4rem; }
        .comment-box { background: #f1f5f9; padding: 15px; border-radius: 10px; margin: 15px 0; border-left: 4px solid #2563eb; }
        .comment-item { margin-bottom: 10px; font-size: 0.95rem; }
        .logout-link { color: #ef4444; font-weight: 600; text-decoration: none; }
    </style>
</head>
<body>
    <?php include 'includes/HomeTopBar.php'; ?>
    <div class="container">
        <div class="blog-header">
            <h2>Welcome, <?php echo htmlspecialchars($username); ?></h2>
            <a href="?action=logout" class="logout-link">Logout</a>
        </div>

        <div class="post-card post-form">
            <h3>Share an Update</h3>
            <form method="post">
                <input type="text" name="title" placeholder="Topic" required>
                <textarea name="content" rows="4" placeholder="What's on your mind?" required></textarea>
                <input type="submit" value="Publish Post">
            </form>
        </div>

        <?php
        $result = $conn->query("SELECT * FROM posts WHERE status = 1 ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            $postId = $row['id'];
            echo '<div class="post-card">';
            echo '<h3 class="post-title">' . htmlspecialchars($row['title']) . '</h3>';
            echo '<p>' . nl2br(htmlspecialchars($row['content'])) . '</p>';

            $comments = $conn->query("SELECT * FROM comments WHERE post_id = $postId AND status = 1");
            if ($comments->num_rows > 0) {
                echo '<div class="comment-box">';
                while ($c = $comments->fetch_assoc()) {
                    echo '<div class="comment-item"><strong>' . htmlspecialchars($c['posted_by_username']) . ':</strong> ' . htmlspecialchars($c['comment']) . '</div>';
                }
                echo '</div>';
            }
            
            echo '<form method="post" style="display:flex; gap:10px;">';
            echo "<input type='hidden' name='post' value='$postId'>";
            echo '<input type="text" name="comment" placeholder="Write a reply..." required style="margin-bottom:0;">';
            echo '<input type="submit" value="Reply" style="padding: 5px 15px;">';
            echo '</form></div>';
        }
        $conn->close();
        ?>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>