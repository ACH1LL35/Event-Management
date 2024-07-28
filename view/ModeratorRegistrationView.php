<?php
session_start();
include('../view/AdminSidebar.php');

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the Login page
    session_destroy();
    header("Location: start.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: start.php");
    exit();
}

$id = $_SESSION['id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include('../controller/ModeratorRegistrationController.php');

$moderatorRegistrationController = new ModeratorRegistrationController($conn);
$moderatorRegistrationController->handleRequest();

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Moderator Access Page</title>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #f2f2f2;
        display: flex;
        align-items: flex-start;
        height: 100vh;
        margin: 0;
    }

    #content {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        max-width: 600px;
        margin: 200px auto;
        padding: 40px;
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
        text-align: center;
    }
    /* Styles for the logout form */
    .logout-form {
        text-align: center;
    }

    .logout-form .logout-button {
        padding: 10px 20px;
        background-color: #007BFF;
        color: #ffffff;
        border: 2px solid #007BFF;
        border-radius: 3px;
        cursor: pointer;
        width: 200px;
        text-decoration: none;
    }

    .logout-form .logout-button:hover {
        background-color: #0056b3;
    }
</style></head>
<body>
    <div id="content">
        <div class="container">
            <h2 class="text-center">Moderator Registration Form</h2>

            <!-- Display error message at the top of the form -->
            <div class="warning">
                <?php echo $moderatorRegistrationController->getError(); ?>
            </div>

            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="uname">Username:</label>
                    <input type="text" name="uname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <center>
                    <input type="submit" name="register" value="Register" class="btn">
                </center>
            </form>
        </div>
    </div>
</body>
</html>
?>
