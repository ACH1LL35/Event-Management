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
            width: 15%; /* Adjust width as needed */
        }
        #content {
            float: left;
            width: 80%; /* Adjust width as needed */
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
    </style>
</head>
<body>
    <?php
    session_start();

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
            <li><a href="UserComplaint.php">Feedback</a></li>
        </ul>
    </div>

    <div id="content">
        <h2><?php echo $username; ?>'s Profile</h2>
        <p>Username: <?php echo $username; ?></p>
        <p>Email: <?php echo $email; ?></p>
    </div>

    <div id="logout-container">
        <form method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
    </div>

    <?php
    mysqli_close($conn);
    ?>
</body>
</html>
