<?php
// AdminBookingHistoryModel.php

function getBookingHistory() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "event_management";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to select all data from the booking table
    $sql = "SELECT * FROM booking";
    $result = $conn->query($sql);

    // Check if the query executed successfully
    if (!$result) {
        die("Error: " . $sql . "<br>" . $conn->error);
    }

    // Fetch the result rows as an associative array
    $bookingHistory = $result->fetch_all(MYSQLI_ASSOC);

    // Close the database connection
    $conn->close();

    return $bookingHistory;
}
?>
