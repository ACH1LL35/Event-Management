<?php include 'HomeTopBar.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>EventX - Your Event Partner</title>
    <style>
        /* Basic CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/gal.jpg'); /* Path to your background image in the "images" folder */
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

        /* CSS styles for the gallery */
        .gallery img {
            max-width: 23%; /* Adjust the image size as needed */
            height: auto;
            margin: 10px;
        }
    </style>
</head>
<body>

    <div class="gallery">
        <?php
        $galleryPath = 'gallery/'; // Relative path to your gallery folder

        // Get all image files in the gallery folder
        $images = glob($galleryPath . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);

        foreach ($images as $image) {
            echo '<img src="' . $image . '" alt="Gallery Image">';
        }
        ?>
    </div>
    <?php include 'view/footer.php'; ?>
</body>
</html>
