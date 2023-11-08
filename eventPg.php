<!DOCTYPE html>
<html>
<head>
    <title>Events Page</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .event-table {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .event-card {
            width: 30%;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s;
            cursor: pointer;
        }

        .event-card:hover {
            transform: scale(1.05);
        }

        .event-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .event-details {
            padding: 10px;
            display: none; /* Initially hidden */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upcoming Events</h1>
        <div class="event-table">
            <?php
            // Connect to the database and retrieve event details
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "event_management";
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id, event_name, venue, ticket_price FROM ticket_cr";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $event_id = $row["id"];
                    $event_name = $row["event_name"];
                    $venue = $row["venue"];
                    $ticket_price = $row["ticket_price"];

                    echo "<div class='event-card' onclick='toggleEventDetails($event_id)'>";
                    echo "<img class='event-image' src='$venue' alt='$event_name'>";
                    echo "<div class='event-details' id='event-details-$event_id'>";
                    echo "<h2>$event_name</h2>";
                    echo "<p>$ticket_price</p>";
                    echo "</div>";
                    echo "</div>";
                }
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script>
        function toggleEventDetails(eventId) {
            var eventDetails = document.getElementById("event-details-" + eventId);
            if (eventDetails.style.display === "block") {
                eventDetails.style.display = "none";
            } else {
                eventDetails.style.display = "block";
            }
        }
    </script>
</body>
</html>
