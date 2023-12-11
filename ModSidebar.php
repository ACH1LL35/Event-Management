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
    <title>Master Admin Page</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #menu {
            width: 250px;
            /* background-color: #333; */
            color: #333;
            padding: 20px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 1px 0;
        }

        h2 {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
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
            width: 200px;
            text-decoration: none;
            margin-bottom: 5px;
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

        /* Additional style for the dropdown */
        details {
            display: inline-block;
        }

        summary {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            border: 2px solid #007BFF;
            border-radius: 3px;
            width: 200px;
            text-align: left;
            list-style: none;
            margin-bottom: 5px;
        }

        details ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        details li {
            margin: 1px 0;
        }

        details a {
            display: block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: left;
            border: 2px solid #007BFF;
            border-radius: 3px;
            cursor: pointer;
            width: 290px;
            text-decoration: none;
            margin-bottom: 5px;
            margin-left: 5px;
        }

        details a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="menu">
        <form class="logout-form" method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <ul>
            <li><a href="ModPanel.php">➾ HOME</a></li>
            <li><a href="ModInfoUpdate.php">INFORMATION UPDATE</a></li>
            
            <!-- Use details and summary for the dropdown -->
            <details>
                <summary>➾ EVENT</summary>
                <ul>
                    <li><a href="ModEvent.php">CREATE EVENT</a></li>
                    <li><a href="eventcal.php">EVENT CALENDAR</a></li>
                </ul>
            </details>

            <li><a href="ModAnalysis.php">ANALYSIS</a></li>
            <li><a href="ModAnalysis.php">➾ ANALYSIS</a></li>
            

            <details>
                <summary>➾ MODERATION</summary>
                <ul>
                    <li><a href="ModPostModeration.php">⤷ POST MODERATION</a></li>
                    <li><a href="#.php">⤷ POST MODERATION HISTORY</a></li>
                    <li><a href="ModCommentModeration.php">⤷ COMMENT MODERATION</a></li>
                    <li><a href="#.php">⤷ COMMENT MODERATION HISTORY</a></li>
                </ul>
            </details>

            <details>
                <summary>➾ FEEDBACK</summary>
                <ul>
                    <li><a href="ModComplaint.php">⤷ QUERY FEEDBACK</a></li>
                    <li><a href="ModQueryF.php">⤷ QUOTATION FEEDBACK</a></li>
                    <li><a href="ModQuotationF.php">⤷ COMPLAINT FEEDBACK</a></li>
                </ul>
            </details>
        </ul>
    </div>
</body>
</html>
