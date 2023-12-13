<?php
class AdminLoginModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "event_management");

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function authenticateUser($id, $password) {
        $sql = "SELECT * FROM admin_mod WHERE (id = ? OR email = ?) AND password = ? AND status = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $id, $id, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        $userData = null;

        if ($result->num_rows === 1) {
            $userData = $result->fetch_assoc();
        }

        $stmt->close();
        return $userData;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>
