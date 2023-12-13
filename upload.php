<?php
session_start();
include('controller/GalleryController.php');

$controller = new GalleryController();

if (isset($_POST['upload'])) {
    $controller->handleUpload();
} else {
    $controller->showUploadForm();
}
?>
