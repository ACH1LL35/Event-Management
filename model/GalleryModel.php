<?php

class GalleryModel {
    private $conn;

    public function __construct() {
        // Establish a database connection
        $this->conn = $this->getConnection();
    }

    public function getUserDetails($id) {
        // Fetch user details based on $id
        $query = "SELECT * FROM admin_mod WHERE id = '$id'";
        $result = mysqli_query($this->conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            return $row;
        } else {
            return false;
        }
    }

    public function uploadImage($title, $description, $fileName) {
        // Insert image details into the database
        $insertQuery = "INSERT INTO gallery_data (title, description, image_path) VALUES ('$title', '$description', '$fileName')";
        
        if (mysqli_query($this->conn, $insertQuery)) {
            return true;
        } else {
            return false;
        }
    }

    private function getConnection() {
        // Establish and return a database connection
        $conn = mysqli_connect("localhost", "root", "", "event_management");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
    }

    public function closeConnection() {
        // Close the database connection
        mysqli_close($this->conn);
    }
}

?>
