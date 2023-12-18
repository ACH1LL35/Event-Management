<?php
session_start();
include('../view/AdminSidebar.php');

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

include('../controller/TicketAuditController.php');

$ticketAuditController = new TicketAuditController($conn);
$ticketAuditController->handleRequest();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Audit</title>
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
        h1 {
            text-align: center;
            margin-bottom: 20px;
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
    <div id="content">
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">Ticket Audit</h1>
        <form method="get">
        <table border="1">
            <tr>
                <th>Event ID</th>
                <th>Event Name</th>
                <th>Event Venue</th>
                <th>Ticket Price</th>
                <th>Total Ticket</th>
                <th>Available Ticket</th>
            </tr>
        <?php foreach ($ticketAuditController->getAllTicketAuditData() as $ticketAuditData): ?>
            <tr>
                <td><?php echo $ticketAuditData["Showid"]; ?></td>
                <td><?php echo $ticketAuditData["event_name"]; ?></td>
                <td><?php echo $ticketAuditData["venue"]; ?></td>
                <td><?php echo $ticketAuditData["ticket_price"]; ?></td>
                <td><?php echo $ticketAuditData["total_tickets"]; ?></td>
                <td><?php echo $ticketAuditData["available_tickets"]; ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
        </form>
    </div>
</body>
</html>
