<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost"; // Update with your database host
    $dbusername = "root";      // Update with your database username
    $dbpassword = "";          // Update with your database password
    $dbname = "host";         // Update with your database name

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fname = $_POST['fname'];
    $uemail = $_POST['uemail'];
    $upass = $_POST['upass'];

    // Insert user data into database
    $sql = "INSERT INTO login (fname, uemail, upass) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fname, $uemail, $upass);
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>