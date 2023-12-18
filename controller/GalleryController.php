<?php
session_start();

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
        $title = mysqli_real_escape_string($this->galleryModel->getConnection(), $_POST['title']);
        $description = mysqli_real_escape_string($this->galleryModel->getConnection(), $_POST['description']);

        // ... (rest of the code remains the same)

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

    // Add more methods as needed
}
?>
