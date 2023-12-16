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

include('../controller/PublishTicketController.php');

$publishTicketController = new PublishTicketController($id);
$publishTicketController->handleRequest();

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUBLISH TICKET</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #content {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f5f5f5;
            flex: 1;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Styles for the logout form */
        .logout-form {
            text-align: center;
            margin-top: 10px;
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
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">PUBLISH TICKET</h1>
        <form method="post">
            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" required><br>

            <label for="venue">Venue:</label>
            <input type="text" name="venue" required><br>

            <label for="ticket_price">Ticket Price:</label>
            <input type="number" name="ticket_price" required><br>

            <label for="total_tickets">Total Tickets:</label>
            <input type="number" name="total_tickets" required><br>

            <center>
            <input type="submit" value="Create Event">
            </center>
        </form>
    </div>
</body>
</html>
