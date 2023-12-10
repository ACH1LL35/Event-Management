<?php
// Include the TCPDF library
require_once("vendor/tecnickcom/tcpdf/tcpdf.php");
require_once("vendor/tecnickcom/tcpdf/tcpdf_barcodes_1d.php"); // Include barcode library

// Function to generate PDF for a specific booking
function generateVenuePDF($bookingId)
{
    // Logic to fetch booking information from the database (adjust based on your database structure)
    $conn = mysqli_connect("localhost", "root", "", "event_management");
    $query = "SELECT * FROM booking WHERE booking_id = '$bookingId'";
    $result = mysqli_query($conn, $query);
    $bookingData = mysqli_fetch_assoc($result);

    // Create a new TCPDF instance
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('times', '', 12);

    // Add booking information to the PDF (customize based on your data)
    $pdf->Cell(0, 10, "Booking ID: " . $bookingData['booking_id'], 0, 1);
    $pdf->Cell(0, 10, "Venue Name: " . $bookingData['venue_name'], 0, 1);
    $pdf->Cell(0, 10, "Booked From Date: " . $bookingData['from_date'], 0, 1);
    $pdf->Cell(0, 10, "Booked Till Date: " . $bookingData['to_date'], 0, 1);

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

    $pdf->write1DBarcode($bookingId, 'C128', '', '', '', 18, 0.4, $style, 'N');

    // ... Add more booking details as needed

    // Output the PDF to the browser for download
    $pdf->Output("booking_$bookingId.pdf", 'D');

    // Close the database connection
    mysqli_close($conn);

    exit; // Ensure that no further code is executed after sending the PDF
}

// Handle download booking button click
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['booking_id'])) {
    $bookingId = $_GET['booking_id'];
    generateVenuePDF($bookingId);
} else {
    // Redirect to a suitable page if accessed without the booking_id
    header("Location: UserBooking.php");
    exit;
}
?>
