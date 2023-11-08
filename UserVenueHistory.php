<!DOCTYPE html>
<html>
<head>
    <div><title>Booking History</title></div>
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
    padding: 10px;
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
    session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: UserLogin.php");
        exit();
    }

    $id = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "root", "", "event_management");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM booking WHERE user_id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<h1>Venue Booking History</h1>";
        echo "<table>";
        echo "<tr>
                <th>Venue</th>
                <th>Booked From Date (yyyy/mm/dd)</th>
                <th>Booked Till Date (yyyy/mm/dd)</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row['venue_name'] . "</td>
                    <td>" . $row['from_date'] . "</td>
                    <td>" . $row['to_date'] . "</td>
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
