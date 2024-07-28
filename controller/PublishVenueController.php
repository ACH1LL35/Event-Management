<?php

class PublishVenueController {
    private $model;
    private $id;

    public function __construct($id) {
        include('../model/PublishVenueModel.php');
        $this->model = new PublishVenueModel($this->getConnection());
        $this->id = $id;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $venue_name = $_POST["venue_name"];
            $venue_fee = $_POST["venue_fee"];

            echo $this->model->createVenue($venue_name, $venue_fee);
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
