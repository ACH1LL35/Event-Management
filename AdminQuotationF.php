<?php
session_start();
include("view/AdminSidebar.php");

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
            height: 100vh;
            margin: 0;
        }

        #content {
            display: flex;
            flex-direction: column; /* Align content vertically */
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
        <?php

        if (!isset($_SESSION['id'])) {
            header("Location: start.php");
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

        <h1>QUOTATION FEEDBACK</h1>
        <table border="1">
            <tr>
                <th>QUOTATION ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>ABOUT</th>
                <th>Description</th>
                <th>Feedback</th>
                <th>Feedback Given By</th>
                <th>Action</th>
            </tr>
            <?php
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
    </div>
</body>
</html>