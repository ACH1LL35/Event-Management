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

$query = "SELECT * FROM admin_mod WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['uname'];
}

// Fetch all events
$events = [];
$query = "SELECT * FROM ticket_cr";
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
            select option[value=""] {
            color: #999; /* Adjust the color as needed */
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

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        textarea {
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

        /* Styles for the logout form */
        .logout-form {
            text-align: center;
            margin-top: 20px;
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


    <div id="content">
        <h2>Select Event:</h2>
        <select id="eventSelect">
            <option value="" disabled selected>Select an event</option>
            <?php foreach ($events as $event): ?>
                <option value="<?php echo $event['Showid']; ?>"><?php echo $event['event_name']; ?></option>
            <?php endforeach; ?>
        </select>

        <div id="eventDetails">
            <h2>Event Details</h2>
            <p><strong>Event Name:</strong> <span id="eventName"></span></p>
            <p><strong>Venue:</strong> <span id="eventVenue"></span></p>
            <p><strong>Ticket Price:</strong> <span id="ticketPrice"></span></p>
            <p><strong>Total Tickets:</strong> <span id="totalTickets"></span></p>
            <p><strong>Available Tickets:</strong> <span id="availableTickets"></span></p>
            <hr>
            <h2>Edit Event Information</h2>
            <label for="newEventVenue">New Venue:</label>
            <input type="text" id="newEventVenue">
            <label for="newTicketPrice">New Ticket Price:</label>
            <input type="text" id="newTicketPrice">
            <label for="newTotalTickets">New Total Tickets:</label>
            <input type="text" id="newTotalTickets">
            <label for="newAvailableTickets">New Available Tickets:</label>
            <input type="text" id="newAvailableTickets">
            <button onclick="updateEvent()">Update Event</button>
        </div>
    </div>

    <script>
        var events = <?php echo json_encode($events); ?>;
        var eventSelect = document.getElementById('eventSelect');
        var eventName = document.getElementById('eventName');
        var eventVenue = document.getElementById('eventVenue');
        var ticketPrice = document.getElementById('ticketPrice');
        var totalTickets = document.getElementById('totalTickets');
        var availableTickets = document.getElementById('availableTickets');
        var newEventVenue = document.getElementById('newEventVenue');
        var newTicketPrice = document.getElementById('newTicketPrice');
        var newTotalTickets = document.getElementById('newTotalTickets');
        var newAvailableTickets = document.getElementById('newAvailableTickets');

        eventSelect.addEventListener('change', function() {
            var selectedEvent = events.find(function(event) {
                return event.Showid == eventSelect.value;
            });

            eventName.innerText = selectedEvent.event_name;
            eventVenue.innerText = selectedEvent.venue;
            ticketPrice.innerText = selectedEvent.ticket_price;
            totalTickets.innerText = selectedEvent.total_tickets;
            availableTickets.innerText = selectedEvent.available_tickets;

            newEventVenue.value = selectedEvent.venue;
            newTicketPrice.value = selectedEvent.ticket_price;
            newTotalTickets.value = selectedEvent.total_tickets;
            newAvailableTickets.value = selectedEvent.available_tickets;
        });

        function updateEvent() {
            var selectedEvent = events.find(function(event) {
                return event.Showid == eventSelect.value;
            });

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_event_details.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
            };

            xhr.send('updateEventDetails=true' +
                     '&showId=' + selectedEvent.Showid +
                     '&newEventVenue=' + newEventVenue.value +
                     '&newTicketPrice=' + newTicketPrice.value +
                     '&newTotalTickets=' + newTotalTickets.value +
                     '&newAvailableTickets=' + newAvailableTickets.value);
        }
    </script>
</body>
</html>
