<?php
include("UserSidebar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>USER INBOX</title>
    <style>
        /* Style for the body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        /* Style for the h1 header */
        h1 {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 20px;
        }

        h4 {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 10px;
            opacity: 50%;
        }

        /* Style for the table */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Style for table headers */
        th {
            background-color: #333;
            color: #fff;
            font-weight: bold;
            padding: 10px;
        }

        /* Style for table cells */
        td {
            padding: 8px;
            text-align: center;
        }

        /* Style for table rows */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <?php
    if (!isset($_SESSION['id'])) {
        header("Location: UserLogin.php");
        exit();
    }

    $id = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "root", "", "event_management");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT msg_id,message FROM messages WHERE msg_to = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr> 
            <th colspan=4>MESSAGE FROM ADMIN</th>
            </tr>";
        echo "<tr>
                <th>MESSAGE ID</th>
                <th>MESSAGE</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . (isset($row['msg_id']) ? $row['msg_id'] : "") . "</td>
                    <td>" . (isset($row['message']) ? $row['message'] : "") . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No data history available.";
    }

    mysqli_close($conn);
    ?>
</body>
</html>
