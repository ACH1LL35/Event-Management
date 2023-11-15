<!DOCTYPE html>
<html>
<head>
    <div><title>Purchase History</title></div>
    <link rel="stylesheet" type="text/css" href="UserPurchase.css">
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: UserLogin.php");
        exit();
    }

    $id = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "root", "", "event_management");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM purchase_info WHERE user_id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<h1>Purchase History</h1>";
        echo "<table>";
        echo "<tr>
                <th>Ticket ID</th>
                <th>Event Name</th>
                <th>Ticket Quantity</th>
                <th>Action</th>
              </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . $row['contact_number'] . "</td>
                    <td>" . $row['event_name'] . "</td>
                    <td>" . $row['ticket_quantity'] . "</td>
                    <td><button onclick='performAction'>Download Ticket</button></td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No purchase history available.";
    }

    mysqli_close($conn);
    ?>
</body>
</html>
