<?php
session_start();
include("../view/AdminSidebar.php");

if (isset($_POST['logout'])) {
    require_once("../controller/logoutController.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: ../start.php");
    exit();
}

$id = $_SESSION['id'];
require_once("../model/commentModelH.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once("../controller/commentActionControllerH.php");
}

$result = getAdminDetails($id);

if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['uname'];
}
require_once("../view/commentViewH.php");
?>
