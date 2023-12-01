<?php
include("UserSidebar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking History</title>
    <style>
        /* Style for the body */
        body {
                font-family: Arial, sans-serif;
                background-color: #f0f0f0;
                margin: 0;
                padding: 0;
            }

            /* Style for the h1 header */
            h1 {
                text-align: center;
                background-color: #333;
                color: #fff;
                padding: 20px;
            }

            /* Style for the table */
            table {
                width: 80%;
                margin: 20px auto;
                border-collapse: collapse;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            /* Style for table headers */
            th {
                background-color: #333;
                color: #fff;
                font-weight: bold;
                padding: 10px;
            }

            /* Style for table cells */
            td {
                padding: 8px;
                text-align: center;
            }

            /* Style for table rows */
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            tr:hover {
                background-color: #ddd;
            }
    </style>
</head>
<body>
    <?php
    if (!isset($_SESSION['id'])) {
        header("Location: UserLogin.php");
        exit();
    }

    $id = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "root", "", "event_management");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['cancel_booking'])) {
            $bookingId = $_POST['booking_id'];

            $deleteQuery = "DELETE FROM booking WHERE booking_id = '$bookingId'";
            $result = mysqli_query($conn, $deleteQuery);

            if ($result) {
                // Booking deleted successfully
                echo "Booking canceled successfully";
            } else {
                // Handle the error, if any
                echo "Error canceling booking: " . mysqli_error($conn);
            }
        }
    }

    $query = "SELECT * FROM booking WHERE user_id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>
                <th>Booking ID</th>
                <th>Venue</th>
                <th>Booked From Date (yyyy/mm/dd)</th>
                <th>Booked Till Date (yyyy/mm/dd)</th>
                <th>Action</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row['booking_id'] . "</td>
                    <td>" . $row['venue_name'] . "</td>
                    <td>" . $row['from_date'] . "</td>
                    <td>" . $row['to_date'] . "</td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='booking_id' value='" . $row['booking_id'] . "'>
                            <input type='submit' name='cancel_booking' value='Cancel Booking'>
                        </form>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No booking history available.";
    }

    mysqli_close($conn);
    ?>
</body>
</html>

