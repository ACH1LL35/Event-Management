<!-- AdminUserView.php -->

<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: start.php");
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
    $username = $row['uname'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            height: 100vh;
            margin: 0;
        }

        #content {
            display: flex;
            flex-direction: column; /* Align content vertically */
            padding-left: 20px; /* Added padding to align with the previous version with the sidebar */
        }

        table {
            border-collapse: collapse;
            width: 80%;
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

        /* Styles for the logout form */
        .logout-form {
            text-align: center;
            margin-top: 10px; /* Adjusted margin for better spacing */
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

        /* Styles for the search bar */
        #search-bar {
            margin-top: 10px;
            text-align: right;
        }

        #search-bar select,
        #search-bar input[type="text"],
        #search-bar input[type="submit"] {
            padding: 5px;
            margin-right: 10px;
        }

        /* Styles for the table */
        #user-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include("../view/AdminSidebar.php"); ?> <!-- Include AdminSidebar.php -->

    <div id="content">
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">User List</h1>

        <!-- Search bar and dropdown -->
        <form method="post" id="search-bar">
            <label for="search-option">Search by:</label>
            <select name="search_option">
                <option value="id">ID</option>
                <option value="name">Name</option>
                <option value="username">Username</option>
                <option value="cnumber">Contact Number</option>
                <option value="email">Email</option>
                <option value="address">Address</option>
                <option value="status">Status</option>
            </select>
            <input type="text" name="search_text" placeholder="Search...">
            <input type="submit" name="search" value="Search">
        </form>

        <!-- User table -->
        <table border="1" id="user-table">
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>USER NAME</th>
                <th>CONTACT NUMBER</th>
                <th>Email</th>
                <th>ADDRESS</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>

            <?php
            $servername = "localhost";
            $username = "root";
            $pass = "";
            $dbname = "event_management";
            $conn = new mysqli($servername, $username, $pass, $dbname);

            if (isset($_POST['action'])) {
                $id = $_POST['user_id'];
                $action = $_POST['action'];
            
                if ($action === 'ban') {
                    // Update the status to 0 (banned)
                    $sql = "UPDATE credential SET status = 0 WHERE id='$id'";
                    mysqli_query($conn, $sql);
                } elseif ($action === 'unban') {
                    // Update the status to 1 (unbanned)
                    $sql = "UPDATE credential SET status = 1 WHERE id='$id'";
                    mysqli_query($conn, $sql);
                }
            }                

            // Add the search functionality
            if (isset($_POST['search'])) {
                $search_option = $_POST['search_option'];
                $search_text = $_POST['search_text'];

                // Modify the SQL query to include the search condition
                $sql = "SELECT * FROM credential WHERE $search_option LIKE '%$search_text%'";
                $res = mysqli_query($conn, $sql);
            } else {
                $sql = "SELECT * FROM credential";
                $res = mysqli_query($conn, $sql);
            }

            while ($r = mysqli_fetch_assoc($res)) {
                ?>
                <tr>
                    <td><?php echo $r["id"]; ?></td>
                    <td><?php echo $r["name"]; ?></td>
                    <td><?php echo $r["username"]; ?></td>
                    <td><?php echo $r["cnumber"]; ?></td>
                    <td><?php echo $r["email"]; ?></td>
                    <td><?php echo $r["address"]; ?></td>
                    <td><?php echo $r["status"]; ?></td>

                    <td>
                    <?php if ($r["status"] == 1): ?>
                        <form method="post" style="display: inline;">
                            <button type="submit" name="action" value="ban">BAN</button>
                            <input type="hidden" name="user_id" value="<?php echo $r["id"]; ?>">
                        </form>
                    <?php else: ?>
                        <form method="post" style="display: inline;">
                            <button type="submit" name="action" value="unban">UNBAN</button>
                            <input type="hidden" name="user_id" value="<?php echo $r["id"]; ?>">
                        </form>
                    <?php endif; ?>
                    </td>

                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>