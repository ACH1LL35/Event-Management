<?php

class VenueModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllEvents() {
        $events = [];
        $query = "SELECT * FROM venues";
        $result = mysqli_query($this->conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }

        return $events;
    }

    public function updateVenueDetails($venue_id, $newVenueName, $newVenueFee) {
        $query = "UPDATE venues SET venue_name = '$newVenueName', venue_fee = '$newVenueFee' WHERE venue_id = '$venue_id'";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return "Venue  details updated successfully.";
        } else {
            return "Error updating venue details: " . mysqli_error($this->conn);
        }
    }
}

?>
