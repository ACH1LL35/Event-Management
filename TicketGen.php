<?php
// Include the TCPDF library
require_once("vendor/tecnickcom/tcpdf/tcpdf.php");
require_once("vendor/tecnickcom/tcpdf/tcpdf_barcodes_1d.php"); // Include barcode library

// Function to generate PDF for a specific ticket
function generateTicketPDF($ticketId)
{
    // Logic to fetch ticket information from the database (adjust based on your database structure)
    $conn = mysqli_connect("localhost", "root", "", "event_management");
    $query = "SELECT * FROM purchase_info WHERE ticket_id = '$ticketId'";
    $result = mysqli_query($conn, $query);
    $ticketData = mysqli_fetch_assoc($result);

    // Create a new TCPDF instance
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('times', '', 12);

    // Add ticket information to the PDF (customize based on your data)
    $pdf->Cell(0, 10, "Ticket ID: " . $ticketData['ticket_id'], 0, 1);
    $pdf->Cell(0, 10, "Event Name: " . $ticketData['event_name'], 0, 1);
    $pdf->Cell(0, 10, "Ticket Quantity: " . $ticketData['ticket_quantity'], 0, 1);

    // Generate barcode
    $style = array(
        'position' => '',
        'align' => 'C',
        'stretch' => false,
        'fitwidth' => true,
        'cellfitalign' => '',
        'border' => true,
        'hpadding' => 0,
        'vpadding' => 0,
        'fgcolor' => array(0, 0, 0),
        'bgcolor' => false, // false for transparent background
        'text' => true,
        'font' => 'helvetica',
        'fontsize' => 8,
        'stretchtext' => 4
    );

    $pdf->write1DBarcode($ticketId, 'C128', '', '', '', 18, 0.4, $style, 'N');

    // ... Add more ticket details as needed

    // Output the PDF to the browser for download
    $pdf->Output("ticket_$ticketId.pdf", 'D');

    // Close the database connection
    mysqli_close($conn);

    exit; // Ensure that no further code is executed after sending the PDF
}

// Handle download ticket button click
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['ticket_id'])) {
    $ticketId = $_GET['ticket_id'];
    generateTicketPDF($ticketId);
} else {
    // Redirect to a suitable page if accessed without the ticket_id
    header("Location: UserPurchase.php");
    exit;
}
?>
