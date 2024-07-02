<!DOCTYPE html>
<html lang="en">
<head>
    <title>EventX - Image Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../visuals/images/gal.jpg'); /* Path to your background image in the "images" folder */
            margin: 0;
            padding: 0;
        }

        /* CSS styles for the gallery */
        .gallery img {
            width: 200px; /* Set the desired width */
            max-width: 100%; /* Ensure images don't exceed their original size */
            height: auto;
            margin: 10px;
            cursor: pointer;
        }

    </style>
</head>
<body>
    <div class="gallery-details">
        <?php
        $dbHost = 'localhost';
        $dbUser = 'root';
        $dbPass = '';
        $dbName = 'host';
        $basePath = "../host/assets/"; // Adjust the base path as needed

        try {
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if 'bid' parameter is provided in the URL
            if (isset($_GET['bid'])) {
                $bid = $_GET['bid'];
                
                // Prepare SQL statement to fetch blog details by 'bid'
                $stmt = $pdo->prepare("SELECT bid, btitle, bintro, bdesc, bimag FROM blogs WHERE bid = :bid");
                $stmt->bindParam(':bid', $bid, PDO::PARAM_INT);
                $stmt->execute();

                $details = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($details) {
                    // Display blog details
                    echo '<img src="' . $basePath . $details['bimag'] . '" alt="Gallery Image" class="gallery-image">';
                    echo '<h2>' . htmlspecialchars($details['btitle']) . '</h2>';
                    echo '<p>' . htmlspecialchars($details['bintro']) . '</p>';
                    echo '<p>' . htmlspecialchars($details['bdesc']) . '</p>';
                } else {
                    // No blog found for the provided 'bid'
                    echo 'Image details not found for ID ' . $bid;
                }
            } else {
                // 'bid' parameter is not provided in the URL
                echo 'ID not provided in the URL.';
            }

        } catch (PDOException $e) {
            // Catch any PDO errors and display the message
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</body>
</html>
