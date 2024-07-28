<?php
class ModeratorRegistrationController {
    private $model;
    private $error;

    public function __construct($conn) {
        include('../model/ModeratorRegistrationModel.php');
        $this->model = new ModeratorRegistrationModel($conn);
        $this->error = "";
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
            $this->processRegistration();
        }
    }

    private function processRegistration() {
        $uname = $_POST["uname"];
        $email = $_POST["email"];
        $password = $_POST["password"]; // Don't hash the password

        $error = $this->model->registerAdmin($uname, $email, $password);
        $this->error = $error;
    }

    public function getError() {
        return $this->error;
    }
}
?>
