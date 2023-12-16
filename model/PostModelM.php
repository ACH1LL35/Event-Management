<?php
class PostModelM {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllPosts() {
        $posts = array();

        $sql = "SELECT * FROM posts";
        $result = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }

        return $posts;
    }

    public function updatePostStatus($postId, $status) {
        $sqlUpdateStatus = "UPDATE posts SET status = $status WHERE id = $postId";
        mysqli_query($this->conn, $sqlUpdateStatus);
    }
}
?>
