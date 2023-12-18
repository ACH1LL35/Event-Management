<?php
include("../view/AdminSidebar.php");
include_once('../controller/GalleryController.php');

$controller = new GalleryController();

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
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #upload-container {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        #upload-container form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            margin: 0 auto;
        }

        #upload-container input,
        #upload-container textarea {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        #upload-container input[type="file"] {
            padding: 10px 0;
        }

        #upload-container button {
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        #upload-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div id="upload-container">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <!-- Form fields for image upload -->
            <input type="text" name="title" placeholder="Image Title" required>
            <textarea name="description" placeholder="Image Description" required></textarea>
            <input type="file" name="image" accept="image/*" required>

            <!-- Submit button -->
            <button type="submit" name="upload">Upload Image</button>
        </form>
    </div>

</body>

</html>

<?php
}
?>
