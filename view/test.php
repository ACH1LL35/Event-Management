<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Update Event</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #ffffff;
            display: flex;
            margin: 0;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #sidebar {
            width: 250px;
            color: #fff;
            box-shadow: none;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1;
        }

        #update-event-form {
            width: 500px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            padding: 20px;
            margin-left: 250px;
            position: relative;
            z-index: 0;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        select,
        input,
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

        #current-event-details {
            background-color: #f2f2f2;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <?php include("AdminSidebar.php"); ?>
    </div>

    <div id="update-event-form">
        <h2>Update Event</h2>

        <?php
        // Initialize variables to store selected event details
        $selectedEventId = $eventName = $eventDate = $eventDetails = "";

        if (isset($_POST["select-event-submit"])) {
            $selectedEventId = $_POST["event-name"];

            // Fetch event details from the database
            $sql = "SELECT * FROM events WHERE ev_id=$selectedEventId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $eventName = $row["event_name"];
                $eventDate = $row["event_date"];
                $eventDetails = $row["event_details"];
            }
        }
        ?>

        <!-- Dropdown for selecting events -->
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="event-name">Select Event:</label>
            <select id="event-name" name="event-name" required>
                <option value="" disabled selected>Select an event...</option>
                <?php
                // Populate the dropdown with event names
                $sql = "SELECT ev_id, event_name FROM events";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $selected = ($row["ev_id"] == $selectedEventId) ? "selected" : "";
                        echo "<option value='" . $row["ev_id"] . "' $selected>" . $row["event_name"] . "</option>";
                    }
                }
                ?>
            </select>

            <button type="submit" name="select-event-submit">Select Event</button>
        </form>

        <!-- Display current event details -->
        <div id="current-event-details">
            <h3>Current Event Details</h3>
            <?php
            // Fetch current event details from the database
            if (isset($_POST["select-event-submit"])) {
                $selectedEventId = $_POST["event-name"];
                $sql = "SELECT * FROM events WHERE ev_id=$selectedEventId";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<p>Event ID: " . $row["ev_id"] . "</p>";
                    echo "<p>Event Name: " . $row["event_name"] . "</p>";
                    echo "<p>Event Date: " . $row["event_date"] . "</p>";
                    echo "<p>Event Details: " . $row["event_details"] . "</p>";
                }
            }
            ?>
        </div>

        <!-- Form for updating event details -->
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="event-id" value="<?php echo $selectedEventId; ?>">

            <label for="new-event-name">New Event Name:</label>
            <textarea id="new-event-name" name="new-event-name" rows="2" style="width: 90%; height: 50px; resize: none;" required></textarea>

            <label for="new-event-details">New Event Details:</label>
            <textarea id="new-event-details" name="new-event-details" rows="5" style="width: 90%; height: 150px; resize: none;" required></textarea>

            <label for="new-event-date">New Event Date:</label>
            <input type="date" id="new-event-date" name="new-event-date" required>

            <button type="submit" name="update-event-submit">Update Event</button>
        </form>

        <?php
        // Handle the form submission for updating events
        if (isset($_POST["update-event-submit"])) {
            $selectedEventId = $_POST["event-id"];
            $newEventName = $_POST["new-event-name"];
            $newEventDetails = $_POST["new-event-details"];
            $newEventDate = $_POST["new-event-date"];

            $updateSql = "UPDATE events SET event_name='$newEventName', event_details='$newEventDetails', event_date='$newEventDate' WHERE ev_id=$selectedEventId";

            if ($conn->query($updateSql) === TRUE) {
                echo "<p>Event updated successfully!</p>";

                // Fetch updated event details
                $sql = "SELECT * FROM events WHERE ev_id=$selectedEventId";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<p>Updated Event Name: " . $row["event_name"] . "</p>";
                    echo "<p>Updated Event Date: " . $row["event_date"] . "</p>";
                    echo "<p>Updated Event Details: " . $row["event_details"] . "</p>";

                    // Output JavaScript to reload the page after 2 seconds
                    echo "<script>
                            setTimeout(function () {
                                window.location.href = '../view/test.php';
                            }, 2000);
                          </script>";
                }
            } else {
                echo "<p>Error updating event: " . $conn->error . "</p>";
            }
        }
        ?>
    </div>
</body>

</html>
