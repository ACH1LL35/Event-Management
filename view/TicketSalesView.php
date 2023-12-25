<?php

// Handle cancellation logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_ticket_id'])) {
    $cancelledTicketId = $_POST['cancel_ticket_id'];

    // Add logic to delete the ticket from the database
    $conn = new mysqli("localhost", "root", "", "event_management");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM purchase_info WHERE ticket_id = ?");
    $stmt->bind_param("s", $cancelledTicketId);

    if ($stmt->execute()) {
        // Ticket cancellation successful
        echo "<script>alert('Ticket cancellation successful.');</script>";
    } else {
        // Ticket cancellation failed
        echo "<script>alert('Ticket cancellation failed.');</script>";
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
}

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

include('../controller/TicketSalesController.php');

$ticketSalesController = new TicketSalesController($id);
$ticketSalesList = $ticketSalesController->getTicketSalesList();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Sales</title>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
            flex-direction: column;
            padding-left: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            background-color: #333;
            color: #000;
            padding: 20px;
            margin: 0;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: #fff;
            text-align: center;
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

        #searchInput {
        padding: 8px;
        margin-bottom: 1px;
        width: 400px; /* Set your desired width */
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 20px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis; /* Display ellipsis (...) for overflowed text */
        margin-top: 25px;
    }

    /* Styles for the table */
    #ticketSalesTable {
        border-collapse: collapse;
        width: 80%;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        margin-bottom: 20px;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: center;
    }

    th {
        background-color: #007BFF;
        color: #fff;
    }
    

    </style>
    <script>
        $(document).ready(function() {
            // Function to handle the search input
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#ticketSalesTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script></head>
<body>
    <div id="content">
    <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">Ticket Sales List</h1>        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" id="searchInput" placeholder="Search..">
            <table border="1" id="ticketSalesTable">
                <tr>
                    <th>USER ID</th>
                    <th>Event Name</th>
                    <th>Ticket ID</th>
                    <th>Ticket Quantity</th>
                    <th>Contact No.</th>
                    <th colspan="2">Action</th>
                </tr>
                <?php foreach ($ticketSalesList as $r): ?>
                    <tr>
                        <td><?php echo $r["user_id"]; ?></td>
                        <td><?php echo $r["event_name"]; ?></td>
                        <td><?php echo $r["ticket_id"]; ?></td>
                        <td><?php echo $r["ticket_quantity"]; ?></td>
                        <td><?php echo $r["contact_number"]; ?></td>
                        <td>
                            <button class="download-button" type="button" onclick="window.open('TicketGenView.php?ticket_id=<?php echo $r["ticket_id"]; ?>', '_blank')">Download</button>
                        </td>
                        <td>
                            <button type="submit" name="cancel_ticket_id" value="<?php echo $r["ticket_id"]; ?>">Cancel</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </div>
</body>
</html>
