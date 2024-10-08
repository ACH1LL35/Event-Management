<?php
include("UserSidebar.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
        }

        #sidebar {
            float: left;
            width: 15%;
        }

        #content {
            float: left;
            width: 50%;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin: 0;
        }

        ul li a {
            display: block;
            padding: 10px;
            background-color: #eee;
            text-decoration: none;
        }

        ul li a:hover {
            background-color: #ddd;
        }

        #logout-container {
            position: absolute;
            top: 20px;
            right: 10px;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff5733;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #ff0000;
        }

        #venue-form {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            width: 55%;
            margin: 130px auto;
        }

        #venue-form label {
            display: block;
            margin-top: 10px;
        }

        #venue-form select,
        #venue-form input[type="date"] {
            width: 65%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #venue-form button[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        #venue-form button[type="submit"]:hover {
            background-color: #0056b3;
        }

        #message {
            background-color: #ddd;
            padding: 10px;
            border: 1px solid #999;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
        }

        #logout-container {
            position: absolute;
            top: 20px;
            right: 10px;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff5733;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #ff0000;
        }
    </style>
</head>

<body>
    <?php
    function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: UserLogin.php");
        exit();
    }

    if (!isset($_SESSION['id'])) {
        header("Location: UserLogin.php");
        exit();
    }

    $id = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "root", "", "event_management");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM credential WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $email = $row['email'];
        $name = $row['name'];
        $cnumber = $row['cnumber'];
    }
    ?>

    <?php

    function connectToDatabase()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "event_management";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];

            $conn = connectToDatabase();

            $venue_name = $_POST['venue'];
            $from_date = $_POST['fromDate'];
            $to_date = $_POST['toDate'];

            // Calculate duration in days
            $fromDate = new DateTime($from_date);
            $toDate = new DateTime($to_date);
            $duration = $fromDate->diff($toDate)->days;

            $booking_id = generateRandomString(10);

            $sql = "SELECT * FROM booking WHERE venue_name = '$venue_name' AND ('$from_date' BETWEEN from_date AND to_date OR '$to_date' BETWEEN from_date AND to_date)";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $message = "Venue is already booked for the selected dates.";
            } else {
                // Retrieve venue fee
                $venueFeeQuery = "SELECT venue_fee FROM Venues WHERE venue_name = '$venue_name'";
                $venueFeeResult = $conn->query($venueFeeQuery);

                if ($venueFeeResult->num_rows > 0) {
                    $venueFeeRow = $venueFeeResult->fetch_assoc();
                    $venue_fee = $venueFeeRow['venue_fee'];

                    $sql = "INSERT INTO booking (booking_id, venue_name, user_id, from_date, to_date, duration, name, email, cnumber, venue_fee) VALUES ('$booking_id', '$venue_name', $id, '$from_date', '$to_date', $duration, '$name', '$email', '$cnumber', $venue_fee)";
                    if ($conn->query($sql) === TRUE) {
                        $message = "Booking confirmed! Booking ID: $booking_id";
                    } else {
                        $message = "Error: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    $message = "Error retrieving venue fee for '$venue_name'";
                }
            }

            $conn->close();
        }
    }

    $conn = connectToDatabase();
    $sql = "SELECT venue_name FROM Venues";
    $result = $conn->query($sql);

    echo '<div id="venue-form">';
    if ($result->num_rows > 0) {
        echo '<form method="POST">';
        echo '<label for="venue">Venue:</label>';
        echo '<select name="venue" required>';
        echo '<option value="">Select a Venue</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['venue_name'] . '">' . $row['venue_name'] . '</option>';
        }
        echo '</select><br>';
        echo '<label for="fromDate">From Date:</label>';
        echo '<input type="date" name="fromDate" required><br>';
        echo '<label for="toDate">To Date:</label>';
        echo '<input type="date" name="toDate" required><br>';
        echo '<button type="submit">Confirm</button>';
        echo '</form>';
    } else {
        echo '<p>No venues available</p>';
    }

    if (isset($message)) {
        echo '<div id="message">' . $message . '</div>';
    }

    echo '</div>';
    $conn->close();
    ?>
    <div id="logout-container">
        <form method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
    </div>
</body>
</html>
