<?php
// AdminUserController.php

// Include the Model if it's not already included
if (!function_exists('getUserList')) {
    include("../model/AdminUserModel.php");
}

// Handle user actions (ban, unban)
if (isset($_POST['action'])) {
    $userId = $_POST['user_id'];
    $action = $_POST['action'];

    if ($action === 'ban') {
        banUser($userId);
    } elseif ($action === 'unban') {
        unbanUser($userId);
    }
}

// Fetch user list data from the Model
$userList = getUserList();

// Include the View file after setting up the data
include("../view/AdminUserView.php");
?>
