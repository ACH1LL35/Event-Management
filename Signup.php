<?php
$successMessage = "";
$errorMessages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "event_management";

    $mysqli = new mysqli($host, $username, $password, $database);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $name = $mysqli->real_escape_string($_POST['name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $cpassword = $mysqli->real_escape_string($_POST['cpassword']);
    $cnumber = $mysqli->real_escape_string($_POST['cnumber']);

    // Server-side validation
    if (empty($name) || empty($email) || empty($password) || empty($cpassword) || empty($cnumber)) {
        $errorMessages[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages[] = "Invalid email format.";
    }

    if (!preg_match("/^01[3-9]\d{8}$/", $cnumber)) {
        $errorMessages[] = "Enter a valid contact number.";
    }

    if ($password !== $cpassword) {
        $errorMessages[] = "Passwords do not match.";
    }

    if (empty($errorMessages)) {
        // Insert user data into the database without password hashing
        $sql = "INSERT INTO credential (name, email, cnumber, password) VALUES ('$name', '$email', '$cnumber', '$password')"; // Updated SQL query

        if ($mysqli->query($sql) === true) {
            $successMessage = "Registration successful!";
        } else {
            $errorMessages[] = "Error: " . $sql . "<br>" . $mysqli->error;
        }
    }

    // Close the database connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var cnumber = document.getElementById("cnumber").value;
            var password = document.getElementById("password").value;
            var cpassword = document.getElementById("cpassword").value;

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var cnumberRegex = /^01[3-9]\d{8}$/;

            // Clear previous error messages
            document.getElementById("nameError").innerHTML = "";
            document.getElementById("emailError").innerHTML = "";
            document.getElementById("cnumberError").innerHTML = "";
            document.getElementById("passwordError").innerHTML = "";
            document.getElementById("cpasswordError").innerHTML = "";

            if (name.trim() === "") {
                document.getElementById("nameError").innerHTML = "Please enter your full name.";
                return false;
            }

            if (!emailRegex.test(email)) {
                document.getElementById("emailError").innerHTML = "Invalid email format.";
                return false;
            }

            if (!cnumberRegex.test(cnumber)) {
                document.getElementById("cnumberError").innerHTML = "Enter a valid contact number.";
                return false;
            }

            if (password.trim() === "") {
                document.getElementById("passwordError").innerHTML = "Please enter a password.";
                return false;
            }

            if (cpassword.trim() === "") {
                document.getElementById("cpasswordError").innerHTML = "Please confirm your password.";
                return false;
            }

            if (password !== cpassword) {
                document.getElementById("cpasswordError").innerHTML = "Passwords do not match.";
                return false;
            }

            return true;
        }
    </script>

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: inline-block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .text-center {
            text-align: center;
        }

        .warning {
            color: red;
        }
        .success-message {
            text-align: center;
            background-color: #4CAF50; /* Green background */
            color: #fff;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($errorMessages)) : ?>
            <div class="warning">
                <?php echo implode("<br>", $errorMessages); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)) : ?>
            <div class="success-message">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <h2>Sign Up</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name">
                <p id="nameError" class="warning"></p>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <p id="emailError" class="warning"></p>
            </div>
            <div class="form-group">
                <label for="cnumber">Contact Number:</label>
                <input type="text" id="cnumber" name="cnumber" pattern="01[3-9]\d{8}" title="Enter a valid contact number.">
                <p id="cnumberError" class="warning"></p>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <p id="passwordError" class="warning"></p>
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password:</label>
                <input type="password" id="cpassword" name="cpassword">
                <p id="cpasswordError" class="warning"></p>
            </div>
            <div class="form-group">
                <input type="checkbox" id="agree" name="agree">
                <label for="agree">I agree to the terms and conditions</label>
            </div>
            <div class="form-group text-center">
                <button type="submit" id="signupButton" class="btn">Sign Up</button>
            </div>
        </form>
        <center>
            <p>Already have an account? <a href="UserLogin.php">Login</a></p>
        </center>
    </div>
</body>
</html>
