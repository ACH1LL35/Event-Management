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
    <title>Moderator Admin Page</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        .sidebar {
            background-color: #333;
            color: #fff;
            width: 200px;
            padding: 20px;
            height: 800px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            text-align: center;
            margin-right: auto;
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

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1>Welcome <?php echo $username; ?></h1>
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
        <form method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
    </div>

    <div class="content">
        <h1>COMPLAINT LIST</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table border="1">
                <tr>
                    <th>Complaint ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Current Feedback</th>
                    <th>Feedback</th>
                </tr>
                <?php while ($r = mysqli_fetch_assoc($result))  {?>
                    <tr>
                        <td><?php echo $r["id"]; ?></td>
                        <td><?php echo $r["name"]; ?></td>
                        <td><?php echo $r["description"]; ?></td>
                        <td><?php echo $r["feedback"]; ?></td>
                        <td>
                            <textarea name="feedback" rows="4" cols="50"><?php echo $r["feedback"]; ?></textarea>
                            <input type="hidden" name="complaint_id" value="<?php echo $r["id"]; ?>">
                            <button type="submit" name="updateFeedback">Update Feedback</button>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>
</body>
</html>
