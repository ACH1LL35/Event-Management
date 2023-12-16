<?php
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function getAdminDetails($id) {
    global $conn;
    $query = "SELECT * FROM admin_mod WHERE id = '$id'";
    return mysqli_query($conn, $query);
}
?>
