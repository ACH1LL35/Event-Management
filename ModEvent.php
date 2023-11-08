<?php
    // Start a PHP session
    session_start();

    // Check if a user ID session variable exists
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];

        // Replace these database connection details with your actual information
        $dbHost = "localhost";
        $dbUser = "root";
        $dbPassword = "";
        $dbName = "event_management";

        $dbConnection = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

        if (!$dbConnection) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $query = "SELECT uname FROM admin_mod WHERE id = '$id'";
        $result = mysqli_query($dbConnection, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $uname = $row['uname'];
            } else {
                $uname = 'Unknown'; // Default value if uname is not found
            }
        } else {
            $uname = 'Unknown'; // Default value if there is an error with the query
        }
    } else {
        $id = null; // Default value when no user is logged in
        $uname = '';
    }

    // Handle the logout functionality
    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: AdminModLogin.php');
        exit();
    }
    ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event-name'])) {
    // Database connection settings
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "event_management";

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the data for insertion
    $eventName = $conn->real_escape_string($_POST['event-name']);
    $eventDate = $conn->real_escape_string($_POST['event-date']);
    $eventDescription = $conn->real_escape_string($_POST['event-description']);

    // Insert data into the database
    $sql = "INSERT INTO events (event_name, event_date, event_details, posted_by) VALUES ('$eventName', '$eventDate', '$eventDescription', '$id')";

    if ($conn->query($sql) === TRUE) {
        echo "Event posted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

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
            flex-direction: column;
            align-items: center;
            justify-content: flex-start; /* Align header to the top */
            height: 100vh;
            margin: 0;
        }

        h1 {
            text-align: center;
        }

        #event-form {
            max-width: 500px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
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
    <h1>Mod - Event Posting</h1>
    <form id="event-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="event-name">Event Name:</label>
        <input type="text" id="event-name" name="event-name">
        <br>
        <label for="event-date">Event Date:</label>
        <input type="date" id="event-date" name="event-date">
        <br>
        <label for="event-description">Event Description:</label>
        <textarea id="event-description" name="event-description" rows="4"></textarea>
        <br>
        <button type="submit">Post Event</button>
    </form>
</body>
</html>
