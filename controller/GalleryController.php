<?php

// session_start();

include_once('../model/GalleryModel.php');

class GalleryController {
    private $galleryModel;

    public function __construct() {
        // Initialize the model
        $this->galleryModel = new GalleryModel();
    }

    public function showUploadForm() {
        // Fetch user details from the model
        $userData = $this->getUserDetails();

        // Include the view
        include_once('../view/upload.php');
    }

    public function handleUpload() {
        // Handle image upload logic
        $title = mysqli_real_escape_string($this->galleryModel->conn, $_POST['title']);
        $description = mysqli_real_escape_string($this->galleryModel->conn, $_POST['description']);

        // Get the uploaded file information
        $uploadedFile = $_FILES['image'];

        // Check if a file was uploaded
        if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
            // Use only the name of the file
            $fileName = $uploadedFile['name'];

            // Generate a unique file name to prevent overwriting
            $targetDirectory = 'C:/xampp/htdocs/project/visuals/gallery/';
            $targetFile = $targetDirectory . $fileName;

            // Move the uploaded file to the target directory on the server
            if (move_uploaded_file($uploadedFile['tmp_name'], $targetFile)) {
                // Insert data into the database
                $uploadResult = $this->galleryModel->uploadImage($title, $description, $fileName);

                if ($uploadResult) {
                    echo "File uploaded successfully.";
                } else {
                    echo "Failed to upload the file. Error in database operation.";
                }
            } else {
                echo "Failed to upload the file.";
            }
        } else {
            echo "Error uploading the file: " . $uploadedFile['error'];
        }

        // Close the database connection
        $this->galleryModel->closeConnection();
    }

    public function logout() {
        // Destroy the session and redirect to the Login page
        session_destroy();
        header("Location: start.php");
        exit();
    }

    public function getUserDetails() {
        $id = $_SESSION['id'] ?? null;

        if ($id) {
            return $this->galleryModel->getUserDetails($id);
        } else {
            return null;
        }
    }
}
?>
