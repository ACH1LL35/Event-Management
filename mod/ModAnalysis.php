<?php
include("ModSidebar.php");

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];

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
                $uname = 'Unknown';
            }
        } else {
            $uname = 'Unknown';
        }
    } else {
        $id = null;
        $uname = '';
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: start.php');
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
