<?php
session_start();
include("../view/AdminSidebar.php");

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the Login page
    session_destroy();
    header("Location: start.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: start.php");
    exit();
}

$id = $_SESSION['id'];

$servername = "localhost";
$username = "root";
$pass = "";
$dbname = "event_management";

// Create a database connection
$conn = new mysqli($servername, $username, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include('../controller/ModeratorListController.php');

$moderatorListController = new ModeratorListController($conn);
$moderatorListController->handleRequest();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator List</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #content {
            flex: 1;
            display: flex;
            flex-direction: column; /* Align content vertically */
        }

        .content {
            padding-left: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }
        /* Styles for the logout form */
        .logout-form {
            text-align: center;
        }

        .logout-form .logout-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            border: 2px solid #007BFF;
            border-radius: 3px;
            cursor: pointer;
            width: 200px;
            text-decoration: none;
        }

        .logout-form .logout-button:hover {
            background-color: #0056b3;
        }
    </style></head>
<body>
    <div id="content">
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">Moderator List</h1>
        <form method="post">
            <table border="1">
                <tr>
                    <th>MOD ID</th>
                    <th>USER NAME</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($moderatorListController->getModerators() as $moderator): ?>
                    <tr>
                        <td><?php echo $moderator["id"]; ?></td>
                        <td><?php echo $moderator["uname"]; ?></td>
                        <td><?php echo $moderator["email"]; ?></td>
                        <td><?php echo $moderator["status"]; ?></td>
                        <td>
                            <?php if ($moderator["status"] == 1): ?>
                                <button type="submit" name="ban" value="<?php echo $moderator["id"]; ?>">Ban</button>
                            <?php else: ?>
                                <button type="submit" name="uban" value="<?php echo $moderator["id"]; ?>">Unban</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </div>
</body>
</html>
