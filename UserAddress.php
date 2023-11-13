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
            width: 20%; /* Adjust width as needed */
        }
        #content {
            float: left;
            width: 45%; /* Adjust width as needed */
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

        /* Add CSS for the Update Address Form */
        .update-address-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .address-input {
            width: 75%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .update-button {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .update-button:hover {
            background-color: #005bb7;
        }
    </style>
</head>
<body>
<?php
    session_start(); // Start the session

    if (isset($_POST['logout'])) {
        // Destroy the session and redirect to the Login page
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
        // Fetch the user's current address from the database
        $address_query = "SELECT address FROM credential WHERE id = '$id'";
        $address_result = mysqli_query($conn, $address_query);
        if ($address_row = mysqli_fetch_assoc($address_result)) {
            $current_address = $address_row['address'];
        }
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
        <p>Unique UserID: <?php echo $id; ?></p>

        <h2>Current Address</h2>
        <p><?php echo $current_address; ?></p>

        <h2>Update Your Address</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="update-address-form">
            <label for="new_address">New Address:</label>
            <input type="text" name="new_address" value="<?php echo $current_address; ?>" class="address-input">
            <br>
            <input type="submit" name="update_address" value="Update Address" class="update-button">
        </form>

        <?php
        // update
        if (isset($_POST["update_address"])) {
            $new_address = mysqli_real_escape_string($conn, $_POST['new_address']);
            $update_address_query = "UPDATE credential SET address = '$new_address' WHERE id = '$id'";
            if (mysqli_query($conn, $update_address_query)) {
                echo "Address updated successfully!";
                // Refresh page
                header("Refresh:0");
            } else {
                echo "Error updating address: " . mysqli_error($conn);
            }
        }
        ?>

        <div id="logout-container">
            <form method="post">
                <input type="submit" name="logout" class="logout-button" value="Log Out">
            </form>
        </div>
    </div>

    <?php
    mysqli_close($conn);
    ?>
</body>
</html>
