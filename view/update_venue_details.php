<?php
// Assuming you have a database connection here
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['updateVenueDetails']) && isset($_POST['venue_id'])) {
    $venue_id = $_POST['venue_id'];

    // Retrieve new details from the POST data

    $newVenueName = $_POST['newVenueName'];
    $newVenueFee = $_POST['newVenueFee'];

    // Update the event details in the database
    $updateQuery = "UPDATE venues SET
                    venue_name = '$newVenueName',
                    venue_fee = '$newVenueFee'
                    WHERE venue_id = '$venue_id'";

    if (mysqli_query($conn, $updateQuery)) {
        echo 'Venue details updated successfully';
    } else {
        echo 'Error updating venue details: ' . mysqli_error($conn);
    }
} else {
    echo 'Invalid request';
}

// Close the database connection
mysqli_close($conn);
?>
