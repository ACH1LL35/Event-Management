<?php
if(!defined('APP_RUNNING')) define('APP_RUNNING', true);
$servername = "localhost";
$username = "root";
$pass = "";
$dbname = "event_management";

$displaySuccessMessage = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $contact = $conn->real_escape_string($_POST["contact"]);
    $description = $conn->real_escape_string($_POST["description"]);

    $sql = "INSERT INTO complaint (name, email, contact, description) VALUES ('$name', '$email', '$contact', '$description')";
    if ($conn->query($sql) === TRUE) {
        $displaySuccessMessage = true;
    } 
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us - EventX</title>
<style>
    body {
        font-family: 'Poppins', Arial, sans-serif;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        margin: 0;
        padding: 0;
        color: #333;
        min-height: 100vh;
    }

    .page-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px 20px;
    }

    .container {
        background-color: #ffffff;
        border-radius: 15px;
        padding: 35px 30px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    }

    h2 {
        text-align: center;
        color: #222;
        margin-bottom: 10px;
    }

    h3 {
        text-align: center;
        color: #666;
        font-size: 14px;
        margin-bottom: 25px;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
    }

    input, textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box;
    }

    .btn {
        width: 100%;
        background: linear-gradient(135deg, #2575fc, #6a11cb);
        color: white;
        font-weight: 600;
        padding: 12px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    .success-message {
        background-color: #4CAF50;
        color: white;
        padding: 12px;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 20px;
    }
</style>
</head>
<body>
    <?php include 'includes/HomeTopBar.php'; ?>
    
    <div class="page-wrapper">
        <div class="container">
            <h2>Public Query Form</h2>
            <h3>Submit your details and we'll get back to you shortly.</h3>

            <?php if($displaySuccessMessage): ?>
                <div class="success-message">Submitted successfully!</div>
            <?php endif; ?>

            <form action="" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="contact">Contact Number</label>
                <input type="tel" id="contact" name="contact" placeholder="01XXXXXXXXX" pattern="01[3-9]\d{8}" required>

                <label for="description">Message</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <button type="submit" class="btn">Send Inquiry</button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>