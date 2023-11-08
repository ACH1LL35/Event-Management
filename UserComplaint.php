<?php
$servername = "localhost";
$username = "root";
$pass = "";
$dbname = "event_management";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli($servername, $username, $pass, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $name = $_POST["name"];
    $email = $_POST["email"];
    $contact = $_POST["contact"];
    $description = $_POST["description"];


    $sql = "INSERT INTO complaint (name, email, contact, description) VALUES ('$name', '$email', '$contact', '$description')";

    $displaySuccessMessage = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if ($conn->query($sql) === TRUE) {
            $displaySuccessMessage = true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if ($displaySuccessMessage) {
        echo '<div class="success-message">Complaint submitted successfully.</div>';
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Query/Complaint Submission Form</title>
    <style>
        
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-right: 20px;
        }

        .container {
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: inline-block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        textarea {
            resize: vertical;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .text-center {
            text-align: center;
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
            justify-content: left;
            text-align: center;
            padding: 10px;
            margin-top: 10px;
            position: absolute;
            top: 0;
        }

    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Complaint Submission Form</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for "contact">Contact Number:</label>
            <input type="tel" id="contact_number" name="contact" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
        </div>
        <center>
            <div class="form-group">
                <input type="submit" class="btn" value="Submit">
            </div>
        </center>
    </form>
</div>

</body>
</html>