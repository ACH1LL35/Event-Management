<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        h2 {
            background-color: #000;
            color: #fff;
            padding: 15px;
            text-align: center;
            margin-top: 20px;
        }

        /* Styles for the image upload form */
        .image-upload-form {
            text-align: left;
            margin: 20px;
            padding: 20px;
            border: 1px solid #007BFF;
            border-radius: 5px;
            width: 300px;
            background-color: #fff;
        }

        .image-upload-form input[type="text"],
        .image-upload-form textarea,
        .image-upload-form input[type="file"] {
            margin: 10px 0;
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
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
    </style>
</head>
<body>
    <?php include('../view/AdminSidebar.php'); ?>

    <div id="content">
        <h2>Image Upload</h2>
        <form class="image-upload-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" required><br>
            
            <label for="description">Description:</label>
            <textarea name="description" rows="4" required></textarea>

            <label for="image">Choose an image:</label>
            <input type="file" name="image" accept="image/*">
            <input type="submit" name="upload" value="Upload Image">
        </form>
    </div>
</body>
</html>
