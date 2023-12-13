<?php

include('controller/visuals/galleryController.php');

$controller = new visuals/galleryController();

if (isset($_POST['upload'])) {
    $controller->handleUpload();
} else {
    $controller->showUploadForm();
}
?>
