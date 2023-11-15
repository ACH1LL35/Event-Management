<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
        }

        #sidebar {
            float: left;
            width: 20%;
        }

        #content {
            float: left;
            width: 80%;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin: 0;
        }

        ul li a {
            display: block;
            padding: 10px;
            background-color: #eee;
            text-decoration: none;
        }

        ul li a:hover {
            background-color: #ddd;
        }

        #logout-container {
            position: absolute;
            top: 20px;
            right: 10px;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff5733;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-button:hover {
            background-color: #ff0000;
        }

        .container {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 0px;
            border-radius: 5px;
            width: 70%;
            background-size: cover;
            position: relative;
        }

        .container h2 {
            color: #333;
        }

        .container label {
            display: block;
            margin-top: 10px;
        }

        .container select,
        .container input[type="number"],
        .container input[type="tel"] {
            width: 75%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .container input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .container input[type="submit"]:hover {
            background-color: #333;
        }

        .container select option:checked::before {
            content: "Selected";
            color: #333;
            font-weight: bold;
            position: absolute;
            top: 0;
            right: 10px;
        }

        #message {
            background-color: #ddd;
            padding: 10px;
            border: 1px solid #999;
            border-radius: 5px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    session_start();

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: UserLogin.php");
        exit();
    }

    if (!isset($_SESSION['id'])) {
        header("Location: UserLogin.php");
        exit();
    }

    $id = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "root", "", "event_management");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM credential WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $email = $row['email'];
        $name = $row['name'];
    }
    ?>

    <h1>Welcome, <?php echo $username; ?>!</h1>

    <div id="sidebar">
        <h2>My Accounts</h2>
        <ul>
            <li><a href="UserProfile.php">DASHBOARD</a></li>
            <li><a href="UserUpdate.php">ACCOUNT DETAILS</a></li>
            <li><a href="UserAddress.php">ADDRESS BOOK</a></li>
            <li><a href="UserTicket.php">PURCHASE TICKET</a></li>
            <li><a href="UserPurchase.php">PURCHASE HISTORY</a></li>
            <li><a href="UserVenueBook.php">BOOK VENUE</a></li>
            <li><a href="UserVenueHistory.php">BOOKING HISTORY</a></li>
            <li><a href="#">UPCOMING</a></li>
            <li><a href="UserComplaint.php">COMPLAINT</a></li>
            <li><a href="UserQuery.php">QUERY</a></li>
            <li><a href="UserQuotation.php">ASK FOR QUOTATION</a></li>
            <li><a href="UserFeedback.php">FEEDBACK</a></li>
        </ul>
    </div>

    <div id="content">
        <h2><?php echo $username; ?>'s Profile</h2>
        <p>Username: <?php echo $username; ?></p>
        <p>Email: <?php echo $email; ?></p>

        <div class="container">
            <h2>Purchase Ticket</h2>
            <?php
            if (isset($_SESSION['id'])) {
            ?>
                <form method="post">
                    <label for="event_name">Event Name:</label>
                    <select name="event_name" required>
                        <option value="" disabled selected>Select an event</option>
                        <?php

                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "event_management";
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = "SELECT event_name, available_tickets FROM ticket_cr";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["event_name"] . "'>" . $row["event_name"] . "</option>";
                            }
                        }

                        $conn->close();
                        ?>
                    </select><br>

                    <label for="ticket_quantity">Ticket Quantity:</label>
                    <input type="number" name="ticket_quantity" required><br>

                    <label for="contact_number">Contact Number:</label>
                    <input type="tel" name="contact_number" required><br><br>

                    <input type="submit" value="Purchase Ticket">
                </form>
            <?php
            } else {
                echo "Please <a href='UserLogin.php'>log in</a> to purchase tickets.";
            }
            ?>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['id'])) {
                $event_name = $_POST["event_name"];
                $ticket_quantity = $_POST["ticket_quantity"];
                $contact_number = $_POST["contact_number"];
                $user_id = $_SESSION['id'];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "event_management";
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT available_tickets FROM ticket_cr WHERE event_name = '$event_name'";
                $result = $conn->query($sql);

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $available_tickets = $row["available_tickets"];

                    if ($ticket_quantity <= $available_tickets) {
                        $new_available_tickets = $available_tickets - $ticket_quantity;
                        $update_sql = "UPDATE ticket_cr SET available_tickets = $new_available_tickets WHERE event_name = '$event_name'";

                        if ($conn->query($update_sql) === TRUE) {
                            $ticket_id = generateRandomString(10);

                            $insert_purchase_sql = "INSERT INTO purchase_info (event_name, ticket_quantity, contact_number, user_id, email, name, ticket_id) VALUES ('$event_name', $ticket_quantity, '$contact_number', $user_id, '$email', '$name', '$ticket_id')";

                            if ($conn->query($insert_purchase_sql) === TRUE) {
                                $message = "Tickets purchased successfully. Ticket ID: $ticket_id";
                            } else {
                                $message = "Error storing purchase information: " . $conn->error;
                            }
                        } else {
                            $message = "Error updating available tickets: " . $conn->error;
                        }
                    } else {
                        $message = "Not enough tickets available for purchase.";
                    }
                } else {
                    $message = "Event not found or multiple events with the same name.";
                }

                $conn->close();
            }

            if (isset($message)) {
                echo '<div id="message">' . $message . '</div>';
            }
            ?>
        </div>
    </div>
    <div id="logout-container">
        <form method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
    </div>
</body>

</html>
