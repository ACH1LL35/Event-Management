<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh; /* Set a minimum height of the viewport */
            display: flex;
            flex-direction: column;
        }

        .footer {
            margin-top: auto; /* Push the footer to the bottom */
            background-color: #0f3c3d;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }

        .footer a {
            color: white;
            text-decoration: none;
            margin: 10px;
        }

        .footer .footer-links {
            display: flex;
        }

        .footer .line {
            border-top: 1px solid white;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .copyright {
            text-align: center;
            margin: 10px;
        }

        .social-icons {
            display: flex;
            justify-content: flex-end;
            margin-right: 10px;
        }

        .social-icons a {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <!-- Your page content goes here -->
    <div class="footer">
        <div class="footer-links">
            <a href="Privacy.php">Privacy Policy</a>
            <a>||</a>
            <a href="/collection-statement">Collection Statement</a>
            <a>||</a>
            <a href="Term.php">Terms & Conditions</a>
            <a>||</a>
            <a href="Ad.php">Advertise</a>
            <a>||</a>
            <a href="HomeContactUs.php">Contact Us</a>
        </div>
        <div class="social-icons">
            <a href="https://www.instagram.com/" target="_blank">
                <!-- Instagram logo (Replace with the actual logo URL) -->
                <img src="logo/instagram.png" alt="Instagram" width="20" height="20">
            </a>
            <a href="https://twitter.com/" target="_blank">
                <!-- Twitter logo (Replace with the actual logo URL) -->
                <img src="logo/twitter.png" alt="Twitter" width="20" height="20">
            </a>
            <a href="https://www.facebook.com/" target="_blank">
                <!-- Facebook logo (Replace with the actual logo URL) -->
                <img src="logo/facebook.png" alt="Facebook" width="20" height="20">
            </a>
            <a href="https://www.youtube.com/" target="_blank">
                <!-- YouTube logo (Replace with the actual logo URL) -->
                <img src="logo/youtube.png" alt="YouTube" width="20" height="20">
            </a>
        </div>
        <div class="line"></div>
        <div class="copyright">
            © 2023 EventX Bangladesh. All rights reserved. <br> EventX.com.bd is a production of JAZZ Digital Media a division of ZiT.
        </div>
    </div>
</body>
</html>
