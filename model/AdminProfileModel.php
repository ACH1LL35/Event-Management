<?php
class AdminProfileModel {
    public $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAdminInfo($id) {
        $query = "SELECT * FROM admin_mod WHERE id = '$id'";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    public function updateUsername($id, $newUsername) {
        $updateQuery = "UPDATE admin_mod SET uname = '$newUsername' WHERE id = '$id'";
        return mysqli_query($this->conn, $updateQuery);
    }

    public function updatePassword($id, $newPassword) {
        $updateQuery = "UPDATE admin_mod SET password = '$newPassword' WHERE id = '$id'";
        return mysqli_query($this->conn, $updateQuery);
    }

    public function getAdminUsername($id) {
        $adminInfo = $this->getAdminInfo($id);

        if ($adminInfo) {
            return $adminInfo['uname'];
        } else {
            return false;
        }
    }

    // Other methods as needed...
}
?>
