<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Admin Page</title>
    <style>
         body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            padding-left: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            text-align: center;
            margin-right: auto;
            background-color: #333;
            color: #fff;
            padding: 10px 350px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 1px 0;
        }

        a {
            display: block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: left;
            border: 2px solid #007BFF;
            border-radius: 3px;
            cursor: pointer;
            width: 150px;
            text-decoration: none;
        }

        a:hover {
            background-color: #0056b3;
        }

        /* Styles for the logout form */
    .logout-form {
        text-align: center;
    }

    .logout-form .logout-button {
        padding: 10px 20px;
        background-color: #007BFF;
        color: #ffffff;
        border: 2px solid #007BFF;
        border-radius: 3px;
        cursor: pointer;
        width: 200px;
        text-decoration: none;
    }

    .logout-form .logout-button:hover {
        background-color: #0056b3;
    }
    </style>
</head>
<body>
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
    <div id="menu">
    <form class="logout-form" method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
        <h1>Welcome, <?php echo $username; ?>!</h1>
    <ul>
            <li><a href="ModPanel.php">DASHBOARD</a></li>
            <li><a href="ModInfoUpdate.php">INFORMATION UPDATE</a></li>
            <li><a href="ModEvent.php">CREATE EVENT</a></li>
            <li><a href="eventcal.php">EVENT CALENDAR</a></li>
            <li><a href="ModAnalysis.php">ANALYSIS</a></li>
            <li><a href="ModComplaint.php">COMPLAINT LIST</a></li>
            <li><a href="ModPostModeration.php">POST MODERATION</a></li>
            <li><a href="#">POST MODERATION HISTORY</a></li>
            <li><a href="ModCommentModeration.php">COMMENT MODERATION</a></li>
            <li><a href="#">COMMENT MODERATION HISTORY</a></li>
            <li><a href="ModComplaint.php">Contact Update</a></li>
            <li><a href="ModComplaint.php">Support Mail</a></li>
    </ul>
</body>
</html>
