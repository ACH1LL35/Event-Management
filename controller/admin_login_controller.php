<?php
include('model/admin_login_model.php');

class AdminLoginController {
    private $model;

    public function __construct() {
        $this->model = new AdminLoginModel();
    }

    public function start() {
        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $password = $_POST['password'];

            $userData = $this->model->authenticateUser($id, $password);

            if ($userData) {
                $_SESSION['id'] = $userData['id'];

                if ($userData['type'] === 'admin') {
                    header("Location: dash.php");
                } elseif ($userData['type'] === 'mod') {
                    header("Location: ModPanel.php");
                } else {
                    $loginMessage = "Invalid user type";
                }
            } else {
                $loginMessage = "Invalid user ID, email, password, or user status. Please contact support.";
            }
        }

        include('view/admin_login_view.php');
        $this->model->closeConnection();
    }
}

$controller = new AdminLoginController();
$controller->start();
?>
