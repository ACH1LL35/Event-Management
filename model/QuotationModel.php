<?php

class QuotationModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllQuotations() {
        $quotations = array();

        $sql = "SELECT * FROM quotation";
        $result = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $quotations[] = $row;
        }

        return $quotations;
    }
}

?>
