<?php

class TicketAuditController {
    private $model;

    public function __construct($conn) {
        include('../model/TicketAuditModel.php');
        $this->model = new TicketAuditModel($conn);
    }

    public function handleRequest() {
        // Handle any request if needed
    }

    public function getAllTicketAuditData() {
        return $this->model->getAllTicketAuditData();
    }
}

?>
