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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="2;url=ModPanel.php">
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
