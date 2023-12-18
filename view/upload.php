<?php
include("../view/AdminSidebar.php");
include_once('../controller/GalleryController.php');

$controller = new GalleryController();

// If logout is requested, handle it in the controller
if (isset($_POST['logout'])) {
    $controller->logout();
}

// Fetch user details from the controller
$userData = $controller->getUserDetails();

// Show upload form or handle upload based on the request
if (isset($_POST['upload'])) {
    $controller->handleUpload();
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        p {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Display user details -->
    <p>Welcome, <?php echo $userData['uname']; ?>!</p>

    <!-- Your upload form HTML goes here -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <!-- Form fields for image upload -->
        <input type="text" name="title" placeholder="Image Title" required>
        <textarea name="description" placeholder="Image Description" required></textarea>
        <input type="file" name="image" accept="image/*" required>

        <!-- Submit button -->
        <button type="submit" name="upload">Upload Image</button>
    </form>

</body>
</html>
<?php
}
?>
