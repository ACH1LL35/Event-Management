<?php
include("ModSidebar.php");

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
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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
            width: 200px;
            text-decoration: none;
            margin-bottom: 5px;
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
        <h1>POST MODERATION</h1>
        <form method="get">
        <table border="1">
            <tr>
                <th>POST UniqueID</th>
                <th>POSTERS UniqueID</th>
                <th>POSTERS UserName</th>
                <th>POST TITLE</th>
                <th>POST</th>
                <th>POST DATE</th>
                <th>ACTION</th>
            </tr>
        <?php
        if(isset($_GET['del']))
        {
            $id= $_GET['del'];
            $sql1="Delete from posts where id='$id'";
            mysqli_query($conn,$sql1);
        }

        $sql="select * from posts";
        $res= mysqli_query($conn,$sql);

        while($r= mysqli_fetch_assoc($res)) {
        ?>
            <tr>
                <td><?php echo $r["id"]; ?></td>
                <td><?php echo $r["posted_by_id"]; ?></td>
                <td><?php echo $r["posted_by_username"]; ?></td>
                <td><?php echo $r["title"]; ?></td>
                <td><?php echo $r["content"]; ?></td>
                <td><?php echo $r["created_at"]; ?></td>
                <center>
                <td><button type="submit" name="del" value="<?php echo $r["id"]; ?>">Delete</button></td>
                </center>
            </tr>
        <?php } ?>
        </table>
        </form>
    </div>
</body>
</html>
