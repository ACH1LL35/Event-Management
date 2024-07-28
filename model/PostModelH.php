<?php
class PostModelH {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getHiddenPosts() {
        $hiddenPosts = array();

        $sql = "SELECT * FROM posts WHERE status = 0";
        $result = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $hiddenPosts[] = $row;
        }

        return $hiddenPosts;
    }

    public function hidePost($postId) {
        $sqlUpdateStatus = "UPDATE posts SET status = 0 WHERE id = $postId";
        mysqli_query($this->conn, $sqlUpdateStatus);
    }

    public function unhidePost($postId) {
        $sqlUpdateStatus = "UPDATE posts SET status = 1 WHERE id = $postId";
        mysqli_query($this->conn, $sqlUpdateStatus);
    }
}
?>
