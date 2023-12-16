<?php

class TicketAuditModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllTicketAuditData() {
        $ticketAuditData = array();

        $sql = "SELECT * FROM ticket_cr";
        $result = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $ticketAuditData[] = $row;
        }

        return $ticketAuditData;
    }
}

?>
