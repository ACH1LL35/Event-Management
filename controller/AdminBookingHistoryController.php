<?php
// AdminBookingHistoryController.php

// Include the Model and necessary files
include("../model/AdminBookingHistoryModel.php");
include("../view/AdminBookingHistoryView.php");

// Fetch booking history data from the Model
$bookingHistory = getBookingHistory();

// Include the View file after setting up the data
include("../view/AdminBookingHistoryView.php");
?>
