<?php
session_start();

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the Login page
    session_destroy();
    header("Location: AdminModLogin.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: AdminModLogin.php");
    exit();
}

$id = $_SESSION['id'];
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM admin_mod WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['uname']; // Update to use the correct variable name
    // $email = $row['email'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Image Upload and Admin Page</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #menu {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 20px;
        }

        #content {
            flex: 1;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            flex-direction: column; /* Center vertically */
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin: 1px 0;
        }

        h2 {
            background-color: #000;
            color: #fff;
            padding: 15px 545px; /* Increase the left and right padding for horizontal size */
            text-align: center;
            margin-top: 20px;
        }



        a {
            display: block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: left;
            border: 2px solid #007BFF;
            border-radius: 3px;
            cursor: pointer;
            width: 200px;
            text-decoration: none;
            margin-bottom: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }

        /* Styles for the image upload form */
        .image-upload-form {
            text-align: center;
            margin: 20px;
            padding: 20px;
            border: 1px solid #007BFF; /* Add a border */
            border-radius: 5px;
            width: 300px; /* Set the width */
            background-color: #fff;
        }

        .image-upload-form input[type="file"] {
            margin: 10px 0;
        }

        .image-upload-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            border: 2px solid #007BFF;
            border-radius: 3px;
            cursor: pointer;
        }

        .image-upload-form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Styles for the logout form */
        .logout-form {
            text-align: center;
        }

        .logout-form .logout-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            border: 2px solid #007BFF;
            border-radius: 3px;
            cursor: pointer;
            width: 200px;
            text-decoration: none;
        }

        .logout-form .logout-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="menu">
        <form class="logout-form" method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
        <h1>Welcome, <?php echo $username; ?>!</h1>
        <ul>
            <li><a href="AdminPanel.php">Home</a></li>
            <li><a href="AdminEvent.php">CREATE EVENT</a></li>
            <li><a href="AdminEventHistory.php">EVENT HISTORY</a></li>
            <li><a href="AdminEventCal.php">EVENT CALENDAR</a></li>
            <li><a href="AdminTicketCreation.php">TICKET PUBLISH</a></li>
            <li><a href="AdminTicketList.php">TICKET SALE LIST</a></li>
            <li><a href="AdminAnalysis.php">ANALYSIS</a></li>
            <li><a href="AdminComplaint.php">COMPLAINT LIST</a></li>
            <li><a href="AdminModAccess.php">MODERATOR ACCESS</a></li>
            <li><a href="AdminModManagement.php">MODERATOR MANAGEMENT</a></li>
            <li><a href="AdminPostModeration.php">POST MODERATION</a></li>
            <li><a href="#">POST MODERATION HISTORY</a></li>
            <li><a href="AdminCommentModeration.php">COMMENT MODERATION</a></li>
            <li><a href="#">COMMENT MODERATION HISTORY</a></li>
            <li><a href="#">QUERY FEEDBACK</a></li>
            <li><a href="#">QOUTATION FEEDBACK</a></li>
            <li><a href="AdminAdd2Gallary.php">ADD TO GALLERY</a></li>
            <li><a href="AdminUserManagement.php">USER MANAGEMENT</a></li>
        </ul>
    </div>
    <div id="content">
        <h2>Image Upload</h2>
        <form class="image-upload-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="image" accept="image/*">
            <input type="submit" name="upload" value="Upload Image">
        </form>

        <?php
        if (isset($_POST['upload'])) {
            // Define the target directory on the server where you want to save the images
            $targetDirectory = 'C:/xampp/htdocs/project/gallery/';

            // Get the uploaded file information
            $uploadedFile = $_FILES['image'];

            // Check if a file was uploaded
            if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
                // Generate a unique file name to prevent overwriting
                $targetFile = $targetDirectory . uniqid() . '_' . $uploadedFile['name'];

                // Move the uploaded file to the target directory on the server
                if (move_uploaded_file($uploadedFile['tmp_name'], $targetFile)) {
                    echo "File uploaded successfully.";
                } else {
                    echo "Failed to upload the file.";
                }
            } else {
                echo "Error uploading the file: " . $uploadedFile['error'];
            }
        }
        ?>
    </div>
</body>
</html>