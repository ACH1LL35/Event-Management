<?php

class PublishTicketController {
    private $model;
    private $id;

    public function __construct($id) {
        include('../model/PublishTicketModel.php');
        $this->model = new PublishTicketModel($this->getConnection());
        $this->id = $id;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $event_name = $_POST["event_name"];
            $venue = $_POST["venue"];
            $ticket_price = $_POST["ticket_price"];
            $total_tickets = $_POST["total_tickets"];

            echo $this->model->createEvent($event_name, $venue, $ticket_price, $total_tickets);
        }
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
