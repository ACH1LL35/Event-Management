<?php
session_start();

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the Login page
    session_destroy();
    header("Location: AdminModLogin.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: AdminModLogin.php");
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
    $username = $row['uname']; // Update to use the correct variable name
    // $email = $row['email'];
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
    <title>Master Admin Page</title>
    <style>
        /* Your existing styles here */
    </style>
</head>
<body>
    <div id="menu">
        <form class="logout-form" method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <h2>Select Event:</h2>
        <select id="eventSelect">
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
            xhr.open('POST', '', true); // Empty URL to use the same file
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(xhr.responseText);
                    // You can handle the response as needed
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
