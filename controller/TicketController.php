<?php
session_start();

include("../mode/TicketModel.php");

// Assuming your database connection is established before this point
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$model = new TicketModel($conn);

// Handling actions from the view
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateEventDetails'])) {
        $showId = $_POST['showId'];
        $newEventVenue = $_POST['newEventVenue'];
        $newTicketPrice = $_POST['newTicketPrice'];
        $newTotalTickets = $_POST['newTotalTickets'];
        $newAvailableTickets = $_POST['newAvailableTickets'];

        $result = $model->updateEventDetails($showId, $newEventVenue, $newTicketPrice, $newTotalTickets, $newAvailableTickets);
        echo $result;
    }
}

// Fetch all events
$events = $model->getAllEvents();

// Close the database connection
mysqli_close($conn);
?>
