<!DOCTYPE html>
<html>
<head>
    <title>Password Update</title>
</head>
<body>
    <h2>Update Password</h2>
    <form method="post" action="UserPassUpdate.php">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password !== $confirm_password) {
                echo "New password and confirm password do not match.";
            } else {
                $db_connection = mysqli_connect('localhost', 'root', '', 'event_management');
                if (!$db_connection) {
                    die("Database connection failed: " . mysqli_connect_error());
                }

                // Assuming you have a user identifier, replace '123' with the actual user identifier
                $id = 2;

                $sql = "SELECT password FROM credential WHERE id = $id";
                $result = mysqli_query($db_connection, $sql);
                $row = mysqli_fetch_assoc($result);
                $current_password_db = $row['password'];

                if ($current_password === $current_password_db) {
                    $update_sql = "UPDATE credential SET password = '$new_password' WHERE id = $id";
                    if (mysqli_query($db_connection, $update_sql)) {
                        echo "Password updated successfully.";
                    } else {
                        echo "Error updating password: " . mysqli_error($db_connection);
                    }
                } else {
                    echo "Current password is incorrect.";
                }

                mysqli_close($db_connection);
            }
        }
        ?>
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" required><br><br>
        
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br><br>
        
        <label for "confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" required><br><br>
        
        <input type="submit" name="submit" value="Confirm">
    </form>
</body>
</html>
