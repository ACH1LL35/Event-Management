<?php include 'HomeTopBar.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>EventX - Your Event Partner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/ser.jpg'); /* Path to "images" folder */
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
            width: 1000px;
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
        }
        .color-text {
            color: wheat;
        }

    </style>
</head>
<body>

    <div class="content">
        <h1 class="center-text">Welcome to EventX</h1>
        <p class="center-text , color-text" >EventX is your premier event partner, providing a wide range of services and unforgettable experiences for all your special occasions.</p>

        <div class="zigzag">
            <div class="image">
                <img src="images/ven.jpg" alt="Image 1">
                <input type="radio" id="popup1" class="image-input" />
                <div class="image-popup" id="popup1">
                    <img src="images/ven.jpg" alt="Image 1">
                </div>
            </div>
            <div class="description">
                <h1>VENUE</h1>
                <p> Discover the perfect venue that sets the stage for your event's success.</p>
            </div>
        </div>

        <div class="zigzag">
            <div class="image">
                <img src="images/staff.jpg" alt="Image 3">
                <input type="radio" id="popup3" class="image-input" />
                <div class="image-popup" id="popup3">
                    <img src="images/staff.jpg" alt="Image 3">
                </div>
            </div>
            <div class="description">
                <h1>STAFFING</h1>
                <p>Our professional staffing ensures seamless execution from start to finish, leaving you stress-free.</p>
            </div>
        </div>

        <div class="zigzag">
            <div class="image">
                <img src="images/deco.jpg" alt="Image 3">
                <input type="radio" id="popup3" class="image-input" />
                <div class="image-popup" id="popup3">
                    <img src="images/deco.jpg" alt="Image 3">
                </div>
            </div>
            <div class="description">
                <h1>DECORATION</h1>
                <p> [SERVICE LAUNCHING SOON] </p>
                <p>Elevate the ambiance with our exquisite decorations that create a memorable atmosphere.</p>
            </div>
        </div>

        <div class="zigzag">
            <div class="image">
                <img src="images/sup.jpg" alt="Image 3">
                <input type="radio" id="popup3" class="image-input" />
                <div class="image-popup" id="popup3">
                    <img src="images/sup.jpg" alt="Image 3">
                </div>
            </div>
            <div class="description">
                <h1>SUPPLIES</h1>
                <p> [SERVICE LAUNCHING SOON] </p>
                <p>From supplies to A/V equipment, we've got your event essentials covered..</p>
            </div>
        </div>

        <div class="zigzag">
            <div class="image">
                <img src="images/cat.jpg" alt="Image 3">
                <input type="radio" id="popup3" class="image-input" />
                <div class="image-popup" id="popup3">
                    <img src="images/cat.jpg" alt="Image 3">
                </div>
            </div>
            <div class="description">
                <h1>CATERING</h1>
                <p> [SERVICE LAUNCHING SOON] </p>
                <p>Indulge in culinary delights with our top-notch catering, offering a delectable menu to satisfy every palate.</p>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>