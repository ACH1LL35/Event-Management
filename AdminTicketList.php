<?php
include("AdminSidebar.php");

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
            flex-direction: column;
            padding-left: 20px;
        }

        h2 {
            text-align: center;
            background-color: #333;
            color: #000;
            padding: 20px;
            margin: 0;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
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
            margin-top: 10px;
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
        <h2 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">Ticket Sales List</h2>
        <form method="get">
            <table border="1">
                <tr>
                    <th>USER ID</th>
                    <th>Event Name</th>
                    <th>Ticket ID</th>
                    <th>Ticket Quantity</th>
                    <th>Contact No.</th>
                </tr>
                <?php
                $servername = "localhost";
                $username = "root";
                $pass = "";
                $dbname = "event_management";
                $conn = new mysqli($servername, $username, $pass, $dbname);

                $sql = "select * from purchase_info";
                $res = mysqli_query($conn, $sql);

                while ($r = mysqli_fetch_assoc($res)) {
                ?>
                    <tr>
                        <td><?php echo $r["user_id"]; ?></td>
                        <td><?php echo $r["event_name"]; ?></td>
                        <td><?php echo $r["ticket_id"]; ?></td>
                        <td><?php echo $r["ticket_quantity"]; ?></td>
                        <td><?php echo $r["contact_number"]; ?></td>
                        <!-- <td><button type="submit" name="del" value="<?php echo $r["id"]; ?>">Delete</button></td> -->
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>
</body>
</html>