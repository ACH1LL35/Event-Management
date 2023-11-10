<!DOCTYPE html>
<html>
<head>
    <title>EventX - Your Event Partner</title>
    <style>
        /* Basic CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .top-bar {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: relative; /* Add this line for positioning */
        }

        .top-bar a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
        }

        .top-bar a:hover {
            text-decoration: underline;
        }

        .company-name {
            font-size: 24px;
            cursor: pointer; /* Add this line to change the cursor to a pointer on hover */
        }

        .company-name:hover {
            text-decoration: underline;
        }

        #Login-button {
            position: absolute;
            top: 20px;
            right: 10px;
            background-color: #ff6600;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        #Login-button:hover {
            background-color: #ff9933;
        }

        #book-button {
            position: absolute;
            top: 20px;
            right: 80px;
            background-color: #ff6600;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        #book-button:hover {
            background-color: #ff9933;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div><a class="company-name" href="AdminModLogin.php">EventX</a></div>
        <a href="Home.php">Home</a>
        <a href="HomeEvents.php">Events</a>
        <a href="HomeServices.php">Services</a>
        <a href="HomeBlog.php">Blog</a>
        <a href="HomeGallery.php">Gallery</a>
        <a href="HomeVenue.php">Venue</a>
        <a href="HomeEventSupport.php">Event Support</a>
        <a id="Login-button" href="UserLogin.php">Login</a>
        <a id="book-button" href="UserTicket.php">Book Now</a>
    </div>

    <?php
// db.php - Database configuration
$host = 'localhost';  // Update with your MySQL host
$db = 'event_management';         // Update with your database name
$user = 'root';       // Update with your MySQL username
$pass = '';           // Update with your MySQL password

// Create a connection to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Handle post submission
if (isset($_POST['title']) && isset($_POST['content']) && isset($_SESSION['id'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    $conn->query($sql);
}

// Handle comment submission
if (isset($_POST['post']) && isset($_POST['comment']) && isset($_SESSION['id'])) {
    $post = $_POST['post'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO comments (post_id, comment) VALUES ('$post', '$comment')";
    $conn->query($sql);
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .post {
            border: 1px solid #ccc;
            margin-bottom: 20px;
            padding: 10px;
        }
        .comment {
            margin-left: 20px;
        }
    </style>
</head>
<body>

<?php
// Check if the user is logged in
if (isset($_SESSION['id'])) {
    echo '<h2>Welcome, User ID: ' . $_SESSION['id'] . '!</h2>';
    echo '<a href="?action=logout">Logout</a>';
    echo '<hr>';
    echo '<h3>Create a new post:</h3>';
    echo '<form action="" method="post">';
    echo '    <label for="title">Title:</label>';
    echo '    <input type="text" name="title" required><br>';
    echo '    <label for="content">Content:</label><br>';
    echo '    <textarea name="content" rows="4" cols="50" required></textarea><br>';
    echo '    <input type="submit" value="Post">';
    echo '</form>';
    echo '<hr>';
}

// Display existing posts
$sql = "SELECT * FROM posts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<h3>Recent Posts:</h3>';
    while ($row = $result->fetch_assoc()) {
        $postId = $row['id'];
        $postTitle = $row['title'];
        $postContent = $row['content'];

        echo '<div class="post">';
        echo '    <h4>' . $postTitle . '</h4>';
        echo '    <p>' . nl2br($postContent) . '</p>';

        // Display comments for this post
        $commentSql = "SELECT * FROM comments WHERE post_id = $postId";
        $commentResult = $conn->query($commentSql);

        if ($commentResult->num_rows > 0) {
            echo '<h5>Comments:</h5>';
            while ($commentRow = $commentResult->fetch_assoc()) {
                echo '<p class="comment">' . nl2br($commentRow['comment']) . '</p>';
            }
        } else {
            echo '<p>No comments yet.</p>';
        }

        // Comment form for this post
        echo '<form action="" method="post" class="comment">';
        echo '    <input type="hidden" name="post" value="' . $postId . '">';
        echo '    <label for="comment">Your Comment:</label><br>';
        echo '    <textarea name="comment" rows="3" cols="40" required></textarea><br>';
        echo '    <input type="submit" value="Comment">';
        echo '</form>';

        echo '</div>';
    }
} else {
    echo '<p>No posts yet.</p>';
}

$conn->close();
?>
</body>
</html>


</body>
</html>
