<?php

class QuotationController {
    private $model;

    public function __construct($conn) {
        include('../model/QuotationModel.php');
        $this->model = new QuotationModel($conn);
    }

    public function handleRequest() {
        // Handle any request if needed
    }

    public function getAllQuotations() {
        return $this->model->getAllQuotations();
    }
}

?>
