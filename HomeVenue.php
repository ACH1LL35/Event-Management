<?php include 'HomeTopBar.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>EventX - Your Event Partner</title>
    <style>
        /* Basic CSS styles... */
        body {
            font-family: Arial, sans-serif;
            background-image: url('visuals/images/ven2.jpg'); /* Path to your background image in the "images" folder */
            margin: 0;
            padding: 0;
            color: #000;
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

        /* Add styles for the content section */
        .content {
            padding: 20px;
        }

        /* Add zigzag class for alternating layout */
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
            width: 600px; /* Adjust the width as needed */
        }

        .image img {
            max-width: 100%;
            height: auto;
        }

        .description {
            color: #000;
            width: 300px;
        }

        .description h2 {
            color: #000;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .description p {
            color: #000;
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

         .button-container {
            display: flex;
            margin-top: 10px;
         }

        .button {
            background-color: #ff6600;
            color: #fff;
            padding: 5px 20px; /* Increase the horizontal padding to make the button wider */
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px; /* Add space to the right of each button */
            text-decoration: none;
            white-space: nowrap; /* Prevent text wrapping */
        }

        .button:hover {
            background-color: #ff9933;
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
                <img src="visuals/images/h1.jpg" alt="Image 1">
                <input type="radio" id="popup1" class="image-input" />
                <div class="image-popup" id="popup1">
                    <img src="visuals/images/h1.jpg" alt="Image 1">
                </div>
            </div>
            <div class="description">
                <h1>HALL - 01</h1>
                <h2> Hall Measurement</h2>
                <p> Mezzanine Floor: 2050 Sq. ft.</p>
                <p> Width: 78´</p>
                <p> Height: 34´</p>
                <p> Length: 205´</p>
                <h2> Interior Type (No. of Seat)</h2>
                <p> Theater: 1600</p>
                <p> Banquet Table: 800</p>
                <p> Class Room: 650</p>
                <p> U-Shape: 300</p>
                <div class="button-container">
                    <!-- Create a button for the popup -->
                    <a class="button" href="images/h1-1.jpg">Full Banquet Dining</a>
                    <a class="button" href="images/h1-2.jpg">Banquet Dining with Stage</a>
                </div>
                <div class="button-container">
                    <a class="button" href="images/h1-3.jpg">Theater with Stage</a>
                    <a class="button" href="images/h1-4.jpg">Banquet with Waiting Stage</a>
                </div>
            </div>
        </div>

        <div class="zigzag">
            <div class="image">
                <img src="visuals/images/h2.jpg" alt="Image 2">
                <input type="radio" id="popup2" class="image-input" />
                <div class="image-popup" id="popup2">
                    <img src="visuals/images/h2.jpg" alt="Image 2">
                </div>
            </div>
            <div class "description">
                <h1>HALL - 02</h1>
                <h2> Hall Measurement</h2>
                <p> Mezzanine Floor: 2050 Sq. ft.</p>
                <p> Width: 78´</p>
                <p> Height: 34´</p>
                <p> Length: 205´</p>
                <h2> Interior Type (No. of Seat)</h2>
                <p> Theater: 1600</p>
                <p> Banquet Table: 800</p>
                <p> Class Room: 65</p>
                <p> U-Shape: 300</p>
                <div class="button-container">
                    <!-- Create a button for the popup -->
                    <a class="button" href="images/h2-1.jpg">Full Banquet Dining</a>
                    <a class="button" href="images/h2-2.jpg">Banquet Dining with Stage</a>
                </div>
                <div class="button-container">
                    <a class="button" href="images/h2-3.jpg">Theater with Stage</a>
                    <a class="button" href="images/h2-4.jpg">Banquet with Waiting Stage</a>
                </div>
            </div>
        </div>

        <div class="zigzag">
            <div class="image">
                <img src="visuals/images/h3.jpg" alt="Image 3">
                <input type="radio" id="popup3" class="image-input" />
                <div class="image-popup" id="popup3">
                    <img src="visuals/images/h3.jpg" alt="Image 3">
                </div>
            </div>
            <div class="description">
                <h1>HALL - 03</h1>
                <h2> Hall Measurement</h2>
                <p>  Mezzanine Floor: 2050 Sq. ft.</p>
                <p> Width: 78´</p>
                <p> Height: 34´</p>
                <p> Length: 205´</p>
                <h2> Interior Type (No. of Seat)</h2>
                <p> Theater: 1600</p>
                <p> Banquet Table: 800</p>
                <p> Class Room: 650</p>
                <p> U-Shape: 300</p>
                <div class="button-container">
                    <!-- Create a button for the popup -->
                    <a class="button" href="images/h3-1.jpg">Full Banquet Dining</a>
                    <a class="button" href="images/h3-2.jpg">Banquet Dining with Stage</a>
                </div>
                <div class="button-container">
                    <a class="button" href="images/h3-3.jpg">Theater with Stage</a>
                    <a class="button" href="images/h3-4.jpg">Banquet with Waiting Stage</a>
                </div>
            </div>
        </div>
    </div>
    <?php include 'view/footer.php'; ?>
</body>
</html>
