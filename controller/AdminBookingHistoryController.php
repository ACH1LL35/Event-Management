<?php
// AdminBookingHistoryController.php

// Include the Model if it's not already included
if (!function_exists('getBookingHistory')) {
    include("../model/AdminBookingHistoryModel.php");
}

// Fetch booking history data from the Model
$bookingHistory = getBookingHistory();

// Include the View file after setting up the data
include("../view/AdminBookingHistoryView.php");
?>
