<?php

include('controller/galleryController.php');

$controller = new galleryController();

if (isset($_POST['upload'])) {
    $controller->handleUpload();
} else {
    $controller->showUploadForm();
}
?>
