<?php
include("UserSidebar.php");

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

$servername = "localhost";
$dbUsername = "root"; // Use a different variable name for the database connection
$password = "";
$dbname = "event_management";

$conn = new mysqli($servername, $dbUsername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define table names with optional custom names
$tables = array(
    "booking" => "",
    "purchase_info" => "",
    "posts" => "",
    "comments" => ""
);

$counts = array();

foreach ($tables as $tableName => $customName) {
    if ($tableName == "posts" || $tableName == "comments") {
        $queryCount = "SELECT COUNT(*) AS count FROM $tableName WHERE posted_by_id = '$id'";
    } else {
        $queryCount = "SELECT COUNT(*) AS count FROM $tableName WHERE user_id = '$id'";
    }

    $result = $conn->query($queryCount);
    $counts[$customName ? $customName : $tableName] = $result->fetch_assoc()['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
        }

        #content {
            margin: 20px; /* Adjust margin as needed */
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .box {
            width: calc(35% - 20px);
            margin: 10px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin: 0;
        }

        ul li a {
            display: block;
            padding: 10px;
            background-color: #eee;
            text-decoration: none;
        }

        ul li a:hover {
            background-color: #ddd;
        }

        #logout-container {
            position: absolute;
            top: 20px;
            right: 10px;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff5733;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #ff0000;
        }

        /* Clearfix for clearing floats */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

    <div id="content">
        <?php
        foreach ($counts as $customName => $count) {
        ?>
            <div class="box">
                <h2><?php echo ($customName !== "") ? $customName : $tableName; ?></h2>
                <p><?php echo $count; ?></p>
            </div>
        <?php
        }
        ?>
    </div>
    <div id="logout-container">
        <form method="post">
            <input type="submit" class="logout-button" name="logout" value="Logout">
        </form>
    </div>
</body>
</html>
