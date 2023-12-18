<?php

class PublishVenueModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createVenue($venue_name, $venue_fee) {
        $sql = "INSERT INTO venues (venue_name, venue_fee) VALUES ('$venue_name', '$venue_fee')";

        if ($this->conn->query($sql) === TRUE) {
            return "Venue created successfully.";
        } else {
            return "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }
}

?>
