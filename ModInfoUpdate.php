<?php
include("ModSidebar.php");

$servername = "localhost";
$username = "root";
$pass = "";
$dbname = "event_management";

$conn = new mysqli($servername, $username, $pass, $dbname);

// Check if a user ID session variable exists
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $query = "SELECT uname FROM admin_mod WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $uname = $row['uname'];
        } else {
            $uname = 'Unknown'; // Default value if uname is not found
        }
    } else {
        $uname = 'Unknown'; // Default value if there is an error with the query
    }
} else {
    $id = null; // Default value when no user is logged in
    $uname = '';
}

if (isset($_POST['feedback'])) {
    $complaint_id = $_POST['complaint_id'];
    $feedback = $_POST['feedback'];
    $sql2 = "UPDATE complaint SET feedback='$feedback' WHERE id='$complaint_id'";
    mysqli_query($conn, $sql2);
}

$sql = "SELECT * FROM complaint";
$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Admin Page</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            text-align: center;
            margin-right: auto;
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

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: #fff;
        }

        #content {
            flex-grow: 1;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin: 20px;
        }

        h2 {
            font-size: 24px;
            margin-top: 10px;
        }

        /* Style for form labels and inputs */
        label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 65%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin: 5px 0;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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

    <div id="content">
        <h2><?php echo $uname; ?>'s Profile</h2>
        <p>Unique UserID: <?php echo $id; ?></p>

        <!-- "Update Your Username" section -->
        <div id="uname-update">
            <h2>Update Your Username</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="uname">New Username:</label>
                <input type="text" name="uname" value="<?php echo $uname; ?>">
                <br>
                <input type="submit" value="Change uname">
            </form>
        </div>

        <?php
        // Handle username update
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['uname'])) {
                $newUsername = mysqli_real_escape_string($conn, $_POST['uname']);

                // Check if the new username already exists
                $checkUsernameQuery = "SELECT id FROM admin_mod WHERE uname = '$newUsername' AND id != '$id'";
                $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);

                if (mysqli_num_rows($checkUsernameResult) > 0) {
                    echo "Username already exists. Please choose a different one.";
                } else {
                    // Update the username in the database
                    $updateUsernameQuery = "UPDATE admin_mod SET uname = '$newUsername' WHERE id = '$id'";
                    if (mysqli_query($conn, $updateUsernameQuery)) {
                        echo "Username updated successfully!";
                        $uname = $newUsername;

                        echo '<meta http-equiv="refresh" content="2;url=ModInfoUpdate.php">';
                        exit();
                    } else {
                        echo "Error updating username: " . mysqli_error($conn);
                    }
                }
            }
        }

        // "Update Password" section
        echo "<div id='password-update'>";
        echo "<h2>Update Password</h2>";
        echo "<form method='post' action='ModInfoUpdate.php'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
                $current_password = $_POST['current_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];

                if ($new_password !== $confirm_password) {
                    echo "New password and confirm password do not match.";
                } else {
                    $db_connection = mysqli_connect("localhost", "root", "", "event_management");
                    if (!$db_connection) {
                        die("Database connection failed: " . mysqli_connect_error());
                    }

                    $id = $_SESSION['id'];

                    $sql = "SELECT password FROM admin_mod WHERE id = $id";
                    $result = mysqli_query($db_connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $current_password_db = $row['password'];

                    if ($current_password === $current_password_db) {
                        $update_sql = "UPDATE admin_mod SET password = '$new_password' WHERE id = $id";
                        if (mysqli_query($db_connection, $update_sql)) {
                            echo "Password updated successfully.";
                            echo '<meta http-equiv="refresh" content="2;url=ModInfoUpdate.php">';
                        exit();
                        } else {
                            echo "Error updating password: " . mysqli_error($db_connection);
                        }
                    } else {
                        echo "Current password is incorrect.";
                    }

                    mysqli_close($db_connection);
                }
            }
        }

        echo "<label for='current_password'>Current Password:</label>";
        echo "<input type='password' name='current_password' required><br><br>";
        echo "<label for='new_password'>New Password:</label>";
        echo "<input type='password' name='new_password' required><br><br>";
        echo "<label for='confirm_password'>Confirm New Password:</label>";
        echo "<input type='password' name='confirm_password' required><br><br>";
        echo "<input type='submit' name='submit' value='Confirm'>";
        echo "</form>";
        echo "</div>";
        ?>
    </div>
</body>
</html>
