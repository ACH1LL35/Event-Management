<?php

class PublishTicketModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createEvent($event_name, $venue, $ticket_price, $total_tickets) {
        $sql = "INSERT INTO ticket_cr (event_name, venue, ticket_price, total_tickets, available_tickets) VALUES ('$event_name', '$venue', $ticket_price, $total_tickets, $total_tickets)";

        if ($this->conn->query($sql) === TRUE) {
            return "Event created successfully.";
        } else {
            return "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }
}

?>
