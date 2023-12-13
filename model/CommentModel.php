<?php
class CommentModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAdminInfo($id) {
        $query = "SELECT * FROM admin_mod WHERE id = '$id'";
        $result = mysqli_query($this->conn, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            return $row;
        }

        return null;
    }

    public function getCommentsWithStatus($status) {
        $sql = "SELECT * FROM comments WHERE status = $status";
        $res = mysqli_query($this->conn, $sql);

        $comments = [];
        while ($row = mysqli_fetch_assoc($res)) {
            $comments[] = $row;
        }

        return $comments;
    }

    public function updateCommentStatus($commentId, $newStatus) {
        $sqlUpdateStatus = "UPDATE comments SET status = $newStatus WHERE id = $commentId";
        mysqli_query($this->conn, $sqlUpdateStatus);
    }
}
