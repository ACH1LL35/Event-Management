<?php
// Include the TCPDF library
require_once("vendor/tecnickcom/tcpdf/tcpdf.php");
require_once("vendor/tecnickcom/tcpdf/tcpdf_barcodes_1d.php"); // Include barcode library

// Custom TCPDF class to override Setview/footer method
class CustomTCPDF extends TCPDF {
    // Override Setview/footer to add custom view/footer
    public function Setfooter() {
        // Add your custom view/footer content here
        $this->SetY(-15);
        $this->SetFont('times', 'I', 8);
        $this->Cell(0, 10, "E-BOOKING provided by EventX", 0, false, 'C');
    }
}

// Function to generate PDF for a specific booking
function generateVenuePDF($bookingId)
{
    // Logic to fetch booking information from the database (adjust based on your database structure)
    $conn = mysqli_connect("localhost", "root", "", "event_management");
    $query = "SELECT * FROM booking WHERE booking_id = '$bookingId'";
    $result = mysqli_query($conn, $query);
    $bookingData = mysqli_fetch_assoc($result);

    // Create a new CustomTCPDF instance
    $pdf = new CustomTCPDF();
    $pdf->AddPage();

    // Add logo to the PDF
    $logoPath = 'visuals/logo/Untitled.jpg';
    $pdf->Image($logoPath, 10, 10, 40, 15);

    // Add a font size 14 heading
    $pdf->SetFont('times', 'B', 20);
    $pdf->Cell(0, 30, 'BOOKING RECEIPT', 0, 1, 'C'); // Center-aligned heading

    // Set font
    $pdf->SetFont('times', '', 12);

    // Set custom X and Y coordinates
    $customX = 20;
    $customY = 30;

    // Add booking information to the PDF at custom X and Y coordinates
    $pdf->SetXY($customX, $customY);
    $pdf->Cell(0, 10, "Booking ID: " . $bookingData['booking_id'], 0, 1);

    // Update Y coordinate for the next cell
    $pdf->SetXY($customX, $customY);
    $pdf->Cell(0, 20, "Venue Name: " . $bookingData['venue_name'], 0, 1);

    
    // Set custom X and Y coordinates
    $customX = 130;
    $customY = 30;

    // Add booking information to the PDF at custom X and Y coordinates
    $pdf->SetXY($customX, $customY);
    $pdf->Cell(0, 10, "Booking Date: " . $bookingData['booked_at'], 0, 1);

    // Add booking information to the PDF at custom X and Y coordinates
    $pdf->SetXY($customX, $customY);
    $pdf->Cell(0, 20, "Booked From Date: " . $bookingData['from_date'], 0, 1);

    // Add booking information to the PDF at custom X and Y coordinates
    $pdf->SetXY($customX, $customY);
    $pdf->Cell(0, 30, "Booked Till Date: " . $bookingData['to_date'], 0, 1);

    // Set custom X and Y coordinates
    $customX = 20;
    $customY = 60;
    
     // Add booking information to the PDF at custom X and Y coordinates
    $pdf->SetXY($customX, $customY);
    $pdf->Cell(0, 10, "" . $bookingData['name'], 0, 1);
    
    // Add booking information to the PDF at custom X and Y coordinates
    $pdf->SetXY($customX, $customY);
    $pdf->Cell(0, 20, "" . $bookingData['cnumber'], 0, 1);


    // Set custom X and Y coordinates
        $customX = 130;
        $customY = 60;
        
    // Add booking information to the PDF at custom X and Y coordinates
        $pdf->SetXY($customX, $customY);
        $pdf->Cell(0, 10, "Booked For The Duration of :" . $bookingData['duration'], 0, 1);
        
    // Add booking information to the PDF at custom X and Y coordinates
        $pdf->SetXY($customX, $customY);
        $pdf->Cell(0, 20, "Total Fee :" . ($bookingData['duration'] * $bookingData['venue_fee']), 0, 1);

    // Set custom X and Y coordinates for barcode
    $barcodeX = 70;
    $barcodeY = 90;

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


    $pdf->write1DBarcode($bookingId, 'C128', $barcodeX, $barcodeY, '', 18, 0.4, $style, 'N');


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
