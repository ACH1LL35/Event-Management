<?php
class ModeratorListController {
    private $model;

    public function __construct($conn) {
        include('../model/ModeratorListModel.php');
        $this->model = new ModeratorListModel($conn);
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['ban'])) {
                $this->model->banModerator($_POST['ban']);
            } elseif (isset($_POST['uban'])) {
                $this->model->unbanModerator($_POST['uban']);
            }
        }
    }

    public function getModerators() {
        return $this->model->getModerators();
    }
}
?>
