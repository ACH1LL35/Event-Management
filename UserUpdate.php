<?php
include("UserSidebar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin: 0;
        }
        #sidebar {
            float: left;
            width: 20%;
        }
        #content {
            float: left;
            width: 45%;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin: 0;
        }
        ul li a {
            display: block;
            padding: 10px;
            background-color: #eee;
            text-decoration: none;
        }
        ul li a:hover {
            background-color: #ddd;
        }
        #logout-container {
            position: absolute;
            top: 20px;
            right: 10px;
        }
        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff5733;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .logout-button:hover {
            background-color: #ff0000;
        }

        /* Styles for the "Update Your Username" section */
        #username-update {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        #username-update h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 10px;
        }

        #username-update label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        #username-update input[type="text"] {
            width: 75%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #username-update input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #username-update input[type="submit"]:hover {
            background-color: #555;
        }

        /* Styles for the "Update Password" section */
        #password-update {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        #password-update h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 10px;
        }

        #password-update label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        #password-update input[type="password"] {
            width: 75%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #password-update input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #password-update input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<?php

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: UserLogin.php");
        exit();
    }

    if (!isset($_SESSION['id'])) {
        header("Location: UserLogin.php");
        exit();
    }

    $id = $_SESSION['id'];

    $conn = mysqli_connect("localhost", "root", "", "event_management");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM credential WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $email = $row['email'];
    }
    ?>

    <div id="content">
        <h2><?php echo $username; ?>'s Profile</h2>
        <p>Unique UserID: <?php echo $id; ?></p>

        <!-- "Update Your Username" section -->
        <div id="username-update">
            <h2>Update Your Username</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="username">New Username:</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <br>
                <input type="submit" value="Change Username">
            </form>
        </div>

        <?php
        // Handle username update
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['username'])) {
                $newUsername = mysqli_real_escape_string($conn, $_POST['username']);

                // Check if the new username already exists
                $checkUsernameQuery = "SELECT id FROM credential WHERE username = '$newUsername' AND id != '$id'";
                $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);

                if (mysqli_num_rows($checkUsernameResult) > 0) {
                    echo "Username already exists. Please choose a different one.";
                } else {
                    // Update the username in the database
                    $updateUsernameQuery = "UPDATE credential SET username = '$newUsername' WHERE id = '$id'";
                    if (mysqli_query($conn, $updateUsernameQuery)) {
                        echo "Username updated successfully!";
                        $username = $newUsername;

                        echo '<meta http-equiv="refresh" content="2;url=UserUpdate.php">';
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
        echo "<form method='post' action='UserUpdate.php'>";
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

                    $sql = "SELECT password FROM credential WHERE id = $id";
                    $result = mysqli_query($db_connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $current_password_db = $row['password'];

                    if ($current_password === $current_password_db) {
                        $update_sql = "UPDATE credential SET password = '$new_password' WHERE id = $id";
                        if (mysqli_query($db_connection, $update_sql)) {
                            echo "Password updated successfully.";
                            echo '<meta http-equiv="refresh" content="2;url=UserUpdate.php">';
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

    <div id="logout-container">
        <form method="post">
            <input type="submit" name="logout" class="logout-button" value="Log Out">
        </form>
    </div>

    <?php
    mysqli_close($conn);
    ?>
</body>
</html>
