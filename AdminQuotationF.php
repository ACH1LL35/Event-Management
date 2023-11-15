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
    <title>QUOTATION FEEDBACK</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #content {
            flex: 1;
            display: flex;
            flex-direction: column; /* Align content vertically */
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

        .content {
            padding-left: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
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
        <?php

        if (!isset($_SESSION['id'])) {
            header("Location: AdminModLogin.php");
            exit();
        }

        $id = $_SESSION['id'];

        $conn = mysqli_connect("localhost", "root", "", "event_management");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query = "SELECT uname FROM admin_mod WHERE id = '$id'";
        $result = mysqli_query($conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            $uname = $row['uname'];
        } else {
            $uname = "Username not found in the database.";
        }
        ?>

    <h1>Welcome, <?php echo $uname; ?>!</h1>
        <ul>
            <li><a href="AdminPanel.php">Home</a></li>
            <li><a href="AdminEvent.php">CREATE EVENT</a></li>
            <li><a href="AdminEventHistory.php">EVENT HISTORY</a></li>
            <li><a href="AdminEventCal.php">EVENT CALENDAR</a></li>
            <li><a href="AdminTicketCreation.php">TICKET PUBLISH</a></li>
            <li><a href="AdminTicketList.php">TICKET SALE LIST</a></li>
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
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">QUOTATION FEEDBACK</h1>
        <form method="get">
        <table border="1">
            <tr>
                <th>QOUTATION ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>ABOUT</th>
                <th>Description</th>
                <th>Feedback</th>
                <th>Feedback Given By</th>
                <th>Action</th>
            </tr>
        <?php
        // if(isset($_GET['del']))
        // {
        //     $id= $_GET['del'];
        //     $sql1="Delete from complaint where id='$id'";
        //     mysqli_query($conn,$sql1);
        // }

        $sql="select * from quotation";
        $res= mysqli_query($conn,$sql);

        while($r= mysqli_fetch_assoc($res)) {
        ?>
            <tr>
                <td><?php echo $r["qo_id"]; ?></td>
                <td><?php echo $r["u_name"]; ?></td>
                <td><?php echo $r["u_email"]; ?></td>
                <td><?php echo $r["qo_about"]; ?></td>
                <td><?php echo $r["qo_des"]; ?></td>
                <td><?php echo $r["qo_fed"]; ?></td>
                <td><?php echo $r["fd_by"]; ?></td>
                <!-- <center>
                <td><button type="submit" name="del" value="?php echo $r["id"]; ?>">Delete</button></td>
                </center> -->
            </tr>
        <?php } ?>
        </table>
        </form>
    </div>
</body>
</html>
