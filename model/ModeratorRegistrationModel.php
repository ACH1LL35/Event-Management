<?php
class ModeratorRegistrationModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registerAdmin($uname, $email, $password) {
        $error_message = ""; // Initialize an empty error message

        // Check if the username already exists in the database
        $checkUsernameQuery = "SELECT * FROM admin_mod WHERE uname='$uname'";
        $resultUsername = $this->conn->query($checkUsernameQuery);

        // Check if the email already exists in the database
        $checkEmailQuery = "SELECT * FROM admin_mod WHERE email='$email'";
        $resultEmail = $this->conn->query($checkEmailQuery);

        if ($resultUsername->num_rows > 0) {
            $error_message = "Username already exists. Please choose a different username.";
        } elseif ($resultEmail->num_rows > 0) {
            $error_message = "Email address is already registered.";
        } else {
            // Neither username nor email is already in use, so proceed with registration
            $sql = "INSERT INTO admin_mod (uname, email, password, type, status) VALUES ('$uname', '$email', '$password', 'mod', '1')";

            if ($this->conn->query($sql) === TRUE) {
                return "Registration successful!";
            } else {
                return "Error: " . $sql . "<br>" . $this->conn->error;
            }
        }

        return $error_message;
    }
}
?>
