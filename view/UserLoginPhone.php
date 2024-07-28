<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "event_management";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = array(); // Create an array to store error messages

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cnumber = $_POST["cnumber"];
    $password = $_POST["password"];

    // Sanitize user input
    $cnumber = $conn->real_escape_string($cnumber);

    // Query to retrieve user data
    $query = "SELECT id, password, status FROM credential WHERE cnumber = '$cnumber'";
    $result = $conn->query($query);

    if (!$result) {
        $errors[] = "Database query error: " . $conn->error;
    } else {
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if ($password === $row["password"]) {
                if ($row["status"] == 1) {
                    $_SESSION["id"] = $row["id"];
                    header("Location: UserProfile.php");
                    exit;
                } else {
                    $errors[] = "Account is not active. Please contact support.";
                }
            } else {
                $errors[] = "Invalid password or Contact Number.";
            }
        } else {
            $errors[] = "Invalid password or Contact Number.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Phone Login</h2>

        <!-- Display errors at the top of the page -->
        <?php if (!empty($errors)) : ?>
            <div style="color: red; text-align: center;">
                <?php foreach ($errors as $error) : ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="cnumber">Contact Number:</label>
                <input type="text" id="cnumber" name="cnumber" pattern="01[3-9]\d{8}" title="Enter a valid contact number starting with 013, 014, 015, 016, 017, 018, or 019" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn">Login</button>
            </div>
        </form>
        <center>
        <p><a href="Recover.php">Forgot password?</a></p>
        <p>Login Using <a href="UserLoginEmail.php">E-Mail</a> Or <a href="UserLogin.php">ID</a></p>
        </center>
        <center>
        <p>Don't have an account? <a href="Signup.php">Signup</a></p>
        </center>
        <center>
        <p><a href="Home.php">Back To Home</a></p>
        </center>
    </div>
</body>
</html>