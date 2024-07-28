<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Event Posting</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            margin: 0;
        }

        #sidebar {
            width: 250px;
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #content {
            flex: 1;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        #event-form {
            max-width: 500px;
            margin: 0 auto; /* Center the form */
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            height: 350px;
            padding: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        textarea {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-left: 10px;
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

        #event-info {
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <?php include("AdminSidebar.php"); ?>
    </div>
    <div id="content">
        <h1>Mod - Event Posting</h1>
        <form id="event-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="event-name">Event Name:</label>
            <input type="text" id="event-name" name="event-name" required>
            <br>
            <label for="event-date">Event Date:</label>
            <input type="date" id="event-date" name="event-date" required>
            <br>
            <label for="event-details">Event Details:</label>
            <textarea id="event-details" name="event-details" rows="4" required></textarea>
            <br>
            <center>
            <button type="submit">Post Event</button>
            </center>
        </form>

        <?php
        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Database connection details
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "event_management";

            // Create a connection to the database
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve form data
            $eventName = $_POST["event-name"];
            $eventDate = $_POST["event-date"];
            $eventDetails = $_POST["event-details"];

            // SQL query to insert data into the database
            $sql = "INSERT INTO events (event_name, event_date, event_details, posted_by) VALUES ('$eventName', '$eventDate', '$eventDetails', '$id')";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                echo "<div id='event-info'>";
                echo "<p>Event posted successfully!</p>";

                // Retrieve and print the inserted data
                $lastInsertedId = $conn->insert_id;
                $selectQuery = "SELECT * FROM events WHERE id = $lastInsertedId";
                $result = $conn->query($selectQuery);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<p>Event ID: " . $row["id"] . "</p>";
                    echo "<p>Event Name: " . $row["event_name"] . "</p>";
                    echo "<p>Event Date: " . $row["event_date"] . "</p>";
                    echo "<p>Event Details: " . $row["event_details"] . "</p>";
                } else {
                    echo "<p>Error retrieving inserted data.</p>";
                }
                echo "</div>";
            } else {
                echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }

            // Close the database connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
