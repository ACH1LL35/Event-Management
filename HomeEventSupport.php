<?php include 'HomeTopBar.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>EventX - Your Event Partner</title>
    <style>
        /* Basic CSS styles... */
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/evsup.jpg'); /* Path to your background image in the "images" folder */
            margin: 0;
            padding: 0;
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

        .content {
            padding: 20px;
        }

        .zigzag {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            margin: 20px;
            padding: 20px;
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .zigzag:nth-child(odd) {
            flex-direction: row-reverse;
        }

        .image {
            width: 1000px; /* Adjust the width as needed */
        }

        .image img {
            max-width: 100%;
            height: auto;
        }

        .description {
            width: 300px;
        }

        .description h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .description p {
            font-size: 14px;
            line-height: 1.6;
        }

        /* Hide radio buttons and labels */
        .image-input {
            display: none;
        }

        .image-label {
            display: block;
            width: 100%;
            background-color: #ff6600;
            color: #fff;
            padding: 5px 10px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
        }

        .image-input:checked + .image-label {
            background-color: #ff9933;
        }

        .image-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            text-align: center;
        }

        .image-popup img {
            max-height: 80%;
            max-width: 80%;
            margin: 10% 0;
        }

        .image-popup:target {
            display: block;
        }
        .center-text {
            text-align: center;
            color: wheat;
        }
        

    </style>
</head>
<body>
    
    <div class="content">
        <h1 class="center-text">Welcome to EventX</h1>
        <p class="center-text" >EventX is your premier event partner, providing a wide range of services and unforgettable experiences for all your special occasions.</p>

        <!-- Display 3 images and descriptions in a zigzag layout -->
        <div class="zigzag">
            <div class="image">
                <img src="images/cel.jpg" alt="Image 1">
                <input type="radio" id="popup1" class="image-input" />
                <div class="image-popup" id="popup1">
                    <img src="images/cel.jpg" alt="Image 1">
                </div>
            </div>
            <div class="description">
                <h1>CELLING</h1>
                <p> [SERVICE LAUNCHING SOON] </p>
                <p> Elevate your event with our stunning ceiling decor that adds a touch of elegance to any venue.</p>
            </div>
        </div>

        <div class="zigzag">
            <div class="image">
                <img src="images/gate.jpg" alt="Image 3">
                <input type="radio" id="popup3" class="image-input" />
                <div class="image-popup" id="popup3">
                    <img src="images/gate.jpg" alt="Image 3">
                </div>
            </div>
            <div class="description">
                <h1>GATE</h1>
                <p> [SERVICE LAUNCHING SOON] </p>
                <p>Our exquisite gate designs welcome guests to an unforgettable experience from the moment they arrive.</p>
            </div>
        </div>

        <div class="zigzag">
            <div class="image">
                <img src="images/stage.jpg" alt="Image 3">
                <input type="radio" id="popup3" class="image-input" />
                <div class="image-popup" id="popup3">
                    <img src="images/stage.jpg" alt="Image 3">
                </div>
            </div>
            <div class="description">
                <h1>STAGE</h1>
                <p> [SERVICE LAUNCHING SOON] </p>
                <p>Transform your stage into a captivating focal point with our expertly crafted and customizable stage decorations.</p>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
