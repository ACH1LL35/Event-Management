<?php
session_start();

include("../mode/VenueModel.php");

// Assuming your database connection is established before this point
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$model = new VenueModel($conn);

// Handling actions from the view
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateVenueDetails'])) {
        $venue_id = $_POST['venue_id'];  // Corrected variable name
        $newVenueName = $_POST['newVenueName'];
        $newVenueFee = $_POST['newVenueFee'];

        $result = $model->updateVenueDetails($venue_id, $newVenueName, $newVenueFee);  // Corrected variable name
        echo $result;
    }
}

// Fetch all events
$events = $model->getAllEvents();

// Close the database connection
mysqli_close($conn);
?>
