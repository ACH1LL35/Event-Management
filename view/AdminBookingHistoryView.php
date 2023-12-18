<?php
// AdminBookingHistoryView.php
session_start();

// Include the Model
include("../model/AdminBookingHistoryModel.php");

// Fetch booking history data from the Model
$bookingHistory = getBookingHistory();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Booking History</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        #content {
            flex: 1;
            display: flex;
            flex-direction: column; /* Align content vertically */
        }

        .content {
            padding-left: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }
        /* Styles for the logout form */
        .logout-form {
            text-align: center;
        }

        .logout-form .logout-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            border: 2px solid #007BFF;
            border-radius: 3px;
            cursor: pointer;
            width: 200px;
            text-decoration: none;
        }

        .logout-form .logout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include("../view/AdminSidebar.php"); ?> <!-- Include AdminSidebar.php -->

    <div id="content">
        <!-- Session-related data in the view -->
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">Venue Booking History</h1>        
        <form method="get">
            <table border="1">
                <tr>
                    <th>USER ID</th>
                    <th>Booked By</th>
                    <th>Venue Name</th>
                    <th>Booking ID</th>
                    <th>From Date</th>
                    <th>To Date</th>
                </tr>
                <?php
                if (!empty($bookingHistory)) {
                    foreach ($bookingHistory as $booking) {
                        echo "<tr>";
                        echo "<td>" . $booking["user_id"] . "</td>";
                        echo "<td>" . $booking["name"] . "</td>";
                        echo "<td>" . $booking["venue_name"] . "</td>";
                        echo "<td>" . $booking["booking_id"] . "</td>";
                        echo "<td>" . $booking["from_date"] . "</td>";
                        echo "<td>" . $booking["to_date"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No booking history data available</td></tr>";
                }
                ?>
            </table>
        </form>
    </div>
</body>
</html>
