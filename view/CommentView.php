<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMMENT MODERATION HISTORY</title>
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
<?php include("view/AdminSidebar.php"); ?>

    <div id="content">
        <h1 style="text-align: center; background-color: #000; color: #fff; padding: 20px;">COMMENT MODERATION HISTORY</h1>
        
        <form method="post">
            <div class="logout-form">
                <button type="submit" name="logout" class="logout-button">Logout</button>
            </div>
        </form>

        <table border="1">
            <tr>
                <th>COMMENTEES UserName</th>
                <th>COMMENT</th>
                <th>COMMENT DATE</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?php echo $comment["posted_by_username"]; ?></td>
                    <td><?php echo $comment["comment"]; ?></td>
                    <td><?php echo $comment["created_at"]; ?></td>
                    <td><?php echo $comment["status"]; ?></td>
                    <td>
                        <?php if ($comment["status"] == 1): ?>
                            <button type="submit" name="hide" value="<?php echo $comment["id"]; ?>">Hide</button>
                        <?php else: ?>
                            <button type="submit" name="unhide" value="<?php echo $comment["id"]; ?>">Unhide</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
