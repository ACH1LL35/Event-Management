<?php
include("UserSidebar.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchase History</title>
    <style>
        body {
                font-family: Arial, sans-serif;
                background-color: #f0f0f0;
                margin: 0;
                padding: 0;
            }

            /* Style for the h1 header */
            h1 {
                text-align: center;
                background-color: #333;
                color: #fff;
                padding: 20px;
            }

            /* Style for the table */
            table {
                width: 80%;
                margin: 20px auto;
                border-collapse: collapse;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            /* Style for table headers */
            th {
                background-color: #333;
                color: #fff;
                font-weight: bold;
                padding: 10px;
            }

            /* Style for table cells */
            td {
                padding: 8px;
                text-align: center;
            }

            /* Style for table rows */
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            tr:hover {
                background-color: #ddd;
            }
    </style>
</head>
<body>
    <?php
    if (!isset($_SESSION['id'])) {
        header("Location: UserLogin.php");
        exit();
    }

    $id = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "root", "", "event_management");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_ticket'])) {
        $ticketId = $_POST['ticket_id'];
        $eventName = $_POST['event_name'];
        $ticketQuantity = $_POST['ticket_quantity'];

        // TODO: Add SQL injection prevention here (use prepared statements or sanitize input)

        // Display a confirmation message
        echo "<script>
                var userConfirmation = confirm('Are you sure you want to cancel this ticket?');
                if (!userConfirmation) {
                    window.location.href = 'UserPurchase.php';  // Redirect back if canceled
                }
              </script>";

        // Perform cancellation process if confirmed
        $cancelQuery = "DELETE FROM purchase_info WHERE ticket_id = '$ticketId'";
        $result = mysqli_query($conn, $cancelQuery);

        if ($result) {
            // Update ticket_cr table
            $updateQuery = "UPDATE ticket_cr SET available_tickets = available_tickets + '$ticketQuantity' WHERE event_name = '$eventName'";
            $result = mysqli_query($conn, $updateQuery);

            if ($result) {
                echo "Ticket cancellation successful.";
            } else {
                echo "Error updating ticket_cr table: " . mysqli_error($conn);
            }
        } else {
            echo "Error deleting from purchase_info table: " . mysqli_error($conn);
        }
    }

    // Display purchase history
    $query = "SELECT * FROM purchase_info WHERE user_id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>
                <th>Ticket ID</th>
                <th>Event Name</th>
                <th>Ticket Quantity</th>
                <th colspan='2'>Action</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row['ticket_id'] . "</td>
                    <td>" . $row['event_name'] . "</td>
                    <td>" . $row['ticket_quantity'] . "</td>
                    <td>
                        <form method='post' action='UserPurchase.php' onsubmit='return confirm(\"Are you sure you want to cancel this ticket?\");'>
                            <input type='hidden' name='ticket_id' value='" . $row['ticket_id'] . "'>
                            <input type='hidden' name='event_name' value='" . $row['event_name'] . "'>
                            <input type='hidden' name='ticket_quantity' value='" . $row['ticket_quantity'] . "'>
                            <input type='submit' name='cancel_ticket' value='Cancel Ticket'>
                        </form>
                    </td>
                    <td><button onclick='performAction'>Download Ticket</button></td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No purchase history available.";
    }

    mysqli_close($conn);
    ?>
</body>
</html>