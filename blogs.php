<?php
session_start(); // Start PHP session

// Database connection parameters
$servername = "localhost"; // Replace with your host
$username = "root";        // Replace with your MySQL username
$password = "";            // Replace with your MySQL password
$dbname = "host";          // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch blogs from database
$sql = "SELECT btitle, bimag FROM blogs"; // Adjusted to use bimag
$result = $conn->query($sql);

// Close the connection (you should fetch all data before closing the connection)
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
            gap: 65px;
        }
        .blog {
            width: 185px;
            height: 100px;
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
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bimagPath = htmlspecialchars($row['bimag']);
                echo '<div class="blog">';
                echo '<img src="' . $bimagPath . '" alt="Blog Image">';
                echo '<p class="blog-title">' . htmlspecialchars($row['btitle']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No blogs found.</p>';
        }
        ?>
    </div>
</body>
</html>