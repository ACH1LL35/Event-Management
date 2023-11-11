<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUBLISH TICKET</title>
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

#content {
    flex: 1;
    display: flex;
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
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
    #content {
    margin: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    background-color: #f5f5f5;
    }

    #content h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    #content form {
        max-width: 400px;
        margin: 0 auto;
    }

    #content label {
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }

    #content input[type="text"],
    #content input[type="number"] {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #content input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }

    #content input[type="submit"]:hover {
        background-color: #45a049;
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
    $uname = $row['uname'];
    // $email = $row['email'];
}
?>
<div id="menu">
<form class="logout-form" method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
    <h1>Welcome, <?php echo $uname; ?>!</h1>
    <ul>
        <li><a href="AdminPanel.php">Home</a></li>
        <li><a href="AdminEvent.php">CREATE EVENT</a></li>
        <li><a href="AdminEventHistory.php">EVENT HISTORY</a></li>
        <li><a href="AdminEventCal.php">EVENT CALENDAR</a></li>
        <li><a href="AdminTicketCreation.php">TICKET PUBLISH</a></li>
        <li><a href="AdminTicketList.php">TICKET SALE LIST</a></li>
        <li><a href="AdminAnalysis.php">ANALYSIS</a></li>
        <li><a href="AdminComplaint.php">COMPLAINT LIST</a></li>
        <li><a href="AdminModAccess.php">MODERATOR ACCESS</a></li>
        <li><a href="AdminModManagement.php">MODERATOR MANAGEMENT</a></li>
        <li><a href="#">POST MODERATION</a></li>
            <li><a href="#">POST MODERATION HISTORY</a></li>
            <li><a href="#">COMMENT MODERATION</a></li>
            <li><a href="#">COMMENT MODERATION HISTORY</a></li>
        <li><a href="AdminAdd2Gallary.php">ADD TO GALLERY</a></li>
        <li><a href="AdminUserManagement.php">USER MANAGEMENT</a></li>
    </ul>
</div>
<div id="content">
    <h1>PUBLISH TICKET</h1>
    <form method="post">
        <label for="event_name">Event Name:</label>
        <input type="text" name="event_name" required><br>

        <label for="venue">Venue:</label>
        <input type="text" name="venue" required><br>

        <label for="ticket_price">Ticket Price:</label>
        <input type="number" name="ticket_price" required><br>

        <label for="total_tickets">Total Tickets:</label>
        <input type="number" name="total_tickets" required><br>

        <input type="submit" value="Create Event">
    </form>
</div>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST["event_name"];
    $venue = $_POST["venue"];
    $ticket_price = $_POST["ticket_price"];
    $total_tickets = $_POST["total_tickets"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "event_management";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO ticket_cr (event_name, venue, ticket_price, total_tickets, available_tickets) VALUES ('$event_name', '$venue', $ticket_price, $total_tickets, $total_tickets)";

    if ($conn->query($sql) === TRUE) {
        echo "Event created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
