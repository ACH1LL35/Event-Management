<?php

class QueryModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllQueries() {
        $queries = array();

        $sql = "SELECT * FROM query";
        $result = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $queries[] = $row;
        }

        return $queries;
    }
}

?>
