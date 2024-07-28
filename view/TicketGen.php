<?php
require_once("vendor/tecnickcom/tcpdf/tcpdf.php");
require_once("vendor/tecnickcom/tcpdf/tcpdf_barcodes_1d.php");

class CustomTCPDF extends TCPDF {
    // Override Setview/footer to customize view/footer content
    public function Setfooter() {
        // Add your custom view/footer content here
        $this->SetY(-15);
        $this->SetFont('times', 'I', 8);
        $this->Cell(0, 10, "E-TICKETING provided by EventX", 0, false, 'C');
    }
}

// Function to generate PDF for a specific ticket
function generateTicketPDF($ticketId)
{
    // Logic to fetch ticket information from the database (adjust based on your database structure)
    $conn = mysqli_connect("localhost", "root", "", "event_management");
    $query = "SELECT * FROM purchase_info WHERE ticket_id = '$ticketId'";
    $result = mysqli_query($conn, $query);
    $ticketData = mysqli_fetch_assoc($result);

    // Create a new CustomTCPDF instance
    $pdf = new CustomTCPDF();
    $pdf->AddPage();

    // Add logo to the PDF
     $logoPath = 'visuals/logo/Untitled.jpg';
    $pdf->Image($logoPath, 10, 10, 40, 15);

    // Add a font size 14 heading
    $pdf->SetFont('times', 'B', 20);
    $pdf->Cell(0, 30, 'ENTRY PASS', 0, 1, 'C'); // Center-aligned heading
    $pdf->Ln(-15);
    // Set font
    $pdf->SetFont('times', '', 10);
    $pdf->Cell(0, 20, "Ticket ID: " . $ticketData['ticket_id'], 0, 1);
    $pdf->Ln(-15);
    $pdf->Cell(0, 20, "Event Name: " . $ticketData['event_name'], 0, 1);
    $pdf->Ln(-15);
    $pdf->Cell(0, 20, "Ticket Quantity: " . $ticketData['ticket_quantity'], 0, 1);
    $pdf->Ln(-15);
    $pdf->Cell(0, 20, "Gate Opening : 2 PM |Event Start : 3 PM | Venue: " . $ticketData['venue'], 0, 1);

    $pdf->Cell(0, 20, "Printing Time: " . date('Y-m-d H:i:s'), 0, 1);





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

    // // Add terms and conditions
    $pdf->Ln(2); // Add some space
    $pdf->MultiCell(0, 5, "Terms and Conditions:\n\n" .
    "1. Each Ticket is valid for only one person.\n" .
    "2. You must produce a valid Ticket to gain access to the event.\n" .
    "3. You can either print the ticket or just show the PDF from your Phone. If you Print the ticket, make sure to have it done securely and from a trusted source.\n" .
    "4. The ticket holder must be 18 years old or above; otherwise, s/he will be denied from entering the event premises, and no refund will be provided.\n" .
    "5. At entry, ticket holders may need to show photo identification. So, one must carry photo identification on the event day.\n" .
    "16. No sharp, pointed and weaponry object is allowed at the venue.\n" .
    "17. No outside food or drinks will be allowed. Food and drinks will be available at the venue.\n" .
    "18. Each ticket holder will be assigned with their designated zone, and one must maintain that as shifting zone is prohibited. Otherwise, necessary actions will be taken against the violation of zone policy.\n" .
    "19. Tickets cannot be refunded unless the event is canceled.\n" .
    "20. There will be no Parking facility from the organizers. If there is any from the venue authority, you can redeem the service at your own accord.\n" .
    "21. It is your responsibility to ascertain whether an event has been canceled or re-scheduled and the date and time of any re-scheduled Event.\n" .
    "22. Organizers reserve the right to make any amendments regarding the issue and ticket holders without prior notice."
    );

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
