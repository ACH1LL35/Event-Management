<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost"; // Update with your database host
$dbusername = "root";      // Update with your database username
$dbpassword = "";          // Update with your database password
$dbname = "host";         // Update with your database name

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
    <title>Dashboard Home</title>
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
        .edit-form {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            width: 300px;
        }
        .edit-form label {
            display: block;
            margin-bottom: 5px;
        }
        .edit-form input[type="text"], .edit-form input[type="email"], .edit-form input[type="password"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }
        .edit-form button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .edit-form button:hover {
            background-color: #45a049;
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
            <a href="blogUpload.php">Blogs</a>
            <a href="logout.php">Logout</a> <!-- Direct link to logout page -->
        </div>
        <div class="content">
            <h2>Welcome <?php echo $user['uname']; ?></h2>
            <p>Full Name: <?php echo $user['fname']; ?></p>
            <p>Email: <?php echo $user['uemail']; ?></p>
            <p>Username: <?php echo $user['uname']; ?></p>

            <div class="edit-form">
                <h3>Edit Information</h3>
                <form action="edit_handler.php" method="post">
                    <div>
                        <label for="fname">Full Name:</label>
                        <input type="text" id="fname" name="fname" value="<?php echo $user['fname']; ?>" required>
                    </div>
                    <div>
                        <label for="uemail">Email:</label>
                        <input type="email" id="uemail" name="uemail" value="<?php echo $user['uemail']; ?>" required>
                    </div>
                    <div>
                        <label for="uname">Username:</label>
                        <input type="text" id="uname" name="uname" value="<?php echo $user['uname']; ?>" required>
                    </div>
                    <div>
                        <label for="upass">New Password:</label>
                        <input type="password" id="upass" name="upass">
                    </div>
                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>