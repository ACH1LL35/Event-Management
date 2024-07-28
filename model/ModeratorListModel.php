<?php
class ModeratorListModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getModerators() {
        $moderators = array();

        $sql = "SELECT * FROM admin_mod WHERE type = 'mod'";
        $result = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $moderators[] = $row;
        }

        return $moderators;
    }

    public function banModerator($id) {
        $sql = "UPDATE admin_mod SET status = 0 WHERE id='$id'";
        mysqli_query($this->conn, $sql);
    }

    public function unbanModerator($id) {
        $sql = "UPDATE admin_mod SET status = 1 WHERE id='$id'";
        mysqli_query($this->conn, $sql);
    }
}
?>
