<!-- topbar.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Blog</title>
    <style>
        /* Basic CSS styles for the top bar */
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
            background-color: #ff6600;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        #Login-button:hover,
        #book-button:hover {
            background-color: #ff9933;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/bg.jpg'); /* Path to your background image in the "images" folder */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .top-bar {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: relative; /* Add this line for positioning */
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
            cursor: pointer; /* Add this line to change the cursor to a pointer on hover */
        }

        .company-name:hover {
            text-decoration: underline;
        }

        #Login-button {
            position: absolute;
            top: 20px;
            right: 10px;
            background-color: #ff6600;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        #Login-button:hover {
            background-color: #ff9933;
        }

        #book-button {
            position: absolute;
            top: 20px;
            right: 80px;
            background-color: #ff6600;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        #book-button:hover {
            background-color: #ff9933;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div><a class="company-name" href="start.php">EventX</a></div>
        <a href="Home.php">Home</a>
        <a href="HomeEvents.php">Events</a>
        <a href="HomeServices.php">Services</a>
        <a href="HomeBlog.php">Blog</a>
        <a href="index.php">visuals/gallery</a>
        <a href="HomeVenue.php">Venue</a>
        <a href="HomeEventSupport.php">Event Support</a>
        <a href="HomeTicketVerify.php">Verify Ticket</a>
        <a id="Login-button" href="UserLogin.php">Login</a>
        <a id="book-button" href="UserTicket.php">Book Now</a>
    </div>
</body>
</html>
