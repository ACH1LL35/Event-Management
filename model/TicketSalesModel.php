<?php

class TicketSalesModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getTicketSalesList() {
        $sql = "SELECT * FROM purchase_info";
        $result = mysqli_query($this->conn, $sql);

        $ticketSalesList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $ticketSalesList[] = $row;
        }

        return $ticketSalesList;
    }
}

?>
