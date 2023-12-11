<?php
include("ModSidebar.php");


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
    $username = $row['uname'];
}

// Process form submissions
if (isset($_POST['q_fed'])) {
    foreach ($_POST['q_id'] as $qId) {
        $q_fedText = isset($_POST['q_fed'][$qId]) ? mysqli_real_escape_string($conn, $_POST['q_fed'][$qId]) : '';
        $qId = mysqli_real_escape_string($conn, $qId);

        // Insert the session ID into the fd_by column only for the associated row
        $fdBy = mysqli_real_escape_string($conn, $id);

        $updateQuery = "UPDATE query SET q_fed = '$q_fedText', fd_by = '$fdBy' WHERE q_id = '$qId'";
        mysqli_query($conn, $updateQuery);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Query Page</title>
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

        .sidebar {
            background-color: #333;
            color: #fff;
            width: 200px;
            padding: 20px;
            height: 900px;
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
            width: 150px;
            text-decoration: none;
        }

        a:hover {
            background-color: #0056b3;
        }
        #content {
            flex: 1;
            display: flex;
            flex-direction: column; /* Align content vertically */
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
        #content h1 {
            text-align: center;
            background-color: #000;
            color: #fff;
            padding: 20px;
            
            width: calc(100% + 40px); /* Adjust the width to cover the banner */
        }
    </style>
</head>
<body>

    <div id="content">
        <h1>QUERY FEEDBACK</h1>
    <form method="post">
        <table border="1">
            <tr>
            <th>QUERY ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Title</th>
                <th>Description</th>
                <th>Current Feedback</th>
                <th>Feedback</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "select * from query";
            $res = mysqli_query($conn, $sql);

            while ($r = mysqli_fetch_assoc($res)) {
                ?>
                    <tr>
                    <td><?php echo $r["q_id"]; ?></td>
                    <td><?php echo $r["u_name"]; ?></td>
                    <td><?php echo $r["u_email"]; ?></td>
                    <td><?php echo $r["q_title"]; ?></td>
                    <td><?php echo $r["q_des"]; ?></td>
                    <td><?php echo $r["q_fed"]; ?></td>
                    <td>
                        <textarea name="q_fed[<?php echo $r['q_id']; ?>]" rows="3"
                                  cols="30"><?php echo $r['q_fed']; ?></textarea>
                    </td>
                    <td>
                        <button type="submit" name="q_id[]" value="<?php echo $r["q_id"]; ?>">Submit Feedback</button>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </form>
</body>
</html>
