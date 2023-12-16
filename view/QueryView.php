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

include('../controller/QueryController.php');

$queryController = new QueryController($conn);
$queryController->handleRequest();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUERY FEEDBACK</title>
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
    </style>
</head>
<body>
    <div class="content">
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">QUERY FEEDBACK</h1>
        <form method="get">
            <table border="1">
                <tr>
                    <th>QUERY ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Feedback</th>
                    <th>Feedback Given By</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($queryController->getAllQueries() as $query): ?>
                    <tr>
                        <td><?php echo $query["q_id"]; ?></td>
                        <td><?php echo $query["u_name"]; ?></td>
                        <td><?php echo $query["u_email"]; ?></td>
                        <td><?php echo $query["q_title"]; ?></td>
                        <td><?php echo $query["q_des"]; ?></td>
                        <td><?php echo $query["q_fed"]; ?></td>
                        <td><?php echo $query["fd_by"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </div>
</body>
</html>

