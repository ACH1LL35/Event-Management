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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="2;url=AdminPanel.php">
    <title>Document</title>
    <style>
        *{
          margin: 0;  
          padding: 0;
        }
        h1{
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <div>
        <h1>THIS PAGE IS UNDER CONSTRUCTION</h1>
    </div>
</body>
</html>
