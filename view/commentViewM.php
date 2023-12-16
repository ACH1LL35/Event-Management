<?php
include_once("../model/commentModelM.php");

// Establish database connection
$conn = mysqli_connect("localhost", "root", "", "event_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Include the commentActionController to handle actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include_once("../controller/commentActionControllerM.php");
}

include_once("../controller/commentControllerM.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMMENT MODERATION</title>
    <style>
         body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
        }

        #content {
            flex: 1;
            display: flex;
            flex-direction: column; /* Align content vertically */
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
    </style>
</head>
<body>
    <div id="content">
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">COMMENT MODERATION</h1>
        <form method="post">
            <table border="1">
                <tr>
                    <th>COMMENT UniqueID</th>
                    <th>COMMENTEES UniqueID</th>
                    <th>COMMENTEES UserName</th>
                    <th>COMMENT</th>
                    <th>COMMENT DATE</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
                <?php
                $sql = "SELECT * FROM comments";
                $res = mysqli_query($conn, $sql);

                while ($r = mysqli_fetch_assoc($res)) {
                ?>
                    <tr>
                        <td><?php echo $r["id"]; ?></td>
                        <td><?php echo $r["posted_by_id"]; ?></td>
                        <td><?php echo $r["posted_by_username"]; ?></td>
                        <td><?php echo $r["comment"]; ?></td>
                        <td><?php echo $r["created_at"]; ?></td>
                        <td><?php echo $r["status"]; ?></td>
                        <center>
                        <td>
                            <?php if ($r["status"] == 1): ?>
                                <button type="submit" name="hide" value="<?php echo $r["id"]; ?>">Hide</button>
                            <?php else: ?>
                                <button type="submit" name="unhide" value="<?php echo $r["id"]; ?>">Unhide</button>
                            <?php endif; ?>
                        </td>
                        </center>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>
</body>
</html>
