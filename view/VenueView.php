<?php
session_start();
include("AdminSidebar.php");

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the Login page
    session_destroy();
    header("Location: start.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: start.php");
    exit();
}

$id = $_SESSION['id'];
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all events
$events = [];
$query = "SELECT * FROM venues";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $events[] = $row;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <style>
        select {
            width: 100%; /* Adjust the width as needed */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #content {
            max-width: 1000px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px auto;
            text-align: left;
            width: 600px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            display: block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div id="content">
        <h2>Select Venue:</h2>
        <select id="eventSelect">
            <option value="" disabled selected>Select a venue</option>
            <?php foreach ($events as $event): ?>
                <option value="<?php echo $event['venue_id']; ?>"><?php echo $event['venue_name']; ?></option>
            <?php endforeach; ?>
        </select>

        <div id="eventDetails">
            <h2>Event Details</h2>
            <label for="venue_id">Venue ID:</label>
            <input type="text" id="venue_id" readonly>
            <label for="venue_name">Venue Name:</label>
            <input type="text" id="venue_name" readonly>
            <label for="venue_fee">Venue Fee:</label>
            <input type="text" id="venue_fee" readonly>
            <hr>
            <h2>Edit Event Information</h2>
            <label for="newVenueName">New Venue Name:</label>
            <input type="text" id="newVenueName">
            <label for="newVenueFee">New Venue Fee:</label>
            <input type="text" id="newVenueFee">
            <button onclick="updateVenue()">Update Venue</button>
        </div>
    </div>

    <script>
        var events = <?php echo json_encode($events); ?>;
        var eventSelect = document.getElementById('eventSelect');
        var venue_id = document.getElementById('venue_id');
        var venue_name = document.getElementById('venue_name');
        var venue_fee = document.getElementById('venue_fee');
        var newVenueName = document.getElementById('newVenueName');
        var newVenueFee = document.getElementById('newVenueFee');

        eventSelect.addEventListener('change', function() {
            var selectedEvent = events.find(function(event) {
                return event.venue_id == eventSelect.value;
            });

            venue_id.value = selectedEvent.venue_id;
            venue_name.value = selectedEvent.venue_name;
            venue_fee.value = selectedEvent.venue_fee;

            newVenueName.value = selectedEvent.venue_name;
            newVenueFee.value = selectedEvent.venue_fee;
        });

        function updateVenue() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_venue_details.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
            };

            xhr.send('updateVenueDetails=true' +
                     '&venue_id=' + venue_id.value +
                     '&newVenueName=' + newVenueName.value +
                     '&newVenueFee=' + newVenueFee.value);
        }
    </script>
</body>
</html>
