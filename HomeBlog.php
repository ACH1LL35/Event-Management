<?php
session_start();

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the Login page
    session_destroy();
    header("Location: UserLogin.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: UserLogin.php");
    exit();
}

$id = $_SESSION['id'];

$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM credential WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username'];
    $email = $row['email'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <style>
        /* Basic CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/bl.jpg'); /* Path to your background image in the "images" folder */
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
        <a href="HomeTicketVerify.php">Verify Ticket</a>
        <a id="Login-button" href="UserLogin.php">Login</a>
        <a id="book-button" href="UserTicket.php">Book Now</a>
    </div>

    <?php
    $host = 'localhost';
    $db = 'event_management';
    $user = 'root';
    $pass = '';

    // Create a connection to the database
    $conn = new mysqli($host, $user, $pass, $db);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle post submission
    if (isset($_POST['title']) && isset($_POST['content']) && isset($_SESSION['id'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];

        $sql = "INSERT INTO posts (posted_by_id, posted_by_username, title, content, status) VALUES ('$id', '$username', '$title', '$content', '1')";
        $conn->query($sql);
    }

    // Handle comment submission
    if (isset($_POST['post']) && isset($_POST['comment']) && isset($_SESSION['id'])) {
        $post = $_POST['post'];
        $comment = $_POST['comment'];

        $sql = "INSERT INTO comments (posted_by_id, posted_by_username, post_id, comment, status) VALUES ('$id', '$username', '$post', '$comment', '1')";
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

    <?php
    // Check if the user is logged in
    if (isset($_SESSION['id'])) {
        echo '<h2>Welcome, ' . $username . '!</h2>';
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

    // Display existing posts with status = 1
    $sql = "SELECT * FROM posts WHERE status = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h3>Recent Posts:</h3>';
        while ($row = $result->fetch_assoc()) {
            $postId = $row['id'];
            $postTitle = $row['title'];
            $postContent = $row['content'];

            echo '<div class="post" style="margin-left: 50px;">';
            echo '    <h4>' . $postTitle . '</h4>';
            echo '    <p>' . nl2br($postContent) . '</p>';

            // Display comments for this post with status = 1
            $commentSql = "SELECT * FROM comments WHERE post_id = $postId AND status = 1";
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
<?php include 'footer.php'; ?>
</body>
</html>
