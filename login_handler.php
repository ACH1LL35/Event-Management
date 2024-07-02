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

    $uemail = $_POST['uemail'];
    $upass = $_POST['upass'];

    // Query to check if the user exists
    $sql = "SELECT * FROM login WHERE uemail=? AND upass=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $uemail, $upass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Login successful, set session variables
        $user = $result->fetch_assoc();
        $_SESSION['uid'] = $user['uid']; // Store user id in session
        header("Location: dashboard.php");
    } else {
        echo "Login failed. Please check your email and password.";
    }

    $stmt->close();
    $conn->close();
}
?>