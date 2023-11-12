<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 20px;
        }

        form {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            width: 300px;
            margin: 0 auto;
        }

        form input {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h1>Administrator Login</h1>
    <form method="post" action="">
        ID or Email: <input type="text" name="id" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>

    <?php
    session_start(); // Start the session

    // Database connection details
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "event_management";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input
        $id = $_POST['id'];
        $password = $_POST['password'];

        // Query the database for user information based on type and status
        $sql = "SELECT * FROM admin_mod WHERE (id = ? OR email = ?) AND password = ? AND status = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $id, $id, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($row['type'] === 'admin') {
                $_SESSION['id'] = $row['id']; // Store user ID in session
                header("Location: AdminPanel.php");
            } elseif ($row['type'] === 'mod') {
                $_SESSION['id'] = $row['id']; // Store user ID in session
                header("Location: ModPanel.php");
            } else {
                echo "Invalid user type";
            }
        } else {
            echo "Invalid user ID, email, password, or user status. Please contact support.";
        }

        $stmt->close();
    }

    $conn->close();
    ?>
</body>
</html>
