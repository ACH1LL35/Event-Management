<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 20px; /* Add margin to create space between sidebar and form */
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>

<div>
    <?php include("AdminSidebar.php"); ?>
</div>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected option and message from the form
    $selectedOption = $_POST["options"];
    $message = $_POST["message"];

    // Validate form data
    if (empty($message)) {
        echo "Message is required.";
    } else {
        // Connect to your database (replace placeholders with actual values)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "event_management";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO messages (msg_to, message) VALUES (?, ?)");

        if ($selectedOption === 'all') {
            // If 'all' is selected, fetch all user IDs and insert message for each
            $result = $conn->query("SELECT id FROM credential");

            while ($row = $result->fetch_assoc()) {
                $stmt->bind_param("is", $row['id'], $message);
                $stmt->execute();
            }
        } else {
            // If a specific user is selected, insert the message for that user
            $stmt->bind_param("is", $selectedOption, $message);
            $stmt->execute();
        }

        // Close the statement and database connection
        $stmt->close();
        $conn->close();

        $successMessage = "Message sent successfully!";
        echo '<script>showAlert("' . $successMessage . '");</script>';
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="options">Select a user or all users:</label>
    <select name="options" id="options">
        <option value="" disabled selected>Select a user</option>
        <option value='all'>All Users</option>
        <?php
        // Connect to your database (replace placeholders with actual values)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "event_management";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch options from the database table
        $result = $conn->query("SELECT * FROM credential");

        // Populate the dropdown with options
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </select>

    <br>

    <label for="message">Enter your message:</label>
    <textarea name="message" id="message" rows="4" cols="50"></textarea>

    <br>

    <input type="submit" value="Send Message">
</form>
</body>
</html>
