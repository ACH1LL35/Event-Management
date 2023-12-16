<?php
session_start();

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
    $uname = $row['uname']; // Update to use the correct variable name
    // $email = $row['email'];
}
?>
<?php
include('../model/galleryModel.php');

class galleryController {
    private $galleryModel;

    public function __construct() {
        // Initialize the model
        $this->galleryModel = new galleryModel();

        // Check if session is started
        if (session_status() == PHP_SESSION_NONE) {
        }
    }

    public function showUploadForm() {
        // Fetch user details from the model
        $id = $_SESSION['id'] ?? null;

        if ($id) {
            $userData = $this->galleryModel->getUserDetails($id);

            // Include the view
            include('../view/gallery_upload_view.php');
        } else {
            echo "User ID not found in session.";
        }
    }

    public function handleUpload() {
        // Handle image upload logic
        $title = mysqli_real_escape_string($this->galleryModel->getConnection(), $_POST['title']);
        $description = mysqli_real_escape_string($this->galleryModel->getConnection(), $_POST['description']);

        // Define the target directory on the server where you want to save the images
        $targetDirectory = 'C:/xampp/htdocs/project/visuals/gallery/';

        // Get the uploaded file information
        $uploadedFile = $_FILES['image'];

        // Check if a file was uploaded
        if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
            // Use only the name of the file
            $fileName = $uploadedFile['name'];

            // Generate a unique file name to prevent overwriting
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

    // Add more methods as needed
}

?>
