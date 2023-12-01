<?php
include("AdminSidebar.php");

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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['hide'])) {
        $postId = $_POST['hide'];
        $sqlUpdateStatus = "UPDATE posts SET status = 0 WHERE id = $postId";
        mysqli_query($conn, $sqlUpdateStatus);
    } elseif (isset($_POST['unhide'])) {
        $postId = $_POST['unhide'];
        $sqlUpdateStatus = "UPDATE posts SET status = 1 WHERE id = $postId";
        mysqli_query($conn, $sqlUpdateStatus);
    }
}

$query = "SELECT * FROM admin_mod WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['uname']; // Update to use the correct variable name
    // $email = $row['email'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST MODERATION HISTORY</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
        }

        #content {
            display: flex;
            flex-direction: column; /* Align content vertically */
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

        .content {
            padding-left: 20px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
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
            margin-top: 20px;
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
    <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">pOST MODERATION HISTORY</h1>
        <form method="post">
            <table border="1">
                <tr>
                    <th>POST TITLE</th>
                    <th>POST</th>
                    <th>POST DATE</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
                <?php
                $sql = "SELECT * FROM posts WHERE status = 0";
                $res = mysqli_query($conn, $sql);

                while ($r = mysqli_fetch_assoc($res)) {
                    ?>
                    <tr>
                        <td><?php echo $r["title"]; ?></td>
                        <td><?php echo $r["content"]; ?></td>
                        <td><?php echo $r["created_at"]; ?></td>
                        <td><?php echo $r["status"]; ?></td>
                        <td>
                            <?php if ($r["status"] == 1): ?>
                                <button type="submit" name="hide" value="<?php echo $r["id"]; ?>">Hide</button>
                            <?php else: ?>
                                <button type="submit" name="unhide" value="<?php echo $r["id"]; ?>">Unhide</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>
</body>
</html>
