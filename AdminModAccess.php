<?php
session_start();

if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the Login page
    session_destroy();
    header("Location: AdminModLogin.php");
    exit();
}

if (!isset($_SESSION['id'])) {
    header("Location: AdminModLogin.php");
    exit();
}

$id = $_SESSION['id'];
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM admin_mod WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $uname = $row['uname']; // Update to use the correct variable name
    // $email = $row['email'];
}
?>
<?php
// Check if the user is logged in and has a session ID
if (!isset($_SESSION['id'])) {
    // Redirect the user to the login page or perform other actions
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id']; // Get the user ID from the session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_management";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the username based on the user's ID
$getUserQuery = "SELECT uname FROM admin_mod WHERE id = $id";
$result = $conn->query($getUserQuery);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $uname = $row['uname'];
} else {
    // Handle the case where the user's ID is not found in the database
    $uname = "Unknown User";
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Master Admin Page</title>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #f2f2f2;
        display: flex;
        align-items: flex-start;
        height: 100vh;
        margin: 0;
    }

    #menu {
        width: 250px;
        background-color: #333;
        color: #fff;
        padding: 20px;
    }

    #content {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    li {
        margin: 1px 0;
    }

    a {
        display: block;
        padding: 10px 20px;
        background-color: #007BFF;
        color: #ffffff;
        text-align: left;
        border: 2px solid #007BFF;
        border-radius: 3px;
        cursor: pointer;
        width: 200px;
        text-decoration: none;
        margin-bottom: 5px;
    }

    a:hover {
        background-color: #0056b3;
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
</style>
</head>
<body>
<div id="menu">
<form class="logout-form" method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
    <h1>Welcome, <?php echo $uname; ?>!</h1>
    <ul>
        <ul>
            <li><a href="AdminPanel.php">Home</a></li>
            <li><a href="AdminEvent.php">CREATE EVENT</a></li>
            <li><a href="AdminEventHistory.php">EVENT HISTORY</a></li>
            <li><a href="AdminEventCal.php">EVENT CALENDAR</a></li>
            <li><a href="AdminTicketCreation.php">TICKET PUBLISH</a></li>
            <li><a href="AdminTicketList.php">TICKET SALE LIST</a></li>
            <li><a href="AdminAnalysis.php">ANALYSIS</a></li>
            <li><a href="AdminComplaint.php">COMPLAINT LIST</a></li>
            <li><a href="AdminModAccess.php">MODERATOR ACCESS</a></li>
            <li><a href="AdminModManagement.php">MODERATOR MANAGEMENT</a></li>
            <li><a href="AdminPostModeration.php">POST MODERATION</a></li>
            <li><a href="#">POST MODERATION HISTORY</a></li>
            <li><a href="AdminCommentModeration.php">COMMENT MODERATION</a></li>
            <li><a href="#">COMMENT MODERATION HISTORY</a></li>
            <li><a href="#">QUERY FEEDBACK</a></li>
            <li><a href="#">QOUTATION FEEDBACK</a></li>
            <li><a href="AdminAdd2Gallary.php">ADD TO GALLERY</a></li>
            <li><a href="UserManagement.php">USER MANAGEMENT</a></li>
        </ul>
    </ul>
</div>
<div id="content">
    <div class="container">
        <h2 class="text-center">Moderator Registration Form</h2>

        <?php
        $error_message = ""; // Initialize an empty error message

        if (isset($_POST['register'])) {
            $uname = $_POST["uname"];
            $email = $_POST["email"];
            $password = $_POST["password"]; // Don't hash the password

            // Check if the username already exists in the database
            $check_username_query = "SELECT * FROM admin_mod WHERE uname='$uname'";
            $result_username = $conn->query($check_username_query);

            // Check if the email already exists in the database
            $check_email_query = "SELECT * FROM admin_mod WHERE email='$email'";
            $result_email = $conn->query($check_email_query);

            if ($result_username->num_rows > 0) {
                $error_message = "username already exists. Please choose a different username.";
            } elseif ($result_email->num_rows > 0) {
                $error_message = "Email address is already registered.";
            } else {
                // Neither username nor email is already in use, so proceed with registration
                $sql = "INSERT INTO admin_mod (uname, email, password, type) VALUES ('$uname', '$email', '$password', 'mod')";

                if ($conn->query($sql) === TRUE) {
                    echo "Registration successful!";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
        // Close the database connection
        $conn->close();
        ?>

        <!-- Display error message at the top of the form -->
        <div class="warning">
            <?php echo $error_message; ?>
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
            <div class "form-group">
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
