<?php
function hideComment($commentId) {
    global $conn;
    $sqlUpdateStatus = "UPDATE comments SET status = 0 WHERE id = $commentId";
    mysqli_query($conn, $sqlUpdateStatus);
}

function unhideComment($commentId) {
    global $conn;
    $sqlUpdateStatus = "UPDATE comments SET status = 1 WHERE id = $commentId";
    mysqli_query($conn, $sqlUpdateStatus);
}
?>
