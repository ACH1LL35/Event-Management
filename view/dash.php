<?php
session_start();

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the Login page
    session_destroy();
    header("Location: start.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: start.php");
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
    $uname = $row['uname']; // Update to use the correct variable name
    // $email = $row['email'];
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define table names with optional custom names
$tables = array(
    "credential" => "Regsitered User",
    "booking" => "Total Booking",
    "comments" => "",
    "complaint" => "",
    "events" => "Active Event",
    "posts" => "",
    "purchase_info" => "",
    "ticket_cr" => "Ongoing Show",
    "query" => "",
    "quotation" => "",
    "gallery_data" => ""
);

$counts = array();

foreach ($tables as $tableName => $customName) {
    $query = "SELECT COUNT(*) AS count FROM $tableName";
    $result = $conn->query($query);
    $counts[$customName ? $customName : $tableName] = $result->fetch_assoc()['count'];
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
            background-color: #fff;
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
            overflow-y: auto; /* Add this line for vertical scrolling */
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 1px 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            background-color: #333;
            color: #fff;
            padding: 10px;
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
            width: 215px;
            text-decoration: none;
            margin-bottom: 5px;
            margin-left: 5px;
        }

        details a:hover {
            background-color: #0056b3;
        }

        #content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; /* Spread columns evenly */
            max-width: 1200px; /* Set your preferred max width */
            margin: 20px auto; /* Add some margin for better spacing */
        }

        .box {
            width: calc(25% - 20px); /* 25% width with some spacing */
            margin: 10px; /* Adjust the margin as needed for spacing */
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        @media (max-width: 768px) {
            .box {
                width: calc(50% - 20px); /* 50% width on smaller screens */
            }
        }
    </style>
</head>
<body>
    <div id="menu">
        <form class="logout-form" method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
        <h1>Welcome, <?php echo $uname; ?>!</h1>
        <ul>
        <li><a href="dash.php">➾ HOME</a></li>
        <li><a href="AdminProfileView.php">➾ Info Update</a></li>

            
            <!-- Use details and summary for the dropdown -->
            <details>
                <summary>➾ TICKET</summary>
                <ul>
                    <li><a href="PublishTicketView.php">⤷ TICKET PUBLISH</a></li>
                    <li><a href="TicketView.php">⤷ TICKET MANAGEMENT</a></li>
                    <li><a href="TicketSalesView.php">⤷ TICKET SALE LIST</a></li>
                    <li><a href="TicketAuditView.php">⤷ TICKET AUDIT</a></li>

                </ul>
            </details>

            <details>
                <summary>➾ EVENT</summary>
                <ul>
                    <li><a href="AdminEvent.php">⤷ POST NEW EVENT</a></li>
                    <li><a href="EventsArchiveView.php">⤷ EVENT HISTORY</a></li>
                    <li><a href="test.php">⤷ EDIT EVENT</a></li>
                </ul>
            </details>
            
            <details>
                <summary>➾ VENUE</summary>
                <ul>
                    <li><a href="PublishVenueView.php">⤷ ADD VENUE</a></li>
                    <li><a href="VenueView.php">⤷ VENUE MANAGEMENT</a></li>
                    <li><a href="AdminBookingHistoryView.php">⤷ VENUE BOOKING LIST</a></li>
                </ul>
            </details>

            <details>
                <summary>➾ MODERATOR</summary>
                <ul>
                    <li><a href="ModeratorRegistrationView.php">⤷ MOD ACCESS</a></li>
                    <li><a href="ModeratorListView.php">⤷ MOD MANAGEMENT</a></li>
                </ul>
            </details>
            
            <li><a href="#">➾ ANALYSIS</a></li>
            

            <details>
                <summary>➾ MODERATION</summary>
                <ul>
                    <li><a href="PostViewM.php">⤷ POST MODERATION</a></li>
                    <li><a href="PostViewH.php">⤷ POST MOD HISTORY</a></li>
                    <li><a href="commentViewM.php">⤷ COMMENT MODERATION</a></li>
                    <li><a href="commentViewH.php">⤷ COMMENT MOD HISTORY</a></li>
                </ul>
            </details>

            <details>
                <summary>➾ FEEDBACK</summary>
                <ul>
                    <li><a href="QueryView.php">⤷ QUERY FEEDBACK</a></li>
                    <li><a href="QuotationView.php">⤷ QUOTATION FEEDBACK</a></li>
                    <li><a href="complaintFeedbackView.php">⤷ COMPLAINT FEEDBACK</a></li>
                </ul>
            </details>

            <li><a href="upload.php">⤷ ADD TO   GALLERY</a></li>

            <details>
                <summary>➾ USER</summary>
                <ul>
                    <li><a href="AdminUserView.php">⤷ USER MANAGEMENT</a></li>
                    <li><a href="#">⤷ NEWSLETTER</a></li>
                </ul>
            </details>
        </ul>
    </div>

    <div id="content">
        <?php foreach ($counts as $customName => $count) { ?>
            <div class="box">
                <h2><?php echo ($customName !== "") ? $customName : $tableName; ?> Count</h2>
                <p><?php echo $count; ?></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
