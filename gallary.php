<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../visuals/images/gal.jpg'); /* Path to your background image in the "images" folder */
            margin: 0;
            padding: 0;
        }
        /* CSS styles for the gallery */
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }

        .gallery img {
            max-width: 23%; /* Adjust the image size as needed */
            height: auto;
            margin: 10px;
            cursor: pointer; /* Add cursor pointer to indicate the images are clickable */
        }
    </style>
</head>a
<body>

    <div class="gallery">
        <?php

        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = 'host';
        $basePath = "C:/xampp/htdocs/host/assets/"; // Adjust the base path to the correct directory

        try {
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT bid, bimag FROM blogs");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $row) {
                $imagePath = $basePath . $row['bimag'];

                // Check if the image file exists
                if (file_exists($imagePath)) {
                    echo '<a href="details.php?bid=' . $row['bid'] . '">';
                    echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Blog Image">';
                    echo '</a>';
                } else {
                    echo '<p>Error: Image not found for ID ' . $row['bid'] . '</p>';
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>