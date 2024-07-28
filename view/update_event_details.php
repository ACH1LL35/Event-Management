<?php
// Assuming you have a database connection here
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['updateEventDetails']) && isset($_POST['showId'])) {
    $showId = $_POST['showId'];

    // Retrieve new details from the POST data
    $newEventVenue = $_POST['newEventVenue'];
    $newTicketPrice = $_POST['newTicketPrice'];
    $newTotalTickets = $_POST['newTotalTickets'];
    $newAvailableTickets = $_POST['newAvailableTickets'];

    // Update the event details in the database
    $updateQuery = "UPDATE ticket_cr SET
                    venue = '$newEventVenue',
                    ticket_price = '$newTicketPrice',
                    total_tickets = '$newTotalTickets',
                    available_tickets = '$newAvailableTickets'
                    WHERE Showid = '$showId'";

    if (mysqli_query($conn, $updateQuery)) {
        echo 'Event details updated successfully';
    } else {
        echo 'Error updating event details: ' . mysqli_error($conn);
    }
} else {
    echo 'Invalid request';
}

// Close the database connection
mysqli_close($conn);
?>