<?php
class PostControllerM {
    private $model;

    public function __construct($conn) {
        include('../model/PostModelM.php');
        $this->model = new PostModelM($conn);
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['hide'])) {
                $this->model->updatePostStatus($_POST['hide'], 0);
            } elseif (isset($_POST['unhide'])) {
                $this->model->updatePostStatus($_POST['unhide'], 1);
            }
        }
    }

    public function getAllPosts() {
        return $this->model->getAllPosts();
    }
}
?>
