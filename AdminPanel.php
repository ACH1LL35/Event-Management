<?php


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
    $userUname = $row['uname'];
    // $email = $row['email'];
}

$servername = "localhost";
$dbUsername = "root"; // Use a different variable name for the database connection
$password = "";
$dbname = "event_management";

$conn = new mysqli($servername, $dbUsername, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define table names with optional custom names
$tables = array(
    "credential" => "REGISTERED USER",
    "booking" => "",
    "comments" => "SITE WIDE COMMENTS",
    "complaint" => "COMPLAINT LAUNCHED",
    "events" => "",
    "posts" => "SITE WIDE POSTS",
    "purchase_info" => "",
    "ticket_cr" => "",
    "query" => "",
    "quotation" => "",
    "gallery_data" => "GALLAEY IMAGES"
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
            background-color: #f2f2f2;
            display: flex;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #menu {
            width: 250px;
            color: #333;
            padding: 20px;
            overflow-y: auto;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 1px 0;
        }

        h3 {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
            border-radius: 45px;
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
            margin-top: 10px;
        }

        .logout-form .logout-button:hover {
            background-color: #0056b3;
        }

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

        #content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            max-width: 1200px;
            margin: 20px auto;
        }

        .box {
            width: calc(25% - 20px);
            margin: 3px;
            padding: 9px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 45px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        @media (max-width: 768px) {
            .box {
                width: calc(50% - 20px);
            }
        }

        p {
            font-size: 25px; /* Adjust the font size as needed */
        }
    </style>
</head>
<body>
    <div id="menu">
    <h3 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">DASHBOARD</h3>
        <form class="logout-form" method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
        <h1>Welcome, <?php echo $userUname; ?>!</h1>
        <ul>
            <li><a href="AdminPanel.php">➾ HOME</a></li>
            <li><a href="AdminInfoUpdate.php">➾ Info Update</a></li>

            <details>
                <summary>➾ TICKET</summary>
                <ul>
                    <li><a href="AdminTicketCreation.php">⤷ TICKET PUBLISH</a></li>
                    <li><a href="AdminTicketManagement.php">⤷ TICKET MANAGEMENT</a></li>
                    <li><a href="AdminTicketList.php">⤷ TICKET SALE LIST</a></li>
                </ul>
            </details>

            <details>
                <summary>➾ EVENT</summary>
                <ul>
                    <li><a href="AdminEventHistory.php">⤷ EVENT HISTORY</a></li>
                    <li><a href="AdminEventCal.php">⤷ EVENT CALENDAR</a></li>
                </ul>
            </details>

            <details>
                <summary>➾ VENUE</summary>
                <ul>
                    <li><a href="AdminVenueManagement.php">⤷ VENUE MANAGEMENT</a></li>
                    <li><a href="AdminVenueBookHistory.php">⤷ VENUE BOOKING LIST</a></li>
                </ul>
            </details>

            <details>
                <summary>➾ MODERATOR</summary>
                <ul>
                    <li><a href="AdminModAccess.php">⤷ MODERATOR ACCESS</a></li>
                    <li><a href="AdminModManagement.php">⤷ MODERATOR MANAGEMENT</a></li>
                </ul>
            </details>

            <li><a href="AdminAnalysis.php">➾ ANALYSIS</a></li>

            <details>
                <summary>➾ MODERATION</summary>
                <ul>
                    <li><a href="AdminPostModeration.php">⤷ POST MODERATION</a></li>
                    <li><a href="AdminPMH.php">⤷ POST MODERATION HISTORY</a></li>
                    <li><a href="AdminCommentModeration.php">⤷ COMMENT MODERATION</a></li>
                    <li><a href="AdminCMH.php">⤷ COMMENT MODERATION HISTORY</a></li>
                </ul>
            </details>

            <details>
                <summary>➾ FEEDBACK</summary>
                <ul>
                    <li><a href="AdminQueryF.php">⤷ QUERY FEEDBACK</a></li>
                    <li><a href="AdminQuotationF.php">⤷ QUOTATION FEEDBACK</a></li>
                    <li><a href="AdminComplaint.php">⤷ COMPLAINT FEEDBACK</a></li>
                </ul>
            </details>

            <details>
                <summary>➾ GALLERY</summary>
                <ul>
                    <li><a href="AdminAdd2Gallary.php">⤷ DD TO GALLERY</a></li>
                    <li><a href="AdminLinkImage.php">⤷ LINK TO GALLERY</a></li>
                </ul>
            </details>

            <details>
                <summary>➾ USER</summary>
                <ul>
                    <li><a href="AdminUserManagement.php">⤷ USER MANAGEMENT</a></li>
                    <li><a href="AdminNewsletter.php">⤷ NEWSLETTER</a></li>
                </ul>
            </details>
        </ul>
    </div>

    <div id="content">
        <?php foreach ($counts as $customName => $count) { ?>
            <div class="box">
                <h3><?php echo ($customName !== "") ? $customName : $tableName; ?></h3>
                <p><?php echo $count; ?></p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
