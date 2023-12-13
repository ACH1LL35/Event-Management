<?php
include('AdminSidebar.php');

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the Login page
    session_destroy();
    header("Location: start.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: start.php");
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
    $username = $row['uname'];
}

if (isset($_POST['upload'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Define the target directory on the server where you want to save the images
    $targetDirectory = 'C:/xampp/htdocs/project/visuals/gallery/';

    // Get the uploaded file information
    $uploadedFile = $_FILES['image'];

    // Check if a file was uploaded
    if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
        // Use only the name of the file
        $fileName = $uploadedFile['name'];

        // Generate a unique file name to prevent overwriting
        // $targetFile = $targetDirectory . uniqid() . '_' . $fileName;
        $targetFile = $targetDirectory . $fileName;


        // Move the uploaded file to the target directory on the server
        if (move_uploaded_file($uploadedFile['tmp_name'], $targetFile)) {
            // Insert data into the database
            $insertQuery = "INSERT INTO visuals/gallery_data (title, description, image_path) VALUES ('$title', '$description', '$fileName')";
            if (mysqli_query($conn, $insertQuery)) {
                echo "File uploaded successfully.";
            } else {
                echo "Failed to upload the file. Error: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload the file.";
        }
    } else {
        echo "Error uploading the file: " . $uploadedFile['error'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
    <style>
body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #content {
            flex: 1;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            flex-direction: column; /* Center vertically */
        }

        h2 {
            background-color: #000;
            color: #fff;
            padding: 15px 545px; /* Increase the left and right padding for horizontal size */
            text-align: center;
            margin-top: 20px;
        }

        /* Styles for the image upload form */
        .image-upload-form {
            text-align: left;
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
        }    </style>
</head>
<body>
    <div id="content">
        <h2>Image Upload</h2>
        <form class="image-upload-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" required><br>
            
            <label for="description">Description:</label>
            <textarea name="description" style="width: 300px; height: 85px;"required></textarea>

            <input type="file" name="image" accept="image/*">
            <input type="submit" name="upload" value="Upload Image">
        </form>
    </div>
</body>
</html>
