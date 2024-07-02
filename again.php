<?php
session_start(); // Start PHP session

// Database connection
$servername = "localhost"; // Replace with your host
$username = "root";        // Replace with your MySQL username
$password = "";            // Replace with your MySQL password
$dbname = "host";          // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$imageFiles = [];

// Fetch blog images from the database
$sql = "SELECT bimag FROM blogs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through each row and add image filenames to $imageFiles
    while ($row = $result->fetch_assoc()) {
        $imageFiles[] = $row['bimag'];
    }
} else {
    echo "No blogs found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .blog-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .blog {
            width: 185px;
            height: auto;
            border: 1px solid #ccc;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .blog img {
            width: 75px;
            height: 75px;
            margin-bottom: 10px;
        }
        .blog-title {
            font-weight: bold;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 150px; /* Adjust as needed */
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Blogs</h2>
    <div class="blog-container">
        <?php
        if (empty($imageFiles)) {
            echo "<p>No blogs found.</p>";
        } else {
            foreach ($imageFiles as $imageFile) {
                $imagePath = "C:/xampp/htdocs/host/assets/" . htmlspecialchars($imageFile); // Adjust the path as needed
                echo '<div class="blog">';
                echo '<img src="' . $imagePath . '" alt="Blog Image">';
                echo '<p class="blog-title">' . htmlspecialchars($imageFile) . '</p>';
                echo '</div>';
            }
        }
        ?>
    </div>

    <!-- Debugging information (optional) -->
    <h3>Debugging Information:</h3>
    <p>Target Directory: C:/xampp/htdocs/host/assets/</p>
    <p>Image Files: <?php var_dump($imageFiles); ?></p>
</body>
</html>
