<?php

class QueryController {
    private $model;

    public function __construct($conn) {
        include('../model/QueryModel.php');
        $this->model = new QueryModel($conn);
    }

    public function handleRequest() {
        // Handle any request if needed
    }

    public function getAllQueries() {
        return $this->model->getAllQueries();
    }
}

?>
