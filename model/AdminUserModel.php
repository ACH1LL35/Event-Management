<?php
// AdminUserModel.php

function getUserList() {
    $userList = array();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "event_management";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to select all data from the credential table
    $sql = "SELECT * FROM credential";
    $result = $conn->query($sql);

    // Check if the query executed successfully
    if (!$result) {
        die("Error: " . $sql . "<br>" . $conn->error);
    }

    // Fetch the result rows as an associative array
    $userList = $result->fetch_all(MYSQLI_ASSOC);

    // Close the database connection
    $conn->close();

    return $userList;
}

function banUser($userId) {
    // Update the status to 0 (banned)
    $sql = "UPDATE credential SET status = 0 WHERE id='$userId'";
    executeQuery($sql);
}

function unbanUser($userId) {
    // Update the status to 1 (unbanned)
    $sql = "UPDATE credential SET status = 1 WHERE id='$userId'";
    executeQuery($sql);
}

function executeQuery($sql) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "event_management";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Query executed successfully
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
