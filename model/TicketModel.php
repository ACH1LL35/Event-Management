<?php

class TicketModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllEvents() {
        $events = [];
        $query = "SELECT * FROM ticket_cr";
        $result = mysqli_query($this->conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }

        return $events;
    }

    public function updateEventDetails($showId, $newEventVenue, $newTicketPrice, $newTotalTickets, $newAvailableTickets) {
        $query = "UPDATE ticket_cr SET venue = '$newEventVenue', ticket_price = '$newTicketPrice', total_tickets = '$newTotalTickets', available_tickets = '$newAvailableTickets' WHERE Showid = '$showId'";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return "Event details updated successfully.";
        } else {
            return "Error updating event details: " . mysqli_error($this->conn);
        }
    }
}

?>
