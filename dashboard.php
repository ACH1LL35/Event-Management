<?php

$servername = "localhost"; // Update with your database host
$dbusername = "root";      // Update with your database username
$dbpassword = "";          // Update with your database password
$dbname = "host";          // Update with your database name

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uid = $_SESSION['uid'];

// Fetch user information from database
$sql = "SELECT * FROM login WHERE uid=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 200px;
            background-color: #333;
            color: white;
            height: 100vh;
            padding: 15px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .content {
            flex: 1;
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Menu</h2>
            <a href="dashHome.php">Home</a> <!-- Link to dashHome.php -->
            <a href="dashProfile.php">Profile</a>
            <a href="dashSettings.php">Settings</a>
            <a href="blogUpload.php">Blogs</a> <!-- Link to BlogUpload.php -->
            <a href="logout.php">Logout</a> <!-- Direct link to logout page -->
        </div>
    </div>
</body>
</html>