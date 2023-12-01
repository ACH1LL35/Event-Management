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

// Initialize variables
$currentEventName = "";
$currentVenue = "";
$currentTicketPrice = "";
$currentTotalTickets = "";

// Check if a selection is made
if (isset($_POST['selectRow'])) {
    $selectedEvent = $_POST['selectRow'];

    // Retrieve data for the selected event from the database and update variables
    $query = "SELECT * FROM ticket_cr WHERE id = '$selectedEvent'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            $currentEventName = $row['event_name'];
            $currentVenue = $row['venue'];  // Make sure the column name is 'venue'
            $currentTicketPrice = $row['ticket_price'];  // Make sure the column name is 'ticket_price'
            $currentTotalTickets = $row['total_tickets'];  // Make sure the column name is 'total_tickets'
        } else {
            echo "No data found for the selected event.";
        }
    } else {
        echo "Error executing query: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event Data</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #menu {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 1px 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
        }

        a {
            display: block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: left;
            border: 2px solid #007BFF;
            border-radius: 3px;
            cursor: pointer;
            width: 200px;
            text-decoration: none;
            margin-bottom: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }

        #content {
            flex-grow: 1;
            padding: 20px;
        }

        /* Additional CSS styles for the event editing form */
        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="menu">
        <form class="logout-form" method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <ul>
            <li><a href="AdminPanel.php">Home</a></li>
            <li><a href="AdminEvent.php">CREATE EVENT</a></li>
            <li><a href="AdminEventHistory.php">EVENT HISTORY</a></li>
            <li><a href="AdminEventCal.php">EVENT CALENDAR</a></li>
            <li><a href="AdminTicketCreation.php">TICKET PUBLISH</a></li>
            <li><a href="AdminTicketManagement.php">TICKET MANAGEMENT</a></li>
            <li><a href="AdminTicketList.php">TICKET SALE LIST</a></li>
            <li><a href="AdminVenueManagement.php">VENUE MANAGEMENT</a></li>
            <li><a href="AdminVenueBookHistory.php">VENUE BOOKING LIST</a></li>
            <li><a href="AdminAnalysis.php">ANALYSIS</a></li>
            <li><a href="AdminComplaint.php">COMPLAINT FEEDBACK</a></li>
            <li><a href="AdminModAccess.php">MODERATOR ACCESS</a></li>
            <li><a href="AdminModManagement.php">MODERATOR MANAGEMENT</a></li>
            <li><a href="AdminPostModeration.php">POST MODERATION</a></li>
            <li><a href="AdminPMH.php">POST MODERATION HISTORY</a></li>
            <li><a href="AdminCommentModeration.php">COMMENT MODERATION</a></li>
            <li><a href="AdminCMH.php">COMMENT MODERATION HISTORY</a></li>
            <li><a href="AdminQueryF.php">QUERY FEEDBACK</a></li>
            <li><a href="AdminQuotationF.php">QUOTATION FEEDBACK</a></li>
            <li><a href="AdminAdd2Gallary.php">ADD TO GALLERY</a></li>
            <li><a href="AdminUserManagement.php">USER MANAGEMENT</a></li>
            <li><a href="AdminNewsletter.php">NEWSLETTER</a></li>
        </ul>
    </div>
    <div id="content">
        <!-- Your event editing form here -->
        <label for="selectRow">Select an event:</label>
        <select name="selectRow" id="selectRow" onchange="updateFields()">
        <?php
            // Fetch events from the database and populate the dropdown options
            $query = "SELECT id, event_name FROM ticket_cr";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $eventId = $row['id'];
                $eventName = $row['event_name'];
                echo "<option value='$eventId' data-eventname='$eventName'>$eventName</option>";
            }
            ?>
        </select>
        <br>

            <!-- Display current data -->
            <label for="currentEventName">Current Event Name:</label>
            <input type="text" name="currentEventName" id="currentEventName" value="<?php echo $currentEventName; ?>" readonly>
            <br>
            <label for="currentVenue">Current Venue:</label>
            <input type="text" name="currentVenue" id="currentVenue" value="<?php echo $currentVenue; ?>" readonly>
            <br>
            <label for="currentTicketPrice">Current Ticket Price:</label>
            <input type="text" name="currentTicketPrice" id="currentTicketPrice" value="<?php echo $currentTicketPrice; ?>" readonly>
            <br>
            <label for="currentTotalTickets">Current Total Tickets:</label>
            <input type="text" name="currentTotalTickets" id="currentTotalTickets" value="<?php echo $currentTotalTickets; ?>" readonly>
            <br>

            <!-- Provide edit boxes -->
            <label for="editEventName">Edit Event Name:</label>
            <input type="text" name="editEventName" id="editEventName" value="<?php echo $currentEventName; ?>">
            <br>
            <label for="editVenue">Edit Venue:</label>
            <input type="text" name="editVenue" id="editVenue" value="<?php echo $currentVenue; ?>">
            <br>
            <label for="editTicketPrice">Edit Ticket Price:</label>
            <input type="text" name="editTicketPrice" id="editTicketPrice" value="<?php echo $currentTicketPrice; ?>">
            <br>
            <label for="editTotalTickets">Edit Total Tickets:</label>
            <input type="text" name="editTotalTickets" id="editTotalTickets" value="<?php echo $currentTotalTickets; ?>">
            <br>

            <input type="submit" value="Submit">
        </form>
    </div>
    <script>
        function updateFields() {
            var select = document.getElementById("selectRow");
            var selectedIndex = select.selectedIndex;

            // Retrieve the values from the selected option's attributes
            var currentEventName = select.options[selectedIndex].getAttribute("data-eventname");
            var currentVenue = select.options[selectedIndex].getAttribute("data-venue");
            var currentTicketPrice = select.options[selectedIndex].getAttribute("data-ticketprice");
            var currentTotalTickets = select.options[selectedIndex].getAttribute("data-totaltickets");

            // Update the input fields
            document.getElementById("currentEventName").value = currentEventName;
            document.getElementById("currentVenue").value = currentVenue;
            document.getElementById("currentTicketPrice").value = currentTicketPrice;
            document.getElementById("currentTotalTickets").value = currentTotalTickets;
        }
    </script>
</body>
</html>
