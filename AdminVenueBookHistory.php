<?php
include("AdminSidebar.php");

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
    $username = $row['uname'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Sales</title>
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

        #content {
            flex: 1;
            display: flex;
            flex-direction: column; /* Align content vertically */
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
    <div id="content">
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">Venue Booking History</h1>
        <form method="get">
            <table border="1">
                <tr>
                    <th>USER ID</th>
                    <th>Booked By</th>
                    <th>Venue Name</th>
                    <th>Booking ID</th>
                    <th>From Date</th>
                    <th>To Date</th>
                </tr>
                <?php
                $servername = "localhost";
                $username = "root";
                $pass = "";
                $dbname = "event_management";
                $conn = new mysqli($servername, $username, $pass, $dbname);

                $sql = "select * from booking";
                $res = mysqli_query($conn, $sql);

                while ($r = mysqli_fetch_assoc($res)) {
                ?>
                    <tr>
                        <td><?php echo $r["user_id"]; ?></td>
                        <td><?php echo $r["name"]; ?></td>
                        <td><?php echo $r["venue_name"]; ?></td>
                        <td><?php echo $r["booking_id"]; ?></td>
                        <td><?php echo $r["from_date"]; ?></td>
                        <td><?php echo $r["to_date"]; ?></td>
                        <!-- <td><button type="submit" name="del" value="<?php echo $r["id"]; ?>">Delete</button></td> -->
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>
</body>
</html>
