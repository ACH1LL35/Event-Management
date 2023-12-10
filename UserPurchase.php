<?php
require_once("vendor/tecnickcom/tcpdf/tcpdf.php"); // Adjust the path accordingly
include("UserSidebar.php");

// Function to generate PDF for a specific ticket
function generateTicketPDF($ticketId)
{
    // Include the TCPDF library
    require_once("vendor/tecnickcom/tcpdf/tcpdf.php");

    // Logic to fetch ticket information from the database (adjust based on your database structure)
    $conn = mysqli_connect("localhost", "root", "", "event_management");
    $query = "SELECT * FROM purchase_info WHERE ticket_id = '$ticketId'";
    $result = mysqli_query($conn, $query);
    $ticketData = mysqli_fetch_assoc($result);

    // Create a new TCPDF instance
    $pdf = new \TCPDF();
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('times', '', 12);

    // Add ticket information to the PDF (customize based on your data)
    $pdf->Cell(0, 10, "Ticket ID: " . $ticketData['ticket_id'], 0, 1);
    $pdf->Cell(0, 10, "Event Name: " . $ticketData['event_name'], 0, 1);
    $pdf->Cell(0, 10, "Ticket Quantity: " . $ticketData['ticket_quantity'], 0, 1);

    // ... Add more ticket details as needed

    // Close the database connection
    mysqli_close($conn);

    // Output the PDF to the browser for download
    $pdf->Output("ticket_$ticketId.pdf", 'D');

    exit; // Ensure that no further code is executed after sending the PDF
}

// Handle download ticket button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['download_ticket'])) {
    $ticketId = $_POST['download_ticket_id'];
    generateTicketPDF($ticketId);
}

// Display purchase history
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM purchase_info WHERE user_id = '$id'";
$result = mysqli_query($conn, $query);

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
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>
                <th>Ticket ID</th>
                <th>Show</th>
                <th>Quantity</th>
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
                        <td>
                            <form method='get' action='TicketGen.php'>
                            <input type='hidden' name='ticket_id' value='" . $row['ticket_id'] . "'>
                            <input type='submit' name='download_ticket' value='Download Ticket'>
                            </form>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "No purchase history available.";
        }

        // Free the result set
        mysqli_free_result($result);
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
