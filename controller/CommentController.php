<?php
session_start();
include("view/AdminSidebar.php");
include("CommentModel.php");

$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$commentModel = new CommentModel($conn);

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: start.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: start.php");
    exit();
}

$id = $_SESSION['id'];
$adminInfo = $commentModel->getAdminInfo($id);

if ($adminInfo) {
    $username = $adminInfo['uname'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['hide'])) {
        $commentId = $_POST['hide'];
        $commentModel->updateCommentStatus($commentId, 0);
    } elseif (isset($_POST['unhide'])) {
        $commentId = $_POST['unhide'];
        $commentModel->updateCommentStatus($commentId, 1);
    }
}

$comments = $commentModel->getCommentsWithStatus(0);

include("CommentView.php");
