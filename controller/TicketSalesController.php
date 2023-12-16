<?php

class TicketSalesController {
    private $model;
    private $id;

    public function __construct($id) {
        include('../model/TicketSalesModel.php');
        $this->model = new TicketSalesModel($this->getConnection());
        $this->id = $id;
    }

    public function getTicketSalesList() {
        return $this->model->getTicketSalesList();
    }

    private function getConnection() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "event_management";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}

?>
