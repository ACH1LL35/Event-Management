<?php
class PostControllerH {
    private $model;

    public function __construct($conn) {
        include('../model/PostModelH.php');
        $this->model = new PostModelH($conn);
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['hide'])) {
                $this->model->hidePost($_POST['hide']);
            } elseif (isset($_POST['unhide'])) {
                $this->model->unhidePost($_POST['unhide']);
            }
        }
    }

    public function getHiddenPosts() {
        return $this->model->getHiddenPosts();
    }
}
?>
