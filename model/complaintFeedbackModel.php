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

function deleteComplaint($id) {
    global $conn;
    $sql = "DELETE FROM complaint WHERE id='$id'";
    mysqli_query($conn, $sql);
}
?>
