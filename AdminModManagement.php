<?php
session_start();
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
    <title>Moderator List</title>
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
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">Moderator List</h1>
        <form method="post">
            <table border="1">
                <tr>
                    <th>MOD ID</th>
                    <th>USER NAME</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php
                $servername = "localhost";
                $username = "root";
                $pass = "";
                $dbname = "event_management";
                $conn = new mysqli($servername, $username, $pass, $dbname);

                if (isset($_POST['ban'])) {
                    $id = $_POST['ban'];
                    // Instead of deleting, update the status to 0 (banned)
                    $sql1 = "UPDATE admin_mod SET status = 0 WHERE id='$id'";
                    mysqli_query($conn, $sql1);
                }

                if (isset($_POST['uban'])) {
                    $id = $_POST['uban'];
                    // Instead of deleting, update the status to 1 (unbanned)
                    $sql2 = "UPDATE admin_mod SET status = 1 WHERE id='$id'";
                    mysqli_query($conn, $sql2);
                }

                $sql = "SELECT * FROM admin_mod WHERE type = 'mod'";
                $res = mysqli_query($conn, $sql);

                while ($r = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr>
                        <td><?php echo $r["id"]; ?></td>
                        <td><?php echo $r["uname"]; ?></td>
                        <td><?php echo $r["email"]; ?></td>
                        <td><?php echo $r["status"]; ?></td>
                        <td>
                            <?php if ($r["status"] == 1): ?>
                                <button type="submit" name="ban" value="<?php echo $r["id"]; ?>">Ban</button>
                            <?php else: ?>
                                <button type="submit" name="uban" value="<?php echo $r["id"]; ?>">Unban</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>
</body>
</html>
