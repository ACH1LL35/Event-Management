<!DOCTYPE html>
<html>
<head>
    <title>EventX - Your Event Partner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/evbg.jpg'); /* Path to your background image in the "images" folder */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #000000;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Basic CSS styles */
        body {
            font-family: Arial, sans-serif;
        }

        .top-bar {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: relative;
        }

        .top-bar a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
        }

        .top-bar a:hover {
            text-decoration: underline;
        }

        .company-name {
            font-size: 24px;
            cursor: pointer;
        }

        .company-name:hover {
            text-decoration: underline;
        }

        #Login-button,
        #book-button {
            position: absolute;
            top: 20px;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        #Login-button {
            right: 10px;
            background-color: #ff6600;
        }

        #book-button {
            right: 80px;
            background-color: #ff6600;
        }

        #Login-button:hover,
        #book-button:hover {
            background-color: #ff9933;
        }

        .event-list {
            margin: 20px;
        }

        .event {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            cursor: pointer;
            background-color: #fff;
            transition: background-color 0.2s;
        }

        .event:hover {
            background-color: #f0f0f0;
        }

        .event h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .event p {
            font-size: 14px;
        }

        .event-details {
            display: none;
            padding: 10px;
            background-color: #f0f0f0;
        }

        .event:hover .event-details {
            display: block;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div><a class="company-name" href="AdminModLogin.php">EventX</a></div>
        <a href="Home.php">Home</a>
        <a href="HomeEvents.php">Events</a>
        <a href="HomeServices.php">Services</a>
        <a href="HomeBlog.php">Blog</a>
        <a href="HomeGallery.php">Gallery</a>
        <a href="HomeVenue.php">Venue</a>
        <a href="HomeEventSupport.php">Event Support</a>
        <a href="HomeTicketVerify.php">Verify Ticket</a>
        <a id="Login-button" href="UserLogin.php">Login</a>
        <a id="book-button" href="UserTicket.php">Book Now</a>
    </div>

    <div class="event-list">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "event_management";

        // Create a connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT event_name, event_date, event_details FROM events ORDER BY event_date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="event">';
                echo '<h2>' . $row['event_name'] . '</h2>';
                echo '<p>Date: ' . $row['event_date'] . '</p>';
                echo '<div class="event-details">' . $row['event_details'] . '</div>';
                echo '</div>';
            }
        } else {
            echo "No events found.";
        }

        $conn->close();
        ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
