<!DOCTYPE html>
<html lang="en">
<head>
    <title>EventX - Image Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/gal.jpg'); /* Path to your background image in the "images" folder */
            margin: 0;
            padding: 0;
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

        /* CSS styles for the visuals/gallery */
        /* CSS styles for the visuals/gallery */
            .visuals/gallery img {
                width: 20px; /* Set the desired width */
                max-width: 100%; /* Ensure images don't exceed their original size */
                height: auto;
                margin: 10px;
                cursor: pointer;
            }


        /* Styles for the modal (popup) */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 80%;
            max-height: 80%;
            overflow: auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
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
        <a href="Homevisuals/gallery.php">visuals/gallery</a>
        <a href="HomeVenue.php">Venue</a>
        <a href="HomeEventSupport.php">Event Support</a>
        <a href="HomeTicketVerify.php">Verify Ticket</a>
        <a id="Login-button" href="UserLogin.php">Login</a>
        <a id="book-button" href="UserTicket.php">Book Now</a>
    </div>

    <div class="visuals/gallery-details">
        <?php
            $dbHost = 'localhost';
            $dbUser = 'root';
            $dbPass = '';
            $dbName = 'event_management';
            $basePath = "visuals/gallery/"; // Adjust the base path as needed

            try {
                $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $stmt = $pdo->prepare("SELECT title, description, image_path, created_at FROM visuals/gallery_data WHERE id = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();

                    $details = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($details) {
                        // With this line
                        echo '<img src="' . $basePath . $details['image_path'] . '" alt="visuals/gallery Image" style="width: 200px; max-width: 100%; height: auto; margin: 10px; cursor: pointer;">';
                        echo '<h2>' . $details['title'] . '</h2>';
                        echo '<p>' . $details['description'] . '</p>';
                        echo '<p>created_at: ' . $details['created_at'] . '</p>';
                    } else {
                        echo 'Image details not found for ID ' . $id;
                    }
                } else {
                    echo 'ID not provided in the URL.';
                }

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        ?>
    </div>

    <?php include 'view/footer.php'; ?>
</body>
</html>
