<?php
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
    // Include the view
    include_once('../view/upload.php');
}
?>
