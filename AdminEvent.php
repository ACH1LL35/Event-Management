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
    <title>Event Posting</title>
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
        background-color: #333;
        color: #fff;
        padding: 20px;
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
        width: 200px;
        text-decoration: none;
        margin-bottom: 5px;
    }

    a:hover {
        background-color: #0056b3;
    }

        #event-form {
            max-width: 1000px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 150px 380px;
            text-align: left;
            width: 600px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        textarea {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            display: block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
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
    <div id="menu">
    <form class="logout-form" method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <ul>
            <li><a href="AdminPanel.php">Home</a></li>
            <li><a href="AdminEvent.php">CREATE EVENT</a></li>
            <li><a href="AdminEventHistory.php">EVENT HISTORY</a></li>
            <li><a href="AdminEventCal.php">EVENT CALENDAR</a></li>
             <li><a href="AdminTicketCreation.php">TICKET PUBLISH</a></li>
            <li><a href="AdminTicketManagement.php">TICKET MANAGEMENT</a></li>
            <li><a href="AdminTicketList.php">TICKET SALE LIST</a></li>
            <li><a href="VenueManagement.php">VENUE MANAGEMENT</a></li>
            <li><a href="VenueBookHistory.php">VENUE BOOKING LIST</a></li>
            <li><a href="AdminAnalysis.php">ANALYSIS</a></li>
            <li><a href="AdminComplaint.php">COMPLAINT FEEDBACK</a></li>
            <li><a href="AdminModAccess.php">MODERATOR ACCESS</a></li>
            <li><a href="AdminModManagement.php">MODERATOR MANAGEMENT</a></li>
            <li><a href="AdminPostModeration.php">POST MODERATION</a></li>
            <li><a href="AdminPMH.php">POST MODERATION HISTORY</a></li>
            <li><a href="AdminCommentModeration.php">COMMENT MODERATION</a></li>
            <li><a href="AdminCMH.php">COMMENT MODERATION HISTORY</a></li>
            <li><a href="AdminQueryF.php">QUERY FEEDBACK</a></li>
            <li><a href="AdminQuotationF.php">QOUTATION FEEDBACK</a></li>
            <li><a href="AdminAdd2Gallary.php">ADD TO GALLERY</a></li>
            <li><a href="AdminUserManagement.php">USER MANAGEMENT</a></li>
            <li><a href="AdminNewsletter.php">NEWSLETTER</a></li>
        </ul>
    </div>
    <div id="content">
        <form id="event-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <center>
            <h2>Event Publishing</h2>
            </center>
            <label for="event-name">Event Name:</label>
            <input type="text" id="event-name" name="event-name">
            <br>
            <label for="event-date">Event Date:</label>
            <input type="date" id="event-date" name="event-date">
            <br>
            <label for="event-description">Event Description:</label>
            <textarea id="event-description" name="event-description" rows="4"></textarea>
            <br>
            <button type="submit">Post Event</button>
        </form>
    </div>
</body>
</html>
